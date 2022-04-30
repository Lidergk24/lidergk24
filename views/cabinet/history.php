<?php include ROOT . '/views/cabinet/Index/Header.php'; ?>
<main class="main-cabinet-user main-cabinet-user-history">
   <div class="container">
      <div class="cabinet-sidebar">
         <div class="btn-close__menu"></div>
         <?php include ROOT . '/views/cabinet/Index/CabinetMenu.php'; ?>
         <?php include ROOT . '/views/cabinet/Index/CabinetMenuSideBar.php'; ?>
      </div>
      <div class="main-cabinet-user__content">
         <ul class="breadcrumb breadcrumb-cabinet">
            <li><a href="/cabinet" title="Главная"><span>ГЛАВНАЯ</span></a></li>
            <li><a><span>История заказов</span></a></li>
         </ul>
           <?php if($selectOrderHistory->num_rows==0){ echo "У вас пока не было заказов, самое время их сделать"; } else{ ?>
         <h1>История заказов</h1>
         <div class="total-orders__history">
            <p>Всего заказов:</p>
            <span class="total-orders__val"><?php echo $selectOrderHistory->num_rows; ?></span>
         </div>
         <div class="table table-history table-contacts">
            <div class="table__head">
               <div class="table__th table-history__number">Номер заказа</div>
               <div class="table__th table-history__date">Дата заказа</div>
               <div class="table__th table-history__sum">Сумма заказа</div>
               <div class="table__th table-history__products">Товаров в заказе</div>
               <div class="table__th table-history__repeat">Повторить заказ</div>
            </div>
            <div class="table__body">
               <?php foreach ($selectOrderHistory as $selectCabinetHistory) { 
                     $jsonItem = $selectCabinetHistory['products'];
                     $arr = json_decode($jsonItem, true); ?>
               <div class="table-body_line {">
                  <div class="table__td table-history__number">
                     <p><?php echo $selectCabinetHistory['order_number']; ?></p>
                  </div>
                  <div class="table__td table-history__date">
                     <p><?php echo $selectCabinetHistory['date']; ?></p>
                  </div>
                  <div class="table__td table-history__sum">
                     <p><?php echo $selectCabinetHistory['order_summ']; ?> ₽</p>
                  </div>
                  <div class="table__td table-history__products">
                     <ul class="list-product">
                        <li>
                           <p><?php echo count($arr); ?></p>
                        </li>
                        <li><a href="/cabinet/view_order/<?php echo $selectCabinetHistory['id']; ?>" class="links-view" title=""><img src="/template/images/Stock/view.svg" alt="Просмотр"></a></li>
                     </ul>
                  </div>
                  <div class="table__td table-history__repeat">
                     <a href="repeat/<?php echo $selectCabinetHistory['order_number']; ?>" class="btn btn_repeat btn_cabinet_add" title="">Повторить заказ</a>
                  </div>
               </div>
               <?php } ?>
            </div>
         </div>
         <?php } ?>
      </div>
   </div>
</main>
<?php include ROOT . '/views/cabinet/Index/Footer.php'; ?>