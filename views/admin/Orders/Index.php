<?php include ROOT . '/views/admin/Index/Header.php'; ?>
<main class="main-cabinet-user main-cabinet-user-view main-cabinet-admin">
   <div class="container">
      <div class="cabinet-sidebar">
         <div class="btn-close__menu"></div>
         <?php include ROOT . '/views/admin/Index/Sidebar.php'; ?>
      </div>
      <div class="main-cabinet-user__content main-cabinet-admin__content">
         <ul class="breadcrumb breadcrumb-cabinet">
            <li><a href="/admin" title="Главная"><span>ГЛАВНАЯ</span></a></li>
            <li><a title="Заказы пользователей"><span>заказы пользователей</span></a></li>
         </ul>
         <h1>Заказы пользователей</h1>
         <div class="filter-cabinet-wrapper w-100">
        <form method="post" class="zak_form">
            <div class="filter-cabinet__box">
               <label><input class="search" type="text" placeholder="Поиск по номеру" name="search" maxlength="5" autocomplete="off"></label>
            </div>
            <div class="filter-cabinet__box">
               <label>
                  <input type="text" data-range="true" name="data" data-multiple-dates-separator=" - " placeholder="Поиск по дате" autocomplete="off" class="datepicker2-here dateZak"/>
               </label>
            </div>
            <div class="filter-cabinet__box">
               <label>
                  <select name="operator" class="select-admin select-form sortOperator">
                     <option>По оператору</option>
                     <?php foreach($operatorBase as $operatorBaseOne){ ?>
                               <option data-dob="<?php echo $operatorBaseOne['operator_dob']; ?>"><?php echo $operatorBaseOne['operator_name']; ?></option>
                       <?php } ?>
                  </select>
               </label>
            </div>
            <div class="filter-cabinet__box">
               <label>
                  <select name="status" class="select-admin select-form sortByStatus">
                     <option>По статусу</option>
                     <option>Оформлен</option>
                     <option>Выставлен счет</option>
                     <option>Отказ</option>
                     <option>Думает</option>
                     <option>Не отвечает</option>
                  </select>
               </label>
            </div>
          
        </form>  
        <div class="hiddenSearch">
        <p class="clickHide">Полный поиск</p>
        <p class="speczakaz">Спецзаказы</p>
        <form method="post" class="zak_form hiddenForm">
            <div class="filter-cabinet__box">
               <label>
                  <input type="text" data-range="true" name="data" data-multiple-dates-separator=" - " placeholder="Поиск по дате" autocomplete="off" class="datepicker2-here dateZak"/>
               </label>
            </div>
            <div class="filter-cabinet__box">
               <label>
                  <select name="operator" class="select-admin select-form">
                     <option>По оператору</option>
                     <option>Баранова Александра</option>
                     <option>Лебедева Екатерина</option>
                     <option>Мосорети Юлия</option>
                     <option>Николаева Марина</option>
                     <option>Петреева Екатерина</option>
                     <option>Рыжак Светлана</option>
                     <option>Шалимова Юлия</option>
                     <option>Яковчук Анна</option>
                  </select>
               </label>
            </div>
            <div class="filter-cabinet__box">
               <label>
                  <select name="status" class="select-admin select-form">
                     <option>По статусу</option>
                     <option>Отказ</option>
                     <option>Оформлен</option>
                     <option>Выставлен счет</option>
                     <option>Отказ</option>
                     <option>Думает</option>
                     <option>Не отвечает</option>
                  </select>
               </label>
            </div>
            <button type="submit" class="form_button" name="submit">Начать поиск</button>
        </form> 
        </div>
         </div>
         <div class="table table-orders w-100">
            <div class="table__head">
               <div class="table__th table-orders__number">№ и дата</div>
               <div class="table__th table-orders__full">ФИО</div>
               <div class="table__th table-orders__phone">Телефон</div>
               <div class="table__th table-orders__sum">Сумма</div>
               <div class="table__th table-orders__manager">Оператор/Менеджер</div>
               <div class="table__th table-orders__status">Статус</div>
               <div class="table__th table-orders__comment">Комментарий</div>
            </div>
            <div class="table__body">
                <?php foreach ($ordersList as $order): 
            $english_format_number = number_format($order['order_summ'], 2);
            $newDate = date("d-m-Y H:i:s", strtotime($order['date']));
            ?>
               <div class="table-body_line">
                  <div class="table__td table-orders__number">
                     <a href="/admin/order/view/<?php echo $order['id']; ?>">
                     <p><?php echo $order['order_number']; ?></p>
                     <p><?php echo $newDate; ?></p>
                     </a>
                  </div>
                  <div class="table__td table-orders__full">
                     <div><?php echo $order['user_name']; ?></div>
                     <?php 
                     $fastOrder = Order::getOrderById($order['id']);
                     if($fastOrder['user_id']) {
                        $innPrices = User::checkIfSpecialPricesExist($fastOrder['user_id']);
                     } else {
                        $innPrices = false;
                     }
                     
                     $userInfo = User::getUserById( $fastOrder['user_id']);
                     if ( $fastOrder['user_id'] == NULL ) { ?>
                     <p class="specOrderAdmin">быстрый заказ</p>
                     <?php } 
                     if (!$fastOrder['user_id'] == 0 ) { ?>
                        <div style="width:100%"> <img  src = "/template/images/Stock/userLogged.png" style=' width:20px; height:20px;margin: 0 auto' title="Пользователь выполнил вход в кабинет"></img></div>
                    <?php  }
                     if ($innPrices) { ?>
                     <p class="specOrderAdmin" style='height:auto; color:lightgrey; border:none; font-size:12px'>спеццена</p>
                     <?php } 
                     if ($userInfo['specialClientPrice']) { ?>
                     <p class="specOrderAdmin" style='height:auto; color:lightgrey; border:none; font-size:12px'>тип цены: <?php echo $userInfo['specialClientPrice'];?></p>
                     <?php } ?>
                  </div>
                  <div class="table__td table-orders__phone">
                     <p><?php echo $order['user_phone']; ?></p>
                  </div>
                  <div class="table__td table-orders__sum">
                     <p><?php echo $english_format_number; ?> ₽</p>
                  </div>
                  <div class="table__td table-orders__manager">
                     
                     <div class="table-orders__manager_box">
                        <label>
                           <select name="selOperator" class="select-admin select-form select-bg__grey selOperator">
                               <?php if(!empty($order['user_operator'])){ ?>
                               <option><?php echo $order['user_operator']; ?></option>
                               <?php } else { ?>
                               <option>Не назначен</option>
                               <?php } foreach($operatorBase as $operatorBaseOne){ ?>
                               <option data-dob="<?php echo $operatorBaseOne['operator_dob']; ?>"><?php echo $operatorBaseOne['operator_name']; ?></option>
                       <?php } ?>
                           </select>
                        </label>
                        <p>оператор</p>
                     </div>
                     <div class="table-orders__manager_box">
                        <label>
                           <select name="manager-select" class="select-admin select-form manager-select">
                              <?php if(!empty($order['user_manager'])){ ?>
                               <option><?php echo $order['user_manager']; ?></option>
                               <?php } else { ?>
                               <option>Не назначен</option>
                               <?php } foreach($managerBase as $managerBaseOne){ ?>
                               <option data-dob="<?php echo $managerBaseOne['manager_phone']; ?>"><?php echo $managerBaseOne['manager_name']; ?></option>
                               <?php } ?>
                           </select>
                        </label>
                        <p>менеджер</p>
                     </div>
                  </div>
                  <div class="table__td table-orders__status">
                     <label>
                         <span class="orders__status-circle does-not-answer" style="background: <?php echo $order['statusColor'] ?>"></span>
                        <select name="status-select" class="select-admin select-form select-choose status-select">
                        <?php if($order['order_status'] !=''){ ?>
                        <option><?php echo $order['order_status']; ?></option>
                        <?php } else { ?>
                        <option>Выбрать</option>
                        <?php } ?>
                         <option data-color="green">Оформлен</option>
                         <option data-color="yellow">Выставлен счет</option>
                         <option data-color="red">Отказ</option>
                         <option data-color="red">Думает</option>
                         <option data-color="red">Не отвечает</option>
                        </select>
                     </label>
                  </div>
                  <div class="table__td table-orders__comment">
                     <label><textarea name="comment_operator" class="comment_operator" maxlength="70" placeholder=""><?php echo $order['order_comment']; ?></textarea></label>
                  </div>
               </div>
               <?php endforeach; ?>
            </div>
         </div>
      </div>
   </div>
