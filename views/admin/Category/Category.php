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
            <li><a title="Категории"><span>Категории</span></a></li>
         </ul>
         <h1>Родительские категории</h1>
         <div class="sales-table__admin table w-100">
            <div class="table__head">
               <div class="table__th sales-table__banner">Категория</div>
               <div class="table__th sales-table__name">Тайтл</div>
               <div class="table__th sales-table__description">Дескрипшн</div>
               <div class="table__th sales-table__actions">Редактировать</div>
            </div>
            <div class="table__body">
               <?php foreach ( $allParentCategory as $allParentCategoryOne ) { ?>
               <div class="table-body_line">
                  <div class="table__td sales-table__banner">
                     <a href="/admin/subcat/<?php echo $allParentCategoryOne['cat_code']; ?>"><?php echo $allParentCategoryOne['cat_name']; ?></a>
                  </div>
                  <div class="table__td sales-table__name">
                     <p><?php echo $allParentCategoryOne['cat_title']; ?></p>
                  </div>
                  <div class="table__td sales-table__description">
                      <?php echo $allParentCategoryOne['cat_description']; ?>
                  </div>
                  <div class="table__td sales-table__actions">
                     <a href="/admin/metacat/<?php echo $allParentCategoryOne['cat_code']; ?>" class="btn-delete deleteBanner" title="редактировать">
                     <img src="/template/images/Stock/edit.svg" alt="редактировать">Редактировать
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