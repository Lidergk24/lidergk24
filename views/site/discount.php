<?php include ROOT . '/views/layouts/header.php'; ?>
<main class="sale-main">
   <div class="container">
      <?php include ROOT . '/views/layouts/sidebar_menu.php'; ?>
      <div class="main-wrapper">
         <div class="breadcrumb-wrapper">
            <ul class="breadcrumb">
               <li><a href="/">Главная</a></li>
               <li><span>Акции</span></li>
            </ul>
         </div>
         <?php if ($allSales == NULL) { ?>
         <h2>Акций пока нет</h2>
         <?php } else { ?>
         <h1 class="catmy_footer_text_discount">Акции</h1>
         <?php
            foreach ($allSales as $allSalesOne) { ?>
         <div class="sale-wrapper">
            <div class="sale-wrapper__image">
               <img src="/upload/banners/<?php echo $allSalesOne['sale_images']; ?>" alt="<?php echo $allSalesOne['sale_name']; ?>">
            </div>
            <div class="sale-wrapper__content">
               <div class="subtitle-line">
                  <h2 class="subtitle"><?php echo $allSalesOne['sale_name']; ?></h2>
               </div>
               <div class="subsection">
                  <div class="bg-grey box-subsection">
                     <?php echo $allSalesOne['sale_text']; ?>
                  </div>
               </div>
            </div>
         </div>
         <?php } } ?>
      </div>
   </div>
</main>
<?php include ROOT . '/views/layouts/footer.php'; ?>