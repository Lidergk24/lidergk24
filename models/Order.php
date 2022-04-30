<?php
/**
 * Класс Order - модель для работы с заказами
 */
class Order {
    /**
     * Сохранение заказа
     * @param string $userName <p>Имя</p>
     * @param string $userPhone <p>Телефон</p>
     * @param string $userComment <p>Комментарий</p>
     * @param integer $userId <p>id пользователя</p>
     * @param array $products <p>Массив с товарами</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function save($userName, $userPhone, $order_email, $userComment, $userId, $products, $allSumm, $orderNumber, $payment, $deliveryData, $formPost, $procentInsertBase, $spec, $array_of_items) {
    	$procentInsertBase = $procentInsertBase ? $procentInsertBase : 0;
        $db = Db::getConnection();
        $sql = 'INSERT INTO product_order (user_name, user_phone, user_email, user_comment, user_id, products, order_summ, order_number, payment_method, delivery_adress, moreData, orderDiscount, specOrder) ' . 
        'VALUES (:user_name, :user_phone, :user_email, :user_comment, :user_id, :products, :order_summ, :order_number, :payment_method, :delivery_adress, :formdata, :orderDiscount, :specOrder)';
        $products = json_encode($products);
        $result = $db->prepare($sql);
        $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindParam(':user_comment', $userComment, PDO::PARAM_STR);
        $result->bindParam(':user_id', $userId, PDO::PARAM_STR);
        $result->bindParam(':products', $products, PDO::PARAM_STR);
        $result->bindParam(':order_summ', $allSumm, PDO::PARAM_STR);
        $result->bindParam(':order_number', $orderNumber, PDO::PARAM_INT);
        $result->bindParam(':payment_method', $payment, PDO::PARAM_STR);
        $result->bindParam(':user_email', $order_email, PDO::PARAM_STR);
        $result->bindParam(':delivery_adress', $deliveryData, PDO::PARAM_STR);
        $result->bindParam(':formdata', $formPost, PDO::PARAM_STR);
        $result->bindParam(':orderDiscount', $procentInsertBase, PDO::PARAM_STR);
        $result->bindParam(':specOrder', $spec, PDO::PARAM_INT);
        $ret =  $result->execute();
        $order_id = $db->lastInsertId();
        foreach( $array_of_items as $one_item_to_insert) {
            $product_id = $one_item_to_insert['id'];
            $quantity = $one_item_to_insert['count'];
            $product_price = $one_item_to_insert['product_price'];
            $discount_price = NULL;
            if ($one_item_to_insert['discount']['conditions_rules']) {
                $discount_price = round($one_item_to_insert['discount_cost'] / $one_item_to_insert['count'], 3);
            }
            $insert_item_sql = 'INSERT INTO order_item (order_id, product_id, quantity, price_at_order_time, discount_price)' .
            'VALUES (:order_id, :product_id, :quantity, :price_at_order_time, :discount)';
            $insert_item = $db->prepare($insert_item_sql);
            $insert_item->bindParam(':order_id', $order_id);
            $insert_item->bindParam(':product_id', $product_id);
            $insert_item->bindParam(':quantity', $quantity);
            $insert_item->bindParam(':price_at_order_time', $product_price);
            $insert_item->bindParam(':discount', $discount_price);
            $insert_item->execute();
        }

        return $order_id;
    }
    public static function saveOneClick($userName, $userPhone, $userId, $products, $allSumm, $orderNumber, $procentInsertBase, $array_of_items) {
	$procentInsertBase = $procentInsertBase ? $procentInsertBase : 0;
        $db = Db::getConnection();
        $sql = 'INSERT INTO product_order (user_name, user_phone, user_id, products, order_summ, order_number, orderDiscount) ' . 'VALUES (:user_name, :user_phone, :user_id, :products, :order_summ, :order_number, :orderDiscount)';
        $products = json_encode($products);
        $result = $db->prepare($sql);
        $result->bindParam(':user_name', $userName, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
        $result->bindParam(':products', $products, PDO::PARAM_STR);
        $result->bindParam(':order_summ', $allSumm, PDO::PARAM_STR);
        $result->bindParam(':order_number', $orderNumber, PDO::PARAM_INT);
        $result->bindParam(':user_id', $userId, PDO::PARAM_STR);
        $result->bindParam(':orderDiscount', $procentInsertBase, PDO::PARAM_STR);
        $ret = $result->execute();
        $order_id = $db->lastInsertId();
        foreach( $array_of_items as $one_item_to_insert) {
            $product_id = $one_item_to_insert['id'];
            $quantity = $one_item_to_insert['count'];
            $product_price = $one_item_to_insert['product_price'];
            $discount_price = NULL;
            if ($one_item_to_insert['discount']['conditions_rules']) {
                $discount_price = round($one_item_to_insert['discount_cost'] / $one_item_to_insert['count'], 2);
            }
            $insert_item_sql = 'INSERT INTO order_item (order_id, product_id, quantity, price_at_order_time, discount_price)' .
            'VALUES (:order_id, :product_id, :quantity, :price_at_order_time, :discount)';
            $insert_item = $db->prepare($insert_item_sql);
            $insert_item->bindParam(':order_id', $order_id);
            $insert_item->bindParam(':product_id', $product_id);
            $insert_item->bindParam(':quantity', $quantity);
            $insert_item->bindParam(':price_at_order_time', $product_price);
            $insert_item->bindParam(':discount', $discount_price);
            $insert_item->execute();
        }
        return $order_id;
    }
    //Получение последнего номера заказа и добавление +1 к его номеру (нумерация заказа)
    public static function getOrderNumber() {
        $db = Db::getConnection();
        $sql = 'Select max(`order_number`) as `product_order` from `product_order`';
        $result = $db->prepare($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }
    /**
     * Возвращает список заказов
     * @return array <p>Список заказов</p>
     */
    public static function getOrdersList() {
        $db = Db::getConnection();
        $result = $db->query('SELECT id, user_name, user_phone, date, order_summ, order_number, user_operator, order_status, order_comment, user_manager, statusColor, specOrder FROM product_order ORDER BY order_number DESC limit 30');
        $ordersList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $ordersList[$i]['id'] = $row['id'];
            $ordersList[$i]['user_name'] = $row['user_name'];
            $ordersList[$i]['user_phone'] = $row['user_phone'];
            $ordersList[$i]['date'] = $row['date'];
            $ordersList[$i]['order_summ'] = $row['order_summ'];
            $ordersList[$i]['order_number'] = $row['order_number'];
            $ordersList[$i]['user_operator'] = $row['user_operator'];
            $ordersList[$i]['order_comment'] = $row['order_comment'];
            $ordersList[$i]['order_status'] = $row['order_status'];
            $ordersList[$i]['user_manager'] = $row['user_manager'];
            $ordersList[$i]['statusColor'] = $row['statusColor'];
            $ordersList[$i]['specOrder'] = $row['specOrder'];
            $i++;
        }
        return $ordersList;
    }
    /**
     * Возвращает заказ с указанным id
     * @param integer $id <p>id</p>
     * @return array <p>Массив с информацией о заказе</p>
     */
    public static function getOrderById($id) {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM product_order WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }
    // Получаем все заказы конкретного пользователя
    public static function allBillFromUser($id) {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM product_order WHERE user_phone = :user_phone';
        $result = $db->prepare($sql);
        $result->bindParam(':user_phone', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetchAll();
    }
    // Проверка и выбор кода из смс подписки в корзине
     public static function emailCouponSelf($email) {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM subscribe WHERE email = :email';
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetchAll();
    }
    // Проверка и выбор кода из смс подписки в корзине
     public static function ordersByToday() {
        $db = Db::getConnection();
        $sql = 'SELECT user_name, user_phone, user_email, date, order_number, order_summ, user_operator, order_status, order_comment FROM product_order WHERE date > NOW() - INTERVAL 2 DAY';
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetchAll();
    }
    public static function allCoupons()
    {
        $db = Db::getConnection();
        $sql = 'SELECT * from coupon';
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetchAll();
        
    }

    public static function getOrderItems($id) {
        $db = Db::getConnection();
        $sql = "SELECT * FROM (SELECT * FROM order_item WHERE order_id = :order_id) AS O JOIN(SELECT * FROM Product P UNION SELECT * FROM ProductCustom C) AS PC ON PC.id = O.product_id";
        $stm = $db->prepare($sql);
        $stm->bindParam(':order_id', $id);
        $stm->execute();
        $order_itemsProduct = $stm->fetchAll(PDO::FETCH_ASSOC);
        $sqlH =  "SELECT * FROM (SELECT * FROM order_item WHERE order_id = :order_id) AS O JOIN product_history AS H ON O.product_id = H.id";
        $stmH = $db->prepare($sqlH);
        $stmH->bindParam(':order_id', $id);
        $stmH->execute();
        $order_itemsHistory = $stmH->fetchAll(PDO::FETCH_ASSOC);
        $order_items = array_merge($order_itemsHistory, $order_itemsProduct);
        return $order_items;
    } 
}