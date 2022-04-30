<?php include ROOT . '/views/layouts/header.php'; ?>
        <section class="registration">
            <div class="breadcrumb-wrapper">
                <div class="container">
                    <ul class="breadcrumb">
                        <li><a href="/" title="Главная"><span>ГЛАВНАЯ</span></a></li>
                        <li><a title="Авторизация"><span>авторизация</span></a></li>
                    </ul>
                </div>
            </div>
            <div class="container">
                <div class="registration__content">
                    <form method="post" class="form-registration notification">
                        <h1>Введите номер телефона для начала работы</h1>
                        <div class="form-notification">
                            <p>Номер не зарегистрирован</p>
                            <a href="/user/register" class="links" title="Регистрация">Регистрация</a>
                        </div>
                        <div class="form-notification-sms">
                           <p>Неверный код смс</p>
                           <a class="links sensSMS">Выслать код повторно</a>
                        </div>
                        <label>
                            <input type="text" name="phone" id="phone" maxlength="18" placeholder="+7 (" inputmode="text" type="tel" autocomplete="off" required>
                        </label>
                        <label>
                            <input type="text" id="sms_kod" name="sms_varify_form" inputmode="numeric" is="one-time-code" maxlength="4" placeholder="* * * *" autocomplete="off" required>
                            <span class="description-input" style="font-weight: 700; color:#000000">Введите пароль из смс</span>
                        </label>
						<div class="form-login-red"> 
							после успешного ввода пароля вы автоматически будете перенаправлены на главную страницу сайта
						</div>
                        <button type="submit" style="opacity:0" id="submit_register" name="submit" class="btn btn_red">Войти в систему</button>
                    </form>
                </div>
            </div>
        </section>
 <?php include ROOT . '/views/layouts/footer.php'; ?>
 <script>
$(document).ready(function(){
    $('input[name="phone"]').focus();
    
    $('#phone').trigger('keyup');

    $("#sms_kod, #submit_register, .form-notification, .form-notification-sms, .description-input").hide();
    $('#phone').on('keyup', function() {
    	var valueInput = $('#phone').val();
    	var valueInputVes = valueInput.length - valueInput.replace(/\d/gm, '').length;
    	
    	if(valueInput.length === 1 && valueInput != '+7 (') {
            if($('#phone').val()==9) {
                $('#phone').val('+7 (' + $('#phone').val());
            } else {
                $('#phone').val().substring(0, str.length - 1)
            }
            //if(valueInput != 9) return;
        }
        else if(valueInput.length === 5 && valueInput != '+7 (') {
            console.log(valueInput.length + ' = ' + valueInput);
            if($('#phone').val()=='+7 (9') {
                $('#phone').val($('#phone').val());
            } else {
                $('#phone').val('+7 (')
            }
            //if(valueInput != 9) return;
        }
        else if(valueInput.length === 0) {
            $('#phone').val('+7 (');
        }
        else if(valueInput.length === 7) {
            $('#phone').val($('#phone').val() + ') ');
        }
        else if(valueInput.length === 12 || valueInput.length === 15) {
            $('#phone').val($('#phone').val() + '-');
        }
    	else if (valueInput.length >= 18) {
    	    let template = [];
    		let random = Math.floor(Math.random() * 1000);
    		$.ajax({
    			type: 'POST',
    			url: '/views/user/auth.php?x=' +random,
    			dataType: 'TEXT',
    			data: {
    				tel: valueInput
    			},
    			success: function(data) {
    				if (JSON.parse(data).status == 'error') {
    					$('.form-notification').slideDown(500);
    					$("#sms_kod, .description-input").slideUp(500);
    					$("#submit_register").slideUp(600);
    				} else {
    					$("#sms_kod").slideDown(500);
    					$("#submit_register, .description-input").slideDown(600);
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
    								url: '/views/user/auth.php',
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
                                    			url: '/views/user/auth.php',
                                    			dataType: 'TEXT',
                                    			data: {
                                    				tel: valueInput
                                    			},
                                    			success: function(data) {
                									if (JSON.parse(data).status == 'smsOk') {
                										$('.form-registration button[name="submit"]').click();
                									} 	
                									if (JSON.parse(data).status == 'smsError') {
                										$('.form-notification-sms').slideDown(500);
                									}
                                    			}
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
    	else {
    	    console.log(/\s+/.test($('#phone').val().slice(0, -2)));
    	    if(/\d/.test($('#phone').val().slice(-1)) === false) {
    	        $('#phone').val($('#phone').val().slice(0, -1));
    	    }
    	}
    });
});
 </script>