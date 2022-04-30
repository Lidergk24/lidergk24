<?php include ROOT . '/views/admin/Index/Header.php'; ?>
<main class="main-cabinet-user main-cabinet-user-view main-cabinet-admin">
   <div class="container">
      <div class="cabinet-sidebar">
         <div class="btn-close__menu"></div>
         <?php include ROOT . '/views/admin/Index/Sidebar.php'; 
         $environment = include_once($_SERVER['DOCUMENT_ROOT'] . '/config/environment.php');
         ?>
      </div>
      <div class="main-cabinet-user__content main-cabinet-admin__content">
         <ul class="breadcrumb breadcrumb-cabinet">
            <li><a href="/admin" title="Главная"><span>ГЛАВНАЯ</span></a></li>
            <li><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" title="Банеры"><span>Категория</span></a></li>
            <li><a title="<?php echo $infoEndcat['cat_name']; ?>"><span><?php echo $infoEndcat['cat_name']; ?></span></a></li>
         </ul>
         <form enctype="multipart/form-data" method="POST" class="form-add-file form-admin-cabinet">
            <?php if(!empty($infoEndcat['cat_icon'])){ ?>
            <span>Иконка категории:</span><img style="display: inline-block;" src="<?php echo $environment["base_url"]; ?>/template/images/icons/<?php echo $infoEndcat['cat_icon']; ?>">
            <?php } ?>
            <input type="file" name="filename">
            <?php if(!empty($infoEndcat['category_image'])){ ?>
            <span>Картинка категории:</span><img style="display: inline-block;" src="/template/images/<?php echo $infoEndcat['category_image']; ?>">
            <?php } ?>
            <input type="file" name="imageCategory">
            <label>
            <span class="form-group__title">TITLE категории</span>
            <input  name="titleCategory" value="<?php echo $infoEndcat['category_title']; ?>" required>
            </label>
            <label>
            <span class="form-group__title">Description категории</span>
            <input name="descriptionCategory" value="<?php echo $infoEndcat['category_description']; ?>" required>
            </label>
            <label>
            <span class="form-group__title">H1 категории</span>
            <input name="hCategory" value="<?php echo $infoEndcat['cat_h1']; ?>" required>
            </label>
            <textarea cols="80" id="editor1" rows="10" name="textCategory" style="visibility: hidden; display: none;"><?php echo $infoEndcat['cat_desc']; ?></textarea>
            <script type="text/javascript">
               CKEDITOR.replace( 'editor1');
            </script>
            <button class="btn btn_black" name="submit" type="submit">Обновить</button>
         </form>
      </div>
   </div>
</main>

<?php include ROOT . '/views/admin/Index/Footer.php'; ?>