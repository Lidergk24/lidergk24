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
            <li><a href="/admin/banners" title="Банеры"><span>Баннеры</span></a></li>
            <li><a title="Добавить банер"><span>Добавить баннер</span></a></li>
         </ul>
         <h1>Добавить баннер 1</h1>
         <div class="cabinet-admin__description">* Размер баннера 1127 х 558 px</div>
         <form enctype="multipart/form-data" method="POST" class="form-add-file form-admin-cabinet">
            <div class="file-upp__wrapper">
               <span class="form-group__title">Загрузить баннер</span>
               <label class="file-upp">
               <span class="icon-plus">
               <img src="images/plus.svg" alt="">
               </span>
               <span class="file-upp-name">Выберите файл</span>
               <input type="file" name="filename">
               </label>
               <div class="js-value">Файл не выбран</div>
            </div>
            <div class="file-result">
            </div>
            <label>
            <span class="form-group__title">Заголовок для баннера и атрибута alt</span>
            <input type="text" name="banerName" required>
            </label>
            <label>
            <span class="form-group__title">Ссылка на страницу, на которую ведет баннер</span>
            <input type="text" name="banerLink" required>
            </label>
            <button class="btn btn_black" name="submit1" type="submit">Добавить баннер</button>
         </form>
         <h1>Добавить баннер 2 </h1>
         <div class="cabinet-admin__description">* Размер баннера 450 х 453 px</div>
         <form enctype="multipart/form-data" action="/admin/addSquareBaner" method="POST" class="form-add-file form-admin-cabinet">
            <div class="file-upp__wrapper">
               <span class="form-group__title">Загрузить баннер</span>
               <label class="file-upp">
               <span class="icon-plus">
               <img src="images/plus.svg" alt="">
               </span>
               <span class="file-upp-name">Выберите файл</span>
               <input type="file" name="filename">
               </label>
               <div class="js-value">Файл не выбран</div>
            </div>
            <div class="file-result">
            </div>
            <label>
            <span class="form-group__title">Заголовок для баннера и атрибута alt</span>
            <input type="text" name="banerName" required>
            </label>
            <label>
            <span class="form-group__title">Ссылка на страницу, на которую ведет баннер</span>
            <input type="text" name="banerLink" required>
            </label>
            <button class="btn btn_black" name="submit2" type="submit">Добавить баннер</button>
         </form>
      </div>
   </div>
</main>

<?php include ROOT . '/views/admin/Index/Footer.php'; ?>