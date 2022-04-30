
            <div class="col-25 mb-30">
               <div class="product-card">
                  <a href="/product/<?php echo $OneProduct['product_part_number']; ?>" class="product-card__image" title="<?php echo $OneProduct['product_name']; ?>">
                  <?php foreach(json_decode($OneProduct['product_image']) as $imagesCategory){
                     foreach(array($imagesCategory) as $oneImagescategory){ 
                       if($oneImagescategory->{0} !=''){ ?>
                  <img src="/upload/<?php echo $oneImagescategory->{0}; ?>" alt="<?php echo $OneProduct['product_name']; ?>">
                  <?php } } } 
                $oneAtribut = explode(";" , $OneProduct['product_atributs']);
                    foreach ($oneAtribut as $oneOne) {
                        $svoistvaOne = explode(":", $oneOne);
                        $svoistvaOnes = $svoistvaOne[1];
                        $productAtributView = Product::getAtributsOne($svoistvaOnes);
                            foreach ($productAtributView as $onesOnesAtribut) { 
                                if($onesOnesAtribut["atributTitle"] == 'АКЦИЯ'){ ?>
                                <span class="item-sale bg-red">акция</span>
                <?php } } } ?>
                  <span class="item-availability bgGrey">Под заказ</span>
                 
                  </a>
                  <div class="product-card__body">
                     <div class="product-card__body_top">
                        <a href="/product/<?php echo $OneProduct['product_part_number']; ?>" class="product-card__title" title="<?php echo $OneProduct['product_name']; ?>"><?php echo $OneProduct['product_name']; ?></a>
                        <div class="product-card__article">Код: <?php echo $OneProduct['product_part_number']; ?></div>
                        <div class="button__group">
                           <?php
                                        $shtukk = '';
                                        $corob ='';
                                         $oneAtribut = explode(";" , $OneProduct['product_atributs']);
                                                foreach ($oneAtribut as $oneOne) {
                                                    $svoistvaOne = explode(":", $oneOne);
                                                    $svoistvaOnes = $svoistvaOne[1];
                                                    $productAtributView = Product::getAtributsOne($svoistvaOnes);
                                                        foreach ($productAtributView as $onesOnesAtribut) { 
                                                            
                                                           
                                                            if($onesOnesAtribut["atributTitle"] == 'Количество в упаковке, шт'){ 
                                                                $shtukk = $onesOnesAtribut["atributValue"];
                                                                
                                                             } 
                                                            
                                                            if($onesOnesAtribut["atributTitle"] == 'Количество в коробке, шт'){
                                                                
                                                                $corob = $onesOnesAtribut["atributValue"];
                                                            }
                                                            
                                                            
                                                        } } 
                                        
                                        ?>
                                        
                                        <a class="btn btn_sorting price_one" title="За штуку" data-price_one="
                                        <?php 
                                        if($OneProduct['miz_zakaz']>1){ 
                                            
                                            echo round($OneProduct['product_price'],2); 
                                          
                                        } 
                                        
                                        else { 
                                        
                                          if($corob>0){
                                              echo round($OneProduct['product_price'],2); 
                                              
                                               
                                          } else {
                                              
                                              
                                               if(empty($corob) && empty($shtukk)){
                                                   echo round($OneProduct['product_price'],2); 
                                               }
                                               else {
                                                   echo round($OneProduct['product_price']/$shtukk,2); 
                                               }
                                               
                                          }
                                           
                                       
                                         
                                        } ?>">за штуку</a>
                                        
                                        
                                        <a class="btn btn_sorting price_pak" title="За упаковку" data-price_pak="
                                        <?php 
                                        
                                        if($OneProduct['miz_zakaz']>1){
                                             echo round($OneProduct['miz_zakaz']*$OneProduct['product_price'],2); 
                                        } else {
                                            
                                            if($corob>0){
                                              echo round($OneProduct['product_price']*$corob,2); 
                                              
                                               
                                          } else {
                                              
                                               if(empty($corob) && empty($shtukk)){
                                                   echo round($OneProduct['product_price'],2); 
                                               }
                                               else {
                                                   echo round(($OneProduct['product_price']*$shtukk)/$shtukk, 2);
                                               }
                                                 
                                          }
                                            
                                           
                                        }
                                        
                                        
                                        ?>
                                        
                                        ">за упаковку</a>
                        </div>
                     </div>
                     <div class="product-card__body_bottom">
                        <div class="line__quantity d-flex align-items-center justify-between">
                           <div class="amount">
                              <span class="down" data-order="<?php echo $OneProduct['miz_zakaz']; ?>">-</span>
                              <input type="text" name="count_product" autocomplete="off" value="<?php echo $OneProduct['miz_zakaz']; ?>" maxlength="5" <?php if($OneProduct['miz_zakaz']>1){ echo "readonly='readonly'"; } ?> class="amount__text countForcorob"/>
                              <span class="up" data-order="<?php echo $OneProduct['miz_zakaz']; ?>">+</span>
                           </div>
                           <div class="price">
                           <?php
                                        $id = User::checkLogged();
                                        $user = User::getUserById($id);
                                        if ((!User::isGuest()) && ($user["specialClient"] == 'yes')) {
                                            echo '<el><strike style="color:grey;margin-right: 5px;">' . $OneProduct['product_site_price'] . '</strike></el>';
                                        } ?>
                              <span><?php echo $OneProduct['product_price']; ?></span>
                              <div class="price__currency">₽</div>
                           </div>
                        </div>
                        <a href="#" data-id="c<?php echo $OneProduct['id']; ?>"  data-product_count="" class="btn btn_red btn__add_card add-cart " title="Добавить в корзину">В корзину</a>
                     </div>
                  </div>
               </div>
            </div>
           