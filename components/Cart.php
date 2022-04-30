<?php
/**
 * Класс Cart
 * Компонент для работы корзиной
 */
class Cart {

    /**
     * Возвращает параметры купона $coupon
     * Если купон не найден, возвращает false;
     * @param string $coupon <p>проверяемый купон</p>
     * @return mixed: boolean or array
     */
    public static function getCoupons($coupon) {
	// Формируем список купонов
	$CouponsList = Array();
	
        // получаем id юзера из сессии
        $currentUser = User::getUserById($_SESSION['user']);
        // Выгребаем все по подписке по имейлу юзера
        $emailCouponSelfList = Order::emailCouponSelf($currentUser["email"]);
	foreach ($emailCouponSelfList as $emailCouponSelf)
	        if($emailCouponSelf['email'] == $currentUser["email"] && $emailCouponSelf['coupon_activate'] == 0 )
			$CouponsList[ $emailCouponSelf['coupon'] ] = Array ( $emailCouponSelf['discount'], 2000, 'email' );
			
	$dtoday = new DateTime();
	// Получаем список купонов из админки	
	$allCoupons = Order::allCoupons();
	foreach ($allCoupons as $oneCoupon) {
		if ($oneCoupon['coupon_activate'] < 0) continue;
		if ($oneCoupon['coupon_user_id'] && $oneCoupon['coupon_user_id'] != $currentUser['phone'] && $oneCoupon['coupon_user_id'] != $_SESSION['user']) continue;
		if ($oneCoupon['coupon_time']) {
			$dt = DateTime::createFromFormat('Y-m-d', $oneCoupon['coupon_time']);
			$dt->setTime(23,59,59);
			if ($dt < $dtoday) continue;
		}
	    $specialPricesExist= User::checkIfSpecialPricesExist($_SESSION['user_data']['id']);
		if((date("Hi") > "0600") && (date("Hi") < "2300") && $oneCoupon['coupon_name'] == 'НОЧЬ' && $specialPricesExist == true) {
			continue;
		}

		$couponType = 'user';
		$CouponsList[ $oneCoupon['coupon_name'] ] = Array ( $oneCoupon['coupon_procent'], $oneCoupon['coupon_summ'], $couponType );
	}
//	file_put_contents('.coupon.list.txt',print_r($CouponsList,true));
	
	if (isset($CouponsList[$coupon])) return $CouponsList[$coupon];
	else return false;
    }

    /**
     * Регистрирует новый купон
     * @param string $coupon <p>Купон для регистрации</p>
     */
    public static function addCoupon($coupon) {
	// Сохраняем новое значение купона в сессию
	$_SESSION['coupon'] = $coupon;
    }

    /**
     * Подсчет количество товаров в корзине (в сессии)
     * @return int <p>Количество товаров в корзине</p>
     */
    public static function countItems() {
        // Проверка наличия товаров в корзине
        if (isset($_SESSION['products'])) {
            // Если массив с товарами есть
            return count($_SESSION['products']);
        } else {
            // Если товаров нет, вернем 0
            return 0;
        }
    }

    /**
     * Возвращает массив с идентификаторами и количеством товаров в корзине<br/>
     * Если товаров нет, возвращает false;
     * @return mixed: boolean or array
     */
    public static function getProductsId() {

//	file_put_contents('_SESSION.txt',print_r($_SESSION,true));

 
        if (isset($_SESSION['products'])) {
            return $_SESSION['products'];
        }
        return false;
    }

