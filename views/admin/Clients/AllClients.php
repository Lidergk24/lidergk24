<?php include ROOT . '/views/admin/Index/Header.php'; 
$paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
$params = include($paramsPath);
$con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
?>
<main class="main-cabinet-user main-cabinet-user-view main-cabinet-admin">
   <div class="container">
      <div class="cabinet-sidebar">
         <div class="btn-close__menu"></div>
         <?php include ROOT . '/views/admin/Index/Sidebar.php'; ?>
      </div>
      <div class="main-cabinet-user__content main-cabinet-admin__content">
         <ul class="breadcrumb breadcrumb-cabinet">
            <li><a href="/admin" title="Главная"><span>ГЛАВНАЯ</span></a></li>
            <li><a><span>Клиенты</span></a></li>
         </ul>
         <h1>Клиенты</h1>
         <form method="post" class="form-search form-search__admin">
            <button type="submit" class="btn"><img src="images/search-grey.png" alt=""></button>
            <label><input type="text" name="search" placeholder="Поиск клиента по номеру телефона"></label>
         </form>
         <div class="sales-table__admin articles-table__admin clients-table table w-100">
            <div class="table__head">
               <div class="table__th articles-table__name_clients">Имя клиента</div>
               <div class="table__th articles-table__phone_clients">Телефон клиента</div>
               <div class="table__th articles-table__manager_clients">Назначить менеджера</div>
               <div class="table__th articles-table__mail_client">Почта клиента</div>
               <div class="table__th articles-table__profile_clients">Заказы/профили</div>
            </div>
            <div class="table__body">
                <?php foreach($allClients as $allClientsOne){ ?>
               <div class="table-body_line">
                  <div class="table__td articles-table__name_clients">
                     <p><?php echo $allClientsOne['name']; ?></p>
                  </div>
                  <div class="table__td articles-table__phone_clients">
                     <p><?php echo $allClientsOne['phone']; ?></p>
                     <a class="btn btn_border btn_border_black" title="">Отправить реквизиты</a>
                  </div>
                  <div class="table__td articles-table__manager_clients">
                     <div class="profile-info__manager_item">
                        <div class="profile-info__manager_line">
                           <div class="profile-info__manager_name">
                              <?php 
                       $selectmanager = mysqli_query($con, "SELECT manager_name FROM Manager");
                       ?>
                       <?php if($allClientsOne['user_manager'] !=''){ ?>
                       <span><?php echo $allClientsOne['user_manager']; ?></span>
                       <?php } ?>
                       <form>
                           <select name="selectManager" class="selectManager">
                               <option value="Виеру Дмитрий"><?php $allClientsOne['user_manager']; ?></option>
                               <?php foreach ($selectmanager as $selectmanagerOne ) { ?>
                               <option value="<?php echo $selectmanagerOne['manager_name']; ?>" ><?php echo $selectmanagerOne['manager_name']; ?></option>
                               <?php } ?>
                           </select>
                       </form>
                              <div class="icon-arrow"><img src="/template/images/Stock/arrow-bottom-grey.png" alt=""></div>
                           </div>
                        </div>
                         <?php
                            $usphone =$allClientsOne['phone'];
                            $orderAdminCount = mysqli_query($con, "SELECT * FROM product_order where user_phone like '%$usphone%'");
                            $allSum = mysqli_query($con, "select SUM(order_summ) as totalSum from product_order where user_phone='$usphone'");
                            $allSumQuery = mysqli_fetch_assoc($allSum);

                        ?>
                        <div class="block__hidden_manager">
                           <p class="date-profile">Дата создания профиля: <span class="value-profile"><?php echo $allClientsOne['registration_date']; ?></span></p>
                           <p>Всего заказов: <span class="value-profile"><?php echo $orderAdminCount->num_rows; ?></span></p>
                           <p>Сумма заказов: <span class="value-profile"><?php if($allSumQuery["totalSum"]==NULL){ echo "0"; } else { echo $allSumQuery["totalSum"];}   ?> ₽</span></p>
                        </div>
                     </div>
                  </div>
                  <div class="table__td articles-table__mail_client">
                     <?php if(!empty($allClientsOne['email'])){ ?>
                     <p><?php echo $allClientsOne['email']; ?></p>
                     <a class="btn btn_border btn_border_black send_prop_email" title="Отправить реквизиты">Отправить реквизиты</a>
                     <?php } ?>
                  </div>
                  <div class="table__td articles-table__profile_clients">
                     <div class="button-group">
                       
                        <a href="/admin/zakaz/<?php echo $usphone; ?>" class="links-list" title="Заказ">
                        <img src="/template/images/Stock/list.png" alt="заказ">
                        <span class="links-list__val"><?php echo $orderAdminCount->num_rows; ?></span>
                        </a>
                        <div class="line-decor"></div>
                        <a href="/admin/profiles/<?php echo $allClientsOne['id']; ?>" class="links-profile" title="Кабинет">
                        <img src="/template/images/Stock/user-cabinet.png" alt="Кабинет">
                        </a>
                     </div>
                  </div>
               </div>
                <?php } ?>
            </div>
         </div>
      </div>
   </div>
</main>

<?php include ROOT . '/views/admin/Index/Footer.php'; ?>

<script>

  /*  function selectManager () {
        var selectManager = $(this).closest('.table-body__line').find('.selectManager').val();
        var clientPhone = $(this).closest('.table-body').find('.name-order p').html();

        $.ajax({
               type: 'post',
               url: "https://lider-gk24.ru/components/ajaxRequest/managerAdmin.php", 
               data: {manage: selectManager, phone: clientPhone},
               dataType: 'TEXT',
        }) 
    } 

    $('.selectManager').click( selectManager ); */
    
    $('input[name="search"]').keyup(function() {
       var searchVal = $('input[name="search"]').val();
        console.log(searchVal);
       if (searchVal.length > 2) {

            $.ajax({
                   type: 'post',
                   url: "/components/ajaxRequest/allCleints.php", 
                   data: { search: searchVal },
                   dataType: 'TEXT',
                    success: function(data) {
                        $(".clients-table").html(data); 
                    }
            }) 
        } 
    });
    
    
    
  
    
  /*  $('.send_prop').click(function() {
        
        var sendPropPhone = $(this).closest('.table-body').find('.name-order p').html();
            $.ajax({
                   type: 'post',
                   url: "https://lider-gk24.ru/ajax/sendproperty", 
                   data: { phone: sendPropPhone},
                   dataType: 'TEXT',
                    success: function(data) {
                       if(data=='success'){
                           $('.send_prop').html('СМС с реквизитами отправлено!');
                           $('.send_prop').addClass('btn-disabled');

                       }
                    }
            }) 
    });
    
    
    $('.send_prop_email').click(function() {
        
        var sendPropEmail = $(this).closest('.table-body').find('.comment-order p').html();
            $.ajax({
                   type: 'post',
                   url: "https://lider-gk24.ru/ajax/sendproperty", 
                   data: { email: sendPropEmail },
                   dataType: 'TEXT',
                    success: function(data) {
                       if(data=='success'){
                           $('.send_prop_email').html('Письмо с реквизитами отправлено!');
                           $('.send_prop_email').addClass('btn-disabled');

                       }
                    }
            }) 
    }); */
    
</script>