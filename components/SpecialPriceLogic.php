<?php
/**
 * Класс SpecialPriceLogic
 * Компонент для работы специальных цен клиентов
 */
class SpecialPriceLogic {

    /**
     * Возвращает массив с идентификаторами и количеством товаров со спец.ценами<br/>
     * Если товаров нет, возвращает пустой массив;
     * @return array
     */
    public static function getProductsId() {
        return isset($_SESSION['specialPrice']) ? $_SESSION['specialPrice'] : Array();
    }

    /**
     * Возвращает массив со списком товаров со спец.ценами
     * @return array
     */
    public static function getProducts() {
	$products = Array();
        // Получаем массив с идентификаторами и количеством товаров со спец.ценами
	if ($productsInCart = self::getProductsId()) {
		// Получаем информацию о продуктах
		$products = Special::getProdustsByPartNumbers(array_keys($productsInCart));
		// Добавляем информацию о количестве товара со спец.ценами
		foreach ($products as $idx=>$next) {
			$products[$idx]['code'] = $next['product_part_number'];
			$products[$idx]['count'] = $productsInCart[$next['product_part_number']];
		}
	}
        return $products;
    }
    

}