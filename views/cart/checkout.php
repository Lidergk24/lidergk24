<?php include ROOT . '/views/layouts/header.php'; ?>
<section class="ordering-section">
   <div class="container">
      <div class="breadcrumb-wrapper">
         <div>
            <ul class="breadcrumb">
               <li><a href="/" title="Главная"><span>ГЛАВНАЯ</span></a></li>
               <li><a href="/cart"><span>Корзина</span></a></li>
            </ul>
         </div>
      </div>
      <?php if ($result) { ?>

         <div class="container">
            <div class="successful-order__info">
               <div class="successful-order__icon"><img src="/template/images/Stock/check.svg" alt="Успешный заказ"></div>
               <h1>Заказ №<?php echo $orderNumber; ?> успешно оформлен</h1>
               <div class="successful-order__text">
                  <p>Информация о заказе отправлена вам в SMS и на электронную почту.</p>
                  <p>Пожалуйста, ожидайте звонка нашего оператора или свяжитесь с нами самостоятельно по номеру: <a href="tel:+78002223236" class="successful-order__phone">8 (800) 222-32-36</a> (звонок бесплатный по РФ)</p>
               </div>
            </div>
         </div>

         <script>
            setTimeout(function() {
               location.replace("/");
            }, 10000);
         </script>
      <?php } else { ?>
         <?php if (!$result) : ?>

            <?php if (isset($errors) && is_array($errors)) : ?>
               <ul>
                  <?php foreach ($errors as $error) : ?>
                     <li> - <?php echo $error; ?></li>
                  <?php endforeach; ?>
               </ul>
            <?php endif; ?>
            <h1>Оформление заказа</h1>
            <form method="post" class="form__ordering">
               <div class="form__ordering_wrap">
                  <div class="ordering__box">
                     <div class="ordering__box_title">Контактные данные</div>
                     <div class="ordering__box_body">
                        <label>
                           <span class="form-group__title nameError">ФИО<span style="color:red;">*</span></span>
                           <input id='userName' type="text" name="userName" maxlength="50" autocomplete="off">
                        </label>
                        <label>
                           <span class="form-group__title phoneError">Телефон<span style="color:red;">*</span></span>
                           <input type="text" id='phone' name="phone" placeholder="+7 (___) ___ - __ - __" autocomplete="off">
                        </label>
                        <label>
                           <span class="form-group__title">E-mail<span style="color:red;">*</span></span>
                           <input id='email' type="email" maxlength="60" name="order_email" autocomplete="off">
                        </label>
                        <label>
                           <span class="form-group__title">Комментарий</span>
                           <textarea name="userComment" rows="14" autocomplete="off"></textarea>
                           <!-- <input type="text" maxlength="60" autocomplete="off" name="userComment"> -->
                        </label>
                     </div>
                  </div>
               </div>
               <div class="form__ordering_wrap">
                  <div class="ordering__box">
                     <div class="ordering__box_title">Доставка</div>
                     <div class="ordering__box_body">
                        <label>
                           <span class="form-group__title">Город<span style="color:red;">*</span></span>
                           <input id='city' type="text" name="city" autocomplete="off">
                        </label>
                        <label>
                           <span class="form-group__title">Улица<span style="color:red;">*</span></span>
                           <input id='street' type="text" name="street" autocomplete="off">
                        </label>
                        <label>
                           <span class="form-group__title">Дом<span style="color:red;">*</span></span>
                           <input id='house' type="text" name="house" autocomplete="off">
                        </label>
                        <label>
                           <span class="form-group__title">Квартира / офис</span>
                           <input id='apt' type="text" autocomplete="off" name="flat">
                        </label>
                        <div class="form-group">
                           <div class="form-group__label">
                              <span class="form-group__title">Домофон</span>
                              <label class="datepicker__label">
                                 <input id='domofon' type="text" name="domofon" maxlength="10" autocomplete="off">
                              </label>
                           </div>
                           <div class="form-group__label">
                              <span class="form-group__title">Дата доставки<span style="color:red;">*</span></span>
                              <label class="datepicker__label">
                                 <input type="text" name="data" autocomplete="off" class="dateZak" required>
                              </label>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-group__label w-100">
                              <span class="form-group__title">Время доставки</span>
                              <ul class="list-radio">
                                 <li class="list-radio__item">
                                    <label class="radio">
                                       <input class="radio-inp" type="radio" value="10:00 - 18:00" checked name="time">
                                       <span class="radio-custom"></span>
                                       <span class="label">10:00 - 18:00</span>
                                    </label>
                                 </li>
                                 <li class="list-radio__item">
                                    <label class="radio">
                                       <input class="radio-inp" type="radio" value="21:00 - 03:00" name="time">
                                       <span class="radio-custom"></span>
                                       <span class="label">21:00 - 03:00</span>
                                    </label>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form__ordering_wrap">
                  <div class="ordering__box">
                     <div class="ordering__box_title">Оплата</div>
                     <div class="ordering__box_body">
                        <label class="radio">
                           <input class="radio-inp" type="radio" checked name="payment" value="Наличными при получении">
                           <span class="radio-custom"></span>
                           <span class="label">Наличными при получении</span>
                        </label>
                        <label class="radio">
                           <input class="radio-inp" type="radio" name="payment" value="Картой онлайн">
                           <span class="radio-custom"></span>
                           <span class="label">Картой онлайн
                              <span class="icon-pay"><img src="/template/images/Stock/visa.svg" alt="visa"></span>
                              <span class="icon-pay"><img src="/template/images/Stock/mastercard.svg" alt="mastercard"></span>
                              <span class="icon-pay"><img src="/template/images/Stock/mir.svg" alt="mir"></span>
                           </span>
                        </label>
                        <label class="radio">
                           <input class="radio-inp" type="radio" value="Безналичный рассчет" name="payment">
                           <span class="radio-custom"></span>
                           <span class="label">Безналичный рассчет</span>
                        </label>
                     </div>
                  </div>


                  <?php
                  if (User::checkLogged()) {
                     $userAdress = User::userAdress($userId);
                     $getUserByProfileUr =  User::getUserByProfileUr($userId);
                     if (!empty($userAdress) || !empty($getUserByProfileUr)) { ?>
                        <div class="ordering__box">
                           <div class="ordering__box_title">Оформить по данным из личного кабинета</div>
                           <div class="ordering__box_body">
                              <label>
                                 
                                 <?php if (!empty($getUserByProfileUr)) { ?>
                                    <div class="form-group__title"> <input type="checkbox" id=”ur-cab” class='cart-checkbox' onclick='checkBoxUrCab()' ;></input>Доставка на Юридическое лицо</div>
                                    <select class="select-cab" type="select" name="ur-cab" autocomplete="off" disabled=true id="ur-select">
                                       <?php
                                       foreach ($getUserByProfileUr as $getUserByProfileUrOne) { ?>
                                          <option>
                                             <?php echo $getUserByProfileUrOne["ur_profile"] . ' • ' . $getUserByProfileUrOne["ur_inn"] . ' • ' . $getUserByProfileUrOne["ur_email"]; ?>
                                          </option>
                                       <?php  }
                                       ?>
                                    </select>
                                 <?php } ?>
                              </label>
                              <label>
                                 <span class="form-group__title"><input type="checkbox" id=”address-cab” class='cart-checkbox' onclick='checkBoxUrAddress()'> </input> Адрес</span>
                                 <select class="select-cab" type="select" name="adr-cab" autocomplete="off" disabled=true id="adr-select">
                                    <?php if (!empty($getUserByProfileUr)) {
                                       foreach ($getUserByProfileUr as $oneProfileAddr) { ?>
                                          <option><?php echo  $oneProfileAddr['ur_adress']; ?></option>
                                    <?php }
                                    } ?>
                                    <?php foreach ($userAdress as $userAdressOne) { ?>
                                       <option>г. <?php echo $userAdressOne['city'] . ', улица ' . $userAdressOne['street'] . ', д.' . $userAdressOne['house'];
                                                   if (!empty($userAdressOne['korpus'])) {
                                                      echo ', ' . $userAdressOne['korpus'];
                                                   }
                                                   echo  ', ' . $userAdressOne['office'];
                                                   ?>
                                       </option>
                                    <?php } ?>
                                    <?php foreach ($getUserByProfileFiz as $oneFizAddress) { ?>
                                       <option> <?php echo $oneFizAddress['fiz_adress'];  ?>
                                       </option>
                                    <?php } ?>

                                 </select>
                              </label>
                           </div>
                        </div>
                  <?php }
                  } ?>
                  <div class="consent">Отправляя форму Вы соглашаетесь с <a href="/agreement" target="_blank" class="color_blue">пользовательским
                        соглашением.</a>
                  </div>
                  <input type="hidden" name="summ" value="<?php echo $totalPrice; ?>" />
                  <button type="submit" name="submit" class="btn btn_red sendOrder" onclick="yaCounter57470944.reachGoal('good_order'); return true;">Оформить заказ</button>
               </div>
   </div>
   </form>
<?php endif; ?>
<?php } ?>

