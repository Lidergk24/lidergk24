<?php include ROOT . '/views/cabinet/Index/Header.php'; ?>
<main class="main-cabinet-user main-cabinet-user-view main-cabinet-admin">
   <div class="container">
      <div class="cabinet-sidebar">
         <div class="btn-close__menu"></div>
         <?php  include ROOT . '/views/cabinet/Index/CabinetMenu.php'; 
         $environment = include_once($_SERVER['DOCUMENT_ROOT'] . '/config/environment.php');?>
      </div>
      <div class="main-cabinet-user__content main-cabinet-admin__content">
         <ul class="breadcrumb breadcrumb-cabinet">
            <li><a href="/cabinet" title="Главная"><span>ГЛАВНАЯ</span></a></li>
            <li><a href="/cabinet/special" title="Главная"><span>СпецЦены</span></a></li>
            <li><a><span>Оформление заказа</span></a></li>
         </ul>
         <div class="parentBlock" style="display:block;">
            <div class="basket__table basket__table_view basket__table_view_admin table w-100">
               <div class="table__head">
                  <div class="table__th basket__table_photo">Фото товара</div>
                  <div class="table__th basket__table_article">Артикул</div>
                  <div class="table__th basket__table_name" style="width: 35%;">Название</div>
                  <div class="table__th basket__table_price">Цена</div>
                  <div class="table__th basket__table_quantity" style="width: 20%;">Количество</div>
               </div>
               <div class="table__body">
                  <?php foreach ( $totalItems as $productOne ) {

			//file_put_contents('_P.txt',print_r($productOne,true),FILE_APPEND);
                
	    		$productOne['product_price'] = Special::getUserPrice($productOne);
			//file_put_contents('_P.txt',"[".$productOne['product_price']."]\n",FILE_APPEND);

		?>
                              
                  <div class="table-body_line" data-id="<?php echo $productOne['id']; ?>" data-code="<?php echo $productOne['product_part_number']; ?>">
                     <div class="table__td basket__table_photo">
                        <input type="checkbox" class="product_select" style="width: 20px; margin: 15px;">
                       
                        <a href="/product/<?php echo $productOne['product_part_number']; ?>" target="_blank" class="basket__table_img" title="<?php echo $productOne['product_name']; ?>">
                        <img width="60" src="/upload/<?php $whole = $productOne['product_image']; $a = (json_decode($whole)); echo($a["0"] -> {"0"});?>">
                        </a>
                     </div>
                     <div class="table__td basket__table_article">
                        <p><?php  echo $productOne['product_part_number']; ?></p>
                     </div>
                     <div class="table__td basket__table_name" style="width: 35%;">
                        <a href="/product/<?php echo $productOne['product_part_number']; ?>" target="_blank" class="basket__table_title" title="<?php echo $productOne['product_name']; ?>"><?php echo $productOne['product_name']; ?></a>
                     </div>
                     <div class="table__td basket__table_price">
                        <p class="specPrice"><?php echo $productOne['product_price']; ?> ₽</p>
                     </div>
                     <div class="table__td basket__table_quantity" style="width: 26%;">
                        <span class="down repeatDown" data-order="<?php echo $productOne['miz_zakaz']; ?>" data-price="<?php echo $productOne['product_price']; ?>">-</span>
                        <input type="text" class="amount__text count_item hideSs" name="count_product" data-price="<?php echo $productOne['product_price']; ?>" maxlength="5" data-id="<?php echo $productOne['id']; ?>" data-code="<?php echo $productOne['product_part_number']; ?>" data-product_count="" value="<?php echo $productOne['miz_zakaz']; ?>" <?php if($productOne['miz_zakaz']>1){ echo "readonly='readonly'"; } ?>/>
                        <span class="up repeatUp" data-order="<?php echo $productOne['miz_zakaz']; ?>" data-price="<?php echo $productOne['product_price']; ?>">+</span>
                        <p class="totalItemThis"><span></span></p>
                     </div>
                  </div>
                  <?php  } ?>
               </div>
            </div>
            <textarea style="width:100%;" rows="6" name="comment" class="comment" placeholder="Ваш комментарий (если есть)"></textarea>
            <p> Адрес доставки</p>
            <select class="specialEndAdress">
                <option><?php echo $selectINNUser["ur_adress"]; ?></option>
                <?php foreach ( $userAdress as $userAdressOne ) { ?>
                <option>г. <?php echo $userAdressOne['city'].', улица '.$userAdressOne['street'].', д.'.$userAdressOne['house'];
                
                    if(!empty($userAdressOne['korpus'])){ echo ', '.$userAdressOne['korpus']; }
                    
                       echo  ', '.$userAdressOne['office'];
                     
                    ?>
                </option>
                <?php } ?>
            </select>
            
            
            <p>Юр лицо</p>
            
            
             <?php if(!empty($getUserByProfileUr)){ ?>
              <select class="specialEndUr">
              <?php
             //  var_dump($getUserByProfileUr); echo "<br>";
              foreach ( $getUserByProfileUr as $getUserByProfileUrOne ) { ?>
          <option><?php  echo $getUserByProfileUrOne["ur_profile"].' - '.$getUserByProfileUrOne["ur_inn"]; ?></option>
            <?php  }
            ?>
            </select>
            <?php } ?>
            <div class="cartTotal" style="display:block;">
               <p class="totalOrderPrice">Сумма заказа: <span></span></p>
               <p class="totalOrderCount">Товаров в заказе: <span></span></p>
                <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " placeholder="Даты доставки" class="datepicker2-here dateDelivery"/>
                <div class="form-group__label w-100">
                  <span class="form-group__title">Время доставки</span>
                  <ul class="list-radio">
                     <li class="list-radio__item">
                        <label class="radio">
                        <input class="radio-inp" type="radio" value="09:00 - 15:00" checked="" name="time">
                        <span class="radio-custom"></span>
                        <span class="label">09:00 - 15:00</span>
                        </label>
                     </li>
                     <li class="list-radio__item">
                        <label class="radio">
                        <input class="radio-inp" type="radio" value="15:00 - 21:00" name="time">
                        <span class="radio-custom"></span>
                        <span class="label">15:00 - 21:00</span>
                        </label>
                     </li>
                     <li class="list-radio__item">
                        <label class="radio">
                        <input class="radio-inp" type="radio" value="21:00 - 03:00" name="time">
                        <span class="radio-custom"></span>
                        <span class="label">21:00 - 03:00</span>
                        </label>
                     </li>
                  </ul>
               </div>
               <a href="#" 
               data-manager-phone="<?php echo $infoResult["manager_phone"]; ?>" 
               data-manager-email="<?php echo $infoResult["manager_email"]; ?>"
               data-manager-name="<?php echo $infoResult["manager_name"]; ?>"
               data-operator-phone="<?php echo $infoResult2["operator_phone"].' доб.: '.$infoResult2["operator_dob"]; ?>"
               data-operator-email="<?php echo $infoResult2["operator_email"]; ?>"
               data-operator-name="<?php echo $infoResult2["operator_name"]; ?>"
               data-inn="<?php echo $selectINNUser["ur_inn"]; ?>"
               data-names="<?php echo $selectINNUser["ur_contact"]; ?>"
               data-company="<?php echo $selectINNUser["ur_company"]; ?>"
               data-urphone="<?php echo $selectINNUser["ur_phone"]; ?>"
               data-items='<?php echo json_encode($totalItems); ?>'
               data-email="<?php echo $user["email"]; ?>"
              
               class="sendSpecialOrder">Оформить заказ</a>
            </div>
         </div>
      </div>
   </div>
