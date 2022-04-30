<?php
/**
 * Контроллер AdminOrderController
 * Управление заказами в админпанели
 */
class AdminOrderController extends AdminBase {
    /**
     * Action для страницы "Управление заказами"
     */
    public function actionIndex() {
        self::checkAdmin();
        $ordersList = Order::getOrdersList();
        $operatorBase = AdminClass::operatorBase();
        $managerBase =  AdminClass::managerBase();
        require_once (ROOT . '/views/admin/Orders/Index.php');
        return true;
    }

    /**
     * Action для страницы "Просмотр заказа"
     */
    public function actionView($id) {
        self::checkAdmin();
        // Получаем данные о конкретном заказе
        $order = Order::getOrderById($id);
        // Получаем массив с идентификаторами и количеством товаров
        $productsQuantity = json_decode($order['products'], true);
        // Получаем массив с индентификаторами товаров
        $productsIds = array_keys($productsQuantity);

	// Выделяем id обычных товаров и получаем список товаров из таблицы Product
	$productsRegularIds = array_filter($productsIds,function ($var) { return preg_match("/^\d+$/",$var); });
	if ($productsRegularIds) $productsRegular = Product::getProdustsByIds($productsRegularIds); else $productsRegular = Array();
	
	// Выделяем part_number товаров со спец.ценой и получаем список товаров из таблицы ProductCustom
	$productsPartNumbers = array_filter($productsIds,function ($var) { return preg_match("/^\d+\-\d+$/",$var); });
	if ($productsPartNumbers) $productsSpecial = Special::getProdustsByPartNumbers($productsPartNumbers); else $productsSpecial = Array();

	// Объединяем списки (скорее всего в одном заказе будут товары только одного типа)
	$products = array_merge( $productsRegular, $productsSpecial);

	// Заполняем поле количества товара
	foreach ($products as $idx=>$nextProduct) {
		if (isset($productsQuantity[$nextProduct['product_part_number']]))
			$products[$idx]['cnt'] = $productsQuantity[$nextProduct['product_part_number']];
		else
			$products[$idx]['cnt'] = $productsQuantity[$nextProduct['id']];
	}
    $order_items = Order::getOrderItems($id);

        require_once (ROOT . '/views/admin/Orders/View.php');
        return true;
    }
    // Просмотр всех заказов пользователя
    public function actionZakaz($id) {
        self::checkAdmin();
        $linkOrder = $_SERVER['REQUEST_URI'];
        $linkOrderRequest = explode('/', $linkOrder);
        $allBillFromUser = Order::allBillFromUser($linkOrderRequest[3]);
        require_once (ROOT . '/views/admin/Orders/Zakaz.php');
        return true;
    }
}