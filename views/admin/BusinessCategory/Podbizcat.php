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
            <li><a href="/admin/businesscategory" title="Бизнес категории"><span>Бизнес категории</span></a></li>
            <li><a title="Бизнес категории"><span><?php echo $infoThisBizCat["categoryName"]; ?></span></a></li>
         </ul>
         <h1>Бизнес категория <?php echo $infoThisBizCat["categoryName"]; ?></h1>
        
         <form method="post" class="form-add-file form-admin-cabinet form-add-manager">
            <div class="form-group">
               <label>
               <span class="form-group__title">Добавить подразделы в которых будут товары</span>
               <input type="text" name="biz" class="addCats" >
               <button class="btn btn_black addBizCat" name="submit" type="submit">Добавить подраздел</button>
               </label>
            </div>
            
         </form>
         <h2>Добавленные категории</h2>
         <div class="sales-table__admin table w-100">
            <div class="table__head">
               <div class="table__th sales-table__banner">Категория</div>
               <div class="table__th sales-table__name">Коды товаров</div>
               <div class="table__th sales-table__description">Обновить</div>
               <div class="table__th sales-table__actions">Удалить</div>
            </div>
            <div class="table__body">
               <?php foreach ( $parentChild as $allBizCatOne ) { $allCodes = explode(',', $allBizCatOne["subCategoryItems"]); ?>
                <div class="table-body_line">
                
                  <div class="table__td sales-table__banner">
                     <a><?php echo $allBizCatOne['categoryName']; ?></a>
                    
                  </div>
                  <div class="table__td sales-table__name">
                    <form method="post">
                     <input type="hidden" name="idSubs" value="<?php echo $allBizCatOne['id']; ?>">
                     <input class="bizCategoryInputStyle" type="text" name="subCatItems[]" value="<?php echo trim($allCodes[0], "'"); ?>"  maxlength="8">
                     <input class="bizCategoryInputStyle" type="text" name="subCatItems[]" value="<?php echo trim($allCodes[1], "'"); ?>"  maxlength="8">
                     <input class="bizCategoryInputStyle" type="text" name="subCatItems[]" value="<?php echo trim($allCodes[2], "'"); ?>"  maxlength="8">
                     <input class="bizCategoryInputStyle" type="text" name="subCatItems[]" value="<?php echo trim($allCodes[3], "'"); ?>"  maxlength="8">
                     <input class="bizCategoryInputStyle" type="text" name="subCatItems[]" value="<?php echo trim($allCodes[4], "'"); ?>"  maxlength="8">
                     <input class="bizCategoryInputStyle" type="text" name="subCatItems[]" value="<?php echo trim($allCodes[5], "'"); ?>"  maxlength="8">
                     <input class="bizCategoryInputStyle" type="text" name="subCatItems[]" value="<?php echo trim($allCodes[6], "'"); ?>"  maxlength="8">
                     <input class="bizCategoryInputStyle" type="text" name="subCatItems[]" value="<?php echo trim($allCodes[7], "'"); ?>"  maxlength="8">
                  </div>
                  <div class="table__td sales-table__description">
                      <button type="submit" name="addSub">Обновить</button>
                  </div>
               </form>
                  <div class="table__td sales-table__actions">
                     <a href="/admin/metacat/<?php echo $allBizCatOne['cat_code']; ?>" class="btn-delete deleteBanner" title="Удалить">
                     <input type="hidden" name="delBizCat" value="<?php echo $allBizCatOne['id']; ?>">
                     <img src="/template/images/Stock/delete.svg" alt="Удалить">
                     </a>
                  </div>
               </div>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>
</main>

<?php include ROOT . '/views/admin/Index/Footer.php'; ?>

<script>
   $('.sales-table__actions').click(function(e){
   e.preventDefault();
   var confirmS = confirm('Удалить категорию?');
    if(confirmS == true){
        var delBizCat = $(this).closest('.table-body_line').find('input[name="delBizCat"]').val();
        
        $.ajax({
             type: "POST",
             url: "/admin/businesscategory",
             data: {idCat: delBizCat},
              success: function (data) {
                    location.reload();

             }
         });
    }
   
   });
</script>