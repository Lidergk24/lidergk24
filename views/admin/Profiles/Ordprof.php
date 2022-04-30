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
            <li><a href="/admin/allprofile" title="Все профили"><span>Профили</span></a></li>
            <li><a ><span><?php echo $allInfprmByProfile["ur_profile"]; ?></span></a></li>
         </ul>
         <h1>Просмотр профиля</h1>
         <div class="profile-wrapper w-100">
            <div class="profile-info__box">
               <div class="profile-info__box_title">Данные профиля:</div>
               <ul class="list-characteristics">
                  <li class="list-characteristics__item">
                     <p>Наименование:</p>
                     <span><?php echo $allInfprmByProfile["ur_company"]; ?></span>
                  </li>
                  <li class="list-characteristics__item">
                     <p>ИНН: </p>
                     <span id="inn"><?php echo $allInfprmByProfile["ur_inn"]; ?></span>
                  </li>
                  <li class="list-characteristics__item">
                     <p>Контакт:</p>
                     <span><?php echo $allInfprmByProfile["ur_contact"]; ?></span>
                  </li>
                  <li class="list-characteristics__item">
                     <p>E-mail:</p>
                     <span><?php echo $allInfprmByProfile["ur_email"]; ?></span>
                  </li>
                  <li class="list-characteristics__item">
                     <p>Телефон:</p>
                     <span id="call"><?php echo $allInfprmByProfile["ur_phone"]; ?></span>
                  </li>
                  <li class="list-characteristics__item">
                     <p>Город:</p>
                     <span><?php echo $allInfprmByProfile["ur_adress"]; ?></span>
                  </li>
               </ul>
            </div>
            <div class="profile-info__manager">
               <div class="profile-info__manager_item">
                  <div class="profile-info__manager_line">
                     <p>Менеджер клиента:</p>
                     <div class="profile-info__manager_name">
                         <select name="selectManager" class="selectManager selM">
                             <?php if(!empty($sqlDate1["user_manager"])){ ?>
                               <option><?php echo $sqlDate1["user_manager"]; ?></option>
                               <?php } else { ?>
                               <option>Не назначен</option>
                               <?php } foreach($managerBase as $managerBaseOne){ ?>
                               <option data-dob="<?php echo $managerBaseOne['manager_phone']; ?>"><?php echo $managerBaseOne['manager_name']; ?></option>
                               <?php } ?>
                         </select>
                         <p class="mn" style="color:green; display:contents;"></p>
                     </div>
                  </div>
                  <div class="block__hidden_manager">
                     <p class="date-profile">Дата создания профиля: <span class="value-profile"><?php echo $allInfprmByProfile["creation_date"]; ?></span></p>
                     <p>Всего заказов: <span class="value-profile"><?php echo count($allOrderByProfileAdmin); ?></span></p>
                     <p>Сумма заказов: <span class="value-profile"><?php echo round($summ["SUM(order_summ)"],2); ?> ₽</span></p>
                  </div>
               </div>
               <div class="profile-info__manager_item">
                  <div class="profile-info__manager_line">
                     <p>Оператор клиента:</p>
                     <div class="profile-info__manager_name">
                         <select name="selectOperator" class="selectManager selO">
                             <?php if(!empty($sqlDate1['user_operator'])){ ?>
                               <option><?php echo $sqlDate1['user_operator']; ?></option>
                               <?php } else { ?>
                               <option>Не назначен</option>
                               <?php } foreach($operatorBase as $operatorBaseOne){ ?>
                               <option data-dob="<?php echo $operatorBaseOne['operator_dob']; ?>"><?php echo $operatorBaseOne['operator_name']; ?></option>
                       <?php } ?>
                         </select>
                         <p class="sm" style="color:green; display:contents;"></p>
                     </div>
                  </div>
                  <div class="block__hidden_manager">
                     <p>У клиента есть спеццены?: <span class="value-profile"><input type="checkbox" class="chekboxSpecial" <?php if($sqlDate1["specialClient"]=='yes'){ ?> checked <?php } ?>></span></p>
                  </div>
                   <div class="block__hidden_manager">
                     <p>Тип цены клиента: 
                        <select name="tipCen" class="selectManager selC">
                            <?php if(!empty($sqlDate1['specialClientPrice'])){ ?>
                            <option><?php echo $sqlDate1['specialClientPrice']; ?></option>
                            <?php } ?>
                            <option>Выбрать</option>
                            <option>Оптовая</option>
                            <option>Цена1</option>
                            <option>Цена2</option>
                            <option>Цена3</option>
                        </select>
                        <p class="mn" style="color:green; display:contents;"></p>
                     </p>
                  </div>
               </div>
            </div>
            
             <p class="dopAdmin">Адреса доставки</p>
            <div class="profile-info__manager" style="width:100%;">
                 
               <div class="profile-info__manager_item">
                    <ul>
                    <li><?php echo $allInfprmByProfile["ur_adress"]; ?></li><br>
                     <?php
                     
                     foreach ( $userAdress as $userAdressOne ) { 
                         
                         echo '<li>'.$userAdressOne["city"].', '.$userAdressOne["street"].', '.$userAdressOne["house"].'</li>';
                     }
                     
                     
                     ?>
                  </ul>
               </div>
              
            </div>
            <p class="dopAdmin">Добавить адрес доставки</p>
            <div class="profile-info__manager" style="width:100%;">
               <div class="profile-info__manager_item">
                  
                    <input type="text" placeholder="Город" name="gorod" style="width:22%;">
                    <input type="text" placeholder="Улица" name="street" style="width:23%;">
                    <input type="text" placeholder="Дом" name="dom" style="width:23%;">
                    <input type="text" placeholder="Квартира, офис, домофон" name="dop" style="width:23%;">
                    <button class="addNewAdress">Создать</button>
                  
               </div>
              
            </div>
            
         </div>
          <p class="dopAdmin">Заказы профиля</p>
          <?php if(!empty($allOrderByProfileAdmin)){ ?>
         <div class="info-orders__table_admin table-profile__admin table w-100">
            <div class="table__head">
               <div class="table__th info-orders__table_number_orders">Номер заказа</div>
               <div class="table__th info-orders__table_data_orders">Дата</div>
               <div class="table__th info-orders__table_delivery_orders">Способ получения</div>
               <div class="table__th info-orders__table_pay_orders">Способ оплаты</div>
               <div class="table__th info-orders__table_sum_orders">Сумма заказа</div>
            </div>
            <div class="table__body">
               
               <?php foreach ($allOrderByProfileAdmin as $allOrderByProfileAdminOne): ?>
               <div class="table-body_line">
                  <div class="table__td info-orders__table_number_orders">
                     <a href="/admin/order/view/<?php echo $allOrderByProfileAdminOne['id']; ?>" class="color_blue" title="">Заказ №<?php echo $allOrderByProfileAdminOne ["order_number"]; ?></a>
                  </div>
                  <div class="table__td info-orders__table_data_orders">
                     <p><?php echo $allOrderByProfileAdminOne["date"]; ?></p>
                  </div>
                  <div class="table__td info-orders__table_delivery_orders">
                     <p><?php echo $allOrderByProfileAdminOne["delivery_method"]; ?></p>
                  </div>
                  <div class="table__td info-orders__table_pay_orders">
                     <p><?php echo $allOrderByProfileAdminOne["payment_method"]; ?></p>
                  </div>
                  <div class="table__td info-orders__table_sum_orders">
                     <p><?php echo $allOrderByProfileAdminOne["order_summ"]; ?> ₽</p>
                  </div>
               </div>
                <?php endforeach; ?>
            </div>
         </div>
        <?php } else { echo "На данный профиль еще не оформляли заказов :("; } ?>
      </div>
   </div>
