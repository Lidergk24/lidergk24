<?php
     include_once( $_SERVER['DOCUMENT_ROOT'] . 'controllers\AdminOrderController.php');
     $paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
     $params = include($paramsPath);
     $con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']);  
   
   if ($_POST["data"] !='') {
       
       if ( strlen ( $_POST["data"] ) == 10 ) {
          
          $data =  date("Y-m-d", strtotime($_POST["data"]));
          $sqlDate = "and date like '%$data%'";
          
          } else {
           
          $twoDare = explode('-', $_POST["data"]);
          $date1 = date("Y-m-d", strtotime($twoDare[0]));
          $date2 = date("Y-m-d", strtotime($twoDare[1]));
          $sqlDate = "and date >= '$date1' AND `date` <= '$date2 23:59:59'";
     
       }
       
   }
   
   if ($_POST["operator"] !='По оператору') {
       
      $operator = $_POST["operator"];
    
   }
   
   if ($_POST["status"] !='По статусу') {
       
       $status = $_POST["status"];
       $sqlStatus = "and order_status = '$status'";
       
   }
   
   $thisSearch = mysqli_query($con, "SELECT * from product_order where user_operator = '$operator' $sqlDate $sqlStatus");
   
  // echo "SELECT * from product_order where user_operator = '$operator' $sqlDate $sqlStatus";
   //exit;
   if ($thisSearch->num_rows > 0) { ?>

   
   <?php foreach ($thisSearch as $order){
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
         <p><?php echo $order['user_name']; ?></p>
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
               <select name="selOperator" class="select-admin select-form select-bg__grey selOperator zak-select">
                  <?php if(!empty($order['user_operator'])){ ?>
                  <option><?php echo $order['user_operator']; ?></option>
                  <?php } else { ?>
                  <option>Не назначен</option>
                  <?php } ?>
                  <option data-dob="131">Баранова Александра</option>
                                                      <option data-dob="121">Герман Ирина</option>
                                                      <option data-dob="122">Говорухина Елена </option>
                                                      <option data-dob="130">Кибаль Виктория </option>
                                                      <option data-dob="121">Крылова Екатерина</option>
                                                      <option data-dob="125">Лебедева Екатерина</option>
                                                      <option data-dob="124">Мосорети Юлия </option>
                                                      <option data-dob="123">Николаева Марина</option>
                                                      <option data-dob="127">Петреева Екатерина </option>
                                                      <option data-dob="126">Рыжак Светлана </option>
                                                      <option data-dob="130">Тарасюк Кристина</option>
                                                      <option data-dob="120">Халяпина Екатерина</option>
                                                      <option data-dob="128">Шалимова Юлия </option>
                                                      <option data-dob="129">Яковчук Анна</option>
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
                  <?php } ?>
                  <option data-dob="8 (925) 997-01-25">Виеру Дмитрий</option>
                  <option data-dob="+7 (926) 079-92-00">Грушевская Светлана</option>
                  <option data-dob="8 (926) 249 70 87">Кулаева Екатерина</option>
                  <option data-dob="+7-999-796-50">Летушова Анастасия</option>
                  <option data-dob="8 (929) 905-95-97">Макарова Зинаида</option>
                  <option data-dob="8 (926) 061-63-12">Мартынова Маргарита</option>
                  <option data-dob="8 (925) 091-06-87">Николаева Лариса</option>
                  <option data-dob="8( 929) 948-52-65">Погожева Оксана</option>
                  <option data-dob="+7 (920) 698-80-23">Торлак Оксана</option>
                  <option data-dob="8 (925) 145-58-37">Чапурина Елена</option>
                  <option data-dob="8 (926) 317-97-14">Щеглова Ирина</option>
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
               <option>Оформлен</option>
               <option>Выставлен счет</option>
               <option>Отказ</option>
               <option>Думает</option>
               <option>Не отвечает</option>
            </select>
         </label>
      </div>
      <div class="table__td table-orders__comment">
         <label><textarea name="comment_operator" class="comment_operator" maxlength="70" placeholder=""><?php echo $order['order_comment']; ?></textarea></label>
      </div>
   </div>
   <?php } ?>

<?php } else { echo "Ничего не найдено :(. Попробуйте другой запрос"; }?>
