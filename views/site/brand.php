<?php include ROOT . '/views/layouts/header.php'; ?>
<div class="subcategory">
   <div class="container">
      <div class="row">
         <div class="col-20">
            <div class="banner-products banner-products__subcategory logoBlockLeft">
               <div class="banner-products__content">
                  <img src="/template/images/Brand/<?php echo $brandDescription['brand_logo']; ?>" alt="<?php echo $brandDescription['brand_name']; ?>">
               </div>
            </div>
         </div>
         <div class="col-80">
            <ul class="breadcrumb w-100">
               <li><a href="/" title="Главная"><span>ГЛАВНАЯ</span></a></li>
               <li><a href="/brandy" title="Бренды"><span>Бренды</span></a></li>
               <li><a title="<?php echo $brandDescription['brand_name']; ?>"><span>Товары бренда: <?php echo $brandDescription['brand_name']; ?></span></a></li>
            </ul>
            <div class="row">
               <h1 class="brands_title_h1">Товары бренда: <?php echo $brandDescription['brand_name']; ?></h1>
               <div class="brandDescription"><?php echo $brandDescription['brand_description']; ?></div>
               <div class="row d-flex w-100">
                  <?php foreach($brandModel as $product){ 
                  include $_SERVER['DOCUMENT_ROOT'].'/views/catalog/product-card.php';
                  }?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php include ROOT . '/views/layouts/footer.php'; ?>