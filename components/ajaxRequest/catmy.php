<?php
// Подключение файлов системы
define('ROOT', dirname(__FILE__)."/../../");
require_once(ROOT.'/components/Autoload.php');
$cmd = @$_REQUEST['cmd'];
$is_custom = @$_REQUEST['custom'];
$paramsPath = $_SERVER['DOCUMENT_ROOT']. '/config/db_params.php';
$params = include($paramsPath);
$con = new mysqli($params['host'],$params['user'],$params['password'],$params['dbname']);  
include '../disabledAtributes.php';
switch ($cmd) {

  case 'content':
  case 'filter':
	// Получаем код категории
	$cid = API_parse_string( @$_REQUEST['cid'] );
	$cat_slug = API_parse_string( @$_REQUEST['cat_slug'] );
	if ( !$cid ) {
		// Определяем код категории по slug
		if ( $is_custom ) {
			$q = Category::CustomCatItems($cat_slug);
			$cid = $q['catCode'];
		} else {
			$q = Category::getChildCategory($cat_slug);
			$cid = $q['cat_code'];
		}
	}
	
	// Считываем опции запроса
	$SEL = Array();
	$selected = @$_REQUEST['selected'];
	if ($selected) {
		$tmp = explode(';',$selected);
		foreach ($tmp as $val) $SEL[$val]=1;
	}
	$filter_min_price = API_parse_number( @$_REQUEST['min_price'] );
	$filter_max_price = API_parse_number( @$_REQUEST['max_price'] );
	if(!@$_REQUEST['sorting']) {
		$filter_sorting = 'ASC';
	} else {
	$filter_sorting = API_parse_string( @$_REQUEST['sorting'] );
	}
	$filter_count = API_parse_number( @$_REQUEST['count'] );
	$filter_begin = API_parse_number( @$_REQUEST['begin'] );
	
	// Базовая структура ответа на запрос 'filter'
	$RES = (object) Array( 'status'=>'error', 'cid'=>'', 'count'=> 0, 'min_price'=>0, 'max_price'=>0, 'filters'=>Array() );
	
	if ($cid) {
		$RES->status = 'success';
		$RES->cid = $cid;

		// Получаем полный список атрибутов
		$ATTR = Array();
		$q = mysqli_query($con, "select * from Product_atributs");
		foreach ($q as $next) $ATTR[$next['atributId']] = $next;
		
		// Задаём порядок сортировки
		$sort_order='';
		switch ($filter_sorting) {
			case 'a-z':
				$sort_order = 'ORDER BY `product_name`';
				break;
			case 'z-a':
				$sort_order = 'ORDER BY `product_name` DESC';
				break;
			case 'ASC':
				$sort_order = 'ORDER BY CAST(`product_price` AS DECIMAL(10,2)) ASC';
				break;
			case 'DESC':
				$sort_order = 'ORDER BY product_price DESC';
				break;
			case 'availability':
				$sort_order = 'ORDER BY product_warehouse DESC';
				break;
		}
		
		// Получаем и обрабатываем список товаров в заданной категории
		$FILTER = Array(); $pcnt = 0;
		$PROD = Array(); $USED = Array();
		//Илья сказал, что продукты из категории под заказ должны быть полностью исключены с сайта, но я оставляю комментарии чтобы их можно было вернуть позже
	    //$productTable = $is_custom ? "ProductCustom" : "Product";
		$productTable = "Product";
		$q = mysqli_query($con, "select * from $productTable where product_category='$cid' and product_price > 0 $sort_order;");
		foreach ($q as $next) {

	    	$next['product_price'] = Product::getUserPrice($next);
			$PROD[$next['product_code']]['q'] = $next;
			$pcnt++;
			if ($next['product_atributs']) {
				$AList = explode( ';', $next['product_atributs'] );
				$AList = array_unique($AList);
				foreach ($AList as $next_attr) {
					$APair = $next_attr ? explode( ':', $next_attr ) : Array();
					if ( count($APair) == 2 ) {
						$tcode = $APair[0];
						$vcode = $APair[1];
					
						if ( isset($ATTR[$vcode]) ) {		// Пропускаем не существующие и ошибочные атрибуты
							$attribute = $ATTR[$vcode];
							if ( !isset($FILTER[$tcode]) ) $FILTER[$tcode] = Array( $attribute['atributTitle'], Array(), 0 );
							$FILTER[$tcode][2]++;		// Считаем общее число значений
							if ( !isset($FILTER[$tcode][1][$vcode]) ) $FILTER[$tcode][1][$vcode] = Array( $attribute['atributValue'], Array() );
							$FILTER[$tcode][1][$vcode][1][] = $next['product_code']; 

							// Сохраняем значения атрибутов у товаров
							$PROD[$next['product_code']][$vcode] = $tcode;
						}
					}
					
					// Помечаем атрибуты, у которых имеются выбранные значения
					if ($SEL[$vcode]) $USED[$tcode][$vcode] = 1;
				}
			}
			$PROD[$next['product_code']]['price'] = $next['product_price'];
			
			if ($RES->min_price == 0) $RES->min_price = $next['product_price'];
			$RES->min_price = $RES->min_price < $next['product_price'] ? $RES->min_price : $next['product_price'];
			$RES->max_price = $RES->max_price > $next['product_price'] ? $RES->max_price : $next['product_price'];
		}

		// Отбираем товары, подходяшие под текущий фильтр
		$PSHOW = Array(); $PUSED = Array();
		foreach ($PROD as $pcode => $P) {
			if ($filter_min_price !== '' && $P['price'] < $filter_min_price) continue;
			if ($filter_max_price !== '' && $P['price'] > $filter_max_price) continue;
			// Если имеются выбранные значения атрибутов
			if (count($SEL)) {
				// Проверяем что у товара имеется хотя-бы одно из выбранных значений для каждого из атрибутов с отметками
				$cnt1 = 0;
				foreach ($USED as $tc => $next_used) {
					$cnt2 = 0;
					foreach ($next_used as $vc => $val) {
						if ( isset($P[$vc]) ) $cnt2++;
					}
					if ($cnt2) $cnt1++;
				}
				if ( $cnt1 != count($USED) ) continue;
			}
			$PSHOW[] = $pcode;
			$PUSED[$pcode] = 1;
		}
		
		// Подсчитываем количества товаров в вариантах фильтров		
		foreach ($FILTER as $tcode => $next) {	
			// Пропускаем атрибуты, у которых только одно значение, имеющееся у всех товаров и атрибуты из списка исключений
		    $skipped = in_array ($next[0], $DISABLED_ATTRIBUTES) || in_array ($next[0], $DISABLED_ATTRIBUTES_SLUG[$cat_slug]);
			if (!$skipped) {
				$NEW = (object) Array( 'id'=>$tcode, 'title'=>$next[0], 'values'=>Array() );
				foreach ($next[1] as $vcode => $next_val) {
					// Вычисляем отобранное количество товаров для каждого варианта
					$cnt = 0;
					foreach($next_val[1] as $pcode) if (isset($PUSED[$pcode])) $cnt++;
					$NEW->values[] = (object) Array( 'id'=>$vcode, 'name'=>$next_val[0], 'count'=>$cnt );
				}
				$RES->filters[]=$NEW;
			}
		}
		// Общее число отобранных товаров
		$RES->count = count( $PSHOW );
	}

	// Выводим данные для формирования фильтра
	if ($cmd == 'filter') print json_encode($RES);

	// Формируем список отобранных товаров
	if ($cmd == 'content' && count($PSHOW)) {
		foreach ($PSHOW as $idx=>$pcode) {
			if ($idx < $filter_begin) continue;
			if ($idx >= $filter_begin + $filter_count) continue;
     			$product = $PROD[$pcode]['q'];
//----------------------------------------------------------------------------------------------------
// Подключаем блок отображения карточки товара
			 include '../../views/catalog/product-card.php';
//----------------------------------------------------------------------------------------------------
		}
	        if (count($PSHOW) > $filter_begin + $filter_count) { ?>
           <div class="row"><a href="#" class="btn btn_border-red load-more" title="">Загрузить еще</a></div>
	        <?php }
	}
	break;
	
  default:
	break;

}


// Обработка параметров (ограничение набора символов)
function API_parse_string ( $str ) { return preg_replace('/[^A-Za-z0-9\-_]/','',$str); }

// Обработка параметров (ограничение набора символов)
function API_parse_number ( $str ) { return preg_replace('/[^0-9]/','',$str); }
?>
