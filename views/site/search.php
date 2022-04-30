<?php include ROOT . '/views/layouts/header.php'; ?>
    <div class="category-section">
   <div class="container">
      
      <div class="category-section__wrapper searchContainer">
         <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
               <a itemprop="item" href="/" title="Главная"><span itemprop="name">ГЛАВНАЯ</span></a>
               <meta itemprop="position" content="1"/>
            </li>
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
               <span itemprop="name">Вы искали: <?php if(isset($_POST['search'])){ echo $_POST['search']; } else { echo $_POST['searchMobile']; echo $_POST['searchFmobile']; } ?></span>
               <meta itemprop="position" content="2" />
            </li>
         </ul>
         
         <div class="row d-flex w-100 appendChild">
             <?php if (!empty(@$searchFrom)) { ?>
            <p class="searchTitle">Мы кое-что нашли</p>
            <?php foreach ($searchFrom as $product) { 
                include $_SERVER['DOCUMENT_ROOT'].'/views/catalog/product-card.php';
            }?>
         </div>
         
         <?php
               } else { echo $text; ?>
            <p class="emptySearch">По вашему запросу ничего не найдено. Пожалуйста, повторите поиск</p>
            <?php } ?>
      </div>
   </div>
</div>
<div class="category-content">
   <div class="container">
      <h1><?php echo $metaChildCategory["cat_name"]; ?></h1>
      <div class="box-text">
         <?php echo $metaChildCategory['cat_desc']; ?>
      </div>
   </div>
</div>
<?php include ROOT . '/views/layouts/footer.php'; ?>
