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
            <li><a href="/admin/thisbrand" title="Бренды"><span>Бренды</span></a></li>
            <li><a title="Редактировать бренд"><span><?php echo $selectBrand['brand_name']; ?></span></a></li>
         </ul>
         <h1>Редактировать брэнд <?php echo $selectBrand['brand_name']; ?></h1>
         <form enctype="multipart/form-data" method="POST" class="form-add-file form-admin-cabinet form-add-article">
            <div class="form-group">
               <label>
               <span class="form-group__title">Название бренда</span>
               <input type="text" name="name_book" value="<?php echo $selectBrand['brand_name']; ?>" required>
               </label>
            </div>
            <div class="form-group form-group__file">
               <div class="file-upp__wrapper">
                  <span class="form-group__title">Загрузить логотип</span>
                  <label class="file-upp">
                  <span class="icon-plus">
                  <img src="/template/images/Stock/plus.svg" alt="<?php echo $selectBrand['brand_name']; ?>">
                  </span>
                  <span class="file-upp-name">Выберите файл</span>
                  <input type="file" name="filename">
                  </label>
                  <img src="/template/images/Brand/<?php echo $selectBrand['brand_logo']; ?>" width="200" alt="<?php echo $selectBrand['brand_name']; ?>">
               </div>
            </div>
            <div class="editor" >
               <textarea cols="80"  id="editor1" rows="10" name="text_book" style="visibility: hidden; display: none;"><?php echo $selectBrand['brand_description']; ?></textarea>
               <script type="text/javascript">
                  CKEDITOR.replace( 'editor1');
               </script>
            </div>
            <button class="btn btn_black" name="submit" type="submit">Сохранить</button>
         </form>
      </div>
   </div>
</main>

<?php include ROOT . '/views/admin/Index/Footer.php'; ?>