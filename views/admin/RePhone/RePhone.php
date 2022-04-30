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
            <li><a href="/admin/allprofile" title="купоны"><span>Замена номера</span></a></li>
         </ul>
         <h1>Замена номера контрагента</h1>
         <p class="rephone">Внимание! В случае изменения номера контрагента (например при смене руководства или закупщика/менеджера). необходимо сменить номер телефона!</p>
         <p class="rephone">В первой колонке вводим номер старый, во второй на который поменять.</p>
         <p class="rephone">Внимание! В случае смены номера все данные для входа станут доступными по новому номеру, все ранее созданные заказы, адреса, профили, спеццены и ранее купленные товары остаются такими же, как и были до смены номера.</p>
         <p class="rephone">Предыдущий владелец номера уже не сможет войти в аккаунт. Делать такие процедуры нужно осознано, когда уверены на 100%, что будет новый номер.</p>
         <p class="rephone">Стоит защита от копирования. Вводить номера только руками, проверив их 2 раза.</p>
         <form method="post" class="form-coupons form-admin-cabinet repP">
            <label>
            <span class="form-group__title">Старый номер</span>
            <input type="text" name="oldPhone" placeholder="+7 (___) ___ - __ - __" autocomplete="off" required>
            </label>
            <label>
            <span class="form-group__title">Новый номер</span>
            <input type="text" name="newPhone" placeholder="+7 (___) ___ - __ - __" autocomplete="off" required>
            </label>
            <button type="submit" name="sendPhone" class="btn btn_black">Обновить номер</button>
         </form>
      </div>
   </div>
</main>
<?php include ROOT . '/views/admin/Index/Footer.php'; ?>

<script>


    $('[name=newPhone], [name=oldPhone]').mask('+7 (999) 999-99-99');
    $("[name=newPhone], [name=oldPhone]").click(function(){
      $(this).setCursorPosition(4);
    }).mask("+7 (999) 999-99-99", {autoclear: false});
    $('[name=newPhone], [name=oldPhone]').mask("+7 (999) 999-99-99", {autoclear: false});

    $(document).ready(function() {
    $("[name=newPhone], [name=oldPhone]").bind('copy', function() { return false;});
    $("[name=newPhone], [name=oldPhone]").bind('paste', function() { alert('Вставлять запрещено! Делаем ручками! А то буду ругаться матом! А вы знаете - я умею :)'); return false;});
    $("[name=newPhone], [name=oldPhone]").bind('cut', function() { return false;});
    });
    
    $('[name=sendPhone]').click(function(e){
        
        e.preventDefault();
        var newPhone = $('[name=newPhone]').val();
        var oldPhone = $('[name=oldPhone]').val();
        
        $.ajax({
            
             type: "POST",
             url: "/components/ajaxRequest/rePhone.php",
             data: { nPhone: newPhone, oPhone: oldPhone},
             
             success: function (data) {
                 
                 if ( data=='yes' ) {
                     
                    alert('Номер изменен!');
                    
                    setTimeout(function(){
                        
                        location.reload();
                        
                    }, 1500);
                     
                 }
             }
         });
         
    });
    
</script>