</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>
<link rel="stylesheet" type="text/css" href="/components/CalendarDate/datepicker.min.css">
<script type="text/javascript" src="/components/CalendarDate/datepicker.min.js"></script>
<script>
   $.datepicker.regional['ru'] = {
      closeText: 'Закрыть',
      prevText: 'Предыдущий',
      nextText: 'Следующий',
      currentText: 'Сегодня',
      monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
      monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
      dayNames: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
      dayNamesShort: ['вск', 'пнд', 'втр', 'срд', 'чтв', 'птн', 'сбт'],
      dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
      weekHeader: 'Не',
      dateFormat: 'dd.mm.yy',
      firstDay: 1,
      isRTL: false,
      showMonthAfterYear: false,
      yearSuffix: '',
   };

   $.datepicker.setDefaults($.datepicker.regional['ru']);

   var dateOp = new Date();
   if (dateOp.getHours() < 15) {
      dateOp.setDate(dateOp.getDate() + 1);
   } else {
      dateOp.setDate(dateOp.getDate() + 2);
   }
   $('.dateZak').datepicker({
      dateFormat: 'dd.mm.yy',
      minDate: dateOp,
      beforeShowDay: function(date) {
         var dayOfWeek = date.getDay();
         if (dayOfWeek == 0) {
            return [false]
         } else {
            return [true]
         }
      },
      beforeShow: function(input, inst) {
         // Handle calendar position before showing it.
         // It's not supported by Datepicker itself (for now) so we need to use its internal variables.
         var calendar = inst.dpDiv;

         // Dirty hack, but we can't do anything without it (for now, in jQuery UI 1.8.20)
         setTimeout(function() {
            calendar.position({
               my: 'right top',
               at: 'right bottom',
               collision: 'none',
               of: input
            });
         }, 1);
      }

   });

   let urCabCheckbox = document.querySelector("#”ur-cab”");
   let addressCheckbox = document.querySelector("#”address-cab”");
   let city = document.querySelector("#city");
   let street = document.querySelector("#street");
   let house = document.querySelector("#house");
   let apt = document.querySelector("#apt");
   let domofon = document.querySelector("#domofon");
   let userName = document.querySelector("#userName");
   let phone = document.querySelector("#phone");
   let email = document.querySelector("#email");
   let adrSelect = document.querySelector("#adr-select");
   let urSelect = document.querySelector("#ur-select");

   function checkBoxUrCab() {
      if (urCabCheckbox.checked) {
         userName.disabled = true;
         phone.disabled = true;
         email.disabled = true;
         urSelect.disabled = false;
      } else {
         userName.disabled = false;
         phone.disabled = false;
         email.disabled = false;
         urSelect.disabled = true;
      }
   }

   function checkBoxUrAddress() {
      if (addressCheckbox.checked) {
         city.disabled = true;
         street.disabled = true;
         house.disabled = true;
         apt.disabled = true;
         domofon.disabled = true;
         adrSelect.disabled = false;
      } else {
         city.disabled = false;
         street.disabled = false;
         house.disabled = false;
         apt.disabled = false;
         domofon.disabled = false;
         adrSelect.disabled = true;
      }
   }
   $('.sendOrder').click(function() {
      var error = 0;
      if (addressCheckbox == null && urCabCheckbox == null) {
         addressCheckbox = 1;
         urCabCheckbox = 1;
      }
      if (addressCheckbox.checked && !urCabCheckbox.checked) {
         let nameFields = new Array("userName", "phone", "order_email");
         $("form").find(":input").each(function() {
            for (var i = 0; i < nameFields.length; i++) {
               if ($(this).attr("name") == nameFields[i]) {
                  if (!$(this).val()) {
                     setTimeout(function() {
                        $(this).css('border', 'red 1px solid');
                        setTimeout(function() {
                           $(this).css('border', 'gray 1px solid');
                        }.bind(this), 2000);
                     }.bind(this), 1);
                     error = 1;
                  } else {
                     $(this).css('border', 'gray 1px solid');
                  }
               }
            }
         })
         if (error == 0) {
            return true;
         } else {
            return false;
         }
      } else if (!addressCheckbox.checked && urCabCheckbox.checked) {
         let addressFields = new Array("city", "street", "house", "data");
         $("form").find(":input").each(function() {

            for (var i = 0; i < addressFields.length; i++) {
               if ($(this).attr("name") == addressFields[i]) {

                  if (!$(this).val()) {
                     setTimeout(function() {
                        $(this).css('border', 'red 1px solid');

                        setTimeout(function() {
                           $(this).css('border', 'gray 1px solid');
                        }.bind(this), 2000);
                     }.bind(this), 1);
                     error = 1;

                  } else {

                     $(this).css('border', 'gray 1px solid');
                  }

               }
            }
         })
         if (error == 0) {
            return true;
         } else {
            return false;
         }
      } else if (!addressCheckbox.checked && !urCabCheckbox.checked) {
         var field = new Array("userName", "phone", "order_email", "city", "street", "house", "data");
         $("form").find(":input").each(function() {

            for (var i = 0; i < field.length; i++) {
               if ($(this).attr("name") == field[i]) {

                  if (!$(this).val()) {
                     setTimeout(function() {
                        $(this).css('border', 'red 1px solid');

                        setTimeout(function() {
                           $(this).css('border', 'gray 1px solid');
                        }.bind(this), 2000);
                     }.bind(this), 1);
                     error = 1;

                  } else {

                     $(this).css('border', 'gray 1px solid');
                  }

               }
            }
         })


         var chekPhone = $('[name=phone]').val().replace(/[^\d.]/ig, '');

         if (chekPhone.length < 11) {
            $(".phoneError").fadeIn("slow");
            $('[name=phone]').css('border', 'red 1px solid');
            return false;

         }

         var chekName = $('[name=userName]').val();

         if (chekName.length < 5) {

            $('.nameError').html('Пожалуйста введите полное ФИО!');
            $(".nameError").fadeIn("slow");
            $('[name=userName]').css('border', 'red 1px solid');
            return false;
         }

         if (error == 0) {
            return true;
         } else {
            return false;
         }
      }
   });
</script>