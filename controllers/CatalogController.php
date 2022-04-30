<?php
/**
 * Контроллер CatalogController
 * Каталог товаров
 */
class CatalogController {
    
    // Главные родительские категории
    public function actionCategory($id) {
        $thisCategory = Category::getThisCategory($id);
        if($thisCategory != false){
            $title = $thisCategory["cat_title"];
            $description = $thisCategory["cat_description"];
            $categories = Category::CategoriesList($thisCategory["cat_code"]);
            require_once (ROOT . '/views/catalog/category.php');
            return true;
        }
    }
    
    // Категории товаров (сетка)
    public function actionCatmy($id) {
        $thisCat = Product::getPodcategorySlug($id);
        if($thisCat !=false){
            $title = $thisCat["category_title"];
            $description = $thisCat["category_description"];
            $productsListCategory = Product::getProductsListCategory($thisCat["cat_code"]);
            $podcategoryURL = explode('/', $_SERVER['REQUEST_URI']);
            $metaChildCategory = Category::getChildCategory($podcategoryURL[2]);
            $breadCrumbsParent = Product::bossCat($metaChildCategory['cat_affiliate_id']);
            require_once (ROOT . '/views/catalog/catmy.php');
            return true;
        }
    }

    public function actionSpecial() {
        $title = 'МОИ СПЕЦЦЕНЫ';
        $id = User::checkLogged();
        $user = User::getUserById($id);
        $selectINNUser = User::selectINNUser($id);
        $selectSpecialPrice = User::selectSpecialPrice($selectINNUser['ur_inn']);
        $totalItems = SpecialPriceLogic::getProducts();
        $SpecialPrices = Array();
        $selectINNUser = User::selectINNUser($id);
        $selectSpecialPrice = User::selectSpecialPrice($selectINNUser['ur_inn']);
        foreach ($selectSpecialPrice as $next) {
            $code = trim($next['itemPartNumber']);
            $price = trim($next['itemSpecialPrice']);
            if ($code && $price) $SpecialPrices[$code] = $price;
        }
        $specialItems = Special::getProdustsByPartNumbers(array_keys($SpecialPrices));
        $specialCodes = [];
        foreach($selectSpecialPrice  as $codes) {
            $specialCodes[$code] = $codes["itemPartNumber"];
            $code++;
        }
        $filtered_array_of_codes = array_filter($specialCodes,  function($value) { return !is_null($value) && $value !== ''; });            
        $segment = '"'.implode('", "', $filtered_array_of_codes) . '"';
        $allItemsFromCode = Special::allItemsFromCode($segment);
        require_once(ROOT . '/views/catalog/special-catalog.php');
        return true;

    }
    
    // Сетка статей
    public function actionArticle() {
        $thisCat = 'Новости | Интернет магазин Lider-gk24.ru';
        $title = 'Полезные статьи от компании Лидер';
        $aticle = Category::article();
        require_once (ROOT . '/views/catalog/article.php');
        return true;
    }
    
    // Вывод одной статьи
    public function actionOne() {
        
        $searchSlugArt = explode('/', $_SERVER['REQUEST_URI']);
        $atricleOnes = Category::atricleOnes($searchSlugArt[2]);
        $description = $atricleOnes['article_description'];
        $title = $atricleOnes['article_title'];
        require_once (ROOT . '/views/catalog/one.php');
        return true;
    }
    
    // Сетка категорий заказных позиций
    public function actionCustom() {
        
        $title = 'Заказные позиции';
        
        $description = 'Заказные позиции компании Лидер';
        
        $gridCategoryCustom = Category::gridCategoryCustom();
        
        require_once (ROOT . '/views/site/Custom/Custom.php');
        return true;
    }  
    
    // Категория заказных позиций
    public function actionIs() {
        
        $rout = explode('/', $_SERVER['REQUEST_URI']);
        
        $cats = Category::ThisCustomCat($rout[2]);
        
        $childCats = Category::childCats($cats["catCode"]);
        
        if ( $childCats != NULL ) {
            
            $title = $cats['catTitle'];
            
            $description = $cats['catDescription'];
            
            require_once (ROOT . '/views/site/Custom/CustomCat.php');
            
        } else {
            
            $codeCat = Category::CustomCatItems($rout[2]);
            
            $title = $codeCat['catTitle'];
            
            $description = $codeCat['catDescription'];
            
            $parentCat = Category::pCat($codeCat["catCode"]);
            
            $globCat = Category::globCat($parentCat[0]["catAffiliateId"]);
          
            $items = Category::items($codeCat["catCode"]);
            
            require_once (ROOT . '/views/site/Custom/GridItemsCustom.php');
            
        }
        
        return true;
    }  
}