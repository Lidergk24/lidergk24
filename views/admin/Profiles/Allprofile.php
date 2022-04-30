<?php include ROOT . '/views/admin/Index/Header.php'; ?>
        <main class="main-cabinet-user main-cabinet-user-view main-cabinet-admin">
            <div class="container">
                <div class="cabinet-sidebar">
                    <div class="btn-close__menu"></div>
                    <?php include ROOT . '/views/admin/Index/Sidebar.php'; ?>
                </div>
                <div class="main-cabinet-user__content main-cabinet-admin__content">
                    <ul class="breadcrumb breadcrumb-cabinet">
                        <li>
                            <a href="/admin">
                                <span>ГЛАВНАЯ</span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span>платежные профили</span>
                            </a>
                        </li>
                    </ul>
                    <h1>Платежные профили</h1>
                    <!--a style="margin-bottom:10px;width: 49%;display: inline-block;" href="/admin/nprofile" class="btn btn_black" title="Добавить профиль">Добавить профиль</a-->
                    <a style="margin-bottom:10px;width: 49%;display: inline-block;" href="/admin/rephone" class="btn btn_black" title="Заменить телефон">Заменить номер профиля</a>
                   <label>
                        <input class="search_frofile" type="text" placeholder="Поиск по профилям" name="search_frofile" maxlength="40" autocomplete="off">
                    </label>
                    
                    <div class="info-orders__table_admin table-profile__admin table-profile__admin-pay table w-100">
                        <div class="table__head">
                            <div class="table__th info-orders__table_profile">Профиль</div>
                            <div class="table__th info-orders__table_requisites">Реквизиты</div>
                            <div class="table__th info-orders__table_full-name">ФИО</div>
                            <div class="table__th info-orders__table_address-pay">Адрес</div>
                            <div class="table__th info-orders__table_contacts">Контакты</div>
                        </div>
                     
                        <div class="table__body">
                            <?php foreach ($allProfileUr as $allProfilesMixOne): ?>
                            <div class="table-body_line">
                                <div class="table__td info-orders__table_profile">
                                    <a class="color_blue" title="<?php echo $allProfilesMixOne['ur_profile']; ?>" href="/admin/ordprof/<?php echo $allProfilesMixOne['fiz_phone']; echo $allProfilesMixOne['ur_phone']; ?>"><?php echo $allProfilesMixOne['fiz_fio']; ?><?php echo $allProfilesMixOne['ur_profile']; ?></a>
                                </div>
                                <div class="table__td info-orders__table_requisites">
                                    <p><?php if(isset($allProfilesMixOne['ur_inn'])){ echo 'ИНН: '.$allProfilesMixOne['ur_inn']; } ?></p>
                                   <p><?php if(isset($allProfilesMixOne['ur_company'])){ echo 'Организация: '.$allProfilesMixOne['ur_company']; } ?></p>
                                   <p><?php if(isset($allProfilesMixOne['ur_kpp'])){ echo 'КПП: '.$allProfilesMixOne['ur_kpp']; } ?></p>
                                   <p><?php if(isset($allProfilesMixOne['ur_bik'])){ echo 'БИК: '.$allProfilesMixOne['ur_bik']; } ?></p>
                                   <p><?php if(isset($allProfilesMixOne['ur_rs'])){ echo 'Р/С: '.$allProfilesMixOne['ur_rs']; } ?></p>
                                   <p><?php echo $allProfilesMixOne['fiz_email']; ?></p>
                                </div>
                                <div class="table__td info-orders__table_full-name">
                                    <p><?php echo $allProfilesMixOne['ur_contact']; ?></p>
                        <p><?php echo $allProfilesMixOne['fiz_email']; ?></p>
                                </div>
                                <div class="table__td info-orders__table_address-pay">
                                   <p><?php echo $allProfilesMixOne['ur_adress']; ?></p>
                        <p><?php echo $allProfilesMixOne['fiz_adress']; ?></p>
                                </div>
                                <div class="table__td info-orders__table_contacts">
                                    <p><?php echo $allProfilesMixOne['ur_email']; ?></p>
                        <p><?php echo $allProfilesMixOne['ur_phone']; ?></p>
                                </div>
                            </div>
                             <?php  endforeach; ?>
                        </div>
                    </div>

                </div>
            </div>
        </main>

<?php include ROOT . '/views/admin/Index/Footer.php'; ?>
<script>
    $('.search_frofile').keyup(function() {
       
       var searchProfile = $('input[name="search_frofile"]').val();
        
       if (searchProfile.length > 2) {
             
            $.ajax({
                   type: 'post',
                   url: "/components/ajaxRequest/allProfile.php", 
                   data: {search: searchProfile },
                   dataType: 'TEXT',
                    success: function(data) {
                         //alert(data);
                        $(".table__body").html(data); 
                       // console.log(data);
       
                    }
            })
        } 
    });
</script>