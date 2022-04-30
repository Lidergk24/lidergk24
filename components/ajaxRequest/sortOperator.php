<?php
include_once( $_SERVER['DOCUMENT_ROOT'] . 'controllers\AdminOrderController.php');
$paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
$params = include($paramsPath);
$con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
$sortOperator = $_POST['operator'];
$environment = include_once($_SERVER['DOCUMENT_ROOT'] . '/config/environment.php');
$sqlDate = mysqli_query($con, "SELECT * from product_order where user_operator ='$sortOperator' order by id DESC limit 30");

$operatorBase = mysqli_query($con, "SELECT * FROM `Operator` order by operator_name ASC");


if ($sqlDate->num_rows > 0) { ?>
       
       
       
        <div class="table__head">
               <div class="table__th table-orders__number">№ и дата</div>
               <div class="table__th table-orders__full">ФИО</div>
               <div class="table__th table-orders__phone">Телефон</div>
               <div class="table__th table-orders__sum">Сумма</div>
               <div class="table__th table-orders__manager">Менеджер/Оператор</div>
               <div class="table__th table-orders__status">Статус</div>
               <div class="table__th table-orders__comment">Комментарий</div>
            </div>
       <div class="table__body">
           <?php foreach ($sqlDate as $order): 
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
                     <?php if ( $order['specOrder'] ==1 ) { ?>
                     <p class="specOrderAdmin">Спецзаказ</p>
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
                           <select name="selOperator" class="select-admin select-form selOperator">
                               <?php if(!empty($order['user_operator'])){ ?>
                          <option><?php echo $order['user_operator']; ?></option>
                          <?php } else { ?>
                          <option>Не назначен</option>
                          <?php } ?>
                                 <?php foreach($operatorBase as $operatorBaseOne){ ?>
                               <option data-dob="<?php echo $operatorBaseOne['operator_dob']; ?>"><?php echo $operatorBaseOne['operator_name']; ?></option>
                       <?php } ?>
                           </select>
                        </label>
                        <p>Оператор</p>
                     </div>
                     <div class="table-orders__manager_box">
                        <label>
                           <select name="manager-select" class="select-admin select-form select-bg__grey manager-select">
                                <?php if(!empty($order['user_manager'])){ ?>
                                <option><?php echo $order['user_manager']; ?></option>
                                <?php } else { ?>
                                <option>Не назначен</option>
                                <?php } ?>
                                <option data-dob="8 (925) 997-01-25">Виеру Дмитрий</option>
                                <option>Грушевская Светлана</option>
                                <option data-dob="8 (926) 249 70 87">Кулаева Екатерина</option>
                                <option data-dob="8 (929) 905-95-97">Макарова Зинаида</option>
                                <option data-dob="8 (926) 061-63-12">Мартынова Маргарита</option>
                                <option data-dob="8 (925) 091-06-87">Николаева Лариса</option>
                                <option data-dob="8( 929) 948-52-65">Погожева Оксана</option>
                                <option>Торлак Оксана</option>
                                <option data-dob="8 (925) 145-58-37">Чапурина Елена</option>
                                <option data-dob="8 (926) 317-97-14">Щеглова Ирина</option>
                           </select>
                        </label>
                        <p>Менеджер</p>
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
                     <label><textarea name="comment_operator" maxlength="70" class="comment_operator" placeholder=""><?php echo $order['order_comment']; ?></textarea></label>
                  </div>
               </div>
            </div>
            <?php endforeach; ?>
     
<?php } else { echo "У данного оператора еще не было заказов"; } ?>
<script src="/template/js/OrderSorting.js"></script>
