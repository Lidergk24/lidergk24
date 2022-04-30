<?php
/**
 * Класс User - модель для работы с пользователями
 */
class User {
    /**
     * Регистрация пользователя
     * @param string $phone <p>телефон</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function register($phone, $secure_code_sms) {
        $db = Db::getConnection();
        $role = 'user';
        $sql = 'INSERT INTO user (phone,role,sms_verify) ' . 'VALUES (:phone,:role,:sms_verify)';
        $result = $db->prepare($sql);
        $result->bindParam(':sms_verify', $secure_code_sms, PDO::PARAM_STR);
        $result->bindParam(':role', $role, PDO::PARAM_STR);
        $result->bindParam(':phone', $phone, PDO::PARAM_STR);
        return $result->execute();
    }
    /**
     * Редактирование данных пользователя
     * @param integer $id <p>id пользователя</p>
     * @param string $name <p>Имя</p>
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function edit($id, $name, $email, $phone, $adressFull) {
        $db = Db::getConnection();
        $sql = "UPDATE user 
            SET name = :name, email = :email, phone = :phone, user_adress = :user_adress
            WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':phone', $phone, PDO::PARAM_STR);
        $result->bindParam(':user_adress', $adressFull, PDO::PARAM_STR);
        return $result->execute();
    }
    /**
     * Проверяем существует ли пользователь с заданными $email и $password
     * @param string $email <p>E-mail</p>
     * @param string $password <p>Пароль</p>
     * @return mixed : integer user id or false
     */
    public static function checkUserData($telAuth_preg_replace, $sms_verify) {
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = 'SELECT * FROM user WHERE phone = :phone AND sms_verify = :sms_verify';
        $result = $db->prepare($sql);
        $result->bindParam(':phone', $telAuth_preg_replace, PDO::PARAM_INT);
        $result->bindParam(':sms_verify', $sms_verify, PDO::PARAM_INT);
        $result->execute();
        $user = $result->fetch();
        if ($user) {
            // Если запись существует, возвращаем id пользователя
            return $user['id'];
        }
        return false;
    }
    /**
     * Запоминаем пользователя
     * @param integer $userId <p>id пользователя</p>
     */
    public static function auth($userId) {
        // Записываем идентификатор пользователя в сессию
        $_SESSION['user'] = $userId;
    }
    /**
     * Возвращает идентификатор пользователя, если он авторизирован.<br/>
     * Иначе перенаправляет на страницу входа
     * @return string <p>Идентификатор пользователя</p>
     */
    public static function checkLogged() {
        // Если сессия есть, вернем идентификатор пользователя
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        header("Location: /user/login");
    }
    /**
     * Проверяет является ли пользователь гостем
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function isGuest() {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }
    /**
     * Проверяет должна ли применяться для пользователя специальная цена из доп.колонки
     * @return string <p>Значение из поля specialClientPrice или пусто</p>
     */
    public static function getSpecialClientPrice() {
	$specialPrice = '';
        if ( @$_SESSION['user_data'] ) {
		if ( @$_SESSION['user_data']['specialClient'] == 'yes' ) {
			$specialPrice = trim( @$_SESSION['user_data']['specialClientPrice'] );
		}
	}
        return $specialPrice;
    }
    /**
     * Проверяет должна ли применяться для пользователя специальная цена из таблицы юр.лиц
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function getSpecialClientINN() {
	$specialINN = '';
        if ( @$_SESSION['user_data'] ) {
		if ( @$_SESSION['user_data']['specialClient'] == 'yes' ) {
			$specialINN = @$_SESSION['user_urdata']['ur_inn'];
		}
	}
        return $specialINN;
    }

//        $sql = 'SELECT * FROM `user_ur` where user_id = :id';

    /**
     * Проверяет имя: не меньше, чем 2 символа
     * @param string $name <p>Имя</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkName($name) {
        if (strlen($name) >= 2) {
            return true;
        }
        return false;
    }
    /**
     * Проверяет телефон: не меньше, чем 10 символов
     * @param string $phone <p>Телефон</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkPhone($phone) {
        if (strlen($phone) == 12) {
            return true;
        }
        return false;
    }
    /**
     * Проверяет имя: не меньше, чем 6 символов
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkPassword($phone) {
        if (strlen($phone) == 15) {
            return true;
        }
        return false;
    }
    /**
     * Проверяет email
     * @param string $email <p>E-mail</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }
    /**
     * Проверяет не занят ли email другим пользователем
     * @param type $email <p>E-mail</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkEmailExists($phone) {
        $db = Db::getConnection();
        $sql = 'SELECT COUNT(*) FROM user WHERE phone = :phone';
        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':phone', $phone, PDO::PARAM_STR);
        $result->execute();
        if ($result->fetchColumn()) return true;
        return false;
    }
    /**
     * Возвращает пользователя с указанным id
     * @param integer $id <p>id пользователя</p>
     * @return array <p>Массив с информацией о пользователе</p>
     */
    public static function getUserById($id) {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM user WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }
    public static function OrderHistory($id) {
        $db = Db::getConnection();
        $sql = 'SELECT * from product_order WHERE user_id= :id';
        $result = $db->prepare($sql);
        $result->bindParam(':user_id', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }
    //Добавление физ лица
    public static function addFiz($userId, $fio, $emailFiz, $fiz_phone, $adress_deleviry) {
        $db = Db::getConnection();
        $sql = 'INSERT INTO user_fiz (user_id, fiz_fio, fiz_email, fiz_phone, fiz_adress) ' . 'VALUES (:user_id, :fiz_fio, :fiz_email, :fiz_phone, :fiz_adress)';
        $result = $db->prepare($sql);
        $result->bindParam(':user_id', $userId, PDO::PARAM_STR);
        $result->bindParam(':fiz_fio', $fio, PDO::PARAM_STR);
        $result->bindParam(':fiz_email', $emailFiz, PDO::PARAM_STR);
        $result->bindParam(':fiz_phone', $fiz_phone, PDO::PARAM_STR);
        $result->bindParam(':fiz_adress', $adress_deleviry, PDO::PARAM_STR);
        return $result->execute();
    }
    // Добавление юр дица
    public static function addUr($userId, $name_profile, $property, $inn, $ur_phone, $contact, $email) {
        try {
            $db = Db::getConnection();
            $sql = 'INSERT INTO user_ur (user_id, ur_profile, property, ur_inn, ur_contact, ur_email, ur_phone) ' . 'VALUES (:user_id, :ur_profile, :property, :ur_inn, :ur_contact, :ur_email, :ur_phone)';
            $result = $db->prepare($sql);
            $result->bindParam(':user_id', $userId, PDO::PARAM_STR);
            $result->bindParam(':ur_profile', $name_profile, PDO::PARAM_STR);
            $result->bindParam(':property', $property, PDO::PARAM_STR);
            $result->bindParam(':ur_inn', $inn, PDO::PARAM_STR);
            //$result->bindParam(':ur_kpp', $kpp, PDO::PARAM_STR);
            //$result->bindParam(':ur_company', $name_company, PDO::PARAM_STR);
            //$result->bindParam(':ur_bik', $bik, PDO::PARAM_STR);
            //$result->bindParam(':ur_rs', $rs, PDO::PARAM_STR);
            $result->bindParam(':ur_contact', $contact, PDO::PARAM_STR);
            $result->bindParam(':ur_phone', $ur_phone, PDO::PARAM_STR);
            //$result->bindParam(':ur_adress', $adress, PDO::PARAM_STR);
            $result->bindParam(':ur_email', $email, PDO::PARAM_STR);
            return $result->execute();
        }
        catch (Throwable $t) {
            $t->getMessage();
        }
    }
    // Получаем список профилей пользователя
    public static function getUserByProfile($user_id) {
        $db = Db::getConnection();
        $sql = 'select * from `user_fiz` where user_id= :user_id';
        $result = $db->prepare($sql);
        $result->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetchAll();
    }

    public static function getFizUserByFizId($id) {
        $db = Db::getConnection();
        $sql = 'select * from `user_fiz` where id= :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetchAll();
    }
    // редактируем конкретный профиль пользователя
    public static function editUserProfile($id) {
        $db = Db::getConnection();
        $sql = "SELECT * FROM `user_fiz` WHERE id= :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetchAll();
    }
    public static function editUrProfile($id) {
        $db = Db::getConnection();
        $sql = "SELECT * FROM `user_ur` WHERE id= :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetchAll();
    }
    public static function updateProfileFiz($byIdFiz, $name, $email, $fiz_phone, $adress_deleviry) {
        $db = Db::getConnection();
        $sql = "UPDATE user_fiz 
            SET fiz_fio = :name, fiz_email = :email, fiz_phone = :fiz_phone, fiz_adress = :adress_deleviry
            WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $byIdFiz, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':fiz_phone', $fiz_phone, PDO::PARAM_STR);
        $result->bindParam(':adress_deleviry', $adress_deleviry, PDO::PARAM_STR);
        return $result->execute();
    }
    public static function getUserByProfileUr($user_id) {
        $db = Db::getConnection();
        $sql = 'select * from `user_ur` where user_id= :user_id';
        $result = $db->prepare($sql);
        $result->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetchAll();
    }
    //редактируем юридический профиль
    public static function editUserProfileur($id) {
        $db = Db::getConnection();
        $sql = "SELECT * FROM `user_ur` WHERE id= :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetchAll();
    }
    //Обновляем профиль юр лица
    public static function editUserProfileurSave($getByIdProfile, $name_profile, $property, $inn, $fio, $ur_email, $fiz_phone) {
        $db = Db::getConnection();
        $sql = "UPDATE user_ur 
            SET ur_profile = :name_profile, property = :property, ur_inn = :ur_inn, ur_contact = :ur_contact, ur_email = :ur_email, ur_phone = :ur_phone
            WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $getByIdProfile, PDO::PARAM_INT);
        $result->bindParam(':name_profile', $name_profile, PDO::PARAM_STR);
        $result->bindParam(':property', $property, PDO::PARAM_STR);
        $result->bindParam(':ur_inn', $inn, PDO::PARAM_STR);
        /*$result->bindParam(':ur_kpp', $kpp, PDO::PARAM_STR);
        $result->bindParam(':name_company', $name_company, PDO::PARAM_STR);
        $result->bindParam(':ur_bik', $bik, PDO::PARAM_STR);
        $result->bindParam(':ur_rs', $rs, PDO::PARAM_STR);*/
        $result->bindParam(':ur_contact', $fio, PDO::PARAM_STR);
        $result->bindParam(':ur_email', $ur_email, PDO::PARAM_STR);
        $result->bindParam(':ur_phone', $fiz_phone, PDO::PARAM_STR);
        //$result->bindParam(':ur_adress', $adress_deleviry, PDO::PARAM_STR);
        return $result->execute();
    }
    //удалению профиля юр лица
    public static function deleteProfileUr($id) {
        $db = Db::getConnection();
        $sql = "DELETE FROM user_ur WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }
    public static function deleteProfileFiz($id) {
        $db = Db::getConnection();
        $sql = "DELETE FROM user_fiz WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
    }
    public static function allUsers() {
        $db = Db::getConnection();
        $sth = $db->prepare("SELECT * FROM `user`");
        $sth->execute();
        $allUsers = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $allUsers;
    }
    public static function callMeManager($nameCompany, $name_manager, $phone_manager, $ckeckBox) {
        $db = Db::getConnection();
        $sql = 'INSERT INTO call_manager (name_client, nameCompany, interesting, phone_client) ' . 'VALUES (:name_client, :nameCompany, :interesting, :phone_client)';
        $result = $db->prepare($sql);
        $result->bindParam(':name_client', $name_manager, PDO::PARAM_STR);
        $result->bindParam(':nameCompany', $nameCompany, PDO::PARAM_STR);
        $result->bindParam(':interesting', $ckeckBox, PDO::PARAM_STR);
        $result->bindParam(':phone_client', $phone_manager, PDO::PARAM_STR);
        return $result->execute();
    }
    // добавление адреса
    public static function addAdress($id, $phone, $city, $street, $house,  $korpus, $office, $domofon) {
        $db = Db::getConnection();
        $sql = 'INSERT INTO user_adress (user_id, user_phone, city, street, house, korpus, office, domofon) ' . 'VALUES (:user_id, :user_phone, :city, :street, :house, :korpus, :office, :domofon)';
        $result = $db->prepare($sql);
        $result->bindParam(':user_id', $id, PDO::PARAM_STR);
        $result->bindParam(':user_phone', $phone, PDO::PARAM_STR);
        $result->bindParam(':city', $city, PDO::PARAM_STR);
        $result->bindParam(':street', $street, PDO::PARAM_STR);
        $result->bindParam(':house', $house, PDO::PARAM_STR);
        $result->bindParam(':korpus', $korpus, PDO::PARAM_STR);
        $result->bindParam(':office', $office, PDO::PARAM_STR);
        $result->bindParam(':domofon', $domofon, PDO::PARAM_STR);
        return $result->execute();
    }
   
    // выводим все адреса пользователя по номеру его телефона (вместо id)
    public static function allAdressFromUser($user_phone) {
        $db = Db::getConnection();
        $sql = 'select * from `user_adress` where user_phone= :user_phone';
        $result = $db->prepare($sql);
        $result->bindParam(':user_phone', $user_phone, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetchAll();
    }
     // удаляем адресс по id
    public static function deleteAdress($byIdUr) {
        $db = Db::getConnection();
        $sql = "DELETE FROM user_adress WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $byIdUr, PDO::PARAM_INT);
        return $result->execute();
    }
    
    // выбор данных менеджера клиента
    public static function usermanager($user_manager) {
        $db = Db::getConnection();
        $sql = 'select * from `Manager` where manager_name= :manager_name';
        $result = $db->prepare($sql);
        $result->bindParam(':manager_name', $user_manager, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }
    public static function useroperator($user_operator) {
        $db = Db::getConnection();
        $sql = 'select * from `Operator` where operator_name= :operator_name';
        $result = $db->prepare($sql);
        $result->bindParam('operator_name', $user_operator, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }
    // Выбираем все данные для формирования повторения заказа
    public static function repeatSelect($order_number) {
        $db = Db::getConnection();
        $sql = 'select * from `product_order` where order_number= :order_number';
        $result = $db->prepare($sql);
        $result->bindParam(':order_number',$order_number, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }
    
    // Выбираем все данные для формирования повторения заказа
    public static function selectRepeatDontAvalible($arrayIds) {
        $db = Db::getConnection();
        $sql = "select * from `Product` where id in ($arrayIds) and product_warehouse>1";
        $result = $db->prepare($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }
    
    // Получаем все суммы клиента за предыдущий месяц
    public static function allSummOrderUser($phone) {
        $db = Db::getConnection();
        $sql = "SELECT SUM(order_summ) as TotalUserMo FROM product_order where user_phone= :phone and MONTH(`date`) = MONTH(DATE_ADD(NOW(), INTERVAL -1 MONTH)) AND YEAR(`date`) = YEAR(NOW())";
        $result = $db->prepare($sql);
        $result->bindParam(':phone', $phone, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }
    
    // Обновляем статус лояльности клиента
    public static function loyaltyUpdate($loyaltyStatus, $phone) {
    }

    // Обновляем дату последнего посещения пользователя
    public static function lastVisitUpdate($id) {
        $db = Db::getConnection();
        $sql = 'UPDATE user SET last_visit=NOW() WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();

	// Обновляем данные о пользователе в переменной сессии
        $_SESSION['user_data'] = self::getUserById($id);
        $_SESSION['user_urdata'] = self::selectINNUser($id);
    }

    // Обновляем дату последней выдачи мотивационного купона
    public static function lastCouponUpdate($id) {
        $db = Db::getConnection();
        $sql = 'UPDATE user SET last_coupon=NOW() WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();
    }
    
    // Получаем все ИНН пользователя из профилей
    public static function selectINNUser($id) {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM `user_ur` where user_id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }
    public static function getUrProfileData($inn) {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM `user_ur` where ur_inn = :inn';
        $result = $db->prepare($sql);
        $result->bindParam(':inn', $inn, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }
    // Получаем все спеццены если они есть
    public static function selectSpecialPrice($inn) {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM `specialPrice` where innParent= :inn';
        $result = $db->prepare($sql);
        $result->bindParam(':inn', $inn, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetchAll();
    }
    
    // Получаем ID юзера по его номеру телефона
    public static function selectID($phone) {
        if (!$phone) {
            return "";
        }
        $db = Db::getConnection();
        $sql = 'SELECT id FROM user where phone= :phone';
        $result = $db->prepare($sql);
        $result->bindParam(':phone', $phone, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
    }
    
    // Получаем Все адреса пользователя по id
    public static function userAdress($user_id) {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM user_adress where user_id = :user_id';
        $result = $db->prepare($sql);
        $result->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetchAll();
    }

    public static function checkIfSpecialPricesExist($id) {
        $ur_profile = User::selectINNUser($id);
        $specialPricesArr =   User::selectSpecialPrice($ur_profile["ur_inn"]);
        return !empty($specialPricesArr);
    }

}