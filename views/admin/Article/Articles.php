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
            <li><a><span>статьи</span></a></li>
         </ul>
         <h1>Статьи</h1>
         <div class="main-cabinet-button__group">
            <a href="/admin/book" class="btn btn_black" title="">
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
               Добавить статью
            </a>
         </div>
         <div class="sales-table__admin articles-table__admin table w-100">
            <div class="table__head">
               <div class="table__th articles-table__name">Название статьи</div>
               <div class="table__th articles-table__title">Тайтл</div>
               <div class="table__th articles-table__description">Дискрипшн</div>
               <div class="table__th articles-table__photo">Наличие фото</div>
               <div class="table__th articles-table__actions">Действия</div>
            </div>
            <div class="table__body">
               <?php foreach($articles as $articleOne){ ?>
               <div class="table-body_line">
                  <div class="table__td articles-table__name">
                     <p><a href="/admin/editbook/<?php echo $articleOne['id']; ?>"><?php echo $articleOne['article_name']; ?></a></p>
                  </div>
                  <div class="table__td articles-table__title">
                     <p><?php echo $articleOne['article_title']; ?></p>
                  </div>
                  <div class="table__td articles-table__description">
                     <p><?php echo $articleOne['article_description']; ?></p>
                  </div>
                  <div class="table__td articles-table__photo">
                     <?php if($articleOne['article_image']!=''){ ?>
                     <div class="picture-icon"><img src="/template/images/Stock/picture.svg" alt=""></div>
                     <?php } ?>
                  </div>
                  <div class="table__td articles-table__actions">
                     <div class="button-group">
                        <a href="/admin/editbook/<?php echo $articleOne['id']; ?>" class="btn-edit" title="Редактировать">
                        <img src="/template/images/Stock/edit.svg" alt="">
                        </a>
                        <a href="/admin/statdelete/<?php echo $articleOne['id']; ?>" class="btn-delete" title="Удалить">
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
</main>
<?php include ROOT . '/views/admin/Index/Footer.php'; ?>