<?php include ROOT . '/views/cabinet/Index/Header.php'; ?>
<main class="main-cabinet-user main-cabinet-editing">
   <div class="container">
      <div class="cabinet-sidebar">
         <div class="btn-close__menu"></div>
         <?php include ROOT . '/views/cabinet/Index/CabinetMenu.php'; ?>
         <?php include ROOT . '/views/cabinet/Index/CabinetMenuSideBar.php'; ?>
      </div>
      <div class="main-cabinet-user__content">
         <ul class="breadcrumb breadcrumb-cabinet">
            <li><a href="/cabinet" title="Главная"><span>ГЛАВНАЯ</span></a></li>
            <li><a><span>Реквизиты</span></a></li>
         </ul>
         <h1>Мои реквизиты</h1>
         <div class="payment-profiles w-100">
            <div class="payment-profiles__box w-100">
             <?php if(!empty($getUserByProfileUr)){ ?>    
                <?php foreach ($getUserByProfileUr as $userProfileIndexUr) { ?>
               <div class="payment-profiles__line">
                  <div class="payment-profiles__text"><?php echo $userProfileIndexUr['ur_profile']; ?></div>
                  <div class="button-group">
                     <a href="/cabinet/urprofile/<?php echo $userProfileIndexUr['id']; ?>" class="btn-edit" title="Редактировать"><img src="/template/images/Stock/edit.svg" alt="Редактировать"></a>
                     <a href="/cabinet/delete/<?php echo $userProfileIndexUr['id']; ?>" class="btn-delete" title="Удалить"><img src="/template/images/Stock/delete.svg" alt="Удалить"></a>
                  </div>
               </div>
            </div>
            <?php } ?>
            
            <?php } ?>
         </div>
         <div class="button__group main-cabinet-button__group">
            <a href="/cabinet/addur" class="btn btn_cabinet_add" title="Реквизиты компаний">
               Добавить реквизиты компании
            </a>
         </div>
      </div>
   </div>
</main>
<?php include ROOT . '/views/cabinet/Index/Footer.php'; ?>
<script>
$('[name=tel]').mask('+7 (999) 999-99-99');

$("[name=tel]").click(function(){
  $(this).setCursorPosition(4);
}).mask("+7 (999) 999-99-99", {autoclear: false});
$('[name=phone]').mask("+7 (999) 999-99-99", {autoclear: false});
</script>