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
            <li><a title="Брошенные корзины"><span>Брошенные корзины</span></a></li>
         </ul>
         <h1>Брошенные корзины</h1>
         <div class="rulers-table__admin coupons-table_admin table w-100">
            <div class="table__head">
               <div class="table__th rulers-table__code">Дата</div>
               <div class="table__th rulers-table__name">Клиент</div>
               <div class="table__th rulers-table__condition">Количество товаров</div>
               <div class="table__th rulers-table__quantity">Статус</div>
            </div>
            <div class="table__body">
     
                <?php
                  
                  $u = mysqli_query($con, "SELECT distinct (user_id), dateDrop FROM ProductDropOrder order by dateDrop DESC");
     
                  foreach ( $u as $uOne ) { ?>
                  
                    <div class="table-body_line">
                        
                        <?php
                         
                         $us = mysqli_query($con, "select * from user where id='".$uOne["user_id"]."'");
                         
                         $ur = mysqli_query($con, "select * from ProductDropOrder where user_id='".$uOne["user_id"]."'");
                         
                         $dd = mysqli_fetch_assoc($us);
                         $zz = mysqli_fetch_assoc($ur);
                         
                         $as = array_merge($zz, array_filter($dd));
                         
                         ?>
                            
                        <div class="table__td rulers-table__code">
                            <p><?php echo $uOne["dateDrop"]; ?></p>
                        </div>
                         
                        <div class="table__td rulers-table__name">
                            <p class="dropUser" data-user="<?php echo $uOne["user_id"]; ?>" style="color: green;font-weight: 600; cursor:pointer;"><?php echo $dd['phone']; ?></p>
                        </div>
                         
                        <?php 
                        
                        $items = mysqli_query($con, "select idProduct from ProductDropOrder where user_id='".$uOne["user_id"]."'");
                         
                        ?>
                        
                        <div class="table__td rulers-table__condition">
                            <p><?php echo $items->num_rows; ?></p>
                        </div>
                        <div class="table__td rulers-table__quantity">
                            <p style="color:red;">Брошен</p>
                        </div>
                     
                  </div> 
                
                <?php } ?>
    
            </div>
         </div>
      </div>
   </div>
</main>
<div class="popup-fade">
	<div class="popup">
        <div class="popup-wrapper">
            <a class="popup-close" href="#">Закрыть</a>
            <p></p>
        </div>
	</div>		
</div>
 

<?php include ROOT . '/views/admin/Index/Footer.php'; ?>

<script>
    
    $(".dropUser").on("click", function() {
        
        var a = $(this).attr("data-user"); 
         
    	$.ajax({
             type: "POST",
             url: "/components/ajaxRequest/dropOrder.php",
             data: {drop: a},
             dataType: 'html',
             success: function (data) {
                 
               $('.popup-fade').fadeIn();
        
    	 // return false; 
                 
                $('.popup p').html(data);
                
                 
             }
         });
    	
    });
    
    $('.popup-close').click(function() {
        
		$(this).parents('.popup-fade').fadeOut();
		
		return false;
		
	});		
 
	$(document).keydown(function(e) {
	    
		if (e.keyCode === 27) {
		    
			e.stopPropagation();
			
			$('.popup-fade').fadeOut();
			
		}
	});
	
	$('.popup-fade').click(function(e) {
	    
		if ($(e.target).closest('.popup').length == 0) {
		    
			$(this).fadeOut();	
			
		}
	});
    
</script>