<?php include ROOT . '/views/admin/Index/Header.php'; ?>
<main class="main-cabinet-user main-cabinet-user-view main-cabinet-admin">
   <div class="container">
      <div class="cabinet-sidebar">
         <div class="btn-close__menu"></div>
         <?php include ROOT . '/views/admin/Index/Sidebar.php'; ?>
      </div>
      <div class="main-cabinet-user__content main-cabinet-admin__content">
         <ul class="breadcrumb breadcrumb-cabinet">
            <li><a href="/admin" title="Главная"><span>ГЛАВНАЯ</span></a></li>
            <li><a href="/admin/onlysales" title="Акции"><span>Акции</span></a></li>
            <li><a title="Добавить акцию"><span>Добавить акцию</span></a></li>
         </ul>
         <h1>Добавить акцию</h1>
         <div class="cabinet-admin__description">* Размер баннера 1130 х 300 px</div>
         <form enctype="multipart/form-data" method="POST" class="form-add-file form-admin-cabinet">
            <div class="file-upp__wrapper">
               <span class="form-group__title">Прикрепить картинку</span>
               <label class="file-upp">
               <span class="icon-plus">
               <img src="images/plus.svg" alt="">
               </span>
               <span class="file-upp-name">Выберите файл</span>
               <input type="file" name="filename">
               </label>
               <div class="js-value">Файл не выбран</div>
            </div>
            <div class="file-result"></div>
            <label>
            <span class="form-group__title">Название акции</span>
            <input type="text" name="banerName" required>
            </label>
            <label>
            <span class="form-group__title">Описание акции</span>
            <textarea cols="80" id="editor1" rows="10" name="textSale" style="visibility: hidden; display: none;"></textarea>
            <script type="text/javascript">
            CKEDITOR.replace( 'editor1');
            </script>
            </label>
            <button class="btn btn_black" name="submit" type="submit">Добавить баннер</button>
         </form>
      </div>
   </div>
</main>
<?php include ROOT . '/views/admin/Index/Footer.php'; ?>