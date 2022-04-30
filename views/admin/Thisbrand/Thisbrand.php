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
            <li><a title="Бренды"><span>Бренды</span></a></li>
         </ul>
         <form method="post" class="form-add-file form-admin-cabinet form-add-manager" action="renewBrandsMainPage">
            <div class="form-group">
               <label>
               <span class="form-group__title toggleClick">Бренды для главной страницы ⇣</span>
                 <div class="toggleThis" style='display:none'>
                 <?php  
                   for($i = 0; $i<24; $i++) {?>
                      <input type="text" name="id['<?php echo $i ?>']" value="<?php echo $selectedBrands[$i]['id']; ?>" required>           
                <?php } ?>
                <button class="btn btn_black " name="submit" type="submit">Обновить бренды для главной страницы</button>
                   </div>
              
               </label>
            </div>
         </form>
         <h1>Бренды товаров</h1>
         <div class="rulers-table__admin coupons-table_admin table w-100">
            <div class="table__head">
               <div class="table__th rulers-table__code">Название бренда</div>
               <div class="table__th rulers-table__name">Описание бренда</div>
               <div class="table__th rulers-table__condition">Лого</div>
               <div class="table__th rulers-table__quantity">Редкатировать описание</div>
               <div class="table__th rulers-table__sale">Удалить</div>
            </div>
            <div class="table__body">
               <?php foreach ( $thisBrand as $thisBrandOne ): ?>
               <div class="table-body_line">
                  <div class="table__td rulers-table__code">
                     <p><?php echo $thisBrandOne['brand_name'];?>
                     <br><br><br><br>
                     <div>КОД = <?php echo $thisBrandOne['id'];?></div>
                  </p>
                  </div>
                  <div class="table__td rulers-table__name">
                     <p><?php echo $thisBrandOne['brand_description']; ?></a></p>
                  </div>
                  <div class="table__td rulers-table__condition">
                      <?php if($thisBrandOne['brand_logo'] =='') { ?>
                      <p style="font-size: 26px;color: red;">&#9746;</p>
                      <?php } else { ?>
                     <p style="font-size: 26px;color: green;">&#9745;</p>
                     <?php } ?>
                  </div>
                  <div class="table__td rulers-table__quantity">
                     <a href="/admin/editbrand/<?php echo $thisBrandOne['id']; ?>" class="btn-edit" title="Редактировать">
                        <img src="/template/images/Stock/edit.svg">
                        </a>
                  </div>
                  <div class="table__td rulers-table__sale">
                     <a class="btn-delete" title="Удалить" data-id="<?php echo $thisBrandOne['id']; ?>"><img src="/template/images/Stock/delete.svg" alt="Удалить"></a>
                  </div>
              
               </div>
               <?php endforeach; ?>
            </div>
         </div>
      </div>
   </div>
</main>

<?php include ROOT . '/views/admin/Index/Footer.php'; ?>

<script>
   $('.toggleClick').click(() => {
    $('.toggleThis').slideToggle();
});

    $('.btn-delete').on('click', function(){
       
       var ids = $(this).attr('data-id');
       
       var isGood= confirm('Удалить бренд?');
       
        if (isGood==true) {
           
           $.ajax({
                   type: 'post',
                   url: "/admin/deletebrand", 
                   data: { id: ids },
                   dataType: 'TEXT',
                   success: function(data){
                       
                       if (data = 'success' ) {
                           
                           window.location.replace('/admin/thisbrand');
                           
                       }
                   }
            }) 
        
        }
      
    });
    
</script>