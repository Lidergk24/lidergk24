<?php
/**
 * Контроллер CartController
 * Корзина
 */
class CartController {

    // Добавление купона
    public function actionCouponAjax() {
        
        if (User::checkUserForCoupon() === true) {
            $new_coupon = trim(@$_REQUEST['coupon']);
    	    // Cохраняем купон
    	    Cart::addCoupon($new_coupon);
    	    // Выводим результаты расчёта
    	    print json_encode(Cart::Calculate());
            return true;
        } else return false;
    }

    // Добавление товара или изменение его количества
    public function actionAddAjax($id) {
        
        $count_product = @$_REQUEST['count'];
	    // Изменяем количество товара
	    Cart::addProduct($id,$count_product);
	    // Выводим результаты расчёта
	    print json_encode(Cart::Calculate());
        return true;
    }

    // Добавление товара или установка кго количества
    public function actionSetAjax($id) {
        $count_product = @$_REQUEST['count'];
    	// Устанавливаем количество товара
    	Cart::setProduct($id,$count_product);
    	// Выводим результаты расчёта
    	print json_encode(Cart::Calculate());
        return true;
    }

    // Action для страницы Корзина
    public function actionIndex() {
        
        // отправка уведомлений в телеграм через api
        define('TELEGRAM_TOKEN', '1366193683:AAG2Z5Jqnbl6s8zFAeTVsbTniYNthXcaDxE');

        define('TELEGRAM_CHATID', '@lider_int');
        
            function message_to_telegram($text)
                    {
                        $ch = curl_init();
                        curl_setopt_array(
                            $ch,
                            array(
                                CURLOPT_URL => 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/sendMessage?chat_id='. TELEGRAM_CHATID .'&text='.$text,
                                CURLOPT_POST => TRUE,
                                CURLOPT_RETURNTRANSFER => TRUE,
                                CURLOPT_TIMEOUT => 10,
                            )
                        );
                        curl_exec($ch);
                    } 
        // конец отправки уведомлений в телеграм
        
        $title = 'Корзина товаров';
        $description = 'Корзина товаров ООО Лидер';
	    $productsInCart = Cart::getProductsId();
	   
        if ($productsInCart) {
	         $calculate = Cart::Calculate();
             $products = $calculate->products;
             $totalPrice = $calculate->TotalPrice;
             $procentInsertBase = $calculate->CouponDiscount;
             $order_item_array = $calculate ->writeToOrderItemsArray;
        }
        if($calculate->TotalPriceLoyalty>0){
            $saleEmail = $calculate->Procent;
        }
        if($calculate->DiscountPrice>0){
            $saleEmail = $calculate->CouponDiscount;
        }
        
        $result = false;
        if (isset($_POST['submit'])) {
            $userName = $_POST['userNameOneClick'];
            $uPhone = $_POST['phone'];
            $userPhone = str_replace([' ', '(', ')', '-'], '', $uPhone);
            
            if (!User::isGuest()) {
                $userId = User::checkLogged();
                
            } else {
                $userId = NULL;
            }
            $orderNum = Order::getOrderNumber();
            $orderNumber = $orderNum["product_order"] + 1;
            $errors = false;
            // Валидация полей
            if (!User::checkName($userName)) {
                $errors[] = 'Неправильное имя';
            }
            if (!User::checkPhone($userPhone)) {
                $errors[] = 'Неправильный телефон';
            }
            if ($errors == false) {
                $thisDate = date('Y-m-d');
                @$result = Order::saveOneClick($userName, $userPhone, $userId, $productsInCart, $totalPrice, $orderNumber, $procentInsertBase,$order_item_array);
                if ($result) {
                    require_once 'SMS_auth/sms.ru.php';
                    $order_items = Order::getOrderItems($result);
                    $smsru = new SMSRU('509E0CA3-4EDA-C574-5753-717EC494989F');
                    $data = new stdClass();
                    $data->to = $userPhone;
                    $data->text = 'Вы успешно оформили заказ № '. $orderNumber . ' Ожидайте звонка оператора. ООО “ЛИДЕР”';
                    $sms = $smsru->send_one($data);
                    $subject = "Быстрый заказ №" . $orderNumber;
                    include "tempEmail/quickOrder/quickOrder.php";
                    @$message = $contentOrder;
                    $headers = "Content-type: text/html; charset=utf-8 \r\n";
                    $headers.= "From: ООО ЛИДЕР <sale@lider-gk24.ru>\r\n";
                    mail('sale@lider-gk24.ru', $subject, $message, $headers);
                    mail('info@lider-gk24.ru', $subject, $message, $headers);
                    message_to_telegram('Поступил новый заказ №'.$orderNumber);

                    // Очищаем корзину после отправки уведомлений   
                    Cart::clear();
                }
            }
        }
        require_once (ROOT . '/views/cart/index.php');
        return true;
    }
    
