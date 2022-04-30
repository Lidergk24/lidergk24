<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Контроллер CabinetController
 * Кабинет пользователя
 */
class CabinetController
{

    /**
     * Action для страницы "Кабинет пользователя"
     */
    public function actionIndex()
    {
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();
        $user = User::getUserById($userId);
        $con = Db::getConnectionMysqli();
        $res = mysqli_query($con, "SELECT ur_adress FROM `user_ur` WHERE user_id=$userId");
        $address = '';
        foreach ($res as $addr) $address = $addr;
        $usermanager = User::usermanager($user['user_manager']);
        $useroperator=User::useroperator($user['user_operator']);
        $specialPricesExist= User::checkIfSpecialPricesExist($userId);
        switch ($user['specialClientPrice'] ) {
            case 'Цена1': $personalDiscount = '15%';
            case 'Цена2': $personalDiscount = '10%';
            case 'Цена3': $personalDiscount = '5%';
            case 'Оптовая': $personalDiscount = '20%';
        }
        $adresses = explode(',', $user["user_adress"]);
        $city = $adresses[0];
        $street = $adresses[1];
        $house = $adresses[2];
        $flat = $adresses[3];
        $domofon = $adresses[4];
        $usermanager = User::usermanager($user['user_manager']);
        $name = $user['name'];
        $email = $user['email'];
        $phone = $user['phone'];
        // Флаг результата
        $result = false;

        if (isset($_POST['submit'])) {
            // Получаем данные из формы редактирования
            $name = htmlspecialchars($_POST['name'], ENT_QUOTES);
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
            $phone = $user['phone'];
            $pass = htmlspecialchars($_POST['radio'], ENT_QUOTES);
            $city = htmlspecialchars($_POST['city'], ENT_QUOTES);
            $street = htmlspecialchars($_POST['street'], ENT_QUOTES);
            $house = htmlspecialchars($_POST['house'], ENT_QUOTES);
            $flat = htmlspecialchars($_POST['flat'], ENT_QUOTES);
            $domofon = htmlspecialchars($_POST['domofon'], ENT_QUOTES);
            $adressFull = $city.', '.$street.', '.$house.', '.$house.', '.$domofon;
            $edit_phone = preg_replace('/\s+/', '', preg_replace("/[^,.+0-9]/", '', $phone));
            $errors = false;
          
            // Валидируем значения
            if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            if ($errors == false) {
                $result = User::edit($userId, $name, $email, $edit_phone, $adressFull);
            }
        }
        require_once(ROOT . '/views/cabinet/Index/Index.php');
        return true;
    }

    /**
     * Action для страницы "Редактирование данных пользователя"
     */
    public function actionEdit()
    {
        $userId = User::checkLogged();
        $user = User::getUserById($userId);
        $getUserByProfileUr = User::getUserByProfileUr($userId);
        $userProfile = User::getUserByProfile($userId);
        require_once(ROOT . '/views/cabinet/edit.php');
        return true;
    }
    
    // Страница историй заказов клиента
    public function actionHistory()
    {
        $userId = User::checkLogged();
        $user = User::getUserById($userId);
        $usermanager = User::usermanager($user['user_manager']);       
        require_once(ROOT . '/components/Db.php');
        $con = Db::getConnectionMysqli();
        $selectOrderHistory = mysqli_query($con, "SELECT * FROM `product_order` WHERE user_id=$userId");
        require_once(ROOT . '/views/cabinet/history.php');
        return true;
    }
    
    /**
     * Action для страницы "Добавление юридического лица"
     */
    public function actionAddur()
    {
        $userId = User::checkLogged();
        $user = User::getUserById($userId);
        $usermanager = User::usermanager($user['user_manager']);
        if (isset($_POST['submit'])) {
            $name_profile = htmlspecialchars($_POST['name_profile'], ENT_QUOTES);
            $inn = htmlspecialchars($_POST['inn'], ENT_QUOTES);
            $property = htmlspecialchars($_POST['property'], ENT_QUOTES);
            //$kpp = htmlspecialchars($_POST['kpp'], ENT_QUOTES);
            $phone = htmlspecialchars($_POST['phone'], ENT_QUOTES);
            $ur_phone = preg_replace('/\s+/', '', preg_replace("/[^,.+0-9]/", '', $phone));
            //$name_company = htmlspecialchars($_POST['name_company'], ENT_QUOTES);
            //$bik = htmlspecialchars($_POST['bik'], ENT_QUOTES);
            //$rs = htmlspecialchars($_POST['rs'], ENT_QUOTES);
            $contact = htmlspecialchars($_POST['contact'], ENT_QUOTES);
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
            //$adress = htmlspecialchars($_POST['adress'], ENT_QUOTES);
    
            $errors = false;
            // Валидируем значения
            if (empty($name_profile)) {
                $errors[] = 'Пожалуйста заполните название профиля';
            }
            if (empty($inn)) {
                $errors[] = 'Пожалуйста заполните ИНН';
            }
            /*if (empty($name_company)) {
                $errors[] = 'Пожалуйста заполните название компании';
            }*/
            if (empty($contact)) {
                $errors[] = 'Пожалуйста заполните номер телефона';
            }
            if (empty($email)) {
                $errors[] = 'Пожалуйста заполните имейл адресс';
            }
            if (empty($phone)) {
                $errors[] = 'Пожалуйста заполните номер телефона';
            }
           /*if (empty($adress)) {
                $errors[] = 'Пожалуйста заполните адрес доставки';
            }*/

            if ($errors === false) {
                // Если ошибок нет, сохраняет изменения профиля
                $result = User::addUr($userId, $name_profile, $property, $inn, $ur_phone, $contact, $email);
                /*var_dump($result);
                die();*/
                //echo "<script>alert('Профиль добавлен'); window.location.replace('/cabinet/edit');</script>";
            }
        }
        require_once(ROOT . '/views/cabinet/addur.php');
        return true;
    }
    
    
    // Страница скидок в кабинете пользователя
    public function actionSale()
    {
        require_once(ROOT . '/views/cabinet/sale.php');
        return true;
    }

