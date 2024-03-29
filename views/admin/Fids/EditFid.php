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
            <li><a href="/admin/allbook" title="Фиды"><span>фиды</span></a></li>
            <li><a title="Редактировать фид"><span><?php echo $result['article_name']; ?></span></a></li>
         </ul>
         <h1>Редактировать фид <?php echo $result['article_name']; ?></h1>
         <form enctype="multipart/form-data" method="POST" class="form-add-file form-admin-cabinet form-add-article">
            <div class="form-group">
               <label>
               <span class="form-group__title">Товар</span>
               <input type="text" name="name_book" value="<?php echo $result['article_name']; ?>" required>
               </label>
               <label>
               <span class="form-group__title">Тайтл</span>
               <input type="text" name="title_book" value="<?php echo $result['article_title']; ?>" required>
               </label>
               <label>
               <span class="form-group__title">Дискрипшн</span>
               <input type="text" name="description_book" value="<?php echo $result['article_description']; ?>" required>
               </label>
            </div>
            <div class="form-group form-group__file">
               <div class="file-upp__wrapper">
                  <span class="form-group__title">Картинка</span>
                  <label class="file-upp">
                  <span class="icon-plus">
                  <img src="/template/images/Stock/plus.svg" alt="<?php echo $result['article_name']; ?>">
                  </span>
                  <span class="file-upp-name">Выберите файл</span>
                  <input type="file" name="filename">
                  </label>
                  <img src="/upload/images/<?php echo $result['article_image']; ?>" width="200" alt="<?php echo $result['article_name']; ?>">
               </div>
            </div>
            <div class="editor" >
               <textarea cols="80"  id="editor1" rows="10" name="text_book" style="visibility: hidden; display: none;"><?php echo $result['article_text']; ?></textarea>
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