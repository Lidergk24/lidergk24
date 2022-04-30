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
            <li><a title="Распродажа"><span>Блок 3 товаров</span></a>
            </li>
         </ul>
         <h1>Блок 6 товаров (добавить/редактировать)</h1>
         <div class="cabinet-admin__description">Поля, отмеченные * обязательны к заполнению</div>
         <?php
            $thissaleProducts = Product::thissaleProducts();
            $allsale = explode(',', $thissaleProducts["product_part_number"]);
            if (isset($_POST['submit'])) { ?>
         <p class="its_ok" style="color:red;"><?php echo 'Илюх все добавлено :)'; ?></p>
         <script>
            setTimeout(function(){
                $('.its_ok').hide(1000);
            }, 2000);
         </script>
         <?php } ?>
         <form method="post" class="form-add-file form-admin-cabinet form-add-manager">
            <div class="form-group">
               <label>
               <span class="form-group__title">Ввести код товаров*</span>
               <input type="text" name="sale[]" value="<?php echo trim($allsale[0], "'"); ?>" required>
               <input type="text" name="sale[]" value="<?php echo trim($allsale[1], "'"); ?>" required>
               <input type="text" name="sale[]" value="<?php echo trim($allsale[2], "'"); ?>" required>
               <input type="text" name="sale[]" value="<?php echo trim($allsale[3], "'"); ?>" required>
               <input type="text" name="sale[]" value="<?php echo trim($allsale[4], "'"); ?>" required>
               <input type="text" name="sale[]" value="<?php echo trim($allsale[5], "'"); ?>" required>
               <button class="btn btn_black " name="submit" type="submit">Добавить товары</button>
               </label>
            </div>
         </form>
      </div>
   </div>
</main>
<?php include ROOT . '/views/admin/Index/Footer.php'; ?>