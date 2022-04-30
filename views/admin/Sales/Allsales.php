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
            <li><a title="Акции"><span>Акции</span></a></li>
         </ul>
         <h1>Все акции</h1>
         <div class="main-cabinet-button__group">
            <a href="/admin/ac" class="btn btn_black" title="Добавить акцию">
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
               Добавить акцию
            </a>
         </div>
         <?php if($allSales == false){ echo "Акций пока нет"; } else { ?>
         <div class="sales-table__admin table w-100">
            <div class="table__head">
               <div class="table__th sales-table__banner">Баннер</div>
               <div class="table__th sales-table__name">Название</div>
               <div class="table__th sales-table__description">Позиция</div>
               <div class="table__th sales-table__actions">Действия</div>
            </div>
            <div class="table__body">
               <?php foreach($allSales as $allSalesOne){ ?>
               <div class="sorting">
                  <div class="table-body_line">
                     <div class="table__td sales-table__banner">
                        <img src="/upload/banners/<?php echo $allSalesOne['sale_images']; ?>" alt="<?php echo $allSalesOne['sale_images']; ?>">
                     </div>
                     <div class="table__td sales-table__name">
                        <p><?php echo $allSalesOne['sale_name']; ?></p>
                     </div>
                     <div class="table__td sales-table__description">
                        <form class="formSort">
                           <input class="inputSortBaner" type="text" name="sortBaner" value="<?php echo $allSalesOne['sale_position']; ?>" maxlength="1" data-id="<?php echo $allSalesOne['id']; ?>">
                        </form>
                     </div>
                     <div class="table__td sales-table__actions">
                        <div class="button-group">
                           <a href="/admin/salesedit/<?php echo $allSalesOne['id']; ?>" class="btn-edit" title="Редактировать"><img src="/template/images/Stock/edit.svg" alt="Редактировать"></a>
                           <a class="btn-delete deleteBanner" title="Удалить"><img src="/template/images/Stock/delete.svg" alt="удалить"></a>
                        </div>
                     </div>
                  </div>
               </div>
               <?php } ?>
            </div>
         </div>
         <?php } ?>
      </div>
   </div>
</main>

<?php include ROOT . '/views/admin/Index/Footer.php'; ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
   $(function() {
       $( ".sorting" ).sortable();
       $( ".sorting" ).disableSelection();
   });
   
   $('input[name="sortBaner"]').blur(function(){
      
       var sortValue = $(this).closest('.table-body_line').find('input[name="sortBaner"]').val();
       var idsSort = $(this).closest('.table-body_line').find('input[name="sortBaner"]').attr('data-id');
       $.ajax({
              type: 'post',
              url: "/ajax/sortsales", 
              data: { id: idsSort , sort: sortValue },
              dataType: 'TEXT',
       }) 
   });
   
   $('input[name="sortBaner"]').bind("keyup", function() {
           if (this.value.match(/[^0-9]/g)) {
               this.value = this.value.replace(/[^0-9]/g, '');
           }
   });
       
   $('.deleteBanner').click(function(){
      
     var isGood = confirm('Удалить акцию?');
     if(isGood==true){
     var banerIdsDelete = $(this).closest('.table-body_line').find('input[name="sortBaner"]').attr('data-id');
     var imageDeleteIds = $(this).closest('.table-body_line').find('.number-order img').attr('alt');
      $.ajax({
              type: 'post',
              url: "/ajax/salesdel", 
              data: { ids: banerIdsDelete, img: imageDeleteIds },
              dataType: 'TEXT',
              success: function(data){
                  if(data='success'){
                      window.location.replace('/admin/onlysales');
                  }
              }
            
       })  
     }    
   });                            
</script>