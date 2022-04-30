<?php include ROOT . '/views/admin/Index/Header.php'; ?>
<main class="main-cabinet-user main-cabinet-editing">
   <div class="container">
      <div class="cabinet-sidebar">
         <div class="btn-close__menu"></div>
         <?php include ROOT . '/views/admin/Index/Sidebar.php'; ?>
      </div>
      <div class="main-cabinet-user__content">
         <ul class="breadcrumb breadcrumb-cabinet">
            <li><a href="/admin" title="Главная"><span>ГЛАВНАЯ</span></a></li>
            <li><a href="/admin/allprofile" title="Профили"><span>Профили</span></a></li>
            <li><a><span>Добавить профиль</span></a></li>
         </ul>
         <div class="required-fields"> Все поля обязательны к заполнению</div>
          <?php if (isset($errors) && is_array($errors)): ?>
                <ul class="error_flag">
                <?php foreach ($errors as $error): ?>
                    <li> - <?php echo $error; ?></li>
                    <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
         <form method="post" class="form-cabinet" action="addnewprofile">
            <div class="form-group">
               <label>
               <span class="form-group__title">Название профиля</span>
               <input type="text" name="name_profile" placeholder="Придумайте название профиля" required>
               </label>
               <label>
               <span class="form-group__title">ИНН</span>
               <input type="text" name="inn" placeholder="Введите ИНН компании (10 цифр)" maxlength="12" required>
               </label>
               <label>
               <span class="form-group__title">КПП</span>
               <input type="text" name="kpp" placeholder="Введите КПП компании (9 цифр)" maxlength="9">
               </label>
               <label>
               <span class="form-group__title">Название компании</span>
               <input type="text" name="name_company" placeholder="Введите правовую форму и название компании">
               </label>
               <label>
               <span class="form-group__title">БИК</span>
               <input type="text" name="bik" placeholder="Укажите БИК Вашей организации (9 цифр)" maxlength="9">
               </label>
            </div>
            <div class="form-group">
               <label>
               <span class="form-group__title">Рассчетный счет</span>
               <input type="text" name="rs" placeholder="Укажите рассчетный счет (20 цифр)" maxlength="20">
               </label>
               <label>
               <span class="form-group__title">Контактное лицо</span>
               <input type="text" name="contact" placeholder="ФИО контактного лица">
               </label>
               <label>
               <span class="form-group__title">E-mail</span>
               <input type="text" name="email" placeholder="Укажите Email" required>
               </label>
               <label>
               <span class="form-group__title">Телефон</span>
               <input type="text" name="phone" id="phone" placeholder="+7 (___) ___ - __ - __" inputmode="numeric" autocomplete="off" required>
               </label>
               <label>
               <span class="form-group__title">Адрес доставки</span>
               <input type="text" name="address" placeholder="Адрес доставки" required>
               </label>
            </div>
            <div class="w-100">
               <button class="btn btn_black">Создать профиль</button>
            </div>
         </form>
      </div>
   </div>
</main>
<?php include ROOT . '/views/admin/Index/Footer.php'; ?>
<script>
    $('[name=phone_manager]').mask('+7 (999) 999-99-99');
    
    $("[name=phone_manager]").click(function(){
      $(this).setCursorPosition(4);
    }).mask("+7 (999) 999-99-99", {autoclear: false});
    $('[name=phone]').mask("+7 (999) 999-99-99", {autoclear: false});
</script>