    /**
     * Возвращает массив со списком товаров в корзине
     * @return array
     */
    public static function getProducts() {
	$result = Array();
        // Получаем массив с идентификаторами и количеством товаров в корзине
	$productsInCart = self::getProductsId();
	if ($productsInCart) {
		// Получаем информацию о продуктах
		$productsIds = array_keys($productsInCart);
		$products = Product::getProdustsByIds($productsIds);
		//var_dump($products);
		// Получаем информацию о скидках
		$discounts = Product::getProdustsDiscountByIds($productsIds);
		// Добавляем информацию о количестве товара в корзине
		foreach ($products as $idx => $item) {
			$isSpecialPrice = Special::returnIfSpecial($item);
			if($isSpecialPrice == false) {
			    
				$item['count'] = $productsInCart[$item['id']];				// Количество товара
				$item['discount'] = @$discounts[$item['id']];				// Правила применения скидок для товара
				// Рассчитываем стоимость товаров
				$item['cost'] = $item['count'] * $item['product_price'];		// Исходная цена товара
				$item['discount_cost'] = $item['cost'];					// Цена товара, после применения скидки за количество
				$item['rest_cost'] = $item['cost'];					// Цена части товара, на которую не применялась скидка

				// Применяем скидку на объём
				if (isset($discounts[$item['id']])) {
					$use_discount = 0;
					switch ( $discounts[$item['id']]['conditions_rules'] ) {
						case 'Равно':
							if ( $item['count'] %  $discounts[$item['id']]['count_rules'] == 0 ) $use_discount = floor ($item['count'] / $discounts[$item['id']]['count_rules']);
							break;
						case 'Больше':
							if ( $item['count'] > $discounts[$item['id']]['count_rules'] ) $use_discount++;
							break;
					}
					if ($use_discount) {
						if ( $discounts[$item['id']]['procent_rules'] ) {
							$item['discount_cost'] *= (100 - $discounts[$item['id']]['procent_rules']) / 100;
							$item['rest_cost'] = 0;				// Процентная скидка действует на все товары
						}
						if ($discounts[$item['id']]['rub_rules']) {
							$item['discount_cost'] -= $use_discount * $discounts[$item['id']]['rub_rules'];
							if ( $discounts[$item['id']]['conditions_rules'] == 'Равно' )
								$item['rest_cost'] -= $use_discount * $discounts[$item['id']]['count_rules'] * $item['product_price'];
							else $item['rest_cost'] = 0;			// Для вариантов 'Меньше' и 'Больше' процентная скидка действует на все товары
						}
					}
				}
				$result[$item['id']] = $item;
			} else {
			    die();
				$item['count'] = $productsInCart[$item['id']];				// Количество товара
				$item['discount'] = '';				// Правила применения скидок для товара
				// Рассчитываем стоимость товаров
				$item['cost'] = $item['count'] * $item['product_price'];		// Исходная цена товара
				$item['discount_cost'] = $item['cost'];					// Цена товара, после применения скидки за количество
				$item['rest_cost'] = $item['product_price'];		
				$result[$item['id']] = $item;
			}
		}
	}  
		
		self::applyDiscountGroupRestriction($result);
        return $result;
    }
	    /**
     * удаляет скидку когда не выполняются условия группы
	 * @param $products изменяется внутри функции 
     */
    private static function applyDiscountGroupRestriction(&$products) {	
		$discount_groups = [];
		foreach($products as &$oneProduct) {
			if ($oneProduct['discount']['discount_group']) {
				if (!array_key_exists($oneProduct['discount']['discount_group'], $discount_groups)) {
					$discount_groups[$oneProduct['discount']['discount_group']] = array(
						"a" => array(),
						"b" => array()
					);
				}
				$discount_groups[$oneProduct['discount']['discount_group']][$oneProduct['discount']['discount_group_side']][] = $oneProduct;
			}
		} 
		//Проходим по ассоциативному массиву продуктов с групповой скидкой и удаляем скидку у тех, у кого нет парной группы 
		foreach($discount_groups as $discount_group) {
			$discount_group_num =  array_search($discount_group,$discount_groups);
			if (empty($discount_group['a'])) {
				foreach($products as &$oneProduct) {
					if ($oneProduct['discount']['discount_group'] == $discount_group_num ) {
						unset($oneProduct['discount']);
						$oneProduct['discount_cost'] = $oneProduct['cost'];
					}
				}
			}
			if (empty($discount_group['b'])) {
				foreach($products as &$oneProduct) {
					if ($oneProduct['discount']['discount_group'] == $discount_group_num ) {
						unset($oneProduct['discount']);
						$oneProduct['discount_cost'] = $oneProduct['cost'];
					}
				}
			}
		}
		return $products;
	}
    /**
     * Возвращает общую стоимость товаров в корзине после применения скидки за количество
     * @return integer <p>Общая стоимость</p>
     */
    public static function getTotalPrice($products = false) {
	
        // Подсчитываем общую стоимость товаров в корзине
        $total = 0;
        // Получаем массив с идентификаторами и количеством товаров в корзине
	if ($products == false) $products = self::getProducts();

	// Проходим по массиву товаров в корзине
	foreach ($products as $item) {
		// Находим общую стоимость: цена товара * количество товара
		$total+= $item['discount_cost'];
	} 
        return round($total, 2);
    }
    public static function getSeparateItemsFromOrder($products) {
		$items_for_table = [];
		$totalSumOfItems = 0;
		foreach ($products as $item) {
			$items_for_table[] = $item;
		} 
		return($items_for_table);
	}
    /**
     * Возвращает общую стоимость товаров в корзине, на которую не применялась скидка на количество
     * @return integer <p>Общая стоимость</p>
     */
    public static function getRestPrice($products = false) {
        // Подсчитываем общую стоимость товаров в корзине
        $total = 0;
        // Получаем массив с идентификаторами и количеством товаров в корзине
	if ($products == false) $products = self::getProducts();

	// Проходим по массиву товаров в корзине
	foreach ($products as $item) {
		// Находим общую стоимость: цена товара * количество товара
		$total+= $item['rest_cost'];
	}
        return round($total, 2);
    }

