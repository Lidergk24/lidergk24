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
            <li><a title="Менеджеры"><span>менеджеры</span></a></li>
         </ul>
         <h1>Менеджеры</h1>
         <div class="main-cabinet-button__group">
            <a href="/admin/addmanager" class="btn btn_black" title="Добавить менеджера">
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
               Добавить менеджера
            </a>
         </div>
         <div class="sales-table__admin managers-table table w-100">
            <div class="table__head">
               <div class="table__th managers-table__name">ФИО</div>
               <div class="table__th managers-table__phone">Телефон</div>
               <div class="table__th managers-table__phone-add">Добавочный</div>
               <div class="table__th managers-table__mail">E-mail</div>
               <div class="table__th managers-table__photo">Удалить</div>
            </div>
            <div class="table__body">
                <?php foreach($managers as $managersOne){ ?>
                <div class="table-body_line">
                  <div class="table__td managers-table__name">
                     <p><?php echo $managersOne['manager_name']; ?></p>
                  </div>
                  <div class="table__td managers-table__phone">
                     <p><?php echo $managersOne['manager_phone']; ?></p>
                  </div>
                  <div class="table__td managers-table__phone-add">
                     <p><?php echo $managersOne['manager_flag']; ?></p>
                  </div>
                  <div class="table__td managers-table__mail">
                     <p><?php echo $managersOne['manager_email']; ?></p>
                  </div>
                  <div class="table__td managers-table__photo">
                      <p class="idManager" data-id="<?php echo $managersOne['id']; ?>">x</p>
                     <!-- <div class="photo-manager"><img src="/template/images/Stock/manager.jpg" alt="фото"></div> -->
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
    
    $('.idManager').on('click', function(){
        
         var idM = $(this).closest('.idManager').attr('data-id');
         
         var isGood= confirm('Удалить манеджера?');
         
         if (isGood==true) {
             
            $.ajax({
             
                url: '/views/admin/Managers/deleteManager.php',
                type: 'post',
                data:{ id: idM },
                    
                    success: function(data) {
                         
                      location.reload();

                    }
            });
        }
         
    });
   
    
</script>