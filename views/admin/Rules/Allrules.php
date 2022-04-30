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
            <li><a title="Правила"><span>правила корзины</span></a></li>
         </ul>
         <h1>Правила корзины</h1>
         <div class="main-cabinet-button__group">
            <a href="/admin/rules" class="btn btn_black" title="Создать правило">
               <span class="icon-plus">
                  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                     <g>
                        <g>
                           <path d="M492,236H276V20c0-11.046-8.954-20-20-20c-11.046,0-20,8.954-20,20v216H20c-11.046,0-20,8.954-20,20s8.954,20,20,20h216
                              v216c0,11.046,8.954,20,20,20s20-8.954,20-20V276h216c11.046,0,20-8.954,20-20C512,244.954,503.046,236,492,236z" />
                        </g>
                     </g>
                  </svg>
               </span>
               Создать правило
            </a>
         </div>
         <div class="rulers-table__admin coupons-table_admin table w-100">
            <div>Группы товаров по акциям </div>
            <div class="table__head">
               <div class="table__th rulers-table__code"> Группа </div>
               <div class="table__th rulers-table__code"> Подгруппа </div>
               <div class="table__th rulers-table__code">Код товара</div>
               <div class="table__th rulers-table__condition">Условие</div>
               <div class="table__th rulers-table__quantity">Количество</div>
               <div class="table__th rulers-table__sale">Скидка</div>
               <div class="table__th rulers-table__delete">Действие</div>
            </div>
            <div class="table__body">
               <?php foreach ($discountedGroups as $discountGroup) { ?>
                  <div class="table-body_line">
                     <div class="table__td rulers-table__code">
                        <p><?php echo  $discountGroup['discount_group']; ?></p>
                     </div>
                     <div class="table__td rulers-table__code">
                        <p><?php echo  $discountGroup['discount_group_side']; ?></p>
                     </div>
                     <div class="table__td rulers-table__code">
                        <p><?php echo  $discountGroup['item_rules']; ?></p>
                     </div>
                     <div class="table__td rulers-table__condition">
                        <p><?php echo $discountGroup['conditions_rules']; ?></p>
                     </div>
                     <div class="table__td rulers-table__quantity">
                        <p><?php echo $discountGroup['count_rules']; ?></p>
                     </div>
                     <div class="table__td rulers-table__sale">
                        <p><?php if (!empty($discountGroup['procent_rules'])) {
                              echo $discountGroup['procent_rules'] . ' %';
                           } else {
                              echo $discountGroup['rub_rules'] . ' ₽';
                           } ?></p>
                     </div>
                     <div class="table__td rulers-table__delete">
                              <a href="/admin/ruldel/<?php echo $discountGroup['item_rules']; ?>" class="btn-delete" title="Удалить"><img src="/template/images/Stock/delete.svg" alt="Удалить"> </a>
                           </div>
                  </div>
               <?php } ?>
            </div>
         </div>
         <div class="rulers-table__admin coupons-table_admin table w-100">
            <div>Единичные товары по акциям <div>
                  <div class="table__head">
                     <div class="table__th rulers-table__code">Код товара</div>
                     <div class="table__th rulers-table__name">Название товара</div>
                     <div class="table__th rulers-table__condition">Условие</div>
                     <div class="table__th rulers-table__quantity">Количество</div>
                     <div class="table__th rulers-table__sale">Скидка</div>
                     <div class="table__th rulers-table__delete">Действие</div>
                  </div>
                  <div class="table__body">
                     <?php foreach ($allRules as $allRulesOne) { ?>
                        <div class="table-body_line">
                           <div class="table__td rulers-table__code">
                              <p><?php echo $allRulesOne['item_rules']; ?></p>
                           </div>
                           <div class="table__td rulers-table__name">
                              <p><a href="/product/<?php echo $allRulesOne['product_part_number']; ?>" target="_blank"><?php echo $allRulesOne['product_name']; ?></a></p>
                           </div>
                           <div class="table__td rulers-table__condition">
                              <p><?php echo $allRulesOne['conditions_rules']; ?></p>
                           </div>
                           <div class="table__td rulers-table__quantity">
                              <p><?php echo $allRulesOne['count_rules']; ?></p>
                           </div>
                           <div class="table__td rulers-table__sale">
                              <p><?php if (!empty($allRulesOne['procent_rules'])) {
                                    echo $allRulesOne['procent_rules'] . ' %';
                                 } else {
                                    echo $allRulesOne['rub_rules'] . ' ₽';
                                 } ?></p>
                           </div>
                           <div class="table__td rulers-table__delete">
                              <a href="/admin/ruldel/<?php echo $allRulesOne['item_rules']; ?>" class="btn-delete" title="Удалить"><img src="/template/images/Stock/delete.svg" alt="Удалить"> </a>
                           </div>
                        </div>
                     <?php } ?>
                  </div>
               </div>
            </div>
         </div>
</main>

<?php include ROOT . '/views/admin/Index/Footer.php'; ?>