</main>
<?php include ROOT . '/views/admin/Index/Footer.php'; ?>
<script>

   $('.glob').click(function() {
	$('.datepicker2').hide();

   });
   
   
   
     $('.hiddenForm').css('display', 'none');
     
     $('.clickHide').click(function(){
         $('.hiddenForm').slideToggle(300);      
		return false;
         
     });
     
     $('.form_button').click(function(e){
       
       e.preventDefault()
        var dataBase = $('.globalZak').val();
        if(dataBase==''){
       
           alert('При сложной сортировке необходимо выбирать дату! Иначе система попросту не поймет о чем речь.');
           
        }   else {
           
               var $data = {};
               
               $('.hiddenForm').find('input, select').each(function() {
                  
                 $data[this.name] = $(this).val();
                 
               });
              
                $.ajax({
                     url: '/components/ajaxRequest/GlobalOrderSearch.php',
                     type: 'post',
                     data: $data,
                    
                     success: function(data) {
                        $(".table-orders").html(data); 
                      }
                 });
            } 
    });
    
    
    $('.speczakaz').on('click', function(){
       
      $.ajax({
                     url: '/components/ajaxRequest/speczakaz.php',
                     type: 'post',

                     success: function(data) {
                        $(".table-orders").html(data); 
                      }
                 });
    });
    
</script>