<?php include ROOT . '/views/layouts/header.php';
 $environment = include_once($_SERVER['DOCUMENT_ROOT'] . '/config/environment.php'); ?>
<div class="subcategory">
   <div class="container">
      <div class="row">
         <div class="col-20">
            <div class="banner-products banner-products__news banner-products__subcategory">
               <a href="<?php echo $environment["base_url"]; ?>/category/eco"><img src="/template/images/Stock/saleCat.jpg" class="banner-products__bg" alt="Акция"></a>
            </div>
         </div>
         <div class="col-80">
            <ul class="breadcrumb w-100" itemscope itemtype="https://schema.org/BreadcrumbList">
               <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="/" title="Главная"><span itemprop="name">ГЛАВНАЯ</span></a><meta itemprop="position" content="1" /></li>
               <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="/custom"><span itemprop="name">Товары под заказ</span></a><meta itemprop="position" content="2" /></li>
               <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item"><span itemprop="name"><?php echo $cats["catName"]; ?></span></a><meta itemprop="position" content="3" /></li>
            </ul>
            <div class="row">
               <?php foreach($childCats as $childCatsOne){ ?>
               <div class="col-25">
                  <a href="/is/<?php echo $childCatsOne['catSlug']; ?>" class="subcategory__item color_white bg-gradient__green" title="<?php echo $childCatsOne['catName']; ?>">
                  <img src="/upload/images/<?php echo $childCatsOne['catImage']; ?>" alt="<?php echo $childCatsOne['catName']; ?>" class="category-appointment__item_bg">
                  <span class="subcategory__item_icon"><img src="/template/images/Icons/<?php echo $childCatsOne['catIcon']; ?>" alt="<?php echo $childCatsOne['catName']; ?>"></span>
                  <span class="subcategory__item_title"><?php echo $childCatsOne['catName']; ?></span>
                  </a>
               </div>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>
</div>
<section class="company-description">
   <div class="container">
      <h1><?php // echo $thisCategory["cat_h1"]; ?></h1>
      <div class="box-text">
         <?php //echo $thisCategory["cat_desc"]; ?>
      </div>
   </div>
</section>
<?php include ROOT . '/views/layouts/footer.php'; ?>