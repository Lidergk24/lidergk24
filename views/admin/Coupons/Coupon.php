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
            <li><a title="купоны"><span>купоны</span></a></li>
         </ul>
         <h1>Действующие купоны</h1>
         <div class="main-cabinet-button__group">
            <a href="/admin/addcoupon" class="btn btn_black" title="Добавить купон">
               <span class="icon-plus">
                  <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                     y="0px"
                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                     <g>
                        <g>
                           <path d="M492,236H276V20c0-11.046-8.954-20-20-20c-11.046,0-20,8.954-20,20v216H20c-11.046,0-20,8.954-20,20s8.954,20,20,20h216
                              v216c0,11.046,8.954,20,20,20s20-8.954,20-20V276h216c11.046,0,20-8.954,20-20C512,244.954,503.046,236,492,236z"/>
                        </g>
                     </g>
                  </svg>
               </span>
               Добавить купон
            </a>
         </div>
         <div class="coupons-table_admin table w-100">
            <div class="table__head">
               <div class="table__th coupons-table__name">Название купона</div>
               <div class="table__th coupons-table__sale">Скидка по купону</div>
               <div class="table__th coupons-table__sum">Сумма от</div>
               <div class="table__th coupons-table__active">Активация<br>(0 - без ограничений) </div>
               <div class="table__th coupons-table__date">Дата создания</div>
               <div class="table__th coupons-table__delete">Удалить</div>
            </div>
            <div class="table__body">
               <?php foreach ($allCoupons as $allCouponsOne): ?>
                <div class="table-body_line">
                  <div class="table__td coupons-table__name">
                     <p><?php echo $allCouponsOne['coupon_name']; ?></p>
                  </div>
                  <div class="table__td coupons-table__sale">
                     <p><?php echo $allCouponsOne['coupon_procent']; ?>%</p>
                  </div>
                  <div class="table__td coupons-table__sum">
                     <p><?php echo $allCouponsOne['coupon_summ']; ?> ₽</p>
                  </div>
                  <div class="table__td coupons-table__active">
                     <p><?php echo $allCouponsOne['coupon_activate']; ?></p>
                  </div>
                  <div class="table__td coupons-table__date">
                     <p><?php echo $allCouponsOne['coupon_time']; ?></p>
                  </div>
                  <div class="table__td coupons-table__delete">
                     <a href="/admin/deletecoupon/<?php echo $allCouponsOne['id']; ?>" class="btn-delete" title="Удалить"><img src="/template/images/Stock/delete.svg" alt="Удалить"></a>
                  </div>
                </div>
                <?php endforeach; ?>
            </div>
         </div>
      </div>
   </div>
</main>

<?php include ROOT . '/views/admin/Index/Footer.php'; ?>