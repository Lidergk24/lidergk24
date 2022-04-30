<?php
/**
 * Контроллер AdminController
 * Главная страница в админпанели
 */
class AdminController extends AdminBase {
    /**
     * Action для стартовой страницы "Панель администратора"
     */
    public function actionIndex() {
        self::checkAdmin();
        $totalOrders = AdminClass::totalOrders();
        $allUsers = User::allUsers();
        $newClientsToday = AdminClass::newClientsToday();
        $AllSummOrders = AdminClass::AllSummOrders();
        $SummOrdersToday = AdminClass::SummOrdersToday();
        $countOrdersToday = AdminClass::countOrdersToday();
        $countOrdersYesterday = AdminClass::countOrdersYesterday();
        $countOrdersWeek = AdminClass::countOrdersWeek();
        $lastOrdersByAdmin = AdminClass::lastOrdersByAdmin();
        require_once (ROOT . '/views/admin/Index/Index.php');
        return true;
    }
    
    // Все клиенты магазина
    public function actionClients() {
        self::checkAdmin();
        $allClients = AdminClass::allClients();
        require_once (ROOT . '/views/admin/Clients/AllClients.php');
        return true;
    }
    
    // Вывод всех профилей клиента
    public function actionProfiles() {
        self::checkAdmin();
        $getByProfiles = explode("/", $_SERVER["REQUEST_URI"]);
        $getByProfilesIds = $getByProfiles[3];
        $con = Db::getConnectionMysqli();
        $getByProfilesIdsFiz = mysqli_query($con,"select * from user_fiz where user_id = '$getByProfilesIds'");
        $getByProfilesIdsUr = mysqli_query($con,"select * from user_ur where user_id = '$getByProfilesIds'");
        require_once (ROOT . '/views/admin/Clients/ClientProfiles.php');
        return true;
    }
    
