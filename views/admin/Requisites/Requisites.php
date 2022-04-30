<?php include ROOT . '/views/admin/Index/Header.php'; ?>
<main class="main-cabinet-user main-cabinet-user-view main-cabinet-admin">
   <div class="container">
      <div class="cabinet-sidebar">
         <div class="btn-close__menu"></div>
         <?php include ROOT . '/views/admin/Index/Sidebar.php'; ?>
      </div>
      <div class="main-cabinet-user__content main-cabinet-admin__content">
         <ul class="breadcrumb breadcrumb-cabinet">
            <li><a href="/" title="Главная"><span>ГЛАВНАЯ</span></a></li>
            <li><a><span>Реквизиты</span></a>
            </li>
         </ul>
         <h1>Наши реквизиты</h1>
         <div class="profile-wrapper w-100">
            <div class="profile-info__box profile-info__box_requisites">
               <ul class="list-characteristics">
                  <li class="list-characteristics__item">
                     <p>ИНН: </p>
                     <span>7703430779</span>
                  </li>
                  <li class="list-characteristics__item">
                     <p>КПП:</p>
                     <span>770301001</span>
                  </li>
                  <li class="list-characteristics__item">
                     <p>ОГРН:</p>
                     <span>51774603025</span>
                  </li>
                  <li class="list-characteristics__item">
                     <p>Р/С:</p>
                     <span>40702810177340017620 <br>
                     В АО Альфа-банк г. Москва</span>
                  </li>
                  <li class="list-characteristics__item">
                     <p>БИК:</p>
                     <span>044525593</span>
                  </li>
                  <li class="list-characteristics__item">
                     <p>ОКПО:</p>
                     <span>19743838</span>
                  </li>
                  <li class="list-characteristics__item">
                     <p>Телефон:</p>
                     <span>8 (495) 308-00-69</span>
                  </li>
                  <li class="list-characteristics__item">
                     <p>Генеральный директор:</p>
                     <span>Павлов Анатолий Владимирович <br>
                     действующий на основании Устава</span>
                  </li>
               </ul>
            </div>
         </div>
         <div class="main-cabinet-user-view__title">Отправить реквизиты</div>
         <form method="post" class="form-requisites">
            <label>
            <span class="form-group__title">По СМС</span>
            <input type="text" id="online_phone" placeholder="+7 (___) ___ - __ - __" name="sms">
            </label>
            <button type="submit" class="btn btn_black send_prop">Отправить</button>
         </form>
         <form method="post" class="form-requisites">
            <label>
            <span class="form-group__title">По E-mail</span>
            <input type="text" placeholder="Имейл для отправки" name="email">
            </label>
            <button type="submit" class="btn btn_black send_prop_email">Отправить</button>
         </form>
      </div>
   </div>
</main>

<?php include ROOT . '/views/admin/Index/Footer.php'; ?>
<script>
   $('.send_prop').click(function(event) {
       
       event.preventDefault();
       var sendPropPhone = $('#online_phone').val();
           $.ajax({
                  type: 'post',
                  url: "/ajax/sendproperty", 
                  data: { phone: sendPropPhone },
                  dataType: 'TEXT',
                   success: function(data) {
                      if(data=='success'){
                          $('.form-group__title').html('СМС с реквизитами отправлено!');
                          $('.form-group__title').css('color', 'red');
                          setTimeout(function() {window.location.reload();}, 2000);
                      }
                   } 
           })   
   });
   
   
   $('.send_prop_email').click(function(event) {
       event.preventDefault();
       var sendPropEmail = $('input[name="email"]').val();
           $.ajax({
                  type: 'post',
                  url: "/ajax/sendproperty", 
                  data: { email: sendPropEmail },
                  dataType: 'TEXT',
                   success: function(data) {
                      if(data=='success'){
                         $('.form-group__title').html('Письмо с реквизитами отправлено!');
                         $('.form-group__title').css('color', 'red');
                         setTimeout(function() {window.location.reload();}, 2000);
                      }
                   }
           }) 
   });
   
</script>
<script>
    $('[name=sms]').mask('+7 (999) 999-99-99');
    
    $("[name=sms]").click(function(){
      $(this).setCursorPosition(4);
    }).mask("+7 (999) 999-99-99", {autoclear: false});
    $('[name=sms ]').mask("+7 (999) 999-99-99", {autoclear: false});

</script>