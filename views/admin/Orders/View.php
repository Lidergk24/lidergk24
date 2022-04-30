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
            <li><a href="/admin/order" title="Заказы"><span>Заказы</span></a></li>
            <li><a title="Личный кабинет"><span>Просмотр заказа № <?php echo $order['order_number']; ?></span></a></li>
         </ul>
         <h1>Просмотр заказа № <?php echo $order['order_number']; ?></h1>
         <div class="main-cabinet-user-view__title">Информация о заказе</div>
         <div class="info-orders__table_admin info-orders__table_admin_products table w-100">
            <div class="table__head">
               <div class="table__th info-orders__table_name">Имя клиента</div>
               <div class="table__th info-orders__table_phone">Телефон</div>
               <div class="table__th info-orders__table_pay">Способ оплаты</div>
               <div class="table__th info-orders__table_delivery">Способ доставки</div>
               <div class="table__th info-orders__table_date">Дата заказа</div>
               <div class="table__th info-orders__table_sum">Сумма</div>
               <div class="table__th info-orders__table_sum info-orders__table_sum-products"></div>
            </div>
            <div class="table__body">
               <div class="table-body_line">
                  <div class="table__td info-orders__table_name">
                     <p><?php echo $order['user_name']; ?></p>
                  </div>
                  <div class="table__td info-orders__table_phone">
                     <p><?php echo $order['user_phone']; ?></p>
                  </div>
                  <div class="table__td info-orders__table_pay">
                     <p><?php echo $order['payment_method']; ?></p>
                  </div>
                  <div class="table__td info-orders__table_delivery">
                     <p><?php echo $order['delivery_method']; ?><?php echo $order['delivery_adress']; ?></p>
                  </div>
                  <div class="table__td info-orders__table_date">
                     <p><?php echo $order['date']; ?></p>
                  </div>
                  <div class="table__td info-orders__table_sum info-orders__table_sum-products">
                     <p><?php echo round($order['order_summ'], 2); ?> ₽</p>
                  </div>
                  <div class="table__td info-orders__table_sum">
                     <p><?php //echo round($order['order_summ'], 2); ?></p>
                  </div>
               </div>
            </div>
         </div>
         <?php
         
         if($order["orderDiscount"] !='' && $order["orderDiscount"] !=NULL && $order["orderDiscount"] >0){ ?>

         <p class="nextStep">Клиент ввел промокод! Применить скидку в размере <?php echo $order["orderDiscount"]; ?>%</p>

         <?php } ?>
          <?php if(!empty($order['user_comment'])){ ?>
          <p class="nextStep"><?php echo $order['user_comment']; ?></p>
          <?php } ?>
         <div class="basket__table basket__table_view basket__table_view_admin basket__table_view_admin_products table w-100">
            <div class="table__head">
               <div class="table__th basket__table_photo">Фото товара</div>
               <div class="table__th basket__table_article">Артикул</div>
               <div class="table__th basket__table_name">Название</div>
               <div class="table__th basket__table_price">Цена</div>
               <div class="table__th basket__table_quantity">Количество</div>
               <div class="table__th basket__table_sum-products">Сумма товара</div>

            </div>
            <div class="table__body">
            
               <?php
                if (!empty($order_items)) { $view_order_items = $order_items; } else {$view_order_items = $products;};
               foreach ($view_order_items as $product): ?>
               <div class="table-body_line">
                  <div class="table__td basket__table_photo">
                     <?php 
                        foreach (json_decode($product['product_image']) as $imagesCategory){
                            foreach(array($imagesCategory) as $oneImagescategory){ ?>
                     <a href="/product/<?php echo $product['product_part_number']; ?>" target="_blank" class="basket__table_img" title="<?php echo $product['product_name']; ?>"><img src="/upload/<?php echo $oneImagescategory->{0}; ?>" alt="<?php echo $product['product_name']; ?>"></a>
                     <?php } } ?>
                  </div>
                  <div class="table__td basket__table_article">
                     <p><?php echo $product['product_part_number']; ?></p>
                  </div>
                  <div class="table__td basket__table_name">
                     <a href="/product/<?php echo $product['product_part_number']; ?>" target="_blank" class="basket__table_title" title="<?php echo $product['product_name']; ?>"><?php echo $product['product_name']; ?></a>
                  </div>
                  <div class="table__td basket__table_price">
                                    <p><?php  if (!empty($order_items)) { if (!$product['discount_price'] > 0) {
                                        echo $product['price_at_order_time'] . ' ₽';
                                    }  else {echo '<del>'.$product['price_at_order_time']. '</del>'; echo '<span style="color:red">'.'<br>'.$product['discount_price']. ' ₽'. '</span>';}}else {echo '';} ?></p>
                                </div>
                  <div class="table__td basket__table_quantity">
                     <p><?php echo $product['quantity']; ?></p>
                  </div>
                   <div class="table__td basket__table_sum-products">
                     <p><?php  if (!empty($order_items)) { if (!$product['discount_price'] > 0) {
                                        echo $product['price_at_order_time']*$product['quantity'] . ' ₽';
                                    }  else {echo '<del>'.$product['price_at_order_time']*$product['quantity']. '</del>'; echo '<span style="color:red">'.'<br>'.$product['discount_price']*$product['quantity']. ' ₽'. '</span>';}}else {echo '';} ?></p>
                  </div>
               </div>
               <?php endforeach; ?>
            </div>
         </div>
      </div>
   </div>
</main>
<?php include ROOT . '/views/admin/Index/Footer.php'; ?>