    /**
     * Возвращает расчёт по товарам в корзине с учётом скидок и стоимости доставки
     * Если товаров нет, возвращает false;
     * @return mixed: boolean or object
     */
    public static function Calculate() {
        
        // Получаем массив с идентификаторами и количеством товаров в корзине
        $productsInCart = self::getProductsId();

	    // Если в корзине не пусто
        if ($productsInCart) {
        	$Res = Array();

		// Получаем список продуктов
		$Res['products'] = self::getProducts();

		// Получаем стоимость товаров в корзине после применения скилки за количество
	        $totalPrice = self::getTotalPrice($Res['products']);   
		// Получаем стоимость части товаров в корзине, на которые не применялась скидка на количество
	        $restPrice = self::getRestPrice($Res['products']);
	        
		// Рассчитываем стоимость доставки
		$deliveryCost = 0;
		$discountPrice = 0;
		$deliveryAlert = '';
		if ($totalPrice < 3000) $deliveryAlert = 'nodelivery';
		if ($totalPrice >= 3000 && $totalPrice < 5000){
		    $moreSum = 5000-$totalPrice;
		    $deliveryCost = 500;
		    $nextStep = 'Закажите еще на '.$moreSum.'₽ для бесплатной  доставки по г. Москва';
		} 
		
		// Рассчитываем скидку по купону
		$couponDiscount = 0;
		$couponType = '';
		$couponAlert = '';
		$coupon = @$_SESSION['coupon'];
		
		$CouponsList = self::getCoupons($coupon);
		if ( isset($CouponsList) ) {
			// Купон найден
			$couponDiscount = $CouponsList[0];
			if ( $totalPrice <  $CouponsList[1] ) {
				// Сумма заказа недостаточна для применения данного купона
				$couponAlert = $CouponsList[1];
			} else {
				// Применяем скидку по купону
				$discountPrice = round($restPrice*$couponDiscount/100, 2);
				$couponType = $CouponsList[2];
			}
		}

        /**
         * Расчет данных суммы за предыдущий месяц для авторизованного клиента. 
         * Получаем его id->номер_телефона->сумму за предудущий месяц и присваеваем статус
        */
	    
	    if (!User::isGuest()) {
	        
            $userId = User::checkLogged();
    	    $userInform = User::getUserById($userId);
    	    // Получаем номер и сумму всех заказов пользователя с таким номером телефона
            $allSummOrderUser = User::allSummOrderUser($userInform["phone"]);
            
	    }
	    
        /**
         * // Конец компонента расчета статуса для программы лояльности
        */

       // Рассчитываем итоновую сумму с учётом скидки и доставки
		$finalPrice = round($totalPrice - $discountPrice + $deliveryCost, 2);
		$Res['Count']=self::countItems();			    // Количество товаров в корзине
		$Res['TotalPrice']=$totalPrice;				    // Общая сумма товаров в корзине без учёта скидок
		$Res['DeliveryCost']=$deliveryCost;			    // Стоимость доставки
		$Res['DeliveryAlert']=$deliveryAlert;		    // Признак невозможности доставки
		$Res['CouponDiscount']=$couponDiscount;		    // Скидка по купону (%)
		$Res['CouponType']=$couponType;				    // Тип купона (по подписке или из админки)
		$Res['CouponAlert']=$couponAlert;			    // Признак гн применения купона - необходимая сумма для применения
		$Res['DiscountPrice']=$discountPrice;		    // Скидка по купону
		$Res['FinalPrice']=$finalPrice;				    // Итоговая сумма заказа с учётом скидок и стоимости доставки
        $Res['TotalPriceLoyalty']=$totalPriceLoyalty;   // Сумма скидки по программе лояльности
        $RES['loyaltyStatus']=$loyaltyStatus;           // Получение статуса пользователя
        $Res['Status']=$loyaltyStatus;                  // вывод статуса
        $Res['Procent']=$loyaltyDiscount;               // вывод суммы скидки
        $Res['nextSum']=$nextStep;                      // сумма допродажи доставки
        $Res['writeToOrderItemsArray'] = self::getSeparateItemsFromOrder($Res['products']);
		return (object) $Res;
	}
	return false;	
    }
    
