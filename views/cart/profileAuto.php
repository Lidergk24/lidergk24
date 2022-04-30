<?php
  $paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
  $params = include($paramsPath);
  $con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
               
   $profile = $_POST['profile'];
   
   $selCardProfileFiz = mysqli_query($con, "SELECT * from user_fiz where fiz_fio='$profile'");
   
   $sql1 = mysqli_fetch_assoc($selCardProfileFiz);
   
   $selCardProfileUr = mysqli_query($con, "SELECT * from user_ur where ur_profile='$profile'");
   
   $sql2 = mysqli_fetch_assoc($selCardProfileUr);
   
   if($selCardProfileFiz->num_rows>0){ ?>
   
<form action="#" method="post">
   <p class="order_text_style">Контактные данные</p>
   <div class="block_cart_one">
      <p class="order_text_style">Ваше ФИО <span style="color:red;">*</span></p>
      <input type="text" name="userName" maxlength="60" value="<?php echo $sql1["fiz_fio"]; ?>" placeholder="Например: Татьяна Иванова" autocomplete="off"/>
      <p class="order_text_style">Номер телефона <span style="color:red;">*</span></p>
      <input type="tel" id="phone"  name="userPhone" value="<?php echo $sql1["fiz_phone"]; ?>" placeholder="7 xxx xxx xx xx" autocomplete="off">
      <p class="order_text_style">Email <span style="color:red;">*</span></p>
      <input type="email" maxlength="60" name="order_email" value="<?php echo $sql1["fiz_email"]; ?>" placeholder="Ваш электронный адрес">
   </div>
   <p class="order_text_style">Оплата</p>
   <div class="block_cart_one">
      <p class="order_text_style">Способ оплаты <span style="color:red;">*</span></p>
      <div class="abc">
         <span class="fancyArrow"><i class="fas fa-money-bill-alt"></i></span>
         <select name="payment" class="select_order_style">
            <option value="Наличными курьеру">Наличными при получении</option>
            <option value="Банковская карта">Банковской картой</option>
            <option value="Безналичный перевод">Безналичный перевод</option>
         </select>
      </div>
   </div>
   <p class="order_text_style">Доставка</p>
   <div class="block_cart_one">
      <p class="order_text_style">Способ получения товара <span style="color:red;">*</span></p>
      <div class="abc">
         <span class="fancyArrow"><i class="fas fa-truck"></i></i></span>
         <select name="deliveryMethod" class="select_order_style selDeliveryMethod">
            <option value="Самовывоз">Самовывоз</option>
            <option value="Доставка по адресу">Доставка по адресу</option>
            <option value="Транспортная компания">Доставка до терминала транспортной компании</option>
         </select>
         <div class="delivery_hidden_block">
            <p class="order_text_style">Адрес доставки <span style="color:red;">*</span></p>
            <input type="text" name="userAdressDelivery" value="<?php echo $sql1["fiz_adress"]; ?>" maxlength="250" placeholder="Включая город" autocomplete="off"/>
         </div>
      </div>
   </div>
   <p class="order_text_style">Комментарий к заказу</p>
   <textarea class="order_textarea" rows="10" cols="45" name="userComment" placeholder="Есть что пожелать?"></textarea>
   <input type="hidden" name="summ" value="<?php echo $totalPrice; ?>" />
   <br/>
   <br/>
   <input type="submit" name="submit" class="send_order_button" onclick="yaCounter57470944.reachGoal('good_order'); return true;" value="Оформить" />
</form>
<br>
<p class="privacy_order_p order_text_style">Отправляя форму Вы соглашаетесь с <a href="/agreement" class="privacy_order">пользовательским соглашением</a>.</p>
<?php } if($selCardProfileUr->num_rows>0){ ?>
<form action="#" method="post">
   <p class="order_text_style">Контактные данные</p>
   <div class="block_cart_one">
      <p class="order_text_style">Ваше ФИО <span style="color:red;">*</span></p>
      <input type="text" name="userName" maxlength="60" value="<?php echo $sql2["ur_profile"]; ?>" placeholder="Например: Татьяна Иванова" autocomplete="off"/>
      <p class="order_text_style">Номер телефона <span style="color:red;">*</span></p>
      <input type="tel" id="phone"  name="userPhone" value="<?php echo $sql2["ur_phone"]; ?>" placeholder="+7 xxx xxx xx xx" autocomplete="off">
      <p class="order_text_style">Email <span style="color:red;">*</span></p>
      <input type="email" maxlength="60" name="order_email" value="<?php echo $sql2["ur_email"]; ?>" placeholder="Ваш электронный адрес">
   </div>
   <p class="order_text_style">Оплата</p>
   <div class="block_cart_one">
      <p class="order_text_style">Способ оплаты <span style="color:red;">*</span></p>
      <div class="abc">
         <span class="fancyArrow"><i class="fas fa-money-bill-alt"></i></span>
         <select name="payment" class="select_order_style">
            <option value="Наличными курьеру">Наличными при получении</option>
            <option value="Банковская карта">Банковской картой</option>
            <option value="Безналичный перевод">Безналичный перевод</option>
         </select>
      </div>
   </div>
   <p class="order_text_style">Доставка</p>
   <div class="block_cart_one">
      <p class="order_text_style">Способ получения товара <span style="color:red;">*</span></p>
      <div class="abc">
         <span class="fancyArrow"><i class="fas fa-truck"></i></i></span>
         <select name="deliveryMethod" class="select_order_style selDeliveryMethod">
            <option value="Самовывоз">Самовывоз</option>
            <option value="Доставка по адресу">Доставка по адресу</option>
            <option value="Транспортная компания">Доставка до терминала транспортной компании</option>
         </select>
         <div class="delivery_hidden_block">
            <p class="order_text_style">Адрес доставки <span style="color:red;">*</span></p>
            <input type="text" name="userAdressDelivery" value="<?php echo $sql2["ur_adress"]; ?>" maxlength="250" placeholder="Включая город" autocomplete="off"/>
         </div>
      </div>
   </div>
   <p class="order_text_style">Комментарий к заказу</p>
   <textarea class="order_textarea" rows="10" cols="45" name="userComment" placeholder="Есть что пожелать?"></textarea>
   <input type="hidden" name="summ" value="<?php echo $totalPrice; ?>" />
   <br/>
   <br/>
   <input type="submit" name="submit" class="send_order_button" onclick="yaCounter57470944.reachGoal('good_order'); return true;" value="Оформить" />
</form>
<br>
<p class="privacy_order_p order_text_style">Отправляя форму Вы соглашаетесь с <a href="/agreement" class="privacy_order">пользовательским соглашением</a>.</p>
<?php } ?>

