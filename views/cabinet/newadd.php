<?php include ROOT . '/views/cabinet/Index/Header.php'; ?>
<?php $environment = include_once($_SERVER['DOCUMENT_ROOT'] . '/config/environment.php'); ?>
<main class="main-cabinet-user main-cabinet-editing">
   <div class="container">
      <div class="cabinet-sidebar">
         <div class="btn-close__menu"></div>
         <?php include ROOT . '/views/cabinet/Index/CabinetMenu.php'; ?>
         <?php include ROOT . '/views/cabinet/Index/CabinetMenuSideBar.php'; ?>
      </div>
      <div class="main-cabinet-user__content">
         <ul class="breadcrumb breadcrumb-cabinet">
            <li><a href="/cabinet" title="Главная"><span>ГЛАВНАЯ</span></a></li>
            <li><a href="/cabinet/adress" title="Адреса"><span>адреса</span></a></li>
            <li><a><span>Добавить адрес</span></a></li>
         </ul>
         <h1>Добавить адрес</h1>
         <?php if ($addAdress) { ?>
         <ul class="ok_flag">
            <li> - Адрес добавлен</li>
         </ul>
        <!--  <script> setTimeout(function(){location.href='/cabinet/adress'},3000)</script> -->
         <?php } else {
            if (isset($errors) && is_array($errors)){ ?>
         <ul class="error_flag">
            <?php foreach ($errors as $error){ ?>
            <li> - <?php echo $error; ?></li>
            <?php } ?>
         </ul>
         <?php } } ?>
         <form method="post" class="form-cabinet">
            <div class="form-group">
               <label>
               <span class="form-group__title">Город*</span>
               <input type="text" name="city" required autocomplete="off">
               </label>
               <label>
               <span class="form-group__title">Дом*</span>
               <input type="text" name="house" autocomplete="off" required>
               </label>
               <label>
               <span class="form-group__title">Квартира / офис</span>
               <input type="text" name="office" placeholder="(если есть)">
               </label>
            </div>
            <div class="form-group">
               <label>
               <span class="form-group__title">Улица*</span>
               <input type="text" name="street" autocomplete="off" required>
               </label>
               <label>
               <span class="form-group__title">Корпус</span>
               <input type="text" name="korpus" placeholder="(если есть)">
               </label>
               <label>
               <span class="form-group__title">Домофон</span>
               <input type="text" name="domofon" placeholder="(если есть)">
               </label>
            </div>
            <div class="w-100">
               <div class="consent consent__form-cabinet">
                  <p>Отправляя форму Вы соглашаетесь с <a href="<?php echo $environment["base_url"]; ?>/agreement" target="_blank" class="color_blue">пользовательским соглашением</a></p>
               </div>
               <button type="submit" name="submit" class="btn btn_cabinet_add">Добавить адрес</button>
            </div>
         </form>
      </div>
   </div>
</main>
<?php include ROOT . '/views/cabinet/Index/Footer.php'; ?>