<?php include ROOT . '/views/cabinet/Index/Header.php'; ?>
<?php $environment = include_once($_SERVER['DOCUMENT_ROOT'] . '/config/environment.php'); ?>
<main class="main-cabinet-user main-cabinet-editing">
   <div class="container">
      <div class="cabinet-sidebar">
         <div class="btn-close__menu"></div>
         <?php include ROOT . '/views/cabinet/Index/CabinetMenu.php'; ?>
      </div>
      <div class="main-cabinet-user__content">
         <ul class="breadcrumb breadcrumb-cabinet">
            <li><a href="/cabinet" title="Главная"><span>ГЛАВНАЯ</span></a></li>
            <li><a href="/cabinet/edit" title="Профиль"><span>профиль</span></a></li>
            <li><a><span>добавить плательщика</span></a></li>
         </ul>
         <h1>Добавить физическое лицо</h1>
         <div class="required-fields">Поля, обозначенные * обязательны к заполнению</div>
           <?php if (isset($errors) && is_array($errors)): ?>
                        <ul class="error_flag">
                            <?php foreach ($errors as $error): ?>
                                <li> - <?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
         <form method="post" class="form-cabinet">
            <div class="form-group">
               <label>
               <span class="form-group__title">ФИО*</span>
               <input type="text" name="fio" placeholder="Укажите ФИО" required autocomplete="off">
               </label>
               <label>
               <span class="form-group__title">Телефон*</span>
               <input type="text" name="phone_fiz" placeholder="+7 (___) ___ - __ - __" id="online_phone" autocomplete="off">
               </label>
            </div>
            <div class="form-group">
               <label>
               <span class="form-group__title">E-mail*</span>
               <input type="text" name="emailfiz" placeholder="Укажите Email" autocomplete="off">
               </label>
               <label>
               <span class="form-group__title">Адрес доставки*</span>
               <input type="text" name="adress_deleviry" placeholder="Адрес доставки">
               </label>
            </div>
            <div class="w-100">
               <div class="consent consent__form-cabinet">
                  
                  <p>Отправляя форму Вы соглашаетесь с <a href="<?php echo $environment["base_url"]; ?>/agreement" target="_blank" class="color_blue">пользовательским соглашением</a></p>
               </div>
               <button type="submit" name="submit" class="btn btn_black">Сохранить</button>
            </div>
         </form>
      </div>
   </div>
</main>
</div>
<?php include ROOT . '/views/cabinet/Index/Footer.php'; ?>
<script>
$('[name=phone_fiz]').mask('+7 (999) 999-99-99');

$("[name=phone_fiz]").click(function(){
  $(this).setCursorPosition(4);
}).mask("+7 (999) 999-99-99", {autoclear: false});
$('[name=phone_fiz]').mask("+7 (999) 999-99-99", {autoclear: false});

</script>