<?php if($profile=='Выберите платежный профиль'){ ?>
    <form action="#" method="post">
                        <p class="order_text_style">Контактные данные</p>
                        <div class="block_cart_one">
                            <p class="order_text_style">Ваше ФИО <span style="color:red;">*</span></p>
                            <input type="text" name="userName" maxlength="60" placeholder="Например: Татьяна Иванова" autocomplete="off"/>
                            <p class="order_text_style">Номер телефона <span style="color:red;">*</span></p>
                            <input type="tel" id="phone"  name="userPhone" placeholder="+7 xxx xxx xx xx" autocomplete="off">
                            <p class="order_text_style">Email <span style="color:red;">*</span></p>
                            <input type="email" maxlength="60" name="order_email" placeholder="Ваш электронный адрес">
                        </div>
                        <p class="order_text_style">Оплата</p>
                        <div class="block_cart_one">
                            <p class="order_text_style">Способ оплаты <span style="color:red;">*</span></p>
                            <div class="abc">
                            <span class="fancyArrow"><i class="fas fa-money-bill-alt"></i></span>
                            <select name="payment" class="select_order_style">
                                <option value="Наличными курьеру">Наличными при получении</option>
                                <option value="Банковская карта">Банковской картой</option>
                                <option value="Безналичный перевод">Безналичный перевод</option>
                            </select>
                            </div>
                        </div>
                        <p class="order_text_style">Доставка</p>
                        <div class="block_cart_one">
                            <p class="order_text_style">Способ получения товара <span style="color:red;">*</span></p>
                                <div class="abc">
                                    <span class="fancyArrow"><i class="fas fa-truck"></i></i></span>
                                        <select name="deliveryMethod" class="select_order_style selDeliveryMethod">
                                            <option value="Самовывоз">Самовывоз</option>
                                            <option value="Доставка по адресу">Доставка по адресу</option>
                                            <option value="Транспортная компания">Доставка до терминала транспортной компании</option>
                                        </select>
                                        <div class="delivery_hidden_block">
                                            <p class="order_text_style">Адрес доставки <span style="color:red;">*</span></p>
                                            <input type="text" name="userAdressDelivery" maxlength="250" placeholder="Включая город" autocomplete="off"/>
                                        </div>
                                </div>
                        </div>
                        <p class="order_text_style">Комментарий к заказу</p>
                        <textarea class="order_textarea" rows="10" cols="45" name="userComment" placeholder="Есть что пожелать?"></textarea>
                        <input type="hidden" name="summ" value="<?php echo $totalPrice; ?>" />
                        <br/>
                        <br/>
                        <input type="submit" name="submit" class="send_order_button" onclick="yaCounter57470944.reachGoal('good_order'); return true;" value="Оформить" />
                    </form>
                    <br>
                    <p class="privacy_order_p order_text_style">Отправляя форму Вы соглашаетесь с <a href="/agreement" target="_blank" class="privacy_order">пользовательским соглашением</a>.</p>
    
<?php } ?>
<script>
   $('.selDeliveryMethod').change(function(){
       
       var selDeliveryMethod = $('.selDeliveryMethod').val();
       if( selDeliveryMethod == 'Доставка по адресу' ) {
           $('.delivery_hidden_block').css('display', 'block');
       } else { 
           $('.delivery_hidden_block').css('display', 'none');
       }
       
   });
   
   function setCursorPosition(pos, e) {
   e.focus();
   if (e.setSelectionRange) e.setSelectionRange(pos, pos);
   else if (e.createTextRange) {
   var range = e.createTextRange();
   range.collapse(true);
   range.moveEnd("character", pos);
   range.moveStart("character", pos);
   range.select()
   }
   }
   
   function mask(e) {
   var matrix = this.placeholder,
     i = 0,
     def = matrix.replace(/\D/g, ""),
     val = this.value.replace(/\D/g, "");
   def.length >= val.length && (val = def);
   matrix = matrix.replace(/[_\d]/g, function(a) {
   return val.charAt(i++) || "_"
   });
   this.value = matrix;
   i = matrix.lastIndexOf(val.substr(-1));
   i < matrix.length && matrix != this.placeholder ? i++ : i = matrix.indexOf("_");
   setCursorPosition(i, this)
   }
   window.addEventListener("DOMContentLoaded", function() {
   var input = document.querySelector("#phone");
   input.addEventListener("input", mask, false);
   input.focus();
   setCursorPosition(3, input);
   });
</script>