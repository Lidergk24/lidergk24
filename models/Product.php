<?php
/**
 * Класс Product - модель для работы с товарами
 */
class Product {
    // Количество отображаемых товаров по умолчанию
    const SHOW_BY_DEFAULT = 8;

    /**
     * Возвращает массив последних товаров
     * @param type $count [optional] <p>Количество</p>
     * @param type $page [optional] <p>Номер текущей страницы</p>
     * @return array <p>Массив с товарами</p>
     */
    public static function getLatestProducts($hit) {
        $db = Db::getConnection();
        $sql = "SELECT id, product_name, product_price, price1, price2, price3, priceOpt, product_part_number, product_image, miz_zakaz, product_warehouse, product_atributs FROM Product where product_part_number IN($hit) order by rand() limit 6";
        $result = $db->prepare($sql);
        //$result->bindParam(':count', $count, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        $i = 0;
        $productsList = array();
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['product_name'] = $row['product_name'];
//            $productsList[$i]['product_price'] = $row['product_price'];
            $productsList[$i]['product_price'] = self::getUserPrice($row);
            $productsList[$i]['product_part_number'] = $row['product_part_number'];
            $productsList[$i]['product_image'] = $row['product_image'];
            $productsList[$i]['miz_zakaz'] = $row['miz_zakaz'];
            $productsList[$i]['product_warehouse'] = $row['product_warehouse'];
            $productsList[$i]['product_atributs'] = $row['product_atributs'];
            $i++;
        }
        return $productsList;
    }
    public static function similarProducts($similarProducts) {
        $db = Db::getConnection();
        $sql = 'SELECT compatible_product from Product where product_part_number = :product_part_number';
        $result = $db->prepare($sql);
        $result->bindParam(':product_part_number', $similarProducts, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
    }
    //получение категории
    public static function getPodcategorySlug($categorySlug) {
        $db = Db::getConnection();
        $sql = 'SELECT * from Product_category where cat_slug = :categorySlug';
        $result = $db->prepare($sql);
        $result->bindParam(':categorySlug', $categorySlug, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
    }
    //проучаем товары по id категории
    public static function getProductsListCategory($product_category) {
       // $limit = Product::SHOW_BY_DEFAULT;
        $db = Db::getConnection();
        $sql =  "SELECT * from Product t where product_category = :product_category and product_image !='[{}]' and product_price !='' ORDER BY CAST(`product_price` AS DECIMAL(10,2)) ASC LIMIT 17";
        $result = $db->prepare($sql);
        $result->bindParam(':product_category', $product_category, PDO::PARAM_STR);
        $result->execute();
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as &$product){
            $product['product_site_price'] =$product['product_price'];
            $product['product_price'] = Special::getUserPrice($product); 
            $product_arr = [];
            $product_arr[] = $product['id'];
            $product['discount'] =  Product::getProdustsDiscountByIds($product_arr)[ $product['id']];
            $product['condition_rules'] = $product['discount']['condition_rules'];
            $product['rub_rules'] = $product['discount']['rub_rules'];
            $product['procent_rules'] = $product['discount']['procent_rules'];
            $product['count_rules'] = $product['discount']['count_rules'];
        }
        return $rows;
    }
    /**
     * Возвращает продукт с указанным id
     * @param integer $id <p>id товара</p>
     * @return array <p>Массив с информацией о товаре</p>
     */
    public static function getProductById($product_part_number) {
        $db = Db::getConnection();
        $sql = "SELECT *, '' AS custom_prefix FROM `Product` WHERE product_part_number= :product_part_number";
        $result = $db->prepare($sql);
        $result->bindParam(':product_part_number', $product_part_number, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
	    $row = $result->fetch();
        if ($row != null) {
            $row['product_site_price'] = $row['product_price'];
            $productIdsArray = array($row['id']);
            $discountForThisProduct = self::getProdustsDiscountByIds($productIdsArray);
            if ($discountForThisProduct != null) {
                $row['count'] = $row['miz_zakaz'];				// Количество товара
				$row['discount'] = $discountForThisProduct;				// Правила применения скидок для товара
				// Рассчитываем стоимость товаров
				$row['cost'] = $row['count'] * $row['product_price'];		// Исходная цена товара
				$row['discount_cost'] = $row['cost'];					// Цена товара, после применения скидки за количество
				$row['rest_cost'] = $row['cost'];	
                $row['count_rules'] =  $discountForThisProduct[key($discountForThisProduct)]['count_rules'];
                $row['condition_rules'] =  $discountForThisProduct[key($discountForThisProduct)]['conditions_rules'];
                $use_discount = 1;
					switch ( $discountForThisProduct[key($discountForThisProduct)]['conditions_rules'] ) {
						case 'Меньше':
							if (  $row['count'] <$discountForThisProduct[key($discountForThisProduct)]['count_rules'] ) $use_discount++;
							break;
						case 'Равно':
							if (  $row['count'] %   $discountForThisProduct[key($discountForThisProduct)]['count_rules'] == 0 ) $use_discount = floor ( $row['count'] / $discountForThisProduct[key($discountForThisProduct)]['count_rules']);
                            $row['condition_rules'] =  'кратно';
							break;
						case 'Больше':
							if (  $row['count'] >  $discountForThisProduct[key($discountForThisProduct)]['count_rules'] ) $use_discount++;
							break;
					}
					if ($use_discount) {
						if ($discountForThisProduct[key($discountForThisProduct)]['procent_rules'] ) {
                            $row['discount_cost'] *= (100 -  $discountForThisProduct[key($discountForThisProduct)]['procent_rules']) / 100;
                            $row['rest_cost'] = 0;				// Процентная скидка действует на все товары
						}
						if (  $discountForThisProduct[key($discountForThisProduct)]['rub_rules'] ) {
                            $row['discount_cost'] -= $use_discount *  $discountForThisProduct[key($discountForThisProduct)]['rub_rules'];
							if ($discountForThisProduct[key($discountForThisProduct)]['conditions_rules'] == 'Равно' )
                            $row['rest_cost'] -= $use_discount * $ $discountForThisProduct[key($discountForThisProduct)]['count_rules'] *  $row['product_price'];
							else $row['rest_cost'] = 0;			// Для вариантов 'Меньше' и 'Больше' процентная скидка действует на все товары
						}
					}	
                    $row['product_discount_price'] = round(($row['discount_cost'] / $row['count']),2);
            } else {
                $row['product_price'] = Special::getUserPrice($row);
            }

            return $row;
        } else {
            return false;
        }

    }
    
    public static function getHistoryProductByPartN($product_part_number) {
        $db = Db::getConnection();
        $sql = "SELECT * FROM `product_history` WHERE product_part_number= :product_part_number" ;
        $result = $db->prepare($sql);
        $result->bindParam(':product_part_number', $product_part_number, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        $row =  $result->fetch();
        if($row != null) {
            
            return $row;
        }
        else {
            return false;
        }

    }
    //Получаем данные по кастомному товару
    public static function getProductByIdCustom($product_part_number) {
        $db = Db::getConnection();
        $sql = "SELECT *, '' AS custom_prefix FROM `ProductCustom` WHERE product_part_number= :product_part_number";
        $result = $db->prepare($sql);
        $result->bindParam(':product_part_number', $product_part_number, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
	$row = $result->fetch();
    if($row != null) {
        $row['product_site_price'] =$row['product_price'];
        $row['product_price'] = Special::getUserPrice($row);
        return $row;
    }
    else {
        return false;
    }
    }
    
    
    
    
    /**
     * Возвращает список товаров с указанными индентификторами
     * @param array $idsArray <p>Массив с идентификаторами</p>
     * @return array <p>Массив со списком товаров</p>
     */
    public static function getProdustsByIds($idsArray)
    {
        $db = Db::getConnection();
        // Разделяем массив идентификатороы на два отдельных массива для разных видов товаров
        $ids = array();
        $idsCustom = array();
        foreach ($idsArray as $nextid)
        if (preg_match('/^c(\d+)$/', $nextid, $tmp)) $idsCustom[] = $tmp[1];
        else $ids[] = $nextid;

        if ($ids) $sqlArray[] = "SELECT * FROM ((select * from Product P) UNION ALL (select * from ProductCustom C)  ) as BigTable where id IN (" . implode(',', $ids) . ")";
        if ($idsCustom) $sqlArray[] = "SELECT *, 'c' AS ttype FROM ProductCustom WHERE id IN (" . implode(',', $idsCustom) . ")";
        $sql = implode(' UNION ', $sqlArray);
        $result = $db->query($sql);
        $i = 0;
        $products = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $products[$i]['id'] = $row['ttype'] . $row['id'];
            $product_id = $products[$i]['id'];
            $products[$i]['discount_price'];
            $products[$i]['product_price'];
            $products[$i]['product_part_number'] = $row['product_part_number'];
            $products[$i]['product_name'] = $row['product_name'];
            $products[$i]['product_site_price'] = $row['product_price'];
            $products[$i]['product_price'] = self::getUserPrice($row);
            $products[$i]['product_image'] = $row['product_image'];
            $products[$i]['miz_zakaz'] = $row['miz_zakaz'];
            $products[$i]['product_atributs'] = $row['product_atributs'];
            $products[$i]['product_warehouse'] = $row['product_warehouse'];
            $products[$i]['price1'] = $row['price1'];
            $products[$i]['price2'] = $row['price2'];
            $products[$i]['price3'] = $row['price3'];
            $products[$i]['priceOpt'] = $row['priceOpt'];

            $i++;
        }
        foreach ($products as &$product) {
            $productIdsArray = array($product['id']);
            $discountForThisProduct = self::getProdustsDiscountByIds($productIdsArray);
            if ($discountForThisProduct != null) {
                $product['product_price'] = $product['product_site_price'];
            } else {
                $product['product_price'] = Special::getUserPrice($product);
            }
        }
        return $products;
    }


    public static function getProductFromHistoryTableByIds($productsIds) {
        $db = Db::getConnection();
        $sql = "select * from product_history where id in (" . implode(',', $productsIds) . ")";
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $products = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $products[$i]['id']= $row['id'];
            $products[$i]['product_part_number'] = $row['product_part_number'];
            $products[$i]['product_name'] = $row['product_name'];
            $products[$i]['product_image'] = $row['product_image'];
            $products[$i]['miz_zakaz'] = 0;
            $products[$i]['product_warehouse'] = 0;
            $products[$i]['product_atributs'] = $row['product_atributs'];
            $i++;
        }
        if ($products != null) {
            return $products;
        } 
        else return false;
    }


    /**
     * Возвращает список скидок для товаров с указанными индентификторами
     * @param array $idsArray <p>Массив с идентификаторами</p>
     * @return array <p>Массив со списком скидок</p>
     */

    public static function getProdustsDiscountByIds($idsArray) {
        $db = Db::getConnection();
        $idsString = "'" . implode("','", $idsArray) . "'";
        $sql = "SELECT * FROM cart_rules cr LEFT JOIN Product p on cr.item_rules = p.product_part_number WHERE p.id IN ($idsString)";
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $i = 0;
        $products = array();
        while ($row = $result->fetch()) {
	    $id = $row['id'];
            $products[$id]['item_rules'] = $row['item_rules'];
            $products[$id]['conditions_rules'] = $row['conditions_rules'];
            $products[$id]['count_rules'] = $row['count_rules'];
            $products[$id]['procent_rules'] = $row['procent_rules'];
            $products[$id]['rub_rules'] = $row['rub_rules'];
            $products[$id]['discount_group'] = $row['discount_group'];
            $products[$id]['discount_group_side'] = $row['discount_group_side'];
            $i++;
        }
        return $products;
    }
    /**
     * Возвращает список рекомендуемых товаров
     * @return array <p>Массив с товарами</p>
     */
    public static function getRecommendedProducts() {
        // Соединение с БД
        $db = Db::getConnection();
        // Получение и возврат результатов
        $result = $db->query("SELECT id, product_name, product_price, price1, price2, price3, priceOpt, product_image FROM Product where product_image !='[{}]' and product_price !='' ORDER BY id ASC limit 6");
        $i = 0;
        $productsList = array();
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['product_name'] = $row['product_name'];
            $productsList[$i]['product_price'] = self::getUserPrice($row);
            $productsList[$i]['product_image'] = $row['product_image'];
            $i++;
        }
        return $productsList;
    }
    /**
     * Возвращает список товаров
     * @return array <p>Массив с товарами</p>
     */
    public static function getProductsList() {
        $db = Db::getConnection();
        $result = $db->query('select * from Product');
        $productsList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $productsList[$i]['id'] = $row['id'];
            $productsList[$i]['product_name'] = $row['product_name'];
            $productsList[$i]['product_code'] = $row['product_code'];
            $productsList[$i]['product_price'] = self::getUserPrice($row);
            $productsList[$i]['product_image'] = $row['product_image'];
            $productsList[$i]['product_part_number'] = $row['product_part_number'];
            $i++;
        }
        return $productsList;
    }
    // Страница поиска
    public static function getSearch($search) {
        $searchArr = explode(" ", $search);
        $searchArrLength = count($searchArr);
        $db = Db::getConnection();
        $sqlConcat = [];
        if ($searchArrLength < 2) {
            $searchWord = mb_strtolower(trim($search));
            $sqlConcat[] =  "LOWER(PC.product_name) REGEXP '[[:<:]]". $searchWord ."[[:>:]]'  OR PC.product_part_number  REGEXP '[[:<:]]". $searchWord ."[[:>:]]'";
        } else {
            $i = 0;
            foreach ($searchArr as $oneWord) {
                $searchWord = mb_strtolower($oneWord);
                if(strlen($oneWord) > 2) {
                    $i++;
                    if ($i < $searchArrLength) {
                        $sqlConcat[] =  "(LOWER(PC.product_name) REGEXP '[[:<:]]". $searchWord."[[:>:]]'  OR PC.product_part_number  REGEXP '[[:<:]]". $searchWord."[[:>:]]') AND";
                    } else {
                        $sqlConcat[] =  "(LOWER(PC.product_name) REGEXP '[[:<:]]". $searchWord."[[:>:]]'  OR PC.product_part_number  REGEXP '[[:<:]]". $searchWord."[[:>:]]')";
                    }
                } else {
                    $sqlConcat[] = "1";
                }
               
            } 
        }

        $sqlInsert = implode(" ", $sqlConcat);
        //Илья сказал, что продукты из категории под заказ должны быть полностью исключены с сайта, но я оставляю комментарии чтобы их можно было вернуть позже
        // $sql = "SELECT * 
        // from
        // (
        //     SELECT   *
        //     FROM
        //         Product P
        //     UNION
        //         SELECT ProdCus.*
        //         FROM ProductCustom ProdCus
        //             JOIN ProductCustomCategory CatCus
        //             ON ProdCus.product_category = CatCus.catCode
        //             WHERE CatCus.catParent != 'ПРОДУКЦИЯ С ЛОГО'
        //             and ProdCus.product_category != 'd4f9a946-4762-11e7-80d2-00155d0ae503'
        // ) AS PC
        // WHERE
        // ($sqlInsert)
        // AND PC.product_image != '[{}]'
        // AND PC.product_price > 0
        // ORDER BY CAST( product_price AS DECIMAL(10, 2)) ASC";
        $sql = "SELECT * 
        from  Product AS PC
        WHERE
        ($sqlInsert)
        AND PC.product_image != '[{}]'
        AND PC.product_price > 0
        ORDER BY CAST( product_price AS DECIMAL(10, 2)) ASC";
        $stm =  $db->prepare($sql);
        $stm->setFetchMode(PDO::FETCH_ASSOC);
        $stm->execute();
        return $stm->fetchALL();
    }
    public static function getProductAtributs($atribut) {
        $db = Db::getConnection();
        $sql = "SELECT product_atributs FROM Product WHERE product_part_number = :product_part_number";
        $result = $db->prepare($sql);
        $result->bindParam(':product_part_number', $atribut, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetchALL();
    }
    public static function getAtributsOne($svoistvaOnes) {
        $db = Db::getConnection();
        $sql = "SELECT * from Product_atributs where atributId= :atributId";
        $result = $db->prepare($sql);
        $result->bindParam(':atributId', $svoistvaOnes, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetchAll();
    }
    // поиск товара по брендам
    public static function brandModel($brandModel) {
        $db = Db::getConnection();
        //Илья сказал, что продукты из категории под заказ должны быть полностью исключены с сайта, но я оставляю комментарии чтобы их можно было вернуть позже
        // $sql = 'SELECT * FROM (SELECT * FROM Product P UNION SELECT * FROM ProductCustom C) as PC WHERE product_brand= :brandModel';
        $sql = 'SELECT * FROM Product  as PC WHERE product_brand= :brandModel';
        $result = $db->prepare($sql);
        $result->bindParam(':brandModel', $brandModel, PDO::PARAM_STR);
        $result->execute();
        return $result->fetchAll();
    }
    public static function brandDescription($brandDescription) {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM `Product_brand` WHERE brand_name= :brand_name';
        $result = $db->prepare($sql);
        $result->bindParam(':brand_name', $brandDescription, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
    }
    // получаем родителя товара
    public static function breadcrumbs($breadcrumbs) {
        $db = Db::getConnection();
        $sql = 'SELECT product_category FROM `Product` WHERE product_part_number= :product_part_number';
        $result = $db->prepare($sql);
        $result->bindParam(':product_part_number', $breadcrumbs, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
    }
    
    // получаем родителя товара кастомного
    public static function breadcrumbsCustom($breadcrumbs) {
        $db = Db::getConnection();
        $sql = 'SELECT product_category FROM `ProductCustom` WHERE product_part_number= :product_part_number';
        $result = $db->prepare($sql);
        $result->bindParam(':product_part_number', $breadcrumbs, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
    }
    // получаем родителя товара
    public static function parentBreadcrumbs($parentBreadcrumbs) {
        $db = Db::getConnection();
        $sql = 'SELECT cat_affiliate_id, cat_name, cat_slug from Product_category where cat_code= :parentBreadcrumbs';
        $result = $db->prepare($sql);
        $result->bindParam(':parentBreadcrumbs', $parentBreadcrumbs, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
    }
    
    // получаем родителя товара кастомного товара
    public static function parentBreadcrumbsCustom($parentBreadcrumbs) {
        $db = Db::getConnection();
        $sql = 'SELECT catAffiliateId, catName AS cat_name, catSlug AS cat_slug from ProductCustomCategory where catCode= :parentBreadcrumbs';
        $result = $db->prepare($sql);
        $result->bindParam(':parentBreadcrumbs', $parentBreadcrumbs, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
    }
    // получаем родителя товара
    public static function bossCat($bossCat) {
        $db = Db::getConnection();
        $sql = 'select cat_name,cat_slug from Category WHERE cat_code= :bossCat';
        $result = $db->prepare($sql);
        $result->bindParam(':bossCat', $bossCat, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
    }
    
    // получаем родителя товара кастомного товара
    public static function bossCatCustom($bossCat) {
        $db = Db::getConnection();
        $sql = 'select catName AS cat_name, catSlug AS cat_slug from CategoryCustom WHERE catCode= :bossCat';
        $result = $db->prepare($sql);
        $result->bindParam(':bossCat', $bossCat, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
    }
    public static function getSaleProducts($part_nums) {
        $db = Db::getConnection();
        $sql = "SELECT * FROM Product p LEFT JOIN cart_rules cr on cr.item_rules = p.product_part_number WHERE p.product_part_number IN($part_nums)";
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function indexBrand() {
        $db = Db::getConnection();
        $sql = "SELECT * FROM `Product_brand` where brand_logo !='' and selected = '1' order by rand() limit 24";
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetchAll(); 
    }
    public static function getProdustsByRepeat($idsArray) {
        $db = Db::getConnection();
        $idsString = implode(',', $idsArray);
        //Илья сказал, что продукты из категории под заказ должны быть полностью исключены с сайта, но я оставляю комментарии чтобы их можно было вернуть позже
        // $sql = "SELECT * FROM ((select * from Product P) UNION ALL (select * from ProductCustom C)  ) as BigTable where id IN ($idsString)";
        $sql = "SELECT * FROM Product P where id IN ($idsString)";
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetch();
    }

    public static function allbaner() {
        $db = Db::getConnection();
        $sql = "SELECT * FROM banners where banner_type = '1' ORDER BY FIELD(banner_position, 1,2,3,4,5,6,7,8) ";
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetchAll();
    }
    // Получаем квадратный банер
    public static function squareBanner()
    {
        $db = Db::getConnection();
        $sth = $db->prepare("SELECT * FROM `banners` where banner_type = '2' order by id desc limit 1 ");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function allSalesView() {
        $db = Db::getConnection();
        $sql = "SELECT * FROM sales ORDER BY FIELD(sale_position, 1,2,3,4,5,6,7,8)";
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetchAll();
    }
    
     public static function thisHitsProducts() {
        $db = Db::getConnection();
        $sql = "SELECT product_part_number FROM ProductHits";
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetch();
    }
     public static function thissaleProducts() {
        $db = Db::getConnection();
        $sql = "SELECT product_part_number FROM ProductSale";
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Возвращает цену из строки товара в зависимости от статуса пользователя
     * @param Array $row <p>строка параметров товара из БД</p>
     * @return price <p>Цена товара</p>
     */
    public static function getUserPrice($row) {
	$price = $row['product_price'];
	switch ( User::getSpecialClientPrice() ) {
		case 'Цена1': $price = $row['price1']; break;
		case 'Цена2': $price = $row['price2']; break;
		case 'Цена3': $price = $row['price3']; break;
		case 'Оптовая': $price = $row['priceOpt']; break;
	}
	return $price;
    }
    
    // Проверяем участвует ли товар в акции
    public static function superItems($code) {
        $db = Db::getConnection();
        $sql = "SELECT * FROM `cart_rules` where item_rules = :item_rules";
        $result = $db->prepare($sql);
        $result->bindParam(':item_rules', $code, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
    }

    //$date = '2021-02-11' или '2021-03-26 16:17:12'
    public static function findProductIdsLoadedBeforeDate($date) {
        $db = Db::getConnection();
        $sql = 'SELECT id FROM Product where product_date < :date';
        $statement = $db->prepare($sql);
        if(!$statement) {
            error_log('error when preparing statement to read old product ids from DB'.print_r( $db->errorInfo(),true));
            return false;
        }
        $statement->bindParam(':date', $date, PDO::PARAM_STR);
        // $statement->execute();
        if(!$statement->execute()) {
            error_log('error execute'.print_r($statement->errorInfo(),true));
            return false;
        }
        $datedIds = [];
        while($oneDatedId = $statement->fetch(PDO::FETCH_ASSOC)){
            $datedIds[] = $oneDatedId['id'];
        };
        return $datedIds;
    }

    public static function findProductById($id) {
        $db = Db::getConnection();
        $select_sql = 'select * from Product where id = :id';
        $stm = $db->prepare( $select_sql);
        if (!$stm) {
            error_log('findProductById $db prepare return error'.print_r($db->errorInfo(), true));
        }
        $stm ->bindParam(':id', $id, PDO::PARAM_STR);
        $stm ->execute();
        if (!$stm) {
            error_log('findProductById $stm execute return error'.print_r($stm->errorInfo(), true));
        }
        $selected_prod = $stm->fetch(PDO::FETCH_ASSOC);
        return $selected_prod;
    }

    public static function archiveProduct($product) {
        if (!$product) {
            error_log('arg product in archiveProduct() '.print_r($product,true));
            return false;
        }
        $db = Db::getConnection();
        $insert_sql = 'insert into product_history (id,product_code, product_name, product_description,product_category,product_image,product_atributs,product_article, product_slug,product_part_number,compatible_product,product_brand,barcode ) values (:id,:product_code, :product_name, :product_description,:product_category,:product_image,:product_atributs,:product_article, :product_slug,:product_part_number,:compatible_product,:product_brand,:barcode )';
        $insert_stm = $db->prepare($insert_sql);
        $insert_stm ->bindParam(':id', $product['id'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':product_code',  $product['product_code'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':product_name', $product['product_name'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':product_description', $product['product_description'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':product_category', $product['product_category'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':product_image', $product['product_image'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':product_atributs', $product['product_atributs'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':product_article', $product['product_article'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':product_slug', $product['product_slug'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':product_part_number', $product['product_part_number'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':compatible_product', $product['compatible_product'], PDO::PARAM_STR); 
        $insert_stm ->bindParam(':product_brand', $product['product_brand'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':barcode', $product['barcode'], PDO::PARAM_STR);
        $delete_sql = 'delete from Product where id = :id';
        $delete_stm = $db->prepare($delete_sql);
        $delete_stm ->bindParam(':id', $product['id'], PDO::PARAM_STR);
        $db->beginTransaction();
        $insert_res = $insert_stm ->execute();
        if(!$insert_res) {
            error_log('insert return error'.print_r($insert_stm ->errorInfo(), true));
        }
        $delete_res = $delete_stm ->execute();
        if(!$delete_res) {
            error_log('delete return error'.print_r($delete_stm->errorInfo(), true));
        }
        if ($insert_res && $delete_res) {
            $db->commit();
            $res = true;
        } else {
            $db->rollBack();
            $res =  false;
        }
        return $res;
    }


     //$date = '2021-02-11' или '2021-03-26 16:17:12'
     public static function   findProductIdsLoadedBeforeDateCustom($date) {
        $db = Db::getConnection();
        $sql = 'SELECT id FROM ProductCustom where product_date < :date';
        $statement = $db->prepare($sql);
        if(!$statement) {
            error_log('error when preparing statement to read old product ids from DB'.print_r( $db->errorInfo(),true));
            return false;
        }
        $statement->bindParam(':date', $date, PDO::PARAM_STR);
        // $statement->execute();
        if(!$statement->execute()) {
            error_log('error execute'.print_r($statement->errorInfo(),true));
            return false;
        }
        $datedIds = [];
        while($oneDatedId = $statement->fetch(PDO::FETCH_ASSOC)){
            $datedIds[] = $oneDatedId['id'];
        };
        return $datedIds;
    }

    public static function findCustomProductById($id) {
        $db = Db::getConnection();
        $select_sql = 'select * from ProductCustom where id = :id';
        $stm = $db->prepare( $select_sql);
        if (!$stm) {
            error_log('findProductById $db prepare return error'.print_r($db->errorInfo(), true));
        }
        $stm ->bindParam(':id', $id, PDO::PARAM_STR);
        $stm ->execute();
        if (!$stm) {
            error_log('findProductById $stm execute return error'.print_r($db->errorInfo(), true));
        }
        $selected_prod = $stm->fetch(PDO::FETCH_ASSOC);
        return $selected_prod;
    }

    public static function archiveCustomProduct($product) {
        if (!$product) {
            error_log('arg product in archiveProduct() '.print_r($product,true));
            return false;
        }
        $db = Db::getConnection();
        $insert_sql = 'insert into product_history (id,product_code, product_name, product_description,product_category,product_image,product_atributs,product_article, product_slug,product_part_number,compatible_product,product_brand,barcode ) values (:id,:product_code, :product_name, :product_description,:product_category,:product_image,:product_atributs,:product_article, :product_slug,:product_part_number,:compatible_product,:product_brand,:barcode )';
        $insert_stm = $db->prepare($insert_sql);
        $insert_stm ->bindParam(':id', $product['id'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':product_code',  $product['product_code'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':product_name', $product['product_name'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':product_description', $product['product_description'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':product_category', $product['product_category'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':product_image', $product['product_image'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':product_atributs', $product['product_atributs'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':product_article', $product['product_article'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':product_slug', $product['product_slug'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':product_part_number', $product['product_part_number'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':compatible_product', $product['compatible_product'], PDO::PARAM_STR); 
        $insert_stm ->bindParam(':product_brand', $product['product_brand'], PDO::PARAM_STR);
        $insert_stm ->bindParam(':barcode', $product['barcode'], PDO::PARAM_STR);
        $delete_sql = 'delete from ProductCustom where id = :id';
        $delete_stm = $db->prepare($delete_sql);
        $delete_stm ->bindParam(':id', $product['id'], PDO::PARAM_STR);
        $db->beginTransaction();
        $insert_res = $insert_stm ->execute();
        if(!$insert_res) {
            error_log('insert return error'.print_r($insert_stm ->errorInfo(), true));
        }
        $delete_res = $delete_stm ->execute();
        if(!$delete_res) {
            error_log('delete return error'.print_r($delete_stm->errorInfo(), true));
        }
        if ($insert_res && $delete_res) {
            $db->commit();
            $res = true;
        } else {
            $db->rollBack();
            $res =  false;
        }
        return $res;
    }
   
    public static function getCompatibleProducts($codes) {
        $db = Db::getConnection();
        $codesString = '"'.implode('", "', $codes) . '"';
        $sql = "SELECT * FROM Product WHERE product_code IN ($codesString) LIMIT 5";
        $stm = $db->prepare($sql);
        $stm->execute();
        $rows = [];
        while ($oneProduct = $stm->fetch(PDO::FETCH_ASSOC)) {
            $oneProduct ['product_price'] = Special::getUserPrice($oneProduct);
            $rows[] = $oneProduct;
        }
        return $rows;
    }

}