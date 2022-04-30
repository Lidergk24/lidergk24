            <div class="col-25 mb-30">
               <div class="product-card" style="min-height:400px">
                  <a href="/product/<?php echo $product['product_part_number']; ?>" class="product-card__image" title="<?php echo $product['product_name']; ?>">
                  <?php foreach(json_decode($product['product_image']) as $imagesCategory){
                     foreach(array($imagesCategory) as $oneImagescategory){ 
                       if($oneImagescategory->{0} !=''){ ?>
                  <img src="/upload/<?php echo $oneImagescategory->{0}; ?>" alt="<?php echo $product['product_name']; ?>">
                  <?php } } }  ?>
                  <div class="product-card-signs">                  
                  <?php if($product['product_warehouse']>0) { ?>
                  <span class="product-card-avaiability">в наличии</span>
                  <?php } else { ?>
                  <span class="product-card-avaiability-not-available">нет в наличии</span>
                  <?php } ?>
                  <span class="part_num"><?php echo $product['product_part_number']; ?></span>
                  <?php if($product['procent_rules'] || $product['rub_rules']) { ?><span class="product-card-discount">-<?=($product['procent_rules']) ? $product['procent_rules'].'%':$product['rub_rules'].'₽';?></span>
                  <?php } ?>
                  </div>
                  </a>
                  <div class="product-card__body">
                            <div class="product-card__body_top">
                                <a href="/product/<?php echo $product['product_part_number']; ?>" class="product-card__title" title=""><?php echo $product['product_name']; ?></a>
                            </div>
                            <div class="product-card__body_bottom ">
                                <div class="flex-column line__quantity d-flex align-items-end">
                                <div class="price">
                           <?php 
                                        $id = User::checkLogged();
                                        $user = User::getUserById($id);
                                        if ((!User::isGuest()) && ($user["specialClient"] == 'yes')) {
                                            echo  '<el><strike style="color:#000000;padding-right: 5px;">' . $product['product_site_price'] . '</strike></el>';
                                        } ?>
                              <?php echo'<span>'. $product['product_price'].'</span>'; ?></span>
                              
                              <div class="price__currency">₽</div>
                           </div>
                                    <div class="min-amount-line"> мин. <input type="text" class="amount__text input_amount_dummy " name="count_product" value="<?php echo $product['miz_zakaz']; ?>" /> <?php echo $product['miz_zakaz']; ?> шт</div>
                                </div>
                                
                                
                           <?php if($product['product_warehouse']>0) { ?>   
                                
                                <a href="#" data-id="<?php echo $product['id']; ?>" data-product_count="<?php echo $product['miz_zakaz']; ?>" class="btn btn_red btn__add_card add-cart" title="Добавить в корзину">В
                                    корзину</a>
                            
                            <?php } else { ?>        
                                    
                                  <a href="#" data-id="<?php echo $product['id']; ?>" data-product_count="<?php echo $product['miz_zakaz']; ?>" class="btn btn_blue btn__add_card add-cart" title="Нет в наличие" style="pointer-events: none;cursor: default;color: #000;">Нет в наличии</a>
                                    
                            <?php } ?>        
                            
                            </div>
                        </div>
               </div>
            </div>