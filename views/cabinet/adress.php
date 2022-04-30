<?php include ROOT . '/views/cabinet/Index/Header.php'; ?>
<main class="main-cabinet-user main-cabinet-user-contacts">
   <div class="container">
      <div class="cabinet-sidebar">
         <div class="btn-close__menu"></div>
         <?php include ROOT . '/views/cabinet/Index/CabinetMenu.php'; ?>
         <?php include ROOT . '/views/cabinet/Index/CabinetMenuSideBar.php'; ?>
      </div>
      <div class="main-cabinet-user__content">
         <ul class="breadcrumb breadcrumb-cabinet">
            <li><a href="/cabinet" title="Кабинет"><span>ГЛАВНАЯ</span></a></li>
            <li><a><span>адреса доставки</span></a></li>
         </ul>
         <h1>Адреса доставки</h1>
                  <div class="personal_manager_block">
                  <!--?php $firstAdress = explode(',', $user["user_adress"]);
                  if (isset($firstAdress)) { ?>
                     <div class="manager-information__content main-cabinet-user__wrap-inner">
                           <div class="form-group__title main-address">Основной адрес</div>
                           <div class="form-group__title">Город</div>
                           <div class=" list-info__item">
                              <p class="list-info__text"><!--?=$firstAdress[0]; ?></p>
                           </div>
                           
                           <div class="form-group__title">Улица</div>
                           <div class=" list-info__item">
                              <p class="list-info__text"><!--?=$firstAdress[1]; ?></p>
                           </div>
                           <div class="form-group__title">Дом</div>
                           <div class=" list-info__item">
                              <p class="list-info__text"><!--?=$firstAdress[2]; ?></p>
                           </div>
                           <div class="form-group__title">Корпус</div>
                           <div class=" list-info__item">
                              <p class="list-info__text"><!--?=$firstAdress[3]; ?></p>
                           </div>
                           <div class="form-group__title">Квартира / офис</div>
                           <div class=" list-info__item">
                              <p class="list-info__text"><!--?=$firstAdress[4]; ?></p>
                           </div>
                     </div>
                     <!--?php } ?-->
                     <?php if(count($allAdressFromUser) == 0)  echo "Адреса доставки еще не добавлены"; ?>
                     <?php foreach ($allAdressFromUser as $ind => $allAdressFromUserOne) { ?>
                        <div class="manager-information__content main-cabinet-user__wrap-inner">
                            <label>Адрес № <?=$ind+1?></label><br />
                            <hr />
                        <div class="form-group__title basket__table_delete">
                              <a href="/cabinet/adressdel/<?php echo $allAdressFromUserOne['id']; ?>" class="btn-delete" title="Удалить"><img src="/template/images/Stock/delete.svg" alt="Удалить"></a>
                           </div>
                           <br>
                           <div class="form-group__title">Город</div>
                           <div class="list-info__item">
                              <p class="list-info__text"><?php echo $allAdressFromUserOne['city']; ?></p>
                           </div>
                           <div class="form-group__title">Улица</div>
                           <div class=" list-info__item">
                              <p class="list-info__text"><?php echo $allAdressFromUserOne['street']; ?></p>
                           </div>
                           <div class="form-group__title">Дом</div>
                           <div class=" list-info__item">
                              <p class="list-info__text"><?php echo $allAdressFromUserOne['house']; ?></p>
                           </div>
                           <div class="form-group__title">Корпус</div>
                           <div class=" list-info__item">
                              <p class="list-info__text"><?php echo $allAdressFromUserOne['korpus']; ?></p>
                           </div>
                           <div class="form-group__title">Квартира / офис</div>
                           <div class=" list-info__item">
                              <p class="list-info__text"><?php echo $allAdressFromUserOne['office']; ?></p>
                           </div>
                        </div>
                     <?php } ?>

               </div>
               <a href="/cabinet/newadd" class="btn btn_black btn-add__address btn_cabinet_add">
               Добавить адрес
            </a>
      </div>
</main>
<?php include ROOT . '/views/cabinet/Index/Footer.php'; ?>