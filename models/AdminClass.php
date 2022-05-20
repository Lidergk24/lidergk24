<?php

/**
 * Класс AdminClass - модель для работы с административной панелью администратора
 */
 
class AdminClass
{
    // Получаем общее количество заказов за все время
    public static function totalOrders()
    {
        $db = Db::getConnection();
        $sth = $db->prepare("select count(id) from product_order");
        $sth->execute();
        $allOrders = $sth->fetch(PDO::FETCH_COLUMN);
        return $allOrders;
    }
    
    // Количество клиентов зарегистрированных сегодня
    public static function newClientsToday()
    {
        $db = Db::getConnection();
        $thisDate = date('d.m.Y');
        $sth = $db->prepare("SELECT * FROM `user` where registration_date ='$thisDate'");
        $sth->execute();
        $allUsers = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $allUsers;
    }
    
    // Количество клиентов зарегистрированных сегодня
    public static function allrules()
    {
        $db = Db::getConnection();
        $sth = $db->prepare("select * from cart_rules inner join Product on cart_rules.item_rules = Product.product_part_number");
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    // Общая сумма всех заказов за все время
    public static function AllSummOrders()
    {
        $db = Db::getConnection();
        $sth = $db->prepare("SELECT SUM(order_summ) FROM product_order");
        $sth->execute();
        $AllSummOrders = $sth->fetch(PDO::FETCH_COLUMN);
        return $AllSummOrders;
    }
    
    // Общая сумма заказов за сегодня
    public static function SummOrdersToday()
    {
        $db = Db::getConnection();
        $dateToday = date('Y-m-d');
        $sth = $db->prepare("SELECT SUM(order_summ) FROM product_order where date like '%$dateToday%'");
        $sth->execute();
        $SummOrdersToday = $sth->fetch(PDO::FETCH_COLUMN);
        return $SummOrdersToday;
    }
    
    // Количество заказов сегодня
    public static function countOrdersToday()
    {
        $db = Db::getConnection();
        $dateToday = date('Y-m-d');
        $sth = $db->prepare("SELECT count(id) FROM product_order where date like '%$dateToday%'");
        $sth->execute();
        $countOrdersToday = $sth->fetch(PDO::FETCH_COLUMN);
        return $countOrdersToday;
    }
    
    // Количество заказов за вчера
    public static function countOrdersYesterday()
    {
        $db = Db::getConnection();
        $dateYesterday = date("Y-m-d", mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')));
        $sth = $db->prepare("SELECT count(id) FROM product_order where date like '%$dateYesterday%'");
        $sth->execute();
        $countOrdersYesterday = $sth->fetch(PDO::FETCH_COLUMN);
        return $countOrdersYesterday;
    }
    
    // Заказов за неделю
    public static function countOrdersWeek()
    {
        $paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
        $params = include($paramsPath);
        $con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
        $countOrdersWeek = mysqli_query($con, "SELECT * FROM product_order WHERE date >= DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 7 DAY)");
        return $countOrdersWeek;
    }
    
    // Заносим статью
    public static function insertArticle($articleName, $articleTitle, $articleDescription,  $articleText, $article_image, $articleSlug)
    {
        $db = Db::getConnection();
        $sql = 'INSERT INTO article (article_name, article_title, article_description, article_text, article_image, article_slug) '
                . 'VALUES (:article_name, :article_title, :article_description, :article_text, :article_image, :article_slug)';
        $result = $db->prepare($sql);
        $result->bindParam(':article_name', $articleName, PDO::PARAM_STR);
        $result->bindParam(':article_title', $articleTitle, PDO::PARAM_STR);
        $result->bindParam(':article_description', $articleDescription, PDO::PARAM_STR);
        $result->bindParam(':article_text', $articleText, PDO::PARAM_STR);
        $result->bindParam(':article_image', $article_image, PDO::PARAM_STR);
        $result->bindParam(':article_slug', $articleSlug, PDO::PARAM_STR);
        return $result->execute();
    } 
    
    // Парсим страну
    public static function getCountry($prodId){
        
        
        $paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
        $params = include($paramsPath);
        $con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
        $cntry = mysqli_query($con, "SELECT `product_atributs` FROM `Product` WHERE `product_part_number` = {$prod}");
        return json_encode($cntry[0]);
        
        /*$db = Db::getConnection();
        $sql = "SELECT `product_atributs` FROM `Product` WHERE `product_part_number` = :prod_id";
        $result = $db->prepare($sql);
        $result->bindParam(':prod_id', $prodId, PDO::PARAM_STR);
        $result->execute();
        $attrs = $result->fetchAll(PDO::FETCH_NUM);
        foreach($attrs as $country) {
            if(strripos($country, '400f93f4-8697-11e9-80e2-00155d0ae503'))
                return $country[0];
        }*/
        //return $attrs[0][0];
    }
    
    // Парсим картинки товаров
    public static function parsePics($pcode) {
        $db = Db::getConnection();
        $sql = "SELECT `product_image` FROM `Product` WHERE `product_part_number` = :pcode";
        $result = $db->prepare($sql);
        $result->bindParam(':pcode', $pcode, PDO::PARAM_STR);
        $result->execute();
        $pic = $result->fetchAll(PDO::FETCH_NUM);
    
        return mb_substr($pic[0][0], 7, -3);
    }
    
    // Формируем данные для фида категории
    public static function getFidByCatId($catId) : ?array {
        $db = Db::getConnection();
        $sql = "SELECT * FROM `Product` WHERE `product_category` = :category_code";
        $result = $db->prepare($sql);
        $result->bindParam(':category_code', $catId, PDO::PARAM_STR);
        $result->execute();
        $catData = $result->fetchAll(PDO::FETCH_ASSOC);
        return $catData;
    }
    
    // Формируем данные для фида всего каталога
    public static function getFidByAllCatalog() : ?array {
        $db = Db::getConnection();
        $sql = "SELECT * FROM `Product`";
        $result = $db->prepare($sql);
        $result->execute();
        $catData = $result->fetchAll(PDO::FETCH_ASSOC);
        return $catData;
    }
    
    
    // Заносим фид
    public static function insertFid($productCode)
    {
        $pic = explode('"', static::parsePics($productCode))[0];
        $img = "https://lider-gk24.ru/upload/{$pic}";
        //$cntry = static::getCountry($productCode);
        self::DeleteFid($productCode);
        $db = Db::getConnection();
        $sql = "INSERT INTO `fids` (`prod_id`,  `category_stat`, `categoryId`, `name`, `vendor`, `url`, `picture`, `price`, `country_of_origin`, `sales_notes`, `min_quantity`, `fid_saving_url`) SELECT :product_code, 1, `product_category`, `product_name`, `product_brand`, 'https:\/\/lider.ru\/product\/:product_code', :img, `product_price`, '', 'При заказе на сумму от 5000 рублей - бесплатная доставка!', `miz_zakaz`, 'NULL' FROM `Product` WHERE `product_part_number` = :product_code";
        $result = $db->prepare($sql);
        $result->bindParam(':product_code', $productCode, PDO::PARAM_STR);
        $result->bindParam(':img', $img, PDO::PARAM_STR);
        //$result->bindParam(':country', $cntry, PDO::PARAM_STR);
        return $result->execute();
    } 
    
    // Заносим фид категории
    public static function insertCatFid($catCode)
    {
        $cdata = static::getFidByCatId($catCode);
        $sql = 'INSERT INTO `fids` (`prod_id`, `category_stat`, `categoryId`, `name`, `vendor`, `url`, `picture`, `price`, `country_of_origin`, `sales_notes`, `min_quantity`, `fid_saving_url`) VALUES ';
        foreach($cdata as $key => $prod) {
            //foreach($prod as $key => $val) {
                $img = explode('/', explode('"', mb_substr($prod['product_image'], 7, -3))[0])[1] . '/' . explode('/', explode('"', mb_substr($prod['product_image'], 7, -3))[0])[2];
                $sql .= "('{$prod['product_part_number']}', 2, '{$prod['product_category']}', '{$prod['product_name']}', '{$prod['product_brand']}', '{$prod['product_slug']}', '{$img}', {$prod['product_price']}, 'NULL', 'При заказе на сумму от 5000 рублей - бесплатная доставка!', {$prod['miz_zakaz']}, 'NULL'), ";
                unset($img);
            //}
        }
        $sql = substr($sql, 0, -2);
        var_dump($sql);
        self::DeleteCatFid($catCode);
        $db = Db::getConnection();
        //$sql = "INSERT INTO `fids` (`prod_id`, `category_stat`, `categoryId`, `name`, `vendor`, `url`, `picture`, `price`, `country_of_origin`, `sales_notes`, `min_quantity`, `fid_saving_url`) SELECT `product_code`, true, `product_category`, `product_name`, `product_brand`, 'https:\/\/lider.ru\/product\/', 'img', `product_price`, 'country', 'При заказе на сумму от 5000 рублей - бесплатная доставка!', `miz_zakaz`, 'NULL' FROM `Product` WHERE `product_category` = :category_code";
        $result = $db->prepare($sql);
        //$result->bindParam(':category_code', $catCode, PDO::PARAM_STR);
        //var_dump($sql);
        //$result->bindParam(':img', $img, PDO::PARAM_STR);
        //$result->bindParam(':country', $cntry, PDO::PARAM_STR);
        return $result->execute();
    } 
    
    // Заносим фид категории
    public static function insertAllFid()
    {
        $cdata = static::getFidByAllCatalog();

        $sql = 'INSERT INTO `fids` (`prod_id`, `category_stat`, `categoryId`, `name`, `vendor`, `url`, `picture`, `price`, `country_of_origin`, `sales_notes`, `min_quantity`, `fid_saving_url`) VALUES ';
        foreach($cdata as $key => $prod) {
            //foreach($prod as $key => $val) {
                $img = explode('/', explode('"', mb_substr($prod['product_image'], 7, -3))[0])[1] . '/' . explode('/', explode('"', mb_substr($prod['product_image'], 7, -3))[0])[2];
                $sql .= "('{$prod['product_part_number']}', 3, '{$prod['product_category']}', '{$prod['product_name']}', '{$prod['product_brand']}', '{$prod['product_slug']}', '{$img}', {$prod['product_price']}, 'NULL', 'При заказе на сумму от 5000 рублей - бесплатная доставка!', {$prod['miz_zakaz']}, 'NULL'), ";
                unset($img);
            //}
        }
        $sql = substr($sql, 0, -2);
        var_dump($sql);
        self::DeleteAllFid();
        $db = Db::getConnection();
        //$sql = "INSERT INTO `fids` (`prod_id`, `category_stat`, `categoryId`, `name`, `vendor`, `url`, `picture`, `price`, `country_of_origin`, `sales_notes`, `min_quantity`, `fid_saving_url`) SELECT `product_code`, true, `product_category`, `product_name`, `product_brand`, 'https:\/\/lider.ru\/product\/', 'img', `product_price`, 'country', 'При заказе на сумму от 5000 рублей - бесплатная доставка!', `miz_zakaz`, 'NULL' FROM `Product` WHERE `product_category` = :category_code";
        $result = $db->prepare($sql);
        //$result->bindParam(':category_code', $catCode, PDO::PARAM_STR);
        //var_dump($sql);
        //$result->bindParam(':img', $img, PDO::PARAM_STR);
        //$result->bindParam(':country', $cntry, PDO::PARAM_STR);
        return $result->execute();
    } 
    
    // Редактирование статьи
    public static function updateArticle($articleName, $articleTitle, $articleDescription,  $articleText, $article_image, $id)
    {
        $db = Db::getConnection();
        $sql = "UPDATE article SET article_name = :article_name,  article_title = :article_title, article_description = :article_description, article_text = :article_text, article_image = :article_image where id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':article_name', $articleName, PDO::PARAM_STR);
        $result->bindParam(':article_title', $articleTitle, PDO::PARAM_STR);
        $result->bindParam(':article_description', $articleDescription, PDO::PARAM_STR);
        $result->bindParam(':article_text', $articleText, PDO::PARAM_STR);
        $result->bindParam(':article_image', $article_image, PDO::PARAM_STR);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    } 
    
    // Получаем все статьи
    public static function allArticles()
    {
        $paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
        $params = include($paramsPath);
        $con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
        $articles = mysqli_query($con, "SELECT * FROM article order by id DESC");
        return $articles;
    } 
    
    // Всего клиентов
    public static function allClients()
    {
        $db = Db::getConnection();
        $sth = $db->prepare("SELECT * FROM `user` order by id desc limit 20");
        $sth->execute();
        $allUsers = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $allUsers;
    }
    
    // Получение товаров по подстроке (поиск)
    public static function getProductsBySubstring($search)
    {
        try {
            $db = Db::getConnection();
            $sql = "SELECT id, product_name FROM `Product` WHERE `product_name` LIKE :search";
            $sth = $db->prepare($sql);
            $sth->bindParam(':search', $search, PDO::PARAM_STR);
            $sth->execute();
            $searchRes = '';
            $searchRes = $sth->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($searchRes);
            /*$paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
            $params = include($paramsPath);
            $con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
            $products = mysqli_query($con, "SELECT * FROM `Product` WHERE `product_name` LIKE $search");
            return $products;*/
        } catch (Throwable $t){
            print "Application called exception: { $t->getMessage(); }";
        }
    }
    
    // Получаем все фиды
    public static function allFids()
    {
        try {
            $paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
            $params = include($paramsPath);
            $con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
            $fids = mysqli_query($con, "SELECT prod_id, category_stat, name FROM fids WHERE category_stat = false ORDER BY `id` ASC");
            $catfids = mysqli_query($con, "SELECT DISTINCT f.`categoryId`, pc.`cat_name` FROM `fids` f JOIN `Product_category` pc ON f.`categoryId`=pc.`cat_code` WHERE f.`category_stat` = true  ORDER BY `id` ASC ");
            $allfids = ['fids' => $fids, 'catfids' => $catfids];
            //var_dump($fids);
            return $allfids;
        }
        catch (Throwable $t) {
            print "Application called exception: { $t->getMessage() }";
        }
    } 
    
    // Добавление менеджера в базу
    public static function addManager($name_manager, $phone_manager, $dob_manager, $email_manager)
    {
        $db = Db::getConnection();
        $sql = 'INSERT INTO Manager (manager_name, manager_phone, manager_flag, manager_email) '
                . 'VALUES (:manager_name, :manager_phone, :manager_flag, :manager_email)';
        $result = $db->prepare($sql);
        $result->bindParam(':manager_name', $name_manager, PDO::PARAM_STR);
        $result->bindParam(':manager_phone', $phone_manager, PDO::PARAM_STR);
        $result->bindParam(':manager_flag', $dob_manager, PDO::PARAM_STR);
        $result->bindParam(':manager_email', $email_manager, PDO::PARAM_STR);
        return $result->execute();
    } 
    
    // Отображение всех менеджеров на странице
    public static function managers()
    {
        $db = Db::getConnection();
        $sth = $db->prepare("SELECT * FROM `Manager`");
        $sth->execute();
        $allUsers = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $allUsers;
    }
    
    // Добавление правила в базу
    public static function cart_rules($name_rules, $rules_select, $count_rules, $form_procent, $form_rub)
    {
        $db = Db::getConnection();
        $sql = 'INSERT INTO cart_rules (item_rules, conditions_rules, count_rules, procent_rules, rub_rules) '
                . 'VALUES (:item_rules, :conditions_rules, :count_rules, :procent_rules, :rub_rules)';
        $result = $db->prepare($sql);
        $result->bindParam(':item_rules', $name_rules, PDO::PARAM_STR);
        $result->bindParam(':conditions_rules', $rules_select, PDO::PARAM_STR);
        $result->bindParam(':count_rules', $count_rules, PDO::PARAM_STR);
        $result->bindParam(':procent_rules', $form_procent, PDO::PARAM_STR);
        $result->bindParam(':rub_rules', $form_rub, PDO::PARAM_STR);
        return $result->execute();
    } 
    //get last group discount number and increment by one 
    public static function getLastGroupDiscountNumber() 
    {
        $db = Db::getConnection();
        $sql = 'SELECT MAX(discount_group) FROM cart_rules';
        $result = $db->prepare($sql);
        $result->execute();
        $lastMaxNum =  $result->fetchAll(PDO::FETCH_ASSOC);
        return $lastMaxNum++;
    }
    
    /**
     * Get all filters for product categories
     * 
     * @return all filters array
     */
    public static function getAllCatFilters($cat) : ?array
    {
        try {
            $db = Db::getConnection();
            $sql = 'SELECT cf.*, pa.attribute_name FROM cat_filters cf join product_attributes pa ON cf.attribute_id = pa.id WHERE cf.cat_id = :cat_id ORDER BY pa.`attribute_name` ASC';
            $result = $db->prepare($sql);
            $result->bindParam(':cat_id', $cat, PDO::PARAM_STR);
            $result->execute();
            $filters = $result->fetchAll(PDO::FETCH_ASSOC);
            return $filters;
        }
        catch (Throwable $t) { die("Application called exception: { $t->getMessage(); }"); }
    }

     /**
     * Get enabled filters for product categories
     * 
     * @param $cat is single cat indenify
     * @return filter's status array
     */
    public static function getEnabledCatFilters($cat) : ?array
    {
        try {
            $db = Db::getConnection();
            //var_dump($_POST['filters']);
            $sql = 'SELECT * FROM cat_filters WHERE `cat_id` = :cat ORDER BY `order` ASC'; //'SELECT cf.cat_id, cf.attribute_id, cf.enabled FROM cat_filters cf JOIN Category c ON cf.cat_id=c.id WHERE c.cat_code = :cat';
            // SELECT cf.*, pa.attribute_name FROM cat_filters cf join product_attributes pa ON cf.attribute_id = pa.id WHERE cf.cat_id = 1 ORDER BY cf.`order` DESC
            $result = $db->prepare($sql);
            $result->bindParam(':cat', $cat, PDO::PARAM_STR);
            $result->execute();
            //$filters = $result->fetchAll(PDO::FETCH_ORI_ABS);
            $filters = [];
            foreach($result->fetchAll(PDO::FETCH_ASSOC) as $attr)
                $filters['status'][$attr['attribute_id']] = $attr['enabled'];
                if (!isset($filters['cat_id'])) $filters['cat_id'] = $attr['cat_id'];
            return $filters;
        }
        catch (Throwable $t) { die ("Application called exception: { $t->getMessage(); }"); }
    }

    /**
     *  Set filter configuration for categories
     * 
     * @property integer $cat_id
     * @property integer $attribute_id
     * @property integer $order
     * @property integer $enabled
     * 
     * @param array $attrFlts list of attribute statuses that need to be saved
     */
    public static function setCatFiltersStats(array $attrFlts)
    {
        try 
        {
            $db = Db::getConnection();
            $sql = '';
            foreach ($attrFlts as $catfilter) {
                /*var_dump($catfilter[enabled]);*/
                $sql .= "UPDATE cat_filters SET `order` = :order, `enabled` = :enabled where `cat_id` = :cat_id and `attribute_id` = :attribute_id;"; 
                $updt = $db->prepare($sql);
                $updt->bindParam(':cat_id', $catfilter[cat], PDO::PARAM_INT);
                $updt->bindParam(':attribute_id', $catfilter[filter], PDO::PARAM_INT);
                $updt->bindParam(':order', $catfilter[order], PDO::PARAM_INT);
                $updt->bindParam(':enabled', $catfilter[enabled], PDO::PARAM_INT);
                $res = $updt->execute();
                //echo $res;
            }
            //var_dump($sql);
            
        }
        catch (Throwable $t) {
            print "Application called exception: {$t->getMessage()}";
        }
    }
    
     /**
     *  Set filter configuration for categories
     * 
     * @property integer $cat_id
     * @property integer $attribute_id
     * @property integer $order
     * @property integer $enabled
     * 
     * @param array $attrFlts list of attribute statuses that need to be saved
     */
    public static function setCatFiltersStatsMSI(array $attrFlts)
    {
        try 
        {
            $paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
            $params = include($paramsPath);
            $con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
            $sql = '';
            foreach ($attrFlts as $catfilter) {
                /*var_dump($catfilter[enabled]);*/
                $sql .= "UPDATE cat_filters SET `order` = $catfilter[order], `enabled` = $catfilter[enabled] where `cat_id` = $catfilter[cat] and `attribute_id` = $catfilter[filter];"; 
                //echo $sql . '<br />';
            }
            $res = mysqli_query($con, $sql);
            echo $res;
        }
        catch (Throwable $t) {
            print "Application called exception: {$t->getMessage()}";
        }
    }

    /**
     * Get idenify of category by cat_code
     * 
     * @return integer id
     */
    public static function getCatIdByGUID($guid) : ?string
    {
        try 
        {
            $db = Db::getConnection();
            $sql = 'SELECT distinct id FROM Category WHERE cat_code =:guid'; 
            $result = $db->prepare($sql);
            $result->bindParam(':guid', $guid, PDO::PARAM_STR);
            $result->execute();
            $id = $result->fetch(PDO::FETCH_NUM);
            return $id[0];
        }
        catch (Throwable $t) {
            print "Application called exception: {$t->getMessage()}";
        }
    }
    
    public static function makeNewDiscountGroup($grop, $subgroup, $part_num, $amount, $condition, $percent, $rubles ) {
        $db = Db::getConnection();
        $sql = 'INSERT INTO cart_rules (item_rules, conditions_rules, count_rules, procent_rules, rub_rules, discount_group, discount_group_side) '
                . 'VALUES (:part_num, :conditions_rules, :count_rules, :procent_rules, :rub_rules, :discount_group, :discount_group_side)';
        $result = $db->prepare($sql);
        $result->bindParam(':part_num', $part_num, PDO::PARAM_STR);
        $result->bindParam(':conditions_rules',  $condition, PDO::PARAM_STR);
        $result->bindParam(':count_rules', $amount, PDO::PARAM_STR);
        $result->bindParam(':procent_rules',$percent, PDO::PARAM_STR);
        $result->bindParam(':rub_rules', $rubles, PDO::PARAM_STR);
        $result->bindParam(':discount_group', $grop,  PDO::PARAM_STR);
        $result->bindParam(':discount_group_side', $subgroup, PDO::PARAM_STR);
        return $result->execute();
    }
    
    public static function getDiscountGroups() {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM cart_rules WHERE discount_group iS NOT NULL';
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Удаляем конкретную статью по ее id
    public static function getByBookrequest($id) {
        $db = Db::getConnection();
        $sql = "DELETE FROM article WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }
    
    // Удаляем фид по prod_id
    public static function DeleteFid($prod_id) {
        unlink($_SERVER['DOCUMENT_ROOT']."/upload/fids/fid__{$prod_id}.yml");
        //if((unlink($_SERVER['DOCUMENT_ROOT']."/upload/fids/fid__{$prod_id}.yml") === true) xor (file_exists($_SERVER['DOCUMENT_ROOT']."/upload/fids/fid__{$prod_id}.yml") === false)) {
            $db = Db::getConnection();
            $sql = "DELETE FROM `fids` WHERE `prod_id`=:prod_id and category_stat=1";
            $result = $db->prepare($sql);
            $result->bindParam(':prod_id', $prod_id, PDO::PARAM_STR);
            return $result->execute();
        //} else echo "/upload/fids/fid__{$prod_id}.yml - не удалён!";
    }
    
    // Удаляем фид по cat_id
    public static function DeleteCatFid($cat_id) {
        if(unlink($_SERVER['DOCUMENT_ROOT']."/upload/fids/fid__{$cat_id}.yml") === true) {
            $db = Db::getConnection();
            $sql = "DELETE FROM `fids` WHERE `categoryId`=:cat_id and category_stat=2";
            $result = $db->prepare($sql);
            $result->bindParam(':cat_id', $cat_id, PDO::PARAM_STR);
            return $result->execute();
        } else echo "/upload/fids/fid__{$cat_id}.yml - не удалён!";
    }
    
    // Удаляем фид всего каталога
    public static function DeleteAllFid() {
        if(unlink($_SERVER['DOCUMENT_ROOT']."/upload/fids/fid__all.yml") === true) {
            $db = Db::getConnection();
            $sql = "DELETE FROM `fids` WHERE category_stat=3";
            $result = $db->prepare($sql);
            return $result->execute();
        } else echo "/upload/fids/fid__all.yml - не удалён!";
    }
    
    // Удаляем правило корзины
    public static function rulDelete($id) {
        $db = Db::getConnection();
        $sql = "DELETE FROM cart_rules WHERE item_rules = :item_rules";
        $result = $db->prepare($sql);
        $result->bindParam(':item_rules', $id, PDO::PARAM_STR);
        $one = $result->execute();
        return $one;
    }
    
    // Отображение всех менеджеров на странице
    public static function getByBookEdit($id)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * from article where id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
    }
    
    // Выбираем все юридические лица
    public static function allProfileUr()
    {
        $db = Db::getConnection();
        $sql = 'SELECT * from user_ur order by id DESC limit 15';
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetchAll();
    }
    
    //Выбираем все заказы по конкретному профилю
    public static function allOrderByProfileAdmin($user_phone)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * from product_order where user_phone = :user_phone';
        $result = $db->prepare($sql);
        $result->bindParam(':user_phone', $user_phone, PDO::PARAM_STR);
        $result->execute();
        return $result->fetchAll();
    }
    
    // Выбираем все юридические лица
    public static function allProfileFiz()
    {
        $db = Db::getConnection();
        $sql = 'SELECT * from user_fiz limit 5';
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetchAll();
    }
    
    // Получаем список всех операторов
    public static function operatorBase()
    {
        $db = Db::getConnection();
        $sth = $db->prepare("SELECT * FROM `Operator` order by operator_name ASC");
        $sth->execute();
        $operatorBase = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $operatorBase;
    }
    public static function deleteOperator($id)
    {
        $db = Db::getConnection();
        $sth = $db->prepare("delete FROM `Operator` where id = :id");
        $sth->bindParam('id',$id, PDO::PARAM_STR);
        return  $sth->execute();
    }

    public static function addOperator($name, $phone, $dob, $email)
    {
        $db = Db::getConnection();
        $sth = $db->prepare("INSERT INTO `Operator` (operator_name, operator_phone, operator_email, operator_dob)"
        . "VALUES(:name,:phone,:email,:dob)");
        $sth->bindParam(':name',$name, PDO::PARAM_STR);
        $sth->bindParam(':phone',$phone, PDO::PARAM_STR);
        $sth->bindParam(':dob',$dob, PDO::PARAM_STR);
        $sth->bindParam(':email',$email, PDO::PARAM_STR);
        return  $sth->execute();
    }


    
    // Получаем список всех менеджеров
    public static function managerBase()
    {
        $db = Db::getConnection();
        $sth = $db->prepare("SELECT * FROM `Manager` order by manager_name ASC");
        $sth->execute();
        $operatorBase = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $operatorBase;
    }
    
    // Добавление банера в базу
    public static function insertBaner($banerName, $banerLink, $banerNames, $type)
    {
        $db = Db::getConnection();
        $sql = 'INSERT INTO banners (banner_title, banner_link, banner_image, banner_type) '
                . 'VALUES (:banner_title, :banner_link, :banner_image, :banner_type)';
        $result = $db->prepare($sql);
        $result->bindParam(':banner_title', $banerName, PDO::PARAM_STR);
        $result->bindParam(':banner_link', $banerLink, PDO::PARAM_STR);
        $result->bindParam(':banner_image', $banerNames, PDO::PARAM_STR);
        $result->bindParam(':banner_type', $type, PDO::PARAM_STR);
        return $result->execute();
    }

    // Получаем все банеры
    public static function allBanner()
    {
        $db = Db::getConnection();
        $sth = $db->prepare("SELECT * FROM `banners` where banner_type = '1'");
        $sth->execute();
        $allbaner = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $allbaner;
    }
    
    // Обновление порядкового номера ортировки банера
    public static function sortBanersThis($id, $banner_position)
    {
        $db = Db::getConnection();
        $sql = "UPDATE banners SET banner_position = :banner_position where id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':banner_position', $banner_position, PDO::PARAM_STR);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    } 
    
    // Обновление порядкового номера акции
    public static function sortSales($id, $banner_position)
    {
        $db = Db::getConnection();
        $sql = "UPDATE sales SET sale_position = :sale_position where id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':sale_position', $banner_position, PDO::PARAM_STR);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }
    
    // Удаляем банер
    public static function deleteBanersIdsfunction($id) {
        $db = Db::getConnection();
        $sql = "DELETE FROM banners WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }
    
    // Удаляем акцию
    public static function deleteSales($id) {
        $db = Db::getConnection();
        $sql = "DELETE FROM sales WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }
    
    // Добавляем акцию
    public static function insertSale($banerName, $saleText, $banerNames) {
        $db = Db::getConnection();
        $sql = 'INSERT INTO sales (sale_name, sale_text, sale_images) '
                . 'VALUES (:sale_name, :sale_text, :sale_images)';
        $result = $db->prepare($sql);
        $result->bindParam(':sale_name', $banerName, PDO::PARAM_STR);
        $result->bindParam(':sale_text', $saleText, PDO::PARAM_STR);
        $result->bindParam(':sale_images', $banerNames, PDO::PARAM_STR);
        return $result->execute();
    }
    
    // Получаем все акции
    public static function allSales()
    {
        $db = Db::getConnection();
        $sth = $db->prepare("SELECT * FROM `sales`");
        $sth->execute();
        $allSales = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $allSales;
       
    }
    
    // Обновление акции
    public static function thisSales($saleId, $banerName, $saleText, $banerNames)
    {
        $db = Db::getConnection();
        $sql = "UPDATE sales SET sale_name = :sale_name, sale_text = :sale_text, sale_images = :sale_images where id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':sale_name', $banerName, PDO::PARAM_STR);
        $result->bindParam(':sale_text', $saleText, PDO::PARAM_STR);
        $result->bindParam(':sale_images', $banerNames, PDO::PARAM_STR);
        $result->bindParam(':id', $saleId, PDO::PARAM_INT);
        return $result->execute();
    } 
    
    // Получаем все акции
    public static function getBySaleEdit($id)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * from sales where id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
       
    }
    
    // Добавляем купон
    public static function addCoupon($couponName, $couponProcent, $couponSumm, $couponActivate, $couponUser, $dateCoupon) {
        $db = Db::getConnection();
        $sql = 'INSERT INTO coupon (coupon_name, coupon_procent, coupon_summ, coupon_activate, coupon_user_id, coupon_time) '
                . 'VALUES (:coupon_name, :coupon_procent, :coupon_summ, :couponactivate, :coupon_user_id, :coupon_time)';
        $result = $db->prepare($sql);
        $result->bindParam(':coupon_name', $couponName, PDO::PARAM_STR);
        $result->bindParam(':coupon_procent', $couponProcent, PDO::PARAM_INT);
        $result->bindParam(':coupon_summ', $couponSumm, PDO::PARAM_INT);
        $result->bindParam(':couponactivate', $couponActivate, PDO::PARAM_INT);
        $result->bindParam(':coupon_user_id', $couponUser, PDO::PARAM_STR);
        $result->bindParam(':coupon_time', $dateCoupon, PDO::PARAM_STR);

        return $result->execute();
    }
    
    
    public static function testCoupon($testCoupon)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * from coupon where coupon_name = :testCoupon';
        $result = $db->prepare($sql);
        $result->bindParam(':testCoupon', $testCoupon, PDO::PARAM_STR);
        $result->execute();
        return $result->fetchAll();
        
    }
    
    // Выводим все купоны
    public static function allCoupons()
    {
        $db = Db::getConnection();
        $sql = 'SELECT * from coupon';
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetchAll();
        
    }
    
    // Выводим все купоны
    public static function  deleteCoupons($id)
    {
        $db = Db::getConnection();
        $sql = "DELETE FROM coupon WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
        
    }
    
    // Получаем все по профилю
    public static function allInfprmByProfile($ur_phone)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * from user_ur where ur_phone = :ur_phone';
        $result = $db->prepare($sql);
        $result->bindParam(':ur_phone', $ur_phone, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
        
    }
        
    // Обновление акции
    public static function updateHits($re, $dateHits)
    {
        $paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
        $params = include($paramsPath);
        $con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 

        $insert = mysqli_query($con, 'UPDATE ProductHits SET product_part_number="'.$re.'", timeAddHit="'.$dateHits.'"');
    } 
    
    // Обновление акции
    public static function updateSale($result, $dateSale)
    {
        $paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
        $params = include($paramsPath);
        $con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 

        mysqli_query($con, 'UPDATE ProductSale SET product_part_number="'.$result.'", saleDate="'.$dateSale.'"');
    } 
   
    // Получаем все по профилю
    public static function allParentCategory()
    {
        $db = Db::getConnection();
        $sql = 'SELECT * from Category order by cat_name ASC';
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetchAll();
        
    }
    
    // Получаем все по профилю
    public static function infoSubcat($cat_affiliate_id)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * from Product_category where cat_affiliate_id = :cat_affiliate_id order by cat_name ASC';
        $result = $db->prepare($sql);
        $result->bindParam(':cat_affiliate_id', $cat_affiliate_id, PDO::PARAM_STR);
        $result->execute();
        return $result->fetchAll();
        
    }
    
    // Получаем все по категории
    public static function infoEndCat($infoEndcat)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * from Product_category where cat_code = :cat_code';
        $result = $db->prepare($sql);
        $result->bindParam(':cat_code', $infoEndcat, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
        
    }
    
    // Обновление мета категории
    public static function updateEndCategory($titleCategory, $descriptionCategory, $h1Category, $textCategory, $fileIcons, $cat_code, $imageCategory)
    {
        $db = Db::getConnection();
        $sql = "UPDATE Product_category SET category_title = :category_title, category_description = :category_description, cat_h1 = :cat_h, cat_desc = :cat_desc, cat_icon = :cat_icon, category_image = :category_image where cat_code = :cat_code";
        $result = $db->prepare($sql);
        $result->bindParam(':category_title', $titleCategory, PDO::PARAM_STR);
        $result->bindParam(':category_description', $descriptionCategory, PDO::PARAM_STR);
        $result->bindParam(':cat_h', $h1Category, PDO::PARAM_STR);
        $result->bindParam(':cat_desc', $textCategory, PDO::PARAM_STR);
        $result->bindParam(':cat_icon', $fileIcons, PDO::PARAM_STR);
        $result->bindParam(':cat_code', $cat_code, PDO::PARAM_STR);
        $result->bindParam(':category_image', $imageCategory, PDO::PARAM_STR);
        return $result->execute();
    } 
    
    // Получаем все по категории
    public static function metaCat($metaCatInfo)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * from Category where cat_code = :cat_code';
        $result = $db->prepare($sql);
        $result->bindParam(':cat_code', $metaCatInfo, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
        
    }
    
    // Обновляем мета данные главной категории
    public static function updateMetaCategory($titleCategory, $descriptionCategory, $hCategory, $textCategory, $cat_code)
    {
        $db = Db::getConnection();
        $sql = "UPDATE Category SET cat_title = :cat_title, cat_description = :cat_description, cat_desc = :cat_desc, cat_h1 = :cat_h where cat_code = :cat_code";
        $result = $db->prepare($sql);
        $result->bindParam(':cat_title', $titleCategory, PDO::PARAM_STR);
        $result->bindParam(':cat_description', $descriptionCategory, PDO::PARAM_STR);
        $result->bindParam(':cat_desc', $textCategory, PDO::PARAM_STR);
        $result->bindParam(':cat_h', $hCategory, PDO::PARAM_STR);
        $result->bindParam(':cat_code', $cat_code, PDO::PARAM_STR);
        return $result->execute();
    } 
    
    // Получаем все по категории
    public static function lastOrdersByAdmin()
    {
        $db = Db::getConnection();
        $sql = 'SELECT * from product_order order by order_number DESC limit 10';
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetchAll();
        
    }
    public static function renewOrderOfBusinessCategories($id, $order, $title, $description) {
        $db = Db::getConnection();
        $sql = 'UPDATE BusinessCategory SET `order` = :order, `categoryTitle` = :title, `categoryDescription` = :categoryDescription where id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':order', $order, PDO::PARAM_STR);
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->bindParam(':title', $title, PDO::PARAM_STR);
        $result->bindParam(':categoryDescription', $description, PDO::PARAM_STR);
        return $result->execute();
    }
    // Добавляем бизнес категорию
    public static function bizCatinsert($bizCat, $bizCatSlug, $title, $description) {
        $db = Db::getConnection();
        $sql = 'INSERT INTO BusinessCategory (categoryName, categoryChpu, categoryTitle, categoryDescription)
         VALUES (:categoryName, :categoryChpu, :categoryTitle, :categoryDescription)';
        $result = $db->prepare($sql);
        $result->bindParam(':categoryName', $bizCat, PDO::PARAM_STR);
        $result->bindParam(':categoryChpu', $bizCatSlug, PDO::PARAM_STR);
        $result->bindParam(':categoryTitle',  $title, PDO::PARAM_STR);
        $result->bindParam(':categoryDescription',$description, PDO::PARAM_STR);
        return $result->execute();
    }
    
    // Выводим сисок всех бизнес категорий
    public static function allBizCat() {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM `BusinessCategory` where categoryParent=""  OR  categoryParent is NULL ORDER BY `order` ASC';
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetchAll();
    }
    
        // Выводим сисок всех бизнес категорий + Главная страница
    public static function allBizCatWithMain() {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM `BusinessCategory` where categoryParent in ("1", NULL, "") ORDER BY `order` ASC';
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetchAll();
    }
    
    // Удаляем бизнес категорию
    public static function deleteBizCat($id) {
        $db = Db::getConnection();
        $sql = "DELETE FROM BusinessCategory WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }
    
    // Получаем подкатегорию бизнес категорий
    public static function infoThisBizCat($id) {
        $db = Db::getConnection();
        $sql = "select * from BusinessCategory where id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetch();
    }
    
    // Добавляем бизнес подкатегорию
    public static function insertCategoryBiz($bizCat, $parentname) {
        $db = Db::getConnection();
        $sql = 'INSERT INTO BusinessCategory (categoryName, categoryParent) '
                . 'VALUES (:categoryName, :categoryParent)';
        $result = $db->prepare($sql);
        $result->bindParam(':categoryName', $bizCat, PDO::PARAM_STR);
        $result->bindParam(':categoryParent', $parentname, PDO::PARAM_STR);
        return $result->execute();
    }
    
    // Выводим товарные категории подкатегорий
    public static function parentChild($name) {
        $db = Db::getConnection();
        $sql = "select * from BusinessCategory where categoryParent = :categoryParent";
        $result = $db->prepare($sql);
        $result->bindParam(':categoryParent', $name, PDO::PARAM_STR);
        $result->execute();
        return $result->fetchAll();
    }
    
    // Обновляем мета данные главной категории
    public static function updateSubs($items, $id)
    {
        $db = Db::getConnection();
        $sql = "UPDATE BusinessCategory SET subCategoryItems = :subCategoryItems where id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':subCategoryItems', $items, PDO::PARAM_STR);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    } 
    
    // Добавляем адрес конкретному юр лицу
    public static function insertAdress($city, $street, $house, $dopInfo, $id) {
        $db = Db::getConnection();
        $sql = 'INSERT INTO user_adress (city, street, house, korpus, user_id) '
                . 'VALUES (:city, :street, :house, :korpus, :user_id)';
        $result = $db->prepare($sql);
        $result->bindParam(':city', $city, PDO::PARAM_STR);
        $result->bindParam(':street', $street, PDO::PARAM_STR);
        $result->bindParam(':house', $house, PDO::PARAM_STR);
        $result->bindParam(':korpus', $dopInfo, PDO::PARAM_STR);
        $result->bindParam(':user_id', $id, PDO::PARAM_STR);

        return $result->execute();
    }
    
    // Получаем все бренды товаров в магазине
    public static function thisBrand() {
        $db = Db::getConnection();
        $sql = "select * from Product_brand";
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetchAll();
    }
    
    // Удаляем бренд товара по его id
    public static function deleteBrand($id) {
        $db = Db::getConnection();
        $sql = "DELETE FROM Product_brand WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }
    
    // Получаем все по бренду
    public static function selectBrand($id) {
        $db = Db::getConnection();
        $sql = "select * from Product_brand WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetch();
    }
    
    // Обновляем бренд
    public static function updateBrand($v, $s, $idss, $logo)
    {
        $db = Db::getConnection();
        $sql = "UPDATE Product_brand SET brand_name = :brand_name, brand_description = :brand_description, brand_logo = :brand_logo where id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':brand_name', $v, PDO::PARAM_STR);
        $result->bindParam(':brand_description', $s, PDO::PARAM_STR);
        $result->bindParam(':brand_logo', $logo, PDO::PARAM_STR);
        $result->bindParam(':id', $idss, PDO::PARAM_INT);
        return $result->execute();
       
    } 

    //selects
    public static function selectedBrands() {
        $db = Db::getConnection();
        $sql = "SELECT id FROM Product_brand WHERE selected = '1'";
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function clearSelectedBrands() {
        $db = Db::getConnection();
        $sql = "UPDATE Product_brand SET selected = NULL WHERE selected = '1'";
        $stm = $db->prepare($sql);
        $res = $stm->execute();
        $c = $db->errorInfo();
        return $res;
    }
    public static function setSelectedBrands($brandIds){
        self::clearSelectedBrands();
        $db = Db::getConnection();
        $sql = "UPDATE Product_brand SET selected = '1' WHERE id IN ($brandIds)";
        $stm = $db->prepare($sql);
        $res = $stm->execute();
        $c = $db->errorInfo();
        return $res;
    }
    // Создаем менеджеру кабинет
    public static function addManagerUser($phoneUser) {
        
        $role = 'operator';
        $db = Db::getConnection();
        $sql = 'INSERT INTO user (role, phone) '
                . 'VALUES (:role, :phone)';
        $result = $db->prepare($sql);
        $result->bindParam(':role', $role, PDO::PARAM_STR);
        $result->bindParam(':phone', $phoneUser, PDO::PARAM_STR);

        return $result->execute();
    }
    public static function getAllRoles() {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM user where role != "user" order by role asc';
        $result = $db->prepare($sql);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function addRole($phone, $name, $role) {
        $db = Db::getConnection();
        $userExists = User::selectID($phone);
        if ($userExists != true) {
            $sql = 'INSERT INTO user (role,name, phone) '
            . 'VALUES (:role,:name,:phone)';
            $result = $db->prepare($sql);
            $result->bindParam(':role', $role, PDO::PARAM_STR);
            $result->bindParam(':name', $name, PDO::PARAM_STR);
            $result->bindParam(':phone', $phone, PDO::PARAM_STR);
        } else {
            $sql = 'UPDATE user set role = :role ,name =:name, phone = :phone WHERE id = :id';
            $result = $db->prepare($sql);
            $result->bindParam(':role', $role, PDO::PARAM_STR);
            $result->bindParam(':name', $name, PDO::PARAM_STR);
            $result->bindParam(':phone', $phone, PDO::PARAM_STR);
            $result->bindParam(':id',  $userExists['id'], PDO::PARAM_STR);
        }
       $ret = $result->execute();
        if ($ret) {
            return true;
        } 
        else{
            return false;
        } 
    }
    public static function removeRole($id) { 
        $db = Db::getConnection();
        $role = 'user';
        $sql = 'UPDATE user set role = :role WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':role', $role, PDO::PARAM_STR);
        $result->bindParam(':id',  $id, PDO::PARAM_STR);
        $ret = $result->execute();
        if ($ret) {
            return true;
        } 
        else{
            return false;
        } 
    }

    public static function addNewProfileToUser($id, $name_profile, $inn, $kpp, $name_company, $bik, $rs, $contact, $email, $phone, $address) {
        $db = Db::getConnection();
        $insertSql = "INSERT INTO user_ur (`user_id`, `ur_profile`, `ur_inn`, `ur_kpp`, `ur_company`, `ur_bik`, `ur_rs`, `ur_contact`, `ur_email`, `ur_phone`, `ur_adress`) VALUES ('" . $id . "', '" . $name_profile . "', '" . $inn . "', '" . $kpp . "', '" . $name_company . "', '" . $bik . "', '" . $rs . "', '" . $contact . "', '" . $email . "', '" . $phone . "', '" . $address . "')";
        $result = $db->prepare($insertSql);
        // $result->bindValue(':client_id', $id);
        // $result->bindValue(':name_profile', $name_profile, PDO::PARAM_STR);
        // $result->bindValue(':inn', $inn, PDO::PARAM_STR);
        // $result->bindValue(':kpp', $kpp, PDO::PARAM_STR);
        // $result->bindValue(':name_company', $name_company, PDO::PARAM_STR);
        // $result->bindValue(':bik', $bik, PDO::PARAM_STR);
        // $result->bindValue(':rs', $rs, PDO::PARAM_STR);
        // $result->bindValue(':user_name', $contact, PDO::PARAM_STR);
        // $result->bindValue(':ur_email', $email, PDO::PARAM_STR);
        // $result->bindValue(':phone', $phone, PDO::PARAM_STR);
        // $result->bindValue(':ur_address', $address, PDO::PARAM_STR);
        $ret =  $result ->execute();
        return($ret) ? true : false;
    }
    public static function createNewUrProfile( $name_profile, $inn, $kpp, $name_company, $bik, $rs, $contact, $email, $phone, $address){
        $db = Db::getConnection();
        $registerSql = "INSERT INTO `user` ( `name`, `email`, `role`, `phone`) VALUES (:user_name, :email, 'user', :phone)";
        $result = $db->prepare($registerSql);
        $result->bindParam(':user_name', $contact, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':phone', $phone, PDO::PARAM_STR);
        $db->beginTransaction();
        $insert_res = $result->execute();
        $userId = $db->lastInsertId();
        if($insert_res) {
            $newProfileSql = "INSERT INTO user_ur (`user_id`, `ur_profile`, `ur_inn`, `ur_kpp`, `ur_company`, `ur_bik`, `ur_rs`, `ur_contact`, `ur_email`, `ur_phone`, `ur_adress`) VALUES ('" .  $userId . "', '" . $name_profile . "', '" . $inn . "', '" . $kpp . "', '" . $name_company . "', '" . $bik . "', '" . $rs . "', '" . $contact . "', '" . $email . "', '" . $phone . "', '" . $address . "')";
            $result = $db->prepare($newProfileSql);
            // $result->bindParam(':client_id', $userId, PDO::PARAM_STR);
            // $result->bindParam(':user_name', $contact, PDO::PARAM_STR);
            // $result->bindParam(':email', $email, PDO::PARAM_STR);
            // $result->bindParam(':phone', $phone, PDO::PARAM_STR);
            // $result->bindParam(':name_profile', $name_profile, PDO::PARAM_STR);
            // $result->bindParam(':inn', $inn, PDO::PARAM_STR);
            // $result->bindParam(':kpp', $kpp, PDO::PARAM_STR);
            // $result->bindParam(':name_company', $name_company, PDO::PARAM_STR);
            // $result->bindParam(':bik', $bik, PDO::PARAM_STR);
            // $result->bindParam(':rs', $rs, PDO::PARAM_STR);
            // $result->bindParam(':ur_address', $address, PDO::PARAM_STR);
            $ret =  $result ->execute();
            if ($ret && $insert_res) {
                $db->commit();
            } else {
                $db->rollBack();
            }
            return($ret) ? true : false;
        }

    }
} 