    // Страница просмотра заказа
    public function actionView_order($id)
    {
        $userId = User::checkLogged();
        $user = User::getUserById($userId);
        $usermanager = User::usermanager($user['user_manager']);
        require_once(ROOT . '/components/Db.php');
        $con = Db::getConnectionMysqli();
        $selectOrderHistory = mysqli_query($con, "SELECT * FROM `product_order` WHERE id=$id and user_id=$userId");
        $order = Order::getOrderById($id);
        $productsQuantity = json_decode($order['products'], true);
        $haystack = '-';
        $productsIds = array_keys($productsQuantity);
        $specialClientOrder = ($productsIds[1][2] == $haystack);
        $productsFresh = Product::getProdustsByIds($productsIds);
        $productsHistory = Product::getProductFromHistoryTableByIds($productsIds);
        if ($productsHistory != false) {
            $products = array_merge($productsFresh,$productsHistory);
        } else {
            $products = $productsFresh;
        }
        $order_items = Order::getOrderItems($id);

        foreach($selectOrderHistory as $oneItembill){ } 
        require_once(ROOT . '/views/cabinet/view_order.php');
        return true;
    }
    
    // Страница редактирования профиля
    public function actionEditprofile()
    {
        $userId = User::checkLogged();
        $getByIdProfile = explode("/", $_SERVER["REQUEST_URI"]);
        $byIdFiz = $getByIdProfile[3];
        $editUserProfile = User::editUserProfile($getByIdProfile[3]);
        foreach($editUserProfile as $editUserProfileOne){ }
      
        if (isset($_POST['submit'])) {
            $name = htmlspecialchars($_POST['fio'], ENT_QUOTES);
            $email = htmlspecialchars($_POST['emailfiz'], ENT_QUOTES);
            $phones = htmlspecialchars($_POST['phone_fiz'], ENT_QUOTES);
            $fiz_phone = preg_replace('/\s+/', '', preg_replace("/[^,.+0-9]/", '', $phones));
            $adress_deleviry = htmlspecialchars($_POST['adress_deleviry'], ENT_QUOTES);
            $errors = false;

            // Валидируем значения
            if (empty($name)) {
                $errors[] = 'Пожалуйста заполните ФИО';
            }
            if (empty($email)) {
                $errors[] = 'Ошибка email адреса';
            }
            if (empty($adress_deleviry)) {
                $errors[] = 'Ошибка в адресе';
            }
            if ($errors == false) {
                // Если ошибок нет, сохраняет изменения профиля
                $result = User::updateProfileFiz($byIdFiz, $name, $email,$fiz_phone, $adress_deleviry);
                echo "<script>alert('Профиль обновлен'); window.location.replace('/cabinet');</script>";
            }
        }
        
        $user = User::getUserById($userId);
        $usermanager = User::usermanager($user['user_manager']);
        require_once(ROOT . '/views/cabinet/editprofile.php');
        return true;
    }
    
