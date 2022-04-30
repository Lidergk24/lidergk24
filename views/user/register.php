<?php include ROOT . '/views/layouts/header.php'; ?>
<section class="registration">
   <div class="breadcrumb-wrapper">
      <div class="container">
         <ul class="breadcrumb">
            <li><a href="/" title="Главная"><span>ГЛАВНАЯ</span></a></li>
            <li><a title="Регистрация"><span>регистрация</span></a></li>
         </ul>
      </div>
   </div>
   <div class="container">
      <div class="registration__content">
         <form method="post" class="form-registration notification">
            <h1>Регистрация</h1>
            <div class="form-notification">
               <p>Номер зарегистрирован</p>
               <a href="/user/login" class="links" title="Авторизация">авторизация</a>
            </div>
            <div class="form-notification-sms">
               <p>Неверный код смс</p>
               <a class="links sensSMS">Выслать код повторно</a>
            </div>
            <label>
            <input type="text" name="phone" id="phone" placeholder="+7 (9" pattern="/^(\+7|8)(\(\d{3}\)|\d{3})\d{7}$/" autocomplete="off" inputmode="none" required>
            </label>
            <label>
            <input type="text" name="sms_varify_form" placeholder="· · · · ·" inputmode="numeric" id="sms_kod" autocomplete="off" maxlength="4" required>
            <span class="description-input">Введите Ваш номер телефона</span>
            </label>
            <button type="submit" name="submit" id="submit_register" class="btn btn_red">Регистрация</button>
         </form>
         <div class="form-links">
            Если Вы уже зарегистрированы, пройдите <a href="/user/login" title="Авторизация">авторизацию</a>
         </div>
      </div>
   </div>
</section>
<?php include ROOT . '/views/layouts/footer.php'; ?>
<script>
$(document).ready(function(){
    //$('input[name="phone"]').focus();
    $('#phone').trigger('keyup');
});
$("#sms_kod, #submit_register, .form-notification, .form-notification-sms").hide();
//$('#phone').focus();

$('#phone').on('keyup', function() {
    $('.description-input').html('Введите код из смс');
	var valueInput = $('#phone').val();
	var valueInputVes =  - valueInput.replace(/\d/gm, '').length;

    if(valueInput.length === 1 && valueInput != '+7 (9') {
        console.log(valueInput.length + ' = ' + valueInput);
        $('#phone').val('+7 (9' + $('#phone').val());
        if(valueInput != 9) return;
    }
    else if(valueInput.length === 0) {
        $('#phone').val('+7 (9');
    }
    else if(valueInput.length === 7) {
        $('#phone').val($('#phone').val() + ') ');
    }
    else if(valueInput.length === 12 || valueInput.length === 15) {
        $('#phone').val($('#phone').val() + '-');
    }
	if (valueInput.length >= 18) {

		$.ajax({
			type: 'POST',
			url: '/views/user/phone.php',
			dataType: 'TEXT',
			data: {
				tel: valueInput
			},
			success: function(data) {

				if (JSON.parse(data).status == 'error') {

					$('.form-notification').slideDown(500);
					$("#sms_kod").slideUp(500);
					$("#submit_register").slideUp(600);

				} else {

					$("#sms_kod").slideDown(500);
					$("#submit_register").slideDown(600);
					$('.form-notification').slideUp(500);
					setTimeout(function() {
						$('input[name="sms_varify_form"]').focus();
					}, 1000);

					$('#sms_kod').on('keyup', function() {

						if (this.value.match(/[^0-9]/g)) {
							this.value = this.value.replace(/[^0-9]/g, '');
						}

						var sms = $('#sms_kod').val();

						if (sms.length >= 4) {

							$.ajax({
								type: 'POST',
								url: '/views/user/phone.php',
								dataType: 'TEXT',
								data: {
									smsCode: sms,
									transPhone: valueInput
								},
								success: function(data) {

									if (JSON.parse(data).status == 'smsOk') {

										$('.form-registration button[name="submit"]').click();

									} 
									
									if (JSON.parse(data).status == 'smsError') {
										$('.form-notification-sms').slideDown(500);

									}
									
									$('.sensSMS').click(function(){
									    $('#sms_kod').val('');
									    $('input[name="sms_varify_form"]').focus();
									    
									    $.ajax({
                                			type: 'POST',
                                			url: '/views/user/phone.php',
                                			dataType: 'TEXT',
                                			data: {
                                				tel: valueInput
                                			},
									    });
									});
								}
							});
						}
					});
				}
			}
		});
	}
});
</script>