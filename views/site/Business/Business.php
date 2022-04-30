<?php include ROOT . '/views/layouts/header.php'; ?>
<main class="sale-main main-catalog">
   <div class="container">
      <div class="main-wrapper">
         <div class="breadcrumb-wrapper">
            <ul class="breadcrumb">
               <li><a href="/">Главная </a></li>
               <li><span><?php echo $infoCat["categoryName"]; ?></span></li>
            </ul>
         </div>
         <div class="main-catalog-wrapper">
            <div class="">
               <h1><?php echo $infoCat["categoryName"]; ?></h1>
               <div class="main-catalog__subcategory">
                    <?php
                     foreach($infoPatentCat as $infoPatentCatOne){
                            $items = $infoPatentCatOne["subCategoryItems"];
                            $productsBiz = Category::getItemsForBusiness($items);
                     ?>
                  <div class="main-catalog__subtitle"><?php echo $infoPatentCatOne["categoryName"]; ?></div>
                  <div class="row d-flex w-100">
                    <?php  foreach ($productsBiz as $product){ 
                     include(ROOT . '/views/catalog/product-card.php');
                     } ?>
                  </div>
                  <?php } ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</main>
<?php include ROOT . '/views/layouts/footer.php'; ?>