<?php
/**
 * Класс Category - модель для работы с категориями товаров
 */
class Category {

    public static function CategorySimpleList() {
        $db = Db::getConnection();
        $sql = 'SELECT DISTINCT PC.cat_parent, PC.cat_affiliate_id, C.cat_slug
        FROM Product_category PC
        JOIN Category C 
        ON PC.cat_affiliate_id = C.cat_code
        WHERE PC.cat_code NOT IN("5cfdb560-3aac-11ea-80ee-00155d0ae503") AND  PC.cat_affiliate_id NOT IN ("bf6f0ae8-9e9f-11e7-80d3-00155d0ae503") 
        ORDER BY  PC.cat_parent ASC';
        $result = $db->prepare($sql);
        $result->execute(); 
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    //просто получаю только названия детей в какой-то категории
    public static function CategoryChildrenSimpleList($cat_affiliate_id) {
        $db = Db::getConnection();
        $sql = 'SELECT DISTINCT cat_name,cat_slug, cat_parent 
        FROM Product_category 
        WHERE cat_affiliate_id = :affiliate_id 
        ORDER BY cat_name ASC';
        $result = $db->prepare($sql);
        $result->bindParam(':affiliate_id',$cat_affiliate_id, PDO::PARAM_STR);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }


    
    // Получаем родительские категории
    public static function CategoriesList($allPodCat) {
        $db = Db::getConnection();
        $sql = 'SELECT * from Product_category where cat_affiliate_id = :affiliate_id and cat_code not in("5cfdb560-3aac-11ea-80ee-00155d0ae503") order by cat_name ASC';
        $result = $db->prepare($sql);
        $result->bindParam(':affiliate_id', $allPodCat, PDO::PARAM_STR);
        $result->execute();
        return $result->fetchAll();
    }
    
    // Получаем самую главную родительскую категорию
    public static function getThisCategory($categorySlug) {
        $db = Db::getConnection();
        $sql = 'SELECT * from Category where cat_slug = :categorySlug';
        $result = $db->prepare($sql);
        $result->bindParam(':categorySlug', $categorySlug, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
    }
    
    //Получаем данные подкатегории
    public static function getChildCategory($cat_slug) {
        $db = Db::getConnection();
        $sql = 'SELECT * from Product_category where cat_slug = :cat_slug';
        $result = $db->prepare($sql);
        $result->bindParam(':cat_slug', $cat_slug, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
    }
    
    // Получаем все статьи
    public static function article() {
        $db = Db::getConnection();
        $result = $db->query('SELECT * from article order by ID DESC limit 6');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetchAll();
    }
    
    // Получаем данные по статье
    public static function atricleOnes($articleSlug) {
        $db = Db::getConnection();
        $result = $db->query("SELECT * from article where article_slug='$articleSlug'");
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }
    
    // Все бренды на странице
    public static function allBrands() {
        $db = Db::getConnection();
        $result = $db->query("SELECT * from Product_brand where brand_logo != '' order by brand_name ASC");
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetchAll();
    }
    
    // Получаем похожие товары
    public static function similarProducts($similarProducts) {
        $db = Db::getConnection();
        $sql = 'SELECT *, "" AS custom_prefix FROM `Product` t WHERE product_category = :product_category and product_image !="[{}]" and product_price !="" ORDER BY RAND() LIMIT 6';
        $result = $db->prepare($sql);
        $result->bindParam(':product_category', $similarProducts, PDO::PARAM_STR);
        $result->execute();  
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as &$product){
            $product['product_site_price'] =$product['product_price'];
            $product['product_price'] = Special::getUserPrice($product);  
        }
        return $rows;
    }
    
    // Получаем похожие товары для кастомных товаров
    public static function similarProductsCustom($similarProducts) {
        $db = Db::getConnection();
        $sql = 'SELECT *, "" AS custom_prefix FROM `ProductCustom` t WHERE product_category = :product_category and product_image !="[{}]" and product_price !="" ORDER BY RAND() LIMIT 6';
        $result = $db->prepare($sql);
        $result->bindParam(':product_category', $similarProducts, PDO::PARAM_STR);
        $result->execute();
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as &$product){
            $product['product_site_price'] =$product['product_price'];
            $product['product_price'] = Special::getUserPrice($product);  
        }
        return $rows;
    }
    public static function getAllBusinessCategories() {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM `BusinessCategory` where categoryParent=""  OR  categoryParent is NULL ORDER BY `order` ASC';
        $result = $db->prepare($sql);
        $result->execute();
        $row =  $result->fetchAll(PDO::FETCH_ASSOC);
        return $row;
    }
    // Получаем похожие товары
    public static function infoCat($catSlug) {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM `BusinessCategory` WHERE categoryChpu = :categoryChpu';
        $result = $db->prepare($sql);
        $result->bindParam(':categoryChpu', $catSlug, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
    }
    
    // Получаем похожие товары
    public static function infoPatentCat($categoryParent) {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM `BusinessCategory` WHERE categoryParent = :categoryParent';
        $result = $db->prepare($sql);
        $result->bindParam(':categoryParent', $categoryParent, PDO::PARAM_STR);
        $result->execute();
        return $result->fetchAll();
    }
    
    // Получаем категории если нет в рекомендуемых товаров
    public static function allParentsCategory($categoryParent) {
        $db = Db::getConnection();
        $sql = 'SELECT cat_code FROM `Product_category` WHERE cat_affiliate_id = :cat_affiliate_id order by rand() limit 4';
        $result = $db->prepare($sql);
        $result->bindParam(':cat_affiliate_id', $categoryParent, PDO::PARAM_STR);
        $result->execute();
        return $result->fetchAll();
    }
    
    // Выгребаем товары на случай если в рекомендуемых нет товаров
    public static function searchNowItems($result, $potrebCount) {
        $db = Db::getConnection();
        $sql = "select id, product_name, product_price, product_part_number, product_image, miz_zakaz, product_warehouse from Product where product_category in ($result) and product_image !='[{}]' and product_price !='' limit $potrebCount";
        $result = $db->prepare($sql);
        $result->execute();
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as &$product){
            $product['product_site_price'] =$product['product_price'];
            $product['product_price'] = Special::getUserPrice($product);  
        }
        return $rows;
    }
    
    // Выгребаем все категории товаров под заказ
    public static function gridCategoryCustom() {
        $db = Db::getConnection();
        $sql = "select * from CategoryCustom where catCode NOT IN ('d4f9a946-4762-11e7-80d2-00155d0ae503', 'fdb34eae-e376-11ea-80f4-00155d0ae503', '18ce6311-1d98-11eb-80f6-00155d0ae503', '2e8815ca-b2b7-11e9-80e8-00155d0ae503', '9e15e537-3ede-11e7-80cc-00155d0ae503', '410264e2-7e29-11ea-80f0-00155d0ae503') order by catName ASC";
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetchAll();
    }
    
    // Получаем ID категории товаров под заказ
    public static function ThisCustomCat($id) {
        $db = Db::getConnection();
        $sql = "select catCode, catName, catTitle, catDescription from CategoryCustom where catSlug = :slug";
        $result = $db->prepare($sql);
        $result->bindParam(':slug', $id, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
    }
    
    // Получаем ID категории для вывода товаров
    public static function CustomCatItems($id) {
        $db = Db::getConnection();
        $sql = "select catCode, catName, catTitle, catDescription from ProductCustomCategory where catSlug = :slug";
        $result = $db->prepare($sql);
        $result->bindParam(':slug', $id, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
    }
    
    // Получаем Все подкатегории родителя заказных товаров
    public static function childCats($id) {
        $db = Db::getConnection();
        $sql = "select * from ProductCustomCategory where catAffiliateId = :id order by catName ASC";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->execute();
        return $result->fetchAll();
    }
    
    // Получаем все товары по коду категории
    public static function items($id) {
        $db = Db::getConnection();
        $sql = "select * from ProductCustom where product_category = :id and product_price > 0 order by product_price ASC ";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->execute();
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as &$product){
            $product['product_site_price'] =$product['product_price'];
            $product['product_price'] = Special::getUserPrice($product);  
        }
        return $rows;
    }
    
    // Получаем текущую кастомную категорию
    public static function pCat($id) {
        $db = Db::getConnection();
        $sql = "select catAffiliateId from ProductCustomCategory where catCode = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->execute();
        return $result->fetchAll();
    }
    
    // Получаем родителя кастомной категории
    public static function globCat($id) {
        $db = Db::getConnection();
        $sql = "select catName, catSlug from CategoryCustom where catCode = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->execute();
        return $result->fetchAll();
    }
    public static function getItemsForBusiness($items) {
        $db = Db::getConnection();
        $sql = "select * from Product where product_part_number in ($items)";
        $result = $db->prepare($sql);
        $result->execute();
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as &$product){
            $product['product_site_price'] =$product['product_price'];
            $product['product_price'] = Special::getUserPrice($product);  
        }
        return $rows;
    }
    
}