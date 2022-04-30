<?php
require '../Db.php';

$paramsPath = $_SERVER['DOCUMENT_ROOT']. '/config/db_params.php';
$params = include($paramsPath);
$con = new mysqli($params['host'],$params['user'],$params['password'],$params['dbname']);
$environment = include_once($_SERVER['DOCUMENT_ROOT'] . '/config/environment.php');  

if (isset($_POST['search'])) {

    $ajax = $_POST['search'];
    $query = mysqli_query($con, "SELECT * from user where phone like '%$ajax%' limit 5");
    if ($query->num_rows > 0) { 
    ?>
      
               
            
              <div class="table__head">
               <div class="table__th articles-table__name_clients">Имя клиента</div>
               <div class="table__th articles-table__phone_clients">Телефон клиента</div>
               <div class="table__th articles-table__manager_clients">Назначить менеджера</div>
               <div class="table__th articles-table__mail_client">Почта клиента</div>
               <div class="table__th articles-table__profile_clients">Заказы/профили</div>
            </div>
            <div class="table__body">
                <?php foreach ($query as $searchResult){ $phone = $searchResult['phone']; $quantity = mysqli_query($con, "SELECT * FROM product_order where user_phone like '$phone'") -> num_rows; 
                $allSum =  mysqli_fetch_array(mysqli_query($con, "SELECT sum(order_summ) FROM product_order where user_phone like '%$phone' "))[0];?>
                
               <div class="table-body_line">
                  <div class="table__td articles-table__name_clients">
                     <p><?php echo $searchResult['name']; ?></p>
                  </div>
                  <div class="table__td articles-table__phone_clients">
                     <p><?php echo $searchResult['phone']; ?></p>
                     <a class="btn btn_border btn_border_black" title="">Отправить реквизиты</a>
                  </div>
                  <div class="table__td articles-table__manager_clients">
                     <div class="profile-info__manager_item">
                        <div class="profile-info__manager_line">
                           <div class="profile-info__manager_name">
                              <?php 
                       $selectmanager = mysqli_query($con, "SELECT manager_name FROM Manager");
                       ?>
                       <?php if($searchResult['user_manager'] !=''){ ?>
                       <span><?php echo $searchResult['user_manager']; ?></span>
                       <?php } ?>
                       <form>
                           <select name="selectManager" class="selectManager">
                               <option value=""></option>
                               <?php foreach ($selectmanager as $selectmanagerOne ) { ?>
                               <option value="<?php echo $selectmanagerOne['manager_name']; ?>" ><?php echo $selectmanagerOne['manager_name']; ?></option>
                               <?php } ?>
                           </select>
                       </form>
                              <div class="icon-arrow"><img src="images/arrow-bottom-grey.png" alt=""></div>
                           </div>
                        </div>
                        <div class="block__hidden_manager">
                           <p class="date-profile">Дата создания профиля: <span class="value-profile"> <?php echo  $searchResult['registration_date']; ?></span></p>
                           <p>Всего заказов: <span class="value-profile"><?php echo $quantity;  ?> </span></p>
                           <p>Сумма заказов: <span class="value-profile"><?php echo  $allSum; ?> </span></p>
                        </div>
                     </div>
                  </div>
                  <div class="table__td articles-table__mail_client">
                     <?php if(!empty($searchResult['email'])){ ?>
                     <p><?php echo $searchResult['email']; ?></p>
                     <a class="btn btn_border btn_border_black send_prop_email" title="Отправить реквизиты">Отправить реквизиты</a>
                     <?php } ?>
                  </div>
                  <div class="table__td articles-table__profile_clients">
                     <div class="button-group">
                        <?php
                        ?>
                        <a href="/admin/zakaz/<?php echo $usphone; ?>" class="links-list" title="Заказ">
                        <img src="/template/images/Stock/list.png" alt="заказ">
                        <span class="links-list__val"><?php echo mysqli_query($con, "SELECT * FROM product_order where user_phone like " .$searchResult['phone']."") -> num_rows;  ?></span>
                        </a>
                        <div class="line-decor"></div>
                        <a href="/admin/profiles/<?php echo $searchResult['id']; ?>" class="links-profile" title="Кабинет">
                        <img src="/template/images/Stock/user-cabinet.png" alt="Кабинет">
                        </a>
                     </div>
                  </div>
               </div>
                <?php } ?>
            </div>
<?php } } ?>
<script>


   $('.selectManager').change(function(){
       
       
       var selectManager = $(this).closest('.table-body__line').find('.selectManager').val();

       var clientPhone = $(this).closest('.table-body').find('.name-order p').html();
        $.ajax({
               type: 'post',
               url: "<?php echo $environment["base_url"]; ?>/components/ajaxRequest/managerAdmin.php", 
               data: {manage: selectManager, phone: clientPhone},
               dataType: 'TEXT',
               success: function(data){
                   console.log(data);
               }
        
               
               
    
        }) 
       
   });
   

    $('.selectManager').change( selectManager );
    
    
    $('.send_prop').click(function() {
        
        var sendPropPhone = $(this).closest('.table-body').find('.name-order p').html();
       // console.log(sendPropPhone);
            $.ajax({
                   type: 'post',
                   url: "<?php  echo $environment["base_url"]; ?>/ajax/sendproperty", 
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
                   url: "<?php echo $environment["base_url"]; ?>/ajax/sendproperty", 
                   data: { email: sendPropEmail },
                   dataType: 'TEXT',
                    success: function(data) {
                       if(data=='success'){
                           $('.send_prop_email').html('Письмо с реквизитами отправлено!');
                           $('.send_prop_email').addClass('btn-disabled');

                       }
                    }
            }) 
    });
    
</script>