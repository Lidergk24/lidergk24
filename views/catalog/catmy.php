<?php include ROOT . '/views/layouts/header.php'; ?>
        <div class="category-section">
   <div class="container">
   <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
               <a itemprop="item" href="/" title="Главная"><span itemprop="name">ГЛАВНАЯ</span></a>
               <meta itemprop="position" content="1"/>
            </li>
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
               <a itemprop="item" href="/category/<?php echo $breadCrumbsParent["cat_slug"]; ?>" title="<?php echo $breadCrumbsParent["cat_name"]; ?>"><span itemprop="name"><?php echo $breadCrumbsParent["cat_name"]; ?></span></a>
               <meta itemprop="position" content="2"/>
            </li>
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
               <span itemprop="name"><?php echo $metaChildCategory["cat_name"]; ?></span>
               <meta itemprop="position" content="3" />
            </li>
         </ul>
      <div class="sidebar">
         <div class="btn-close__menu"></div>
         <div class="filter-content">
         <div class="filter__box open">
            <div class="filter__box_header">
               <h3 class="filter__box_title">Стоимость</h3>
            </div>
            <div class="filter__box_body">
               <div id="buy_price"></div>
               <div class="price-range__wrapper">
                  <label class="price-range__label">
                  <span>от</span>
                  <input name="price_s" type="text" value=""/>
                  </label>
                  <label class="price-range__label">
                  <span>до</span>
                  <input name="price_f" type="text" value=""/>
                  </label>
               </div>
            </div>
         </div>
         <div class="filter__box open">
            <div class="filter__box_header">
               <h3 class="filter__box_title"></h3>
            </div>
            <div class="filter__box_body">
               <ul class="list-checkbox scroll-box">
                  <li class="list-checkbox__item">
                     <label class="checkbox">
                     <input class="checkbox-inp" type="checkbox" name="checkbox">
                     <span class="checkbox-custom"></span>
                     <span class="label"></span>
                     </label>
                  </li>
               </ul>
            </div>
         </div>
       
      
       
        
         <div class="button-group">
            <a href="#" class="btn btn_red btn_apply" title="">применить</a>
            <a href="#" class="links-grey btn-clear" title="">сбросить фильтр</a>
         </div>
         </div>
      </div>
      <div class="category-section__wrapper">
         <div class="button-group__mobile">
            <a href="#" class="btn btn_border btn_filter" title="">фильтр</a>
            <a href="#" class="btn btn_border btn_sort" title="">сортировка</a>
         </div>
         <div class="sorting-wrapper">
            <div class="btn-close__menu"></div>
            <div class="sorting__box">
               <div class="sorting__box_title">Сортировка</div>
               <a data-sort="ASC" class="sorting__box_links links-tag active" title="Цене по возрастанию">по возрастанию цены</a>
               <a data-sort="DESC" class="sorting__box_links links-tag" title="Цене по убыванию">по убыванию цены</a>
               <a data-sort="a-z" class="sorting__box_links links-tag" title="А-Я">по алфавиту А-Я</a>
               <a data-sort="z-a" class="sorting__box_links links-tag" title="Я-А">по алфавиту Я-А</a>
            </div>
         </div>
         <div class="row d-flex w-100 appendChild">
            <?php foreach($productsListCategory as $idx=>$product){
	         if ($idx<16) include ROOT . '/views/catalog/product-card.php'; ?>
            <?php } ?>
           <?php if(count($productsListCategory)>16){ ?>
           <div class="row"><a href="#" class="btn btn_border-red load-more" title="">Загрузить еще</a></div>
           <?php } ?>
         </div>
      </div>
   </div>
</div>
<div class="category-content">
   <div class="container">
      <h1 class="description-h1"><?php echo $metaChildCategory["cat_name"]; ?>  <span class="arrow-down-main-page"><img class="img-arrow-down" src="/template/images/Stock/arrow-bottom-grey.png"></span> </h1>
      <div class="box-text-no-show box-text">
         <?php echo $metaChildCategory['cat_desc']; ?>
      </div>
   </div>
</div>

<?php include ROOT . '/views/layouts/footer.php'; ?>
<script src="/template/js/catmy.js"></script>