<?php include ROOT . '/views/cabinet/Index/Header.php'; ?>
<main class="main-cabinet-user">
   <div class="container">
      <div class="cabinet-sidebar">
         <div class="btn-close__menu"></div>
         <?php include ROOT . '/views/cabinet/Index/CabinetMenu.php'; ?>
         <?php include ROOT . '/views/cabinet/Index/CabinetMenuSideBar.php'; ?>
      </div>
      <div class="main-cabinet-user__content">
         <div class="main-cabinet-user__wrap">
            <div class="main-cabinet-user__wrap-inner">
               <h1>
                  Здравствуйте<?php if ($user["name"]) {
                                    echo ", " . $user["name"] . "! ";
                                 } ?> </h1>


               <div class="main-cabinet-user__wrap-inner">
                  <div class="form-group__title">Телефон</div>
                  <?php echo $user['phone']; ?>
               </div>
               <div class="main-cabinet-user__wrap-inner">
               <?php if ($user['email']) { ?>
                     <div class="form-group__title">E-mail</div>
                     <?php echo $user['email']; ?>
               </div>
                <?php } ?>
                <?php if ($address) { ?>
                     <div class="form-group__title">Город</div>
                     <?=$address['ur_adress']; ?>
                <?php } ?>
                <div class="editPersonalData">Редактировать личные данные
           </div>
           <div class="personalDataModal hidden">
                  <?php if ($result) : ?>
                     <ul class="ok_flag">
                        <li> - Данные отредактированы</li>
                     </ul>
                     <script>
                        setTimeout(function() {
                           location.href = '/cabinet/edit'
                        }, 3000)
                     </script>
                  <?php else : ?>
                     <?php if (isset($errors) && is_array($errors)) : ?>
                        <ul class="error_flag">
                           <?php foreach ($errors as $error) : ?>
                              <li> - <?php echo $error; ?></li>
                           <?php endforeach; ?>
                        </ul>
                     <?php endif; ?>
                     <form method="post" class="form-cabinet">
                        <div class="form-group">
                           <div class="cabinet-h2"></div>
                           <label>
                              <span class="form-group__title">ФИО*</span>
                              <input type="text" name="name" placeholder="ФИО" value="<?php echo $name; ?>">
                           </label>
                           <label>
                              <span class="form-group__title">Город*</span>
                              <input type="text" name="city" value="<?php echo $city; ?>" placeholder="Введите город" autocomplete="off">
                           </label>
                        </div>
                        <div class="form-group">
                           <div class="cabinet-h2"></div>
                           <label>
                              <span class="form-group__title">E-mail</span>
                              <input type="text" type="email" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>">
                           </label>
                           <label>
                              <span class="form-group__title">Телефон*</span>
                              <input type="text" name="tel" id="online" placeholder="+7 (___) ___ - __ - __" disabled value="<?php echo $phone; ?>" autocomplete="off">
                           </label>
                        </div>
                        <div class="w-100">
                           <button type="submit" name="submit" class="btn btn_cabinet_add">Сохранить</button>
                        </div>
                     </form>
                  <?php endif; ?>
         </div>

            <?php
            if ($user["specialClient"]) { ?>

               <div class="form-group__title">Персональная скидка</div>
               <ul class="list-info">
                        <li class="list-info__item">
                           <div class="list-info__text"><?php echo $personalDiscount; ?></div>
                        </li>
               </ul>

            <?php }?>
            <?php
            if ($specialPricesExist) { ?>
               <div class="btn btn_cabinet_add btn-special"><a href="/special" class="list-info__text">Мои спеццены</a></div>
            <?php }?>
            </div>
            <div class="personal_manager_block">
               <?php if ($usermanager != '') { ?>
                  <div class="manager-information__content main-cabinet-user__wrap-inner">
                     <div class="form-group__title">Менеджер</div>
                     <ul class="list-info">
                        <li class="list-info__item">
                           <div class="list-info__text"><?php echo $usermanager['manager_name']; ?></div>
                        </li>
                        <li class="list-info__item">
                           <a href="tel:+79262510313" class="phone-cabinet">
                              <span class="list-info__icon"><img src="/template/images/Stock/002-phone-call.svg"></span>
                              <span class="list-info__text"><?php echo $usermanager['manager_phone']; ?></span>
                           </a>
                           <br><br>
                        </li>
                        <li class="list-info__item">
                           <a href="mailto:<?php echo $usermanager['manager_email']; ?>" class="mail-cabinet">
                              <span class="list-info__text"><?php echo $usermanager['manager_email']; ?></span>
                           </a>
                        </li>
                        <li class="list-info__item">
                           <div class="list-info__icon"><img src="/template/images/Stock/004-clock.svg"></div>
                           <div class="list-info__text">Пн-Пт 10:00-18:00</div>
                        </li>
                     </ul>
                  </div>
               <?php } ?>
               <?php if ($useroperator != '') { ?>
                  <div class="manager-information__content main-cabinet-user__wrap-inner">
                     <div class="form-group__title">Оператор</div>
                     <ul class="list-info">
                        <li class="list-info__item">
                           <div class="list-info__text"><?php echo $useroperator['operator_name']; ?></div>
                        </li>
                        <li class="list-info__item">
                           <a href="tel:+79262510313" class="phone-cabinet">
                              <span class="list-info__icon"><img src="/template/images/Stock/002-phone-call.svg"></span>
                              <span class="list-info__text"><?php echo $useroperator['operator_phone'] . "<br> добавочный " . $useroperator['operator_dob'] ?></span>
                           </a>
                        </li>
                        <li class="list-info__item">
                           <a href="mailto:<?php echo $useroperator['manager_email']; ?>" class="mail-cabinet">
                              <span class="list-info__text"><?php echo $useroperator['operator_email']; ?></span>
                           </a>
                        </li>
                        <li class="list-info__item">
                           <div class="list-info__icon"><img src="/template/images/Stock/004-clock.svg"></div>
                           <div class="list-info__text">Пн-Пт 10:00-18:00</div>
                        </li>
                     </ul>
                  </div>
               <?php } ?>
            </div>
            


         </div>

      </div>
   </div>
</main>
<?php include ROOT . '/views/cabinet/Index/Footer.php'; ?>
