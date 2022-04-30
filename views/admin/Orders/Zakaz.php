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
            <li><a href="/admin/clients" title="Клиенты"><span>Клиенты</span></a></li>
         </ul>
         <h1>Все заказы пользователя с номером: <?php echo $linkOrderRequest[3]; ?></h1>
         <div class="main-cabinet-user-view__title">Заказы профиля:</div>
         <?php if(!empty($allBillFromUser)){ ?>
         <div class="info-orders__table_admin table-profile__admin table w-100">
            <div class="table__head">
               <div class="table__th info-orders__table_number_orders">Номер заказа</div>
               <div class="table__th info-orders__table_data_orders">Дата</div>
               <div class="table__th info-orders__table_delivery_orders">Способ получения</div>
               <div class="table__th info-orders__table_pay_orders">Способ оплаты</div>
               <div class="table__th info-orders__table_sum_orders">Сумма заказа</div>
            </div>
            <div class="table__body">
               <?php foreach ($allBillFromUser as $oneAllBillFromUser): ?>
               <div class="table-body_line">
                  <div class="table__td info-orders__table_number_orders">
                     <a href="/admin/order/view/<?php echo $oneAllBillFromUser['id']; ?>" class="color_blue" title="">Заказ №<?php echo $oneAllBillFromUser ["order_number"]; ?></a>
                  </div>
                  <div class="table__td info-orders__table_data_orders">
                     <p><?php echo $oneAllBillFromUser["date"]; ?></p>
                  </div>
                  <div class="table__td info-orders__table_delivery_orders">
                     <p><?php echo $oneAllBillFromUser["delivery_method"]; ?></p>
                  </div>
                  <div class="table__td info-orders__table_pay_orders">
                     <p><?php echo $oneAllBillFromUser["payment_method"]; ?></p>
                  </div>
                  <div class="table__td info-orders__table_sum_orders">
                     <p><?php echo $oneAllBillFromUser["order_summ"]; ?> ₽</p>
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