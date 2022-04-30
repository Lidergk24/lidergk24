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
            <li><a href="/cabinet/edit" title="Профили"><span>реквизиты</span></a></li>
            <li><a><span>добавить реквизиты</span></a></li>
         </ul>
         <h1>Добавить реквизиты</h1>
        
         <div class="required-fields">Все поля обязательны к заполнению</div>
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
               <span class="form-group__title">Название компании</span>
               <input type="text" name="name_profile" placeholder="Укажите название компании" required>
               </label>
               <label>
               <span class="form-group__title">Форма юр. собственности*</span>
               <select type="text" name="property" placeholder="Укажите форму юридической собственности профиля" value="OOO" required>
                  <option disabled>Укажите форму юридической собственности</option>
                  <option value="ИП">ИП</option>
                  <option value="ООО">ООО</option>
                  <option value="Самозанятый">Самознятый</option>
               </select>
               </label>
               <label>
               <span class="form-group__title">ИНН</span>
               <input type="text" name="inn" placeholder="Введите ИНН компании" required>
               </label>
            </div>
            <div class="form-group">
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
               <input type="text" name="phone" id="online_phone" placeholder="+7 (___) ___ - __ - __" autocomplete="off" required>
               </label>
            </div>
            <div class="w-100">
               <div class="consent consent__form-cabinet">
                  <p>Отправляя форму Вы соглашаетесь с <a href="<?php echo $environment["base_url"]; ?>/agreement" target="_blank" class="color_blue">пользовательским соглашением</a></p>
               </div>
               <button type="submit" name="submit" class="btn btn_cabinet_add">Создать профиль</button>
            </div>
         </form>
      </div>
   </div>
</main>
<?php include ROOT . '/views/cabinet/Index/Footer.php'; ?>
<script>
/*$('[name=phone]').mask('+7 (999) 999-99-99');

$("[name=phone]").click(function(){
  $(this).setCursorPosition(4);
}).mask("+7 (999) 999-99-99", {autoclear: true});*/
//$('[name=phone]').mask("+7 (999) 999-99-99", {autoclear: false});
</script>