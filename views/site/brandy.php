<?php include ROOT . '/views/layouts/header.php'; ?>
<div class="subcategory">
   <div class="container">
      <div class="row">
         <div class="col-80 col-brands">
            <ul class="breadcrumb w-100">
               <li><a href="/" title="Главная"><span>ГЛАВНАЯ</span></a></li>
               <li><span>Бренды</span></li>
            </ul>
            <h1>Бренды представленные в интернет магазине Lider-gk24.ru</h1>
            <div class="row">
               <?php foreach($allBrands as $oneBrands){ ?>
               <div class="col-25 col-brands-style">
                  <a href="/brand/<?php echo $oneBrands['brand_name']; ?>" class="subcategory__item color_white styleBrandHover" title="<?php echo $oneBrands['brand_name']; ?>">
                  <img src="/template/images/Brand/<?php echo $oneBrands['brand_logo']; ?>" alt="<?php echo $oneBrands['brand_name']; ?>" class="category-appointment__brands">
                  </a>
               </div>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>
</div>
<?php include ROOT . '/views/layouts/footer.php'; ?>