    // Удаление товара из корзины
    public function actionDelAjax($id) {
	// Удаляем товар из корзины
        Cart::deleteProduct($id);
	// Выводим результаты расчёта
	    print json_encode(Cart::Calculate());
        return true;
    }
    
    // Action для страницы Оформление покупки
    public function actionCheckout() {
    $environment =include_once($_SERVER['DOCUMENT_ROOT'] . '/config/environment.php');
	// Если пришли не со страницы повтора заказа - очищаем данные повторного заказа
	$referer = explode('/',$_SERVER['HTTP_REFERER']);
	if ($referer[3].'/'.$referer[4]!=='cabinet/repeat') $_SESSION['repeat']='';

        // Добавляем в корзину товары из повторного заказа
        if ($_SESSION['repeat']) {
            foreach ($_SESSION['repeat'] as $id => $count) {
                Cart::addProduct($id,   $count);
                $_SESSION['repeat'] = '';
            }

            require_once(ROOT . '/views/cart/index.php');
            die();
        }
     
        $productsInCart = Cart::getProductsId();
        
        if (!count($productsInCart)) {
	        header("Location:".$environment["base_url"]);
	        die();
	    }

        $title = 'Оформление заказа';
        $description = 'Оформление заказа через корзину';
     	$calculate = Cart::Calculate();
     	$procentInsertBase = $calculate->CouponDiscount;
        $products = $calculate->products;
        $totalPrice = $calculate->TotalPrice;
        $order_item_array = $calculate ->writeToOrderItemsArray;
    	if($calculate->DeliveryAlert) {
    	        header("Location:".$environment["base_url"] . "/cart");
    	        die();
    	}
    	if($calculate->TotalPriceLoyalty>0){
            $saleEmail = $calculate->Procent;
        }
        if($calculate->DiscountPrice>0){
            $saleEmail = $calculate->CouponDiscount;
        }
        $totalQuantity = Cart::countItems();
        
        $userName = false;
        $userPhone = false;
        $userComment = false;
        $result = false;
        
        $orderNum = Order::getOrderNumber();
        // Проверяем является ли пользователь гостем
        if (!User::isGuest()) {
            $userId = User::checkLogged();
            $user = User::getUserById($userId);
            $orderNumber = $orderNum["product_order"] + 1;
          
        } else {
            $orderNumber = $orderNum["product_order"] + 1;
            $userId = false;
        }
        if (isset($_POST['submit'])) {
            $ur_address =$_POST['ur-cab'];
            $fiz_address = $_POST['fiz-cab'];
            if($fiz_address != '') {
                $fiz_data = explode(' • ',$fiz_address);
                $fizId = trim($fiz_data[0]);
                $fullFizData =  User::getFizUserByFizId($fizId)[0];
                $order_email =  filter_var( $fullFizData["fiz_email"], FILTER_SANITIZE_EMAIL);
                $uPhone =  $fullFizData["fiz_phone"];
                $userName = $fullFizData["fiz_fio"];
            } elseif($ur_address != '') {
                $ur_data = explode(' • ',$ur_address);
                $ur_inn = trim($ur_data[1]);
                $fullUrData = User::getUrProfileData($ur_inn);
                $userName =  $fullUrData['ur_company'] .' - Контактное лицо: '. $fullUrData['ur_contact']. ' - ИНН: ' .$fullUrData['ur_inn'];
                $order_email =  filter_var($fullUrData['ur_email'], FILTER_SANITIZE_EMAIL);
                $uPhone = $fullUrData['ur_phone'];
            } else {
                $userName = $_POST['userName'];
                $order_email = filter_var( $_POST['order_email'], FILTER_SANITIZE_EMAIL);
                $uPhone = $_POST['phone'];
            }
            
            $userPhone = str_replace([' ', '(', ')', '-'], '', preg_replace("/[^,.+0-9]/", '', $uPhone));
            $userComment = $_POST['userComment'];
            $allSumm = $calculate->TotalPrice;
            $payment = $_POST['payment'];

            $cab_adress = $_POST['adr-cab'];
           
            if($cab_adress != '') {
                $deliveryData = $cab_adress;
            } else {
                $deliveryData =  $_POST['city'].', '.$_POST['street'].', '.$_POST['house'].', '.$_POST['flat']; 
            }
            $formPost = json_encode(array('Домофон'=>$_POST['domofon'], 'Дата доставки'=>$_POST['data'], 'Время доставки'=>$_POST['time']));
           
           
            
	    $coupon = @$_SESSION['coupon'];

	    // Выполняем деактивацию купона по рассылке
	    if ($calculate->CouponType == 'email') {
		$db = Db::getConnection();
		$sql = 'SELECT * FROM subscribe WHERE coupon = :coupon AND email = :email';
		$result = $db->prepare($sql);
		$result->bindParam(':coupon', $coupon, PDO::PARAM_STR);
		$result->bindParam(':email', $user['email'], PDO::PARAM_STR);
		$result->execute();
		$res = $result->fetch();
	
		if ($res['coupon_activate'] == 0) {
			$sql = 'UPDATE subscribe SET coupon_activate = 1 WHERE coupon = :coupon AND email = :email';
			$result = $db->prepare($sql);
			$result->bindParam(':coupon', $coupon, PDO::PARAM_STR);
			$result->bindParam(':email', $user['email'], PDO::PARAM_STR);
			$result->execute();
		} else {
			$errors[] = 'Купон уже активирован';
		}
	    }

	    // Уменьшаем счётчик доступных активация для купона из админки
	    if ($calculate->CouponType == 'admin') {
		$db = Db::getConnection();
		$result = $db->prepare('SELECT * FROM coupon WHERE coupon_name = :coupon_name');
		$result->bindParam(':coupon_name', $coupon, PDO::PARAM_STR);
		$result->setFetchMode(PDO::FETCH_ASSOC);
		$result->execute();
		$res = $result->fetch();
		print_r($res);

		if ($res['coupon_activate'] == -1) {
			$errors[] = 'Исчерпано число активаций для купона';
		}
    		if ($res['coupon_activate'] > 0) {
    			$count = $res['coupon_activate'] == 1 ? -1 : $res['coupon_activate'] - 1;
    			$sql = 'UPDATE coupon SET coupon_activate = :count WHERE coupon_name = :coupon_name';
    			$result = $db->prepare($sql);
    			$result->bindParam(':count', $count, PDO::PARAM_STR);
    			$result->bindParam(':coupon_name', $coupon, PDO::PARAM_STR);
    			$result->execute();
    		}
	    }
        // отправка уведомлений в телеграм через api
        define('TELEGRAM_TOKEN', '1366193683:AAG2Z5Jqnbl6s8zFAeTVsbTniYNthXcaDxE');

        define('TELEGRAM_CHATID', '@lider_int');
        
            function message_to_telegram($text)
                    {
                        $ch = curl_init();
                        curl_setopt_array(
                            $ch,
                            array(
                                CURLOPT_URL => 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/sendMessage?chat_id='. TELEGRAM_CHATID .'&text='.$text,
                                CURLOPT_POST => TRUE,
                                CURLOPT_RETURNTRANSFER => TRUE,
                                CURLOPT_TIMEOUT => 10,
                            )
                        );
                        curl_exec($ch);
                    } 
        // конец отправки уведомлений в телеграм

            if ($errors == false) {
                $result = Order::save($userName, $userPhone, $order_email, $userComment, $userId, $productsInCart, $allSumm, $orderNumber, $payment, $deliveryData, $formPost, $procentInsertBase, $specOrder=0, $order_item_array );
                if ($result) {
                    $subject = "Новый заказ №" . $orderNumber;
                    $order_items = Order::getOrderItems($result);
                    include "tempEmail/newOrder/newOrder.php";
                    @$message = $contentOrder;
                    $headers = "Content-type: text/html; charset=utf-8 \r\n";
                    $headers.= "From: ООО ЛИДЕР <sale@lider-gk24.ru>\r\n";
                    mail('sale@lider-gk24.ru', $subject, $message, $headers);
                    mail('info@lider-gk24.ru', $subject, $message, $headers);
                    mail($order_email, $subject, $message, $headers);
                    require_once 'SMS_auth/sms.ru.php';
                    $smsru = new SMSRU('509E0CA3-4EDA-C574-5753-717EC494989F');
                    $data = new stdClass();
                    $data->to = $userPhone;
                    $data->text = 'Вы успешно оформили заказ № '. $orderNumber . ' Ожидайте звонка оператора. ООО “ЛИДЕР”';
                    $sms = $smsru->send_one($data);
                    
                    message_to_telegram('Поступил новый заказ №'.$orderNumber);

                    //Очищаем корзину
                    Cart::clear(); 
                }
           }
        }
        require_once (ROOT . '/views/cart/checkout.php');
        return true;
    }
}