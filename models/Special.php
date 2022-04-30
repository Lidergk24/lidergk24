<?php
/**
 * Класс Special - модель для работы со спец.ценами
 */
class Special {

    /**
     * Возвращает продукт с указанным id
     * @param integer $id <p>id товара</p>
     * @return array <p>Массив с информацией о товаре</p>
     */
    public static function getProductById($id) {
        $db = Db::getConnection();
        $sql = "SELECT * FROM `Product` WHERE id= :id UNION SELECT * FROM `ProductCustom` WHERE id= :id ";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }


    /**
     * Возвращает список товаров с указанными part_numbers
     * @param array $part_numbersArray <p>Массив с part_numbers</p>
     * @return array <p>Массив со списком товаров</p>
     */
    public static function getProdustsByPartNumbers($product_part_numbersArray) {
        $db = Db::getConnection();
        $idsString = "'". implode("','", $product_part_numbersArray) ."'";
        $sql = "SELECT * FROM Product WHERE product_part_number IN ($idsString) UNION SELECT * FROM ProductCustom WHERE product_part_number IN ($idsString)";
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $i = 0;
        $products = array();
        while ($row = $result->fetch()) {
            $products[$i]['id'] = $row['id'];
            $products[$i]['product_part_number'] = $row['product_part_number'];
            $products[$i]['product_code'] = $row['product_code'];
            $products[$i]['product_name'] = $row['product_name'];
            $products[$i]['product_site_price'] =  $row['product_price'];
            $products[$i]['product_price'] = Special::getUserPrice($products[$i]); 
            $products[$i]['price1'] = $row['price1'];
            $products[$i]['price2'] = $row['price2'];
            $products[$i]['price3'] = $row['price3'];
            $products[$i]['priceOpt'] = $row['priceOpt'];
            $products[$i]['product_image'] = $row['product_image'];
            $products[$i]['miz_zakaz'] = $row['miz_zakaz'];
            $products[$i]['product_atributs'] = $row['product_atributs'];
            $products[$i]['product_category'] = $row['product_category'];
            $products[$i]['product_warehouse'] =  $row['product_warehouse'];
            $i++;
        }
        return $products;
    }
    

    
    public static function allItemsFromCode($code) {
        $db = Db::getConnection();
        $sql = "SELECT * FROM Product WHERE product_part_number IN ($code) UNION SELECT * FROM ProductCustom WHERE product_part_number IN ($code)";
       // echo "SELECT * FROM Product WHERE product_part_number IN ($code) UNION SELECT * FROM ProductCustom WHERE product_part_number IN ($code)";
        $result = $db->prepare($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetchAll();
    }

    public static function returnIfSpecial($row) {
        $specialPriceReceived = false;
        $price = Product::getUserPrice($row);
        if ( $inn = User::getSpecialClientINN()) {
                $db = Db::getConnection();
                $sql = 'SELECT * FROM `specialPrice` WHERE innParent= :inn AND itemPartNumber= :part_number';
                $result = $db->prepare($sql);
                $result->bindParam(':inn', $inn, PDO::PARAM_STR);
                $result->bindParam(':part_number', $row['product_part_number'], PDO::PARAM_STR);
                $result->setFetchMode(PDO::FETCH_ASSOC);
                $result->execute();
                $specRow = $result->fetchAll();
            // Если найдена спец.цена для товара
            if (count($specRow)) { $specialPriceReceived = true;}
        } 
        
        return $specialPriceReceived;
    }
    /**
     * Возвращает цену из строки товара в зависимости от статуса пользователя либо спеццену
     * @param Array $row <p>строка параметров товара из БД</p>
     * @return price <p>Цена товара</p>
     */
    public static function getUserPrice($row) {
    $specialPriceReceived = false;
	$price = Product::getUserPrice($row);
	if ( $inn = User::getSpecialClientINN()) {
	        $db = Db::getConnection();
	        $sql = 'SELECT * FROM `specialPrice` WHERE innParent= :inn AND itemPartNumber= :part_number';
	        $result = $db->prepare($sql);
	        $result->bindParam(':inn', $inn, PDO::PARAM_STR);
	        $result->bindParam(':part_number', $row['product_part_number'], PDO::PARAM_STR);
	        $result->setFetchMode(PDO::FETCH_ASSOC);
	        $result->execute();
	        $specRow = $result->fetchAll();
		// Если найдена спец.цена для товара
		if (count($specRow)) {$price = $specRow[0]['itemSpecialPrice']; $specialPriceReceived = true;}
	} 
	return $price;
    }

   
}