    // Страница юридического профиля
    public function actionUrprofile()
    {
        $userId = User::checkLogged();
        $getByIdProfile = explode("/", $_SERVER["REQUEST_URI"]);
        $editUserProfileur = User::editUserProfileur($getByIdProfile[3]);
        foreach($editUserProfileur as $editUserProfileOneUr){ }
      
            if (isset($_POST['submit'])) {
                $name_profile = htmlspecialchars($_POST['name_profile'], ENT_QUOTES);
                $property = htmlspecialchars($_POST['property'], ENT_QUOTES);
                $inn = htmlspecialchars($_POST['inn'], ENT_QUOTES);
                $property = htmlspecialchars($_POST['property'], ENT_QUOTES);
                /*$kpp = htmlspecialchars($_POST['kpp'], ENT_QUOTES);
                $name_company = htmlspecialchars($_POST['name_company'], ENT_QUOTES);
                $bik = htmlspecialchars($_POST['bik'], ENT_QUOTES);
                $rs = htmlspecialchars($_POST['rs'], ENT_QUOTES);*/
                $ur_email = htmlspecialchars($_POST['email'], ENT_QUOTES);
                $fio = htmlspecialchars($_POST['name'], ENT_QUOTES);
                $tel = htmlspecialchars($_POST['phone'], ENT_QUOTES);
                $fiz_phone = preg_replace('/\s+/', '', preg_replace("/[^,.+0-9]/", '', $tel));
                // $adress_deleviry = htmlspecialchars($_POST['adress'], ENT_QUOTES);
                // Флаг ошибок
                $errors = false;
                // Валидируем значения
                if (empty($name_profile)) {
                    $errors[] = 'Пожалуйста заполните название профиля';
                }
                if (empty($property)) {
                    $errors[] = 'Пожалуйста заполните форму юр. собственности';
                }
                if (empty($inn)) {
                    $errors[] = 'Пожалуйста заполните ИНН';
                }
                /*if (empty($name_company)) {
                    $errors[] = 'Пожалуйста заполните название компании';
                }*/
                if (empty($ur_email)) {
                    $errors[] = 'Пожалуйста заполните Email';
                }
                if (empty($tel)) {
                    $errors[] = 'Пожалуйста заполните телефон';
                }
                /*if (empty($adress_deleviry)) {
                    $errors[] = 'Пожалуйста заполните адрес';
                }*/
                if ($errors == false) {
                    // Если ошибок нет, сохраняет изменения профиля
                    $result = User::editUserProfileurSave($getByIdProfile[3], $name_profile, $property, $inn, /*$kpp, $name_company, $bik, $rs, */$fio, $ur_email, $fiz_phone);
                    header("Location:/cabinet/edit");
                }
            }
        $user = User::getUserById($userId);
        $usermanager = User::usermanager($user['user_manager']);
        require_once(ROOT . '/views/cabinet/urprofile.php');
        return true;
    }
    
    // Удаление юр лица
    public function actionDelete()
    {
        $userId = User::checkLogged();
        $getByIdProfile = explode("/", $_SERVER["REQUEST_URI"]);
        $byIdUr = $getByIdProfile[3];
        $result = User::deleteProfileUr($byIdUr);
        //var_dump($result);
        echo "<script>window.location.replace('/cabinet');</script>";
        return true;
    }
    
    
    // Адреса доставки
    public function actionAdress()
    {
        $userId = User::checkLogged();
        $user = User::getUserById($userId);
        $usermanager = User::usermanager($user['user_manager']);
        $allAdressFromUser = User::allAdressFromUser($user['phone']);
        require_once(ROOT . '/views/cabinet/adress.php');
        return true;
    }
    
    // Добавить адресс
    public function actionNewadd()
    {
        $userId = User::checkLogged();
        $user = User::getUserById($userId);
        $usermanager = User::usermanager($user['user_manager']);
        $addAdress = false;

        if (isset($_POST['submit'])) {
            $city = htmlspecialchars($_POST['city'], ENT_QUOTES);
            $street = htmlspecialchars($_POST['street'], ENT_QUOTES);
            $house = htmlspecialchars($_POST['house'], ENT_QUOTES);
            $korpus = htmlspecialchars($_POST['korpus'], ENT_QUOTES);
            $office = htmlspecialchars($_POST['office'], ENT_QUOTES);
            $domofon = htmlspecialchars($_POST['domofon'], ENT_QUOTES);
            $errors = false;
          
            // Валидируем значения
            if (strlen($city)<3) {
                $errors[] = 'Город не должен быть короче 3 символов';
            }
            if (strlen($street)<4) {
                $errors[] = 'Название улицы не может быть короче 4 символов';
            }
            if ($errors == false) {
                
                $addAdress = User::addAdress($user['id'], $user['phone'], $city, $street, $house,  $korpus, $office, $domofon);
                header("Location:/cabinet/adress");
            }

        }
        require_once(ROOT . '/views/cabinet/newadd.php');
        return true;
    }
    
    // Удаление юр лица
    public function actionAdressdel()
    {
        $userId = User::checkLogged();
        $getByIdProfile = explode("/", $_SERVER["REQUEST_URI"]);
        $byIdUr = $getByIdProfile[3];
        $result = User::deleteAdress($byIdUr);
        echo "<script>window.location.replace('/cabinet/adress');</script>";
        return true;
    }

    // Повторить заказ
    public function actionRepeat()
    {
        $userId = User::checkLogged();
        $getByIdProfile = explode("/", $_SERVER["REQUEST_URI"]);
        $selectRepeat = User::repeatSelect($getByIdProfile[3]);
	    $ProductsForRepeat = Array();
        $idsArray = [];
        foreach(json_decode($selectRepeat["products"]) as $arrayIds => $countKey) {
            $idsArray[] = $arrayIds;
            $selectRepeatDontAvalible = User::selectRepeatDontAvalible($arrayIds);
            if($selectRepeatDontAvalible !=NULL){
                $ProductsForRepeat[$selectRepeatDontAvalible['id']] = $countKey;
            }
        }
        $productDiscounts = Product::getProdustsDiscountByIds($idsArray);
	    $_SESSION['repeat'] = $ProductsForRepeat;
        require_once(ROOT . '/views/cabinet/repeat.php');
        return true;
    }
}
?>