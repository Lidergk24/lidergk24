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
            <li><a href="/cabinet/history" title="Заказы"><span>Заказы</span></a></li>
         </ul>
         <h1>Повторить заказ №<?php echo $getByIdProfile[3]; ?></h1>
         <div class="basket__table table w-100">
            <div class="table__head">
               <div class="table__th basket__table_photo">Фото товара</div>
               <div class="table__th basket__table_name">Название</div>
               <div class="table__th basket__table_price">Цена</div>
               <div class="table__th basket__table_quantity">Количество</div>
            </div>
            <div class="table__body">
               <?php 
                  foreach(json_decode($selectRepeat["products"]) as $arrayIds => $countKey){

                                 $arrayIdsItems = array($arrayIds);
                                 $product = Product::getProdustsByRepeat($arrayIdsItems);
                                 $price_for_this_user  = Product::getUserPrice($product);
                  ?>
               <div class="table-body_line <?php if($product['product_warehouse']<1){ ?>blockRepeatOrder<?php } ?>">
                  <div class="table__td basket__table_photo">
                     <a href="/product/<?php echo $product['product_part_number']; ?>" target="_blank" class="basket__table_img" title="<?php echo $product['product_name']; ?>">
                     <?php 
                        foreach (json_decode($product['product_image']) as $imagesCategory){
                            foreach(array($imagesCategory) as $oneImagescategory){ ?>
                     <img src="/upload/<?php echo $oneImagescategory->{0}; ?>" style="width:65%;" alt="<?php echo $product['product_name']; ?>">
                     <?php } } ?>
                     </a>
                  </div>
                  <div class="table__td basket__table_name">
                     <a href="/product/<?php echo $product['product_part_number']; ?>" target="_blank" class="basket__table_title" title="<?php echo $product['product_name']; ?>"><?php echo $product['product_name']; ?></a>
                      <?php if(($productDiscounts[$product['id']]['procent_rules']>0) || ($productDiscounts[$product['id']]['rub_rules']) > 0) { 
                        if ($productDiscounts[$product['id']]['conditions_rules'] == 'Равно') {
                              $condition_sale = 'кратно';
                        } else {
                           $condition_sale =  mb_strtolower($productDiscounts[$product['id']]['conditions_rules']);
                        }
                        if ($productDiscounts[$product['id']]['procent_rules']>0) {
                              $discount_label = '-' .$productDiscounts[$product['id']]['procent_rules'] . '₽';
                        }
                           else {$discount_label = '-' .$productDiscounts[$product['id']]['rub_rules'] . '₽';}
                              ?>
                        <p style = 'color:red'><?php echo 'Aкция! '.$discount_label. ' при покупке '. $condition_sale . $productDiscounts[$product['id']]['count_rules'] . ' шт.' ; 
                        error_log( '$productDiscounts[$product[id]] === '.print_r( $productDiscounts[$product['id']], true ) ); ?></p>
                        <?php } ?>
                     <?php if($product['product_warehouse']<1){ ?>
                     <div class=" color_red">Товара нет в наличии</div>
                     <?php } ?>
                  </div>
                  <div class="table__td basket__table_price">
                     <p><?php echo $price_for_this_user;?> ₽</p>

                     <p><?php echo $productDiscounts[$product['id']]['procent_rules']; ?></p>

                  </div>
                  <div class="table__td basket__table_quantity">
                     <div class="amount amount-table">
                       <input type="text" class="amount__text count_item" name="count_product" maxlength="5" data-id="<?php echo $product['id']; ?>" data-product_count="" value="<?php echo $countKey; ?>" <?php if($product['miz_zakaz']>1){ echo "readonly='readonly'"; } ?>/>
                     </div>
                  </div>
               </div>
               <?php } ?>
            </div>
         </div>
         <div class="w-100">
            <a href="/cart/order" class="btn btn_cabinet_add ">Добавить в корзину</a>
         </div>
      </div>
   </div>
</main>

<?php include ROOT . '/views/cabinet/Index/Footer.php'; ?>