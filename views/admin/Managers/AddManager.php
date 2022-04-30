<?php include ROOT . '/views/admin/Index/Header.php'; ?>
<main class="main-cabinet-user main-cabinet-user-view main-cabinet-admin">
   <div class="container">
      <div class="cabinet-sidebar">
         <div class="btn-close__menu"></div>
         <?php include ROOT . '/views/admin/Index/Sidebar.php'; ?>
      </div>
      <div class="main-cabinet-user__content main-cabinet-admin__content">
         <ul class="breadcrumb breadcrumb-cabinet">
            <li><a href="/" title="Главная"><span>ГЛАВНАЯ</span></a></li>
            <li><a href="/admin/allmg" title="Менеджеры"><span>менеджеры</span></a></li>
            <li><a><span>Добавить менеджера</span></a></li>
         </ul>
         <h1>Добавить менеджера</h1>
         <div class="cabinet-admin__description">Поля, отмеченные * обязательны к заполнению</div>
            <?php if (isset($addManager)) { ?>
            <ul class="error_flag">
               <li> - Менеджер добавлен</li>
            </ul>
            <script> setTimeout(function(){location.href='/admin/allmg'},3000)</script>
            <?php } else {
               if (isset($errors) && is_array($errors)){ ?>
            <ul class="error_flag">
               <?php foreach ($errors as $error){ ?>
               <li> - <?php echo $error; ?></li>
               <?php } ?>
            </ul>
            <?php } } ?>
         <form method="post" class="form-add-file form-admin-cabinet form-add-manager">
            <div class="form-group">
               <label>
               <span class="form-group__title">Имя и фамилия менеджера*</span>
               <input type="text" name="name_manager" maxlength="40" placeholder="Имя менеджера" required autocomplete="off">
               </label>
               <label>
               <span class="form-group__title">Добавочный городской (если есть)</span>
               <input type="text" name="dob_manager" maxlength="10" placeholder="Добавочный городской (если есть)" autocomplete="off">
               </label>
               <label>
               <span class="form-group__title">Телефон*</span>
               <input type="text" name="phone_manager" maxlength="13" placeholder="+7 (___) ___ - __ - __" autocomplete="off" required>
               </label>
               <label>
               <span class="form-group__title">E-mail менеджера*</span>
               <input type="email" name="email_manager" placeholder="Имейл адрес менеджера" autocomplete="off" required>
               </label>
            </div>
            <div class="form-group form-group__file">
               <div class="file-upp__wrapper">
                  <span class="form-group__title">Прикрепить фото</span>
                  <label class="file-upp">
                  <span class="icon-plus">
                  <img src="/template/images/Stock/plus.svg" alt="добавить">
                  </span>
                  <span class="file-upp-name">Выберите файл</span>
                  <input type="file" name="attachment-file" value="1">
                  </label>
               </div>
               <div class="file-result">
                  <div class="file-result__img"><img src="/template/images/Stock/manager.jpg" alt=""></div>
               </div>
            </div>
            <button class="btn btn_black" name="submit" type="submit">Добавить менеджера</button>
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