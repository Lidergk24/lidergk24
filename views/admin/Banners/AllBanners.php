<?php include ROOT . '/views/admin/Index/Header.php'; ?>
<main class="main-cabinet-user main-cabinet-user-view main-cabinet-admin">
   <div class="container">
      <div class="cabinet-sidebar">
         <div class="btn-close__menu"></div>
         <?php include ROOT . '/views/admin/Index/Sidebar.php'; 
           $environment = include_once($_SERVER['DOCUMENT_ROOT'] . '/config/environment.php');?>
      </div>
      <div class="main-cabinet-user__content main-cabinet-admin__content">
         <ul class="breadcrumb breadcrumb-cabinet">
            <li><a href="/admin" title="Главная"><span>ГЛАВНАЯ</span></a></li>
            <li><a title="Все баннеры"><span>Все баннеры</span></a></li>
         </ul>
         <h1>Все баннеры</h1>
         <div class="main-cabinet-button__group">
            <a href="/admin/addbaner" class="btn btn_black" title="Добавить банер">
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
               Добавить баннер
            </a>
         </div>
         <div class="sales-table__admin table w-100">
            <div class="table__head">
               <div class="table__th sales-table__banner">Баннер</div>
               <div class="table__th sales-table__name">Название</div>
               <div class="table__th sales-table__description">Позиция</div>
               <div class="table__th sales-table__actions">Удалить</div>
            </div>
            <div class="table__body">
               <?php foreach($allBanner as $allBannerOne){ ?>
               <div class="table-body_line">
                  <div class="table__td sales-table__banner">
                     <img src="<?php  echo $environment["base_url"]; ?>/upload/banners/<?php echo $allBannerOne['banner_image']; ?>" alt="<?php echo $allBannerOne['banner_image']; ?>">
                  </div>
                  <div class="table__td sales-table__name">
                     <p><?php echo $allBannerOne['banner_title']; ?></p>
                  </div>
                  <div class="table__td sales-table__description">
                     <form class="formSort">
                        <input class="inputSortBaner" type="text" name="sortBaner" value="<?php echo $allBannerOne['banner_position']; ?>" maxlength="1" data-id="<?php echo $allBannerOne['id']; ?>">
                     </form>
                  </div>
                  <div class="table__td sales-table__actions">
                     <a class="btn-delete deleteBanner" title="Удалить">
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
   $('input[name="sortBaner"]').blur(function(){
       
        var sortValue = $(this).closest('.table-body_line').find('input[name="sortBaner"]').val();
        var idsSort = $(this).closest('.table-body_line').find('input[name="sortBaner"]').attr('data-id');
        $.ajax({
               type: 'post',
               url: "/ajax/sortbaner", 
               data: {id: idsSort , sort: sortValue},
               dataType: 'TEXT',
             
        }) 
   });
   
   $('input[name="sortBaner"]').bind("keyup", function() {
            if (this.value.match(/[^0-9]/g)) {
                this.value = this.value.replace(/[^0-9]/g, '');
            }
   });
        
   $('.deleteBanner').click(function(){
      var isGood= confirm('Удалить банер?');
      if (isGood==true) {
      var banerIdsDelete = $(this).closest('.table-body_line').find('input[name="sortBaner"]').attr('data-id');
      var imageDeleteIds = $(this).closest('.table-body_line').find('.sales-table__banner img').attr('alt');
        $.ajax({
               type: 'post',
               url: "/ajax/deletebaner", 
               data: { ids: banerIdsDelete, img: imageDeleteIds },
               dataType: 'TEXT',
               success: function(data){
                   if(data='success'){
                       window.location.replace('/admin/banners');
                   }
               }
        }) 
      }
   });                            
                                    
</script>