    /**
     * Добавляет товар с указанным $id в корзину или Изменяет количество у существующего товара на $count
     * Для существующего товара параметр $count может иметь отризательные значения
     * Если изменений количества даст в итоге нулевое или отрицательное значение количества товара, изменение не производится
     * @param integer $id <p>id товара</p>
     * @param integer $count <p>количество товара</p>
     */
    public static function addProduct($id, $count) {
	// При наличии товара с указанным $id и данных об изменении количества
	if ( Product::getProdustsByIds(Array($id)) and $count ) {
	        $productsInCart = self::getProductsId();		// Считываем список товаров в корзине из сессии
		if (array_key_exists($id, $productsInCart)) {		// Если такой товар уже есть в корзине
			$productsInCart[$id]+= intval($count);
			if ($productsInCart[$id] < 1)			// При получении отрицательного значения откатываем изменение
				$productsInCart[$id]-=intval($count);
		} else {
			$productsInCart[$id] = intval($count);		// Добавляем новый товар в корзину
		}
	        // Сохраняем новый список товаров в сессии
	        $_SESSION['products'] = $productsInCart;

	        if(!isset($_SESSION['start_time']))
	            {
        	        $_SESSION['start_time'] = time();
	            }

		// Сохраняем изменения корзины в таблицу сохранённых товароы	            
		self::saveProducts();
	}
    }

    /**
     * Добавляет товар с указанным $id в корзину или Устанавливает количество у существующего товара в значение $count
     * @param integer $id <p>id товара</p>
     * @param integer $count <p>количество товара</p>
     */
    public static function setProduct($id, $count) {
	// При наличии товара с указанным $id и данных об изменении количества
	if ( Product::getProdustsByIds(Array($id)) and $count ) {
	        $productsInCart = self::getProductsId();	// Считываем список товаров в корзине из сессии
		$productsInCart[$id]= intval($count);		// Устанавливаем количество товара
	        $_SESSION['products'] = $productsInCart;	// Сохраняем новый список товаров в сессии

		// Сохраняем изменения корзины в таблицу сохранённых товароы	            
		self::saveProducts();
	}  
    }

    /**
     * Удаляет товар с указанным id из корзины
     * @param integer $id <p>id товара</p>
     */
    public static function deleteProduct($id) {
        // Получаем массив с идентификаторами и количеством товаров в корзине
        $productsInCart = self::getProductsId();
        // Удаляем из массива элемент с указанным id
        unset($productsInCart[$id]);
        // Записываем массив товаров с удаленным элементом в сессию
        $_SESSION['products'] = $productsInCart;

	// Сохраняем изменения корзины в таблицу сохранённых товароы	            
	self::saveProducts();
    }

    /**
     * Сохраняет корзину в отдельную таблицу, для отправки мотивационного купона
     */
    public static function saveProducts() {
	$user_id = @$_SESSION['user'];
	if ($user_id) { 
		// Создаём экземпляр класса для работы с сохранёнными списками товаров
		$PD = new ProductDrop();
		// Получаем текущий список товаров в корзине
		$productsInCart = self::getProductsId();
		// Сохраняем список товаров
		$PD->save($user_id,$productsInCart);
	}
    }
    
    /**
     * Очищает корзину
     */
    public static function clear() {
        if (isset($_SESSION['products'])) {
            unset($_SESSION['products']);
            unset($_SESSION['delivery']);
            unset($_SESSION['discount']);
            unset($_SESSION['start_time']);

	    // Также удаляем сохранённые товары
	    self::saveProducts();
        }
    }
}