</main>
<?php include ROOT . '/views/admin/Index/Footer.php'; ?>

<script>

     $('.selM').change(function(){
      
     var manager = $('.selM').val();
     //var innAgent = $('.list-characteristics__item:eq(8) span').html();
     var innAgent = $('.list-characteristics__item span#call').html();
     
     $.ajax({
         
             type: "POST",
             url: "/components/ajaxRequest/updateProfile.php",
             data: { m: manager, inn: innAgent},
             success: function (data) {
                 if (data == 'success') {
                     
                    $('.mn').html('Успешно!');
                    
                    setTimeout(function () {
                        
                         $(".mn").fadeOut(500);
                         
                    }, 2000);
                    
                 } 
             }
         });
    
    });    
    
    $('.selO').change(function(){
       
    var operator = $('.selO').val();
    //var innAgents = $('.list-characteristics__item:eq(8) span').html();
    var innAgents = $('.list-characteristics__item span#call').html();
    
    var selC = $('.selC').val();
    console.log(selC);
    
      $.ajax({
         
             type: "POST",
             url: "/components/ajaxRequest/updateProfile.php",
             data: { o: operator, inn: innAgents},
             success: function (data) {
                 
                 if (data == 'success') {
                     
                    $('.sm').html('Успешно!');
                    
                    setTimeout(function () {
                        
                         $(".sm").fadeOut(500);
                         
                    }, 2000);
                    
                 } 
             }
         }); 
    
    });    
        
    $('.chekboxSpecial').click(function(){
   
        //var userAgent = $('.list-characteristics__item:eq(8) span').html();
        var userAgent = $('.list-characteristics__item span#call').html();
        
        if ($('.chekboxSpecial').is(':checked')) {
            
            var stat = 'yes';
            
        } else {
            
            var stat = 'no';
         
        }
        
        $.ajax({
         
             type: "POST",
             url: "/components/ajaxRequest/updateProfile.php",
             data: { s: stat, inn: userAgent },
             success: function (data) {
                 
                 if (data == 'success') {
                     
                    alert('Готово');
                    
                 } 
             }
         }); 
    });
    
    
    
    $('.selC').change(function(){
       
    var selC = $('.selC').val();
    
    //var innAgents = $('.list-characteristics__item:eq(8) span').html();
    var innAgents = $('.list-characteristics__item span#call').html();

        $.ajax({
         
             type: "POST",
             url: "/components/ajaxRequest/updateProfile.php",
             data: { cena: selC, inn: innAgents},
             
             success: function (data) {
                 
                 if (data == 'success') {
                     
                    alert('готово');
                    
                 } 
             }
         }); 
    
    }); 
    
    
    $('.addNewAdress').on('click', function(){
        
       var gorod = $('input[name="gorod"]').val();
       var street = $('input[name="street"]').val();
       var dom = $('input[name="dom"]').val();
       var dop = $('input[name="dop"]').val();
       var user_id = '<?php echo $allInfprmByProfile["user_id"]; ?>';
       
       $.ajax({
         
             type: "POST",
             url: "/admin/addadressclient",
             data: { city: gorod, st: street, d: dom, op: dop, id: user_id },
             
             success: function (data) {
                 
                 alert('Адрес добавлен');
                 
                 location.reload();
             }
         }); 
       
    });
</script>