    // Добавление статьи в админке
    public function actionBook() {
        self::checkAdmin();
        function rus2translit($string) {
            $converter = array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ь' => '\'', 'ы' => 'y', 'ъ' => '\'', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch', 'Ь' => '\'', 'Ы' => 'Y', 'Ъ' => '\'', 'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',);
            return strtr($string, $converter);
        }
        function str2url($str) {
            // переводим в транслит
            $str = rus2translit($str);
            // в нижний регистр
            $str = strtolower($str);
            // заменям все ненужное нам на "-"
            $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
            // удаляем начальные и конечные '-'
            $str = trim($str, "-");
            return $str;
        }
        if (isset($_POST['submit'])) {
            $articleName = $_POST['name_book'];
            $articleTitle = $_POST['title_book'];
            $articleDescription = $_POST['description_book'];
            $articleText = $_POST['text_book'];
            $fileName = $_FILES['filename']['name'];
            $fileNames = md5(uniqid($fileName)) . '.jpg';
            $uploaddir =   $_SERVER['DOCUMENT_ROOT'].'/upload/images/'.$fileNames;
            if (move_uploaded_file($_FILES['filename']['tmp_name'], $uploaddir)) {
                echo "файл загружен";
            } else {
                echo "ошибка загрузки файла";
            }
            $articleSlug = str2url($articleName);
            $dates = date("m-d-y");
            $articleSlugDate = $articleSlug.'-'.$dates;
            $insertArticle = AdminClass::insertArticle($articleName, $articleTitle, $articleDescription, $articleText, $fileNames, $articleSlugDate);
        }
        require_once (ROOT . '/views/admin/Article/AddArticle.php');
        return true;
    }
    
    // Добавление фида в админке
    public function actionAddfid() {
        if (isset($_POST['prod_code'])) {
            $productCode = $_POST['prod_code'];
            $insertFid = AdminClass::insertFid($productCode);
        }
        require_once (ROOT . '/views/admin/Fids/AddFid.php');
        return true;
        //return $_POST['product_code'];
    }
    
    // Добавление фида с категорией в админке
    public function actionAddCatfid() {
        if (isset($_POST['prod_code'])) {
            $catCode = $_POST['prod_code'];
            //$carr = AdminClass::getFidByCatId($catCode);
            $insertFid = AdminClass::insertCatFid($catCode);
        }
        require_once (ROOT . '/views/admin/Fids/AddFid.php');
        return true;
        //return $_POST['product_code'];
    }
    
    // Добавление фида для всего каталога в админке
    public function actionAddAllfid() {
         if (isset($_POST['parse_type']) and $_POST['parse_type'] == 'all') {
            $insertFid = AdminClass::insertAllFid();
         }
        require_once (ROOT . '/views/admin/Fids/AddFid.php');
        return true;
        //return $_POST['product_code'];
    }
    
    // Ajax-поиск товаров товара по подстроке
    public function actionSearchProduct() {
        if (isset($_POST['prod_code'])) {
            /*$res = $AdminClass::getProductsBySubstring('%'.$_POST['search'].'%');
            echo json_encode($res);
            $searchQuery = '%'.$_POST['search'].'%';
            $res = AdminClass::getProductsBySubstring($searchQuery);
            echo json_encode($res);*/
            return $_POST['prod_code'];
        } else return 'none';
    }
    
    // Список статей в админке
    public function actionAllbook() {
        self::checkAdmin();
        $articles = AdminClass::allArticles();
        require_once (ROOT . '/views/admin/Article/Articles.php');
        return true;
    }
    
    // Список фидов в админке
    public function actionFids() {
        self::checkAdmin();
        $fids = AdminClass::allFids();
        require_once (ROOT . '/views/admin/Fids/Fids.php');
        return true;
    }
    
    // Все менеджеры проекта
    public function actionAllmg() {
        self::checkAdmin();
        $managers = AdminClass::managers();
        require_once (ROOT . '/views/admin/Managers/AllManager.php');
        return true;
    }

    public function actionOperators() {
        self::checkAdmin();
        $operators = AdminClass::operatorBase();
        require_once (ROOT . '/views/admin/Managers/operators.php');
        return true;
    }
    public function actionDeleteOperator() {
        self::checkAdmin();
        $delete_res = AdminClass::deleteOperator($_POST['id']);
        return $delete_res;
    }

    public function actionAddOperator() {
        self::checkAdmin();
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $dob= $_POST['dob'];
        $email = $_POST['email'];
        $insert_res = AdminClass::AddOperator($name, $phone, $dob, $email);
        return $insert_res;
    }

    public function actionRoles() {
        self::checkAdmin();
        $users =  AdminClass::getAllRoles();
        require_once (ROOT . '/views/admin/Managers/roles.php');
        return true;
    } 

    public function actionAddRole() {
        self::checkAdmin();
        $edit_phone = preg_replace('/\s+/', '', preg_replace("/[^,.+0-9]/", '', $_POST['phone']));
        $name = $_POST['name'];
        $role = $_POST['role'];
        AdminClass::addRole($edit_phone, $name,$role);
        return true;
    }

    public function actionRemoveRole() {
        self::checkAdmin();
        $id = $_POST['id'];
        AdminClass::removeRole($id);
        return true;
    }

    // Добавить менеджера
    public function actionAddmanager() {
        self::checkAdmin();
         
        if (isset($_POST['submit'])) {
            $name_manager = $_POST['name_manager'];
            $phone_manager = $_POST['phone_manager'];
            $dob_manager = $_POST['dob_manager'];
            $email_manager = $_POST['email_manager'];
            $errors = false;
            if (empty($name_manager) || strlen($name_manager)<3) {
                $errors[] = 'Имя не должно быть короче 3-х символов';
            }
            if (empty($phone_manager) || strlen($phone_manager)<11) {
                $errors[] = 'Номер телефона не может быть короче 11 символов';
            }

            if ($errors == false) {
                
                $addManager = AdminClass::addManager($name_manager, $phone_manager, $dob_manager, $email_manager);
                
                $phoneUser = str_replace([' ', '(', ')', '-'], '', $phone_manager);
                
                $addManagerUser = AdminClass::addManagerUser($phoneUser);
            }
        }
        require_once (ROOT . '/views/admin/Managers/AddManager.php');
        return true;
    }
    
    // Правила работы с корзиной
    public function actionRules() {
        self::checkAdmin();
        if (isset($_POST['submit'])) {
        $name_rules = $_POST['name_rules'];
        $rules_select = $_POST['rules_select'];
        $count_rules = $_POST['count_rules'];
        $form_procent = $_POST['form_procent'];
        $form_rub = $_POST['form_rub'];
        $addRules = AdminClass::cart_rules($name_rules, $rules_select, $count_rules, $form_procent, $form_rub);
        }
        require_once (ROOT . '/views/admin/Rules/Addrules.php');
        return true;
    }
    
    // Все правила работы с корзиной
    public function actionAllrules() {
        self::checkAdmin();
        $allRules = AdminClass::allrules();
        $discountedGroups = AdminClass:: getDiscountGroups();
        require_once (ROOT . '/views/admin/Rules/Allrules.php');
        return true;
    }

    public function actionSetRulesGroup() {
        self::checkAdmin();
        $group = AdminClass::getLastGroupDiscountNumber()[0]['MAX(discount_group)'] + 1;
        $part_nums1 = $_POST['part_nums1'];
        $part_nums2 = $_POST['part_nums2'];
        $conditions1 = $_POST['conditions1'];
        $conditions2 = $_POST['conditions2'];
        $amounts1 = $_POST['amounts1'];
        $amounts2 = $_POST['amounts2'];
        $form_percent = $_POST['form_procent'];
        $form_rub = $_POST['form_rub'];
        $group_a = [];
        for ($i = 0; $i < count( $part_nums1); $i++) {
            $group_a[$i]['discount_group_side'] = 'a';
            $group_a[$i]['part_num'] = $part_nums1[$i];
            $group_a[$i]['condition'] =  $conditions1[$i];
            $group_a[$i]['amount'] =  $amounts1[$i];
            $group_a[$i]['discount_group'] =  $group;
        }
        $group_b = [];
        for ($i = 0; $i < count( $part_nums2); $i++) {
            $group_b[$i]['discount_group_side'] = 'b';
            $group_b[$i]['part_num'] = $part_nums2[$i];
            $group_b[$i]['condition'] =  $conditions2[$i];
            $group_b[$i]['amount'] =  $amounts2[$i];
            $group_b[$i]['discount_group'] =  $group;
        }
        foreach($group_a as $oneProductToDiscount) {
            AdminClass::makeNewDiscountGroup($oneProductToDiscount['discount_group'],
            $oneProductToDiscount['discount_group_side'], $oneProductToDiscount['part_num'], $oneProductToDiscount['amount'], $oneProductToDiscount['condition'], $form_percent, $form_rub);
        }
        foreach($group_b as $oneProductToDiscount) {
            AdminClass::makeNewDiscountGroup($oneProductToDiscount['discount_group'],
            $oneProductToDiscount['discount_group_side'], $oneProductToDiscount['part_num'], $oneProductToDiscount['amount'], $oneProductToDiscount['condition'], $form_percent, $form_rub);
        }
        echo "<script>window.location.replace('/admin/allrules');</script>";
        return true;
       
    }
    
    // удаление статьи
    public function actionStatdelete()
    {
        self::checkAdmin();
        $getByBook = explode("/", $_SERVER["REQUEST_URI"]);
        $getByBookrequest = $getByBook[3];
        $result = AdminClass::getByBookrequest($getByBookrequest);
        echo "<script>window.location.replace('/admin/allbook');</script>";
        return true;
    }
    
    // удаление фида
    public function actionFiddelete()
    {
        self::checkAdmin();
        $getProdId = explode("/", $_SERVER["REQUEST_URI"]);
        $prod_id = $getProdId[3];
        $result = AdminClass::DeleteFid($prod_id);
        echo "<script>window.location.replace('/admin/fids');</script>";
        return true;
    }
    
    // удаление фида
    public function actionCatFiddelete()
    {
        self::checkAdmin();
        $getCatId = explode("/", $_SERVER["REQUEST_URI"]);
        $cat_id = $getProdId[3];
        $result = AdminClass::DeleteCatFid($cat_id);
        echo "<script>window.location.replace('/admin/fids');</script>";
        return true;
    }
    
    // удаление правила корзины
    public function actionRuldel()
    {
        self::checkAdmin();
        $getByBook = explode("/", $_SERVER["REQUEST_URI"]);
        $getByBookrequest = $getByBook[3];
        $result = AdminClass::rulDelete($getByBookrequest);
        echo "<script>window.location.replace('/admin/allrules');</script>";
        return true;
    }
    
    // Все профили клиентов
    public function actionAllprofile()
    {
        self::checkAdmin();
        $getByBook = explode("/", $_SERVER["REQUEST_URI"]);
        $getByBookrequest = $getByBook[3];
        $allProfileUr = AdminClass::allProfileUr();
        require_once (ROOT . '/views/admin/Profiles/Allprofile.php');
        return true;
    }
    
    // Просмотр профиля и его заказов
    public function actionOrdprof()
    {
        self::checkAdmin();
        $getByBook = explode("/", $_SERVER["REQUEST_URI"]);
        $allInfprmByProfile = AdminClass::allInfprmByProfile($getByBook[3]);
        $allOrderByProfileAdmin = AdminClass::allOrderByProfileAdmin($getByBook[3]);
        $con = DB::getConnectionMysqli();
        $sqlDate = mysqli_query($con, "SELECT * from user where id='".$allInfprmByProfile["user_id"]."'");
        $sqlDate1 = mysqli_fetch_assoc($sqlDate);
        $sum = mysqli_query($con, "select SUM(order_summ) from product_order where user_id='".$allInfprmByProfile["user_id"]."'");
        $summ = mysqli_fetch_assoc($sum);
        $userAdress = mysqli_query($con, 'select * from user_adress where user_id="'.$allInfprmByProfile["user_id"].'"');
        $operatorBase = AdminClass::operatorBase();
        $managerBase =  AdminClass::managerBase();
        require_once (ROOT . '/views/admin/Profiles/Ordprof.php');
        return true;
    }
    
    // Редкатирование статьи
    public function actionEditbook()
    {
        self::checkAdmin();
        $getByBook = explode("/", $_SERVER["REQUEST_URI"]);
        $getByBookEdit = $getByBook[3];
        $result = AdminClass::getByBookEdit($getByBookEdit);
        $fileNames = $result['article_image'];
        if (isset($_POST['submit'])) {
            
            $articleName = $_POST['name_book'];
            $articleTitle = $_POST['title_book'];
            $articleDescription = $_POST['description_book'];
            $articleText = $_POST['text_book'];
            if(strlen($_FILES['filename']["name"])>0){
                $fileName = $_FILES['filename']['name'];
                $fileNames = md5(uniqid($fileName)) . '.jpg';
                $uploaddir = $_SERVER['DOCUMENT_ROOT'] .'/upload/images/'.$fileNames;
                if(move_uploaded_file($_FILES['filename']['tmp_name'], $uploaddir)){
                    echo "файл загружен";
                } 
                else{
                    echo "ошибка загрузки картинки";
                }
            }
            $idUpdate = $result['id'];
            $insertArticle = AdminClass::updateArticle($articleName, $articleTitle, $articleDescription, $articleText, $fileNames, $idUpdate);
            echo "<script>window.location.replace('/admin/allbook');</script>";
        }
        require_once (ROOT . '/views/admin/Article/EditArticle.php');
        return true;
    }
    
    // Добавление банера
    public function actionAddbaner()
    {
        self::checkAdmin();
        if (isset($_POST['submit1'])) {
           
            $banerName = $_POST['banerName'];
            $banerLink = htmlspecialchars($_POST['banerLink']);
            $banerNameFile = $_FILES['filename']['name'];
            $banerNames = md5(uniqid($banerNameFile)) . '.jpg';
            $uploaddirBaner = $_SERVER['DOCUMENT_ROOT'] .'/upload/banners/'.$banerNames;
            if(move_uploaded_file($_FILES['filename']['tmp_name'], $uploaddirBaner)){
                echo "файл загружен";
            } 
            else{
                echo "ошибка загрузки картинки";
            }
            $insertBaner = AdminClass::insertBaner($banerName, $banerLink, $banerNames, '1');
            echo "<script>window.location.replace('/admin/banners');</script>";
        }
        require_once (ROOT . '/views/admin/Banners/AddBanner.php');
        return true;
    }
    public function actionAddSquareBaner()
    {
        self::checkAdmin();
        if (isset($_POST['submit2'])) {
           
            $banerName = $_POST['banerName'];
            $banerLink = htmlspecialchars($_POST['banerLink']);
            $banerNameFile = $_FILES['filename']['name'];
            $banerNames = md5(uniqid($banerNameFile)) . '.jpg';
            $uploaddirBaner = $_SERVER['DOCUMENT_ROOT'] .'/upload/banners/'.$banerNames;
            if(move_uploaded_file($_FILES['filename']['tmp_name'], $uploaddirBaner)){
                echo "файл загружен";
            } 
            else{
                echo "ошибка загрузки картинки";
            }
            $insertBaner = AdminClass::insertBaner($banerName, $banerLink, $banerNames, '2');
            echo "<script>window.location.replace('/admin/banners');</script>";
        }
        require_once (ROOT . '/views/admin/Banners/AddBanner.php');
        return true;
    }
    
    // Вывести все банеры
    public function actionBanners()
    {
        self::checkAdmin();
        $allBanner = AdminClass::allBanner();
        require_once (ROOT . '/views/admin/Banners/AllBanners.php');
        return true;
    } 
    
    // Добавить акцию
    public function actionAc()
    {
        self::checkAdmin();
           if (isset($_POST['submit'])) {
            $banerName = $_POST['banerName'];
            $saleText = $_POST['textSale'];
            $banerNameFile = $_FILES['filename']['name'];
            $banerNames = md5(uniqid($banerNameFile)) . '.jpg';
            $uploaddirBaner = $_SERVER['DOCUMENT_ROOT'] .'/upload/banners/'.$banerNames;
            if(move_uploaded_file($_FILES['filename']['tmp_name'], $uploaddirBaner)){
                echo "файл загружен";
            } 
            $insertSale = AdminClass::insertSale($banerName, $saleText, $banerNames);
            if($insertSale){
                            echo "<script>window.location.replace('/admin/onlysales');</script>";
            }
        }
        require_once (ROOT . '/views/admin/Sales/AddSales.php');
        return true;
    }
    
    // Все акции
    public function actionOnlysales()
    {
        self::checkAdmin();
        $allSales = AdminClass::allSales();
        require_once (ROOT . '/views/admin/Sales/Allsales.php');
        return true;
    }
    
    // Редактирование акции
    public function actionSalesedit()
    {
        self::checkAdmin();
        $thisSalesIt = explode("/", $_SERVER["REQUEST_URI"]);
        $saleId = $thisSalesIt[3];
        $result = AdminClass::getBySaleEdit($saleId);
         $banerNames = $result['sale_images'];
        if (isset($_POST['submit'])) {
           
            $banerName = $_POST['banerName'];
            $saleText = $_POST['textSale'];
            if(strlen($_FILES['filename']["name"])>0){
            $banerNameFile = $_FILES['filename']['name'];
            $banerNames = md5(uniqid($banerNameFile)) . '.jpg';
            $uploaddirBaner = $_SERVER['DOCUMENT_ROOT'] .'/upload/banners/'.$banerNames;
                if(move_uploaded_file($_FILES['filename']['tmp_name'], $uploaddirBaner)){
                    echo "файл загружен";
                } 
            }
            $thisSales = AdminClass::thisSales($saleId, $banerName, $saleText, $banerNames);
            if($thisSales){
                echo "<script>window.location.replace('/admin/onlysales');</script>";
            }
        }    
        require_once (ROOT . '/views/admin/Sales/EditSales.php');
        return true;
    }
    
    // Все купоны
    public function actionCoupon()
    {
        self::checkAdmin();
        $allCoupons = AdminClass::allCoupons();
        require_once (ROOT . '/views/admin/Coupons/Coupon.php');
        return true;
    }
    
    // Добавить купон
    public function actionAddcoupon()
    {
        self::checkAdmin();
        if (isset($_POST['submit'])) {
            $couponName = $_POST['couponName'];
            $testCoupon = AdminClass::testCoupon($couponName);
                if (empty($testCoupon[0])) {
                $couponProcent = $_POST['couponProcent'];
                $couponSumm = $_POST['couponSumm'];
                $couponActivate = $_POST['couponActivate'];
                $couponUserReplace = $_POST['couponUser'];
                $couponUser = str_replace([' ', '(', ')', '-'], '', $couponUserReplace);
                $selectID = User::selectID($couponUser);
                $dateCoupon = date("y.m.d"); 
            
                $addCoupon = AdminClass::addCoupon($couponName, $couponProcent, $couponSumm, $couponActivate, $selectID["id"], $dateCoupon);

                if($addCoupon){
                    echo "<script>window.location.replace('/admin/coupon');</script>";
    
                }
                
            } else {
                  $error = 'такой промокод уже есть. Попробуйте другой';
            }
        }    
        require_once (ROOT . '/views/admin/Coupons/AddCoupon.php');
        return true;
    }
   
    // Удаление купона
    public function actionDeletecoupon()
    {
        self::checkAdmin();
        $thisCoupone = explode("/", $_SERVER["REQUEST_URI"]);
        $deleteCoupons = AdminClass::deleteCoupons($thisCoupone[3]);
        if($deleteCoupons){
            echo "<script>window.location.replace('/admin/coupon');</script>";
        }
        return true;
    }
    
    // Страница отправки реквизитов
    public function actionSend()
    {
        self::checkAdmin();
        require_once (ROOT . '/views/admin/Requisites/Requisites.php');
        return true;
    }
    
    // Формирование отчетов
    public function actionReport()
    {
        self::checkAdmin();
        require_once (ROOT . '/views/admin/Report/Report.php');
        return true;
    }
    
    // Страница хитов
    public function actionHit()
    {
        self::checkAdmin();
        if (isset($_POST['submit'])) {
             $dateHits = date('Y-m-d H:i:s');
             $hit = $_POST['hit'];
             foreach($hit as $b) 
             $result[] = $b; 
             $result = "'".implode("','", $result)."'"; 
             $updateHits = AdminClass::updateHits($result, $dateHits);
        }    
        require_once (ROOT . '/views/admin/Hits/Hits.php');
        return true;
    }
    
    // Блок акционных товаров на главной странице
    public function actionSaleblock()
    {
        self::checkAdmin();
        if (isset($_POST['submit'])) {
             $dateSale = date('Y-m-d H:i:s');
             $sale = $_POST['sale'];
             foreach($sale as $b) 
             $result[] = $b; 
             $result = "'".implode("','", $result)."'"; 
             $updateSale = AdminClass::updateSale($result, $dateSale);
        }    
        require_once (ROOT . '/views/admin/SaleBlock/SaleBlock.php');
        return true;
    }

    // Получаем все родительские категории с сортировкой по алфавиту
    public function actionCategory()
    {
        self::checkAdmin();
        $allParentCategory = AdminClass::allParentCategory();
        require_once (ROOT . '/views/admin/Category/Category.php');
        return true;
    }
    
    // Получаем все подкатегории
    public function actionSubcat()
    {
        self::checkAdmin();
        $thisSubcat = explode("/", $_SERVER["REQUEST_URI"]);
        $infoSubcat = AdminClass::infoSubcat($thisSubcat[3]);
        require_once (ROOT . '/views/admin/Category/Subcat.php');
        return true;
    }
    
    // Получаем конкретную категорию
    public function actionEndcat()
    {
        self::checkAdmin();
        $thisEndcat = explode("/", $_SERVER["REQUEST_URI"]);
        $infoEndcat = AdminClass::infoEndCat($thisEndcat[3]);
        if (isset($_POST['submit'])) {
            $titleCategory = $_POST['titleCategory'];
            $descriptionCategory = $_POST['descriptionCategory'];
            $h1Category = $_POST['hCategory'];
            $textCategory = $_POST['textCategory'];
            $cat_code = $thisEndcat[3];
            $fileIcons = $infoEndcat['cat_icon'];
             $imageCategory = $infoEndcat['category_image'];
            if(!empty($_FILES['filename']['name'])){
                
                $iconsName = $_FILES['filename']["tmp_name"];
                $fileIcons = md5(uniqid($iconsName)) . '.png';
                $uploaddir = $_SERVER['DOCUMENT_ROOT'] .'/upload/icons/'.$fileIcons;
                move_uploaded_file($_FILES['filename']['tmp_name'], $uploaddir);
            }
            if(!empty($_FILES['imageCategory']["tmp_name"])){
               
                $imageName = $_FILES['imageCategory']['name'];
                $imageCategory = md5(uniqid($imageName)) . '.jpg';
                $uploaddir = $_SERVER['DOCUMENT_ROOT'] .'/upload/images/'.$imageCategory;
                move_uploaded_file($_FILES['imageCategory']['tmp_name'], $uploaddir);
            }
            
            $updateMetaGategory = AdminClass::updateEndCategory($titleCategory, $descriptionCategory, $h1Category, $textCategory, $fileIcons, $cat_code, $imageCategory);
        }    
        require_once (ROOT . '/views/admin/Category/Endcat.php');
        return true;
    }
    
    // Редактирование родительских категорий
    public function actionMetacat()
    {
        self::checkAdmin();
        $metaCat = explode("/", $_SERVER["REQUEST_URI"]);
        $catFilters = AdminClass::getAllCatFilters();
        $metaCatInfo = AdminClass::metaCat($metaCat[3]);
        
        if (isset($_POST['submit'])) {
             
            $titleCategory = $_POST['titleCategory'];
            $descriptionCategory = $_POST['descriptionCategory'];
            $h1Category = $_POST['hCategory'];
            $textCategory = $_POST['textCategory'];
            $cat_code = $metaCat[3];
            $updateMetaCategory = AdminClass::updateMetaCategory($titleCategory, $descriptionCategory, $h1Category, $textCategory, $cat_code);
        }    
        require_once (ROOT . '/views/admin/Category/Metacat.php');
        return true;
    }
    public static function actionRenumerateBusinessCat() {
        self::checkAdmin();
        $ids = $_POST['ids'];
        $order = $_POST['order'];
        $titles = $_POST['titles'];
        $descriptions = $_POST['descriptions'];
        for ($i = 0; $i < count($ids); $i++) {
            AdminClass::renewOrderOfBusinessCategories($ids[$i], $order[$i], $titles[$i], $descriptions[$i]);
        }
        require_once (ROOT . '/views/admin/BusinessCategory/Businesscategory.php');
        return true;
    }
    // Редактирование родительских категорий
    public function actionBusinesscategory()
    {
        self::checkAdmin();
        $allBizCat = AdminClass::allBizCatWithMain();
        if(isset($_POST['idCat'])){
            $deleteBizCat = AdminClass::deleteBizCat($_POST['idCat']);
        }
        function rus2translit($string) {
            $converter = array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ь' => '\'', 'ы' => 'y', 'ъ' => '\'', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch', 'Ь' => '\'', 'Ы' => 'Y', 'Ъ' => '\'', 'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',);
            return strtr($string, $converter);
        }
        function str2url($str) {
            $str = rus2translit($str);
            $str = strtolower($str);
            $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
            $str = trim($str, "-");
            return $str;
        }
        if (isset($_POST['submit'])) {
            $bizCat = $_POST['biz'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $bizCatSlug = str2url('biz-'.$bizCat);
            $bizCatinsert = AdminClass::bizCatinsert($bizCat, $bizCatSlug,  $title, $description);
            header('Location: /admin/businesscategory');
        }    
        require_once (ROOT . '/views/admin/BusinessCategory/Businesscategory.php');
        return true;
    }
    
    // Редактирование родительских категорий
    public function actionPodbizcat()
    {
        self::checkAdmin();
        $thisBizCat = explode('/', $_SERVER['REQUEST_URI']);
        $infoThisBizCat = AdminClass::infoThisBizCat($thisBizCat[3]);
        $idsCat = $infoThisBizCat['id'];
        $parentChild = AdminClass::parentChild($infoThisBizCat["categoryName"]);
        if(isset($_POST['submit'])){
            $insertCategoryBiz = AdminClass::insertCategoryBiz($_POST['biz'], $infoThisBizCat["categoryName"]);
            header("Location: /admin/podbizcat/$idsCat");
        }
        
        if (isset($_POST['addSub'])) {
             $subCats = $_POST['subCatItems'];
             foreach($subCats as $b) 
             $result[] = $b; 
             $result = "'".implode("','", $result)."'"; 
             $updateSubs = AdminClass::updateSubs($result, $_POST['idSubs']);
             
        }    
        require_once (ROOT . '/views/admin/BusinessCategory/Podbizcat.php');
        return true;
    }

    public function actionNprofile() {
        self::checkAdmin();
        require_once(ROOT . '/views/admin/NewProfile/NewProfile.php');
        return true;
    }
    // Добавление нового профиля юридического лица
    public function actionAddNewprofile()
    {
        self::checkAdmin();
            $name_profile =  htmlspecialchars($_POST['name_profile'], ENT_QUOTES);
            $inn =htmlspecialchars( $_POST['inn'], ENT_QUOTES);
            $kpp = htmlspecialchars($_POST['kpp'], ENT_QUOTES);
            $name_company = htmlspecialchars($_POST['name_company'], ENT_QUOTES);
            $bik = htmlspecialchars($_POST['bik'], ENT_QUOTES);
            $rs = htmlspecialchars($_POST['rs'], ENT_QUOTES);
            $contact =htmlspecialchars( $_POST['contact'], ENT_QUOTES);
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
            $phone = str_replace([' ', '(', ')', '-'], '',  $_POST['phone']);
            $address =   htmlspecialchars($_POST['address'], ENT_QUOTES);
            $client_id = User::selectID($phone)['id'];

            if (!empty($client_id)) {
                $inserted = AdminClass::addNewProfileToUser($client_id, $name_profile, $inn, $kpp, $name_company, $bik, $rs, $contact, $email, $phone, $address);
            } else {
                $inserted = AdminClass::createNewUrProfile($name_profile, $inn, $kpp, $name_company, $bik, $rs, $contact, $email, $phone, $address);
            }
            header("Location: /admin/nprofile");
            require_once(ROOT . '/views/admin/NewProfile/NewProfile.php');
            return true;
    }
    
    // Страница брошенных заказов
    public function actionDrop()
    {
        $con = Db::getConnectionMysqli();
        $allDrop = mysqli_query($con, "select distinct(user_id) from ProductDropOrder");
        
        
        
        require_once(ROOT . '/views/admin/Drop/Drop.php');
        return true;
    }
    
    // Глобальное изменение номера при смене номера талефона в контрагенте
    public function actionRephone()
    {
        
        require_once(ROOT . '/views/admin/RePhone/RePhone.php');
        return true;
    }
    
    // Обновление спец цен через загрузку файла
    public function actionUpprice()
    {
        require_once(ROOT . '/views/admin/UpPrice/UpPrice.php');
        return true;
    }
    
    // Добавляем адрес к конкретному юр лицу
    public function actionAddadressclient()
    {
        
        $insertAdress = AdminClass::insertAdress($_POST["city"], $_POST["st"], $_POST["d"], $_POST["op"], $_POST["id"]);
        
        return true;
    }
    
    // Загрузка прайс листа
    public function actionPrice()
    {
        
        require_once(ROOT . '/views/admin/Price/Price.php');
        
        return true;
        
    }
    
    // Страница брендов товаров в кабинете админа
    public function actionThisbrand()
    {
        $selectedBrands =  AdminClass::selectedBrands();
        $thisBrand = AdminClass::thisBrand();
        
        require_once(ROOT . '/views/admin/Thisbrand/Thisbrand.php');
        
        return true;
        
    }
    
    // Удаление бренда
    public function actionDeletebrand()
    {
       
        $deleteBrand = AdminClass::deleteBrand($_POST['id']);
        
        return true;
    }
    public function actionRenewBrandsMainPage() {
        $ids = implode(',',$_POST['id']);
        $renewed = AdminClass::setSelectedBrands($ids);
        header("Location: ".$_SERVER['HTTP_REFERER']);
        return true;
    }
    // Обновление бренда
    public function actionEditbrand()
    {
        
        $id = explode('/', $_SERVER['REQUEST_URI']);
        
        $selectBrand = AdminClass::selectBrand($id[3]);
        
        $logo = $selectBrand['brand_logo'];
        
        if (isset ( $_POST['submit'] ) )
        {
            
            $idss = intval($id[3]);
            
            $v = $_POST["name_book"];
            
            $s = $_POST["text_book"];
            
            if ( !empty ( $_FILES['filename']['name'] ) ) 
            {
                
                $banerNameFile = $_FILES['filename']['name'];
                
                $banerNames = md5(uniqid($banerNameFile)) . '.png';
                
                $uploaddirBaner = $_SERVER['DOCUMENT_ROOT'] .'/template/images/Brand/'.$banerNames;
                
                if ( move_uploaded_file ( $_FILES['filename']['tmp_name'], $uploaddirBaner ) )
                {
                    
                    $logo = $banerNames;
                    
                }  else 
                
                {
                 
                 $logo = $selectBrand['brand_logo'];
                 
                }
                 
             }
            
            $updateBrand = AdminClass::updateBrand($v, $s, $idss, $logo);
          
        }
        
        require_once(ROOT . '/views/admin/Thisbrand/Editbrand.php');
        
        return true;
        
    }

}