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
            <li><a href="/admin/clients" title="Клиенты"><span>клиенты</span></a></li>
            <li><a><span>Профили</span></a></li>
         </ul>
         <h1>Профили пользователя</h1>
         <?php if($getByProfilesIdsFiz->num_rows>0){ ?>
         <div class="main-cabinet-user-view__title">Профили физических лиц</div>
         <div class="info-orders__table_admin table-profile__admin table w-100">
            <div class="table__head">
               <div class="table__th info-orders__table_name">ФИО</div>
               <div class="table__th info-orders__table_phone">Телефон</div>
               <div class="table__th info-orders__table_mail">E-mail</div>
               <div class="table__th info-orders__table_address">Адрес</div>
            </div>
            <div class="table__body">
                <?php foreach($getByProfilesIdsFiz as $allClientsOne){ ?>
               <div class="table-body_line">
                  <div class="table__td info-orders__table_name">
                     <p><?php echo $allClientsOne['fiz_fio']; ?></p>
                  </div>
                  <div class="table__td info-orders__table_phone">
                     <p><?php echo $allClientsOne['fiz_phone']; ?></p>
                  </div>
                  <div class="table__td info-orders__table_mail">
                     <p><?php echo $allClientsOne['fiz_email']; ?></p>
                  </div>
                  <div class="table__td info-orders__table_address">
                     <p><?php echo $allClientsOne['fiz_adress']; ?></p>
                  </div>
               </div>
               <?php } ?>
            </div>
         </div>
         <?php } else { ?>
          <div class="attention-profile">
            <div class="attention-profile__icon"><img src="/template/images/Stock/warning.svg" alt=""></div>
            <div class="attention-profile__text">Профили физических лиц не найдены</div>
         </div>
         <?php } ?>
         <?php if($getByProfilesIdsUr->num_rows>0){ ?>
         <div class="main-cabinet-user-view__title">Профили юридическх лиц</div>
         <div class="info-orders__table_admin table-profile__admin table w-100">
                        <div class="table__head">
                            <div class="table__th info-orders__table_name">Наименование</div>
                            <div class="table__th info-orders__table_phone">Телефон</div>
                            <div class="table__th info-orders__table_mail">E-mail</div>
                            <div class="table__th info-orders__table_address">Адрес</div>
                        </div>
                        <div class="table__body">
                            <?php foreach ($getByProfilesIdsUr as $allClientsOneUr){ ?>
                            <div class="table-body_line">
                                <div class="table__td info-orders__table_name">
                                    <p><?php echo $allClientsOneUr['ur_profile']; ?></p>
                                </div>
                                <div class="table__td info-orders__table_phone">
                                    <p><?php echo $allClientsOneUr['ur_phone']; ?></p>
                                </div>
                                <div class="table__td info-orders__table_mail">
                                    <p><?php echo $allClientsOneUr['ur_email']; ?></p>
                                </div>
                                <div class="table__td info-orders__table_address">
                                    <p><?php echo $allClientsOneUr['ur_adress']; ?></p>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
        <?php } else { ?>
         <div class="attention-profile">
            <div class="attention-profile__icon"><img src="/template/images/Stock/warning.svg" alt="Профили юридических лиц"></div>
            <div class="attention-profile__text">Профили юридических лиц не найдены</div>
         </div>
         <?php } ?>
      </div>
   </div>
</main>

<?php include ROOT . '/views/admin/Index/Footer.php'; ?>