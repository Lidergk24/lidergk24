<?php include ROOT . '/views/layouts/header.php';
 $environment = include_once($_SERVER['DOCUMENT_ROOT'] . '/config/environment.php'); ?>
<div class="subcategory">
   <div class="container">
      <div class="row">
         
            <ul class="breadcrumb w-100" itemscope itemtype="https://schema.org/BreadcrumbList">
               <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="/" title="Главная"><span itemprop="name">ГЛАВНАЯ</span></a><meta itemprop="position" content="1" /></li>
               <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item"><span itemprop="name"><?php echo $thisCategory["cat_name"]; ?></span></a><meta itemprop="position" content="2" /></li>
            </ul>
            <div class="row">
               <?php foreach($categories as $categoriesOne){ ?>
               <div class="col-25">
                  <a href="/podcat/<?php echo $categoriesOne['cat_slug']; ?>" class="subcategory__item color_white bg-gradient__green" title="<?php echo $categoriesOne['cat_name']; ?>">
                  <img src="/upload/images/<?php echo $categoriesOne['category_image']; ?>" alt="<?php echo $categoriesOne['cat_name']; ?>" class="category-appointment__item_bg">
                  <span class="subcategory__item_title"><?php echo $categoriesOne['cat_name']; ?></span>
                  </a>
               </div>
               <?php } ?>
            </div>

      </div>
   </div>
</div>
<section class="container">  <?php echo $thisCategory["cat_h1"]; ?> <span class="arrow-down-main-page"><img class="img-arrow-down" src="/template/images/Stock/arrow-bottom-grey.png"></span> 
   <div class="box-text-no-show box-text">
      <div class="box-text">
         <?php echo $thisCategory["cat_desc"]; ?>
      </div>
   </div>
</section>
<?php include ROOT . '/views/layouts/footer.php'; ?>