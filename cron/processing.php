<?php
/*
 *	Скрипт для отправки мотивационных купонов
 *
 * Скотпь запускается по расписанию и просматривает таблицу сохранённых товаров
 * если у пользователя, время последнего обращения к серверу у которого превысило заданное, в корзине оставались товары
 * для такого пользователя создаётся мотивационный купон и отправляется в письме
**/
//ini_set('display_errors',1);
//error_reporting(E_ALL);
//ini_set('serialize_precision', 14);
//ini_set('precision', 14);

// Подключение файлов системы
define('ROOT', dirname(__FILE__)."/..");
require_once(ROOT.'/components/Autoload.php');


// Интервал времени в секундах, с момента последнего обращения пользователя к сайту, после которого ему отправляется купон
//define('USER_GONE_TIME', 1800);				// 30 минут
define('USER_GONE_TIMEOUT', 10);
// Интервал времени в секундах, между отправками купонов
//define('NEXT_COUPON_TIMEOUT', 30*24*60*60);		// Один месяц
define('NEXT_COUPON_TIMEOUT', 10);

// Параметры купона
define('COUPON_SUMM', 2000);
define('COUPON_PERCENT', 5);
define('COUPON_ACTIVATE', 1);
define('COUPON_TIME', 48*3600);



// Создаём экземпляр класса для работы с сохранёнными списками товаров
$PD = new ProductDrop();
// Получаем список пользователей, у которых есть сохранённые товары, и время последнего обращения которых к сайту больше заданного
$Users = $PD->get_users(USER_GONE_TIMEOUT);


// Обрабатываем список пользователей, для которых время отсутствия превысило заданное (если такие есть)
if ($Users) {
	// Для нормальной работы класса Cart необходимо стартовать сессию
	session_name('PROCESSING_SESSON');
	session_start();

	print "<pre>";

	// Обрабатываем список отобранных пользователей
	foreach ($Users as $id=>$dt) {
		if ($id != 2138 && $id != 4) continue;

		// Восстанавливает сохранённые товары и идентификатор пользователя в переменную сессии
		$PD->restore($id);

		// Получаем информацию о пользователе
	        $user_info = User::getUserById($id);

		// Пропускаем пользователей без email
		if (!trim($user_info['email'])) continue;
	
		// Получаем сумму товаров
		$CART = new Cart();
		$total = $CART->getTotalPrice();

		// Рассчитываем время, прошедшее с момента последней генерации купонов
		$dt = DateTime::createFromFormat('Y-m-d H:i:s', $user_info['last_coupon']);
		// Пропускаем пользователей, которым недавно был выдан купон
		if ( time() - $dt->format('U') < NEXT_COUPON_TIMEOUT ) continue;
		
		// Генерируем купон для пользователя
		$coupon_name = 'TMP' . time() . $id;
		$dt = DateTime::createFromFormat('U', time()+COUPON_TIME);
		$coupon_date = $dt->format('Y-m-d');
		AdminClass::addCoupon($coupon_name, COUPON_PERCENT, COUPON_SUMM, COUPON_ACTIVATE, $id, $coupon_date);
		// Устанавливаем купон в переменную сессии
		$_SESSION['coupon'] = $coupon_name;

		// Выполняем расчёт корзины с учётом выпущенного купона
		$calculate = Cart::Calculate();
		//	print_r($calculate);
			//	print_r($_SESSION);
	//	print_r($user_info);
	
		$subject = "Вы забыли оформить свой заказ. Мы дарим скидку 5%";
                    include "../tempEmail/recallOrder/recallOrder.php";
                    @$message = $contentOrder;
                    $headers = "Content-type: text/html; charset=utf-8 \r\n";
                    $headers.= "From: ООО ЛИДЕР <sale@lider-gk24.ru>\r\n";
                    mail($user_info['email'], $subject, $message, $headers);

		
		// Отправляем Email
	

		// Обновляем время выпуска последнего купона
		User::lastCouponUpdate($id);
	}

	// Очищаем сохранйнные товары у отобранных пользователей
	foreach ($Users as $id=>$dt) { $PD->clear($id); }

	// Удаляем устаревшие мотивационные купоны
	// Желательно вынести в какую-то модель
        $db = Db::getConnection();
        $sql = 'DELETE FROM coupon WHERE coupon_time<CURDATE();';
        $result = $db->prepare($sql);
        $result->execute();
	
}
