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
            <li><a href="/admin/coupon" title="купоны"><span>купоны</span></a></li>
            <li><a title="Добавить купон"><span>Добавить купон</span></a></li>
         </ul>
         <h1>Добавить купон</h1>
         <?php
           if(isset($error)){ ?>
           <p style="color:red;"><?php echo $error; ?></p>  
         <?php } ?>
         <form method="post" class="form-coupons form-admin-cabinet">
            <label>
            <span class="form-group__title">Название купона</span>
            <input type="text" name="couponName" required>
            <span class="generate">Сгенерировать</span>
            </label>
            <label>
            <span class="form-group__title">Скидка, %</span>
            <input type="text" maxlength="3" name="couponProcent" required>
            </label>
            <label>
            <span class="form-group__title">От какой суммы можно применить</span>
            <input type="text" name="couponSumm" required>
            </label>
            <label>
            <span class="form-group__title">Сколько активаций (0 - без ограничений)</span>
            <input type="text" name="couponActivate" required>
            </label>
            <label class="w-100">
            <span class="form-group__title">Для пользователя (по номеру телефона)</span>
            <input type="text" name="couponUser" id="online_phone" placeholder="+7 (___) ___ - __ - __" autocomplete="off">
            </label>
            <button type="submit" name="submit" class="btn btn_black">Добавить купон</button>
         </form>
      </div>
   </div>
</main>

<?php include ROOT . '/views/admin/Index/Footer.php'; ?>
<script>

    $('[name=couponUser]').mask('+7 (999) 999-99-99');
    
    $("[name=couponUser]").click(function(){
        
      $(this).setCursorPosition(4);
      
    }).mask("+7 (999) 999-99-99", {autoclear: false});
    
    $('[name=phone]').mask("+7 (999) 999-99-99", {autoclear: false});

$('.generate').click(function(){
    
        $.ajax({
         
            type: 'post',
            url: "/views/admin/Coupons/generate.php", 
            dataType: 'TEXT',
            
                success: function(data) {

                        $("[name=couponName]").val($.trim(data)); 
                    }
                }) 
     
        });
</script>
