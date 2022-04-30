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
            <li><a><span>фиды</span></a></li>
         </ul>
         <h1>Фиды</h1>
         <div class="main-cabinet-button__group">
            <a href="/admin/addfid" class="btn btn_black" title="">
               <span class="icon-plus">
                  <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                     y="0px"
                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                     <g>
                        <g>
                           <path d="M492,236H276V20c0-11.046-8.954-20-20-20c-11.046,0-20,8.954-20,20v216H20c-11.046,0-20,8.954-20,20s8.954,20,20,20h216
                              v216c0,11.046,8.954,20,20,20s20-8.954,20-20V276h216c11.046,0,20-8.954,20-20C512,244.954,503.046,236,492,236z"/>
                        </g>
                     </g>
                  </svg>
               </span>
               Добавить фид
            </a>
         </div>
         <div class="sales-table__admin articles-table__admin table w-100">
            <div class="table__head">
               <div class="table__th articles-table__name" id="fid">Артикул</div>
               <div class="table__th articles-table__title">Товар</div>
               <div class="table__th articles-table__actions">Действия</div>
            </div>
            <div class="table__body">
            <?php foreach($fids['fids'] as $fid){ ?>
               <div class="table-body_line">
                  <div class="table__td articles-table__name" id="fid">
                     <p><?=$fid['prod_id']; ?></p>
                  </div>
                  <div class="table__td articles-table__title">
                     <p><?php echo $fid['name']; ?></p>
                  </div>
                  <div class="table__td articles-table__actions">
                     <div class="button-group">
                        <a href="/admin/fiddelete/<?php echo $fid['prod_id']; ?>" class="btn-delete" title="Удалить">
                        <img src="/template/images/Stock/delete.svg" alt="">
                        </a>
                     </div>
                  </div>
               </div>
               <?php } ?>
            </div>
            <hr />
            <div class="table__body">
                <div class="table__head">
                   <div class="table__th articles-table__name" id="fid">Категория</div>
                   <div class="table__th articles-table__title">Название</div>
                   <div class="table__th articles-table__actions">Действия</div>
                </div>
                <div class="table__body">
                    <?php foreach($fids['catfids'] as $fid){ ?>
                       <div class="table-body_line">
                          <div class="table__td articles-table__name" id="fid">
                             <p><?=$fid['categoryId']; ?></p>
                          </div>
                          <div class="table__td articles-table__title">
                             <p><?php echo $fid['cat_name']; ?></p>
                          </div>
                          <div class="table__td articles-table__actions">
                             <div class="button-group">
                                <a href="/admin/catfiddelete/<?php echo $fid['categoryId']; ?>" class="btn-delete" title="Удалить">
                                <img src="/template/images/Stock/delete.svg" alt="">
                                </a>
                             </div>
                          </div>
                       </div>
                    <?php } ?>
                </div>
            </div>
         </div>
      </div>
   </div>
</main>
<?php include ROOT . '/views/admin/Index/Footer.php'; ?>