</main>
</div>
<?php include ROOT . '/views/cabinet/Index/Footer.php'; ?>

<script>

$(function() {

	// Инициализация DatePicker
	$('.dateDelivery').datepicker2();


	var ajaxQueue = Array();	// Очередь обновления
	var ajaxFlag = 0;		// Флаг для запрета параллельных Ajax-запросов

	// Обновляем данные на странице в соответствии с текущими данными в сессии
	special_order_load();
	
	// При любом изменени в данных вызываем обработчик для записи id товара в очередь
	$('.product_select').change(special_order_change_count);
	$('input[name=count_product]').change(special_order_change_count);
	$('.up, .down').click(special_order_change_count);
	
	// Запускаем процесс-обработчик очереди изменений
	setInterval(special_order_processing_queue,200);

	// Начальная загрузка данных заказа
	function special_order_load() {
		// Получаем текущий список товаров в заказе
		$.ajax('/special/listAjax', {
			method: 'POST',
			dataType: 'json',
			cache: false,
			success: function (d) {
				special_order_list_update(d.list);
				special_order_total_update(d.total);
				$('.parentBlock').fadeIn();
			}
		});
	}
	
	// Обновление списка товаров в соответствии с загруженными данными
	function special_order_list_update (list) {
		if (list.length) for (var i=0; i<list.length; i++) {
			var code = list[i].code;
			var count = list[i].count;
			$('.table-body_line').each( function() {
				if ( $($(this).find('.count_item')[0]).data('code') == code ) {
					$(this).find('.product_select')[0].checked = true;
					$(this).find('.count_item')[0].value = count;
				}
			});
		}
	}
 
	// Обновление итоговых значений
	function special_order_total_update (total) {
		if (total.cnt) {
			$('.totalOrderCount span').text(total.cnt);
			$('.totalOrderPrice span').text(total.sum.toFixed(2));
			$('.cartTotal').show();
			$('.cartEmpty').hide();
		} else {
			$('.cartTotal').hide();
			$('.cartEmpty').show();
		}
	}

	// Обработка изменения количества товара
	function special_order_change_count(e) {
		var row = $(e.target).closest('.table-body_line');
		// Заносим товар в очередь обновлений
		ajaxQueue.push(row);
	}
	
	// Процесс-обработчик очереди изменений
	function special_order_processing_queue () {
		if (ajaxFlag) return;		// Запрос уже выполняется
		if (!ajaxQueue.length) return;	// Очередь обновлений пуста

		// Устанавливаем флаг для запрета повторного запроса до окончания текущего
		ajaxFlag++;

		// Берём первый элемент для обработки
		var row = ajaxQueue.shift();
		
		// Безопасно очищаем очередь от всех элементов с отобранным id
		var copyQueue = Array();
		while (next = ajaxQueue.shift()) copyQueue.push(next);
		while (next = copyQueue.pop()) if (next.data('code')!=$(row.find('.count_item')[0]).data('code')) ajaxQueue.unshift(next);

		var code = $(row.find('.count_item')[0]).data('code');
		var checked = row.find('.product_select')[0].checked;
		var count = row.find('.count_item').val();
		$.ajax('/special/setAjax/'+code, {
			data: { count: checked ? count : 0 },
			method: 'POST',
			dataType: 'json',
			cache: false,
			success: function (d) { special_order_total_update(d.total); },
			complete: function(){ ajaxFlag = 0; }	// Разрешаем новый запрос
		}); 
	};
	
	$('.sendSpecialOrder').click(function(e) {

        e.preventDefault();
        
        var adres = $('.specialEndAdress').val();
        var urlico = $('.specialEndUr').val();
        
        var managerPhone = $('.sendSpecialOrder').attr("data-manager-phone");
        var managerEmail = $('.sendSpecialOrder').attr("data-manager-email");
        var managerName =  $('.sendSpecialOrder').attr("data-manager-name");

        var operatorPhone = $('.sendSpecialOrder').attr("data-operator-phone");
        var operatorEmail = $('.sendSpecialOrder').attr("data-operator-email");
        var operatorName = $('.sendSpecialOrder').attr("data-operator-name");

        var deliveryDate = $('input[name="date"]').val();
        var deliveryTime = $('input[name="time"]:checked').val();
        var innUser = $('.sendSpecialOrder').attr("data-inn");
        var comment = $('.comment').val();
        var companyName = $('.sendSpecialOrder').attr("data-company");
        var phoneClient = $('.sendSpecialOrder').attr("data-urphone");
        var names = $('.sendSpecialOrder').attr("data-names");
        var its = $('.sendSpecialOrder').attr("data-items");
        var email = $('.sendSpecialOrder').attr("data-email");
        var itogSumm = parseFloat($('.totalOrderPrice span').html());
        
        $.post("/cabinet/specialorder", {

                items: its,
                inn : innUser,
                coment: comment,
                company: companyName,
                phone: phoneClient,
                time: deliveryTime,
                date: deliveryDate,
                oN: operatorName,
                oE: operatorEmail,
                Op: operatorPhone,
                mP: managerPhone,
                namS: names,
                mE: managerEmail,
                mN: managerName,
                sum: itogSumm,
                adress: adres,
                ur: urlico,
                m: email

            },
            function(data) {
                if (data == 1) {
                    $('.parentBlock').html('<p class="itsOkOrder">Спасибо! Ваш заказ по спецценам принят в обработку оператором</p>');
                    setTimeout(function() {
                        var url = <?php echo $environment["base_url"]; ?>/cabinet/special";
                        $(location).attr('href',url);
                    }, 3000);
                }
        }, 'json');
    });
});
</script>