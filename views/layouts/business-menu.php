<div class="header__bottom">
    <div class="container">
        <?php foreach ($allBusinessCategories as $businessCategory) { ?> 
            <span class="header-bottom-menu-links"><a href="/business/<?php echo $businessCategory['categoryChpu'];?>" class="" title="<?php echo $businessCategory['categoryTitle'];?>"><?php echo $businessCategory['categoryName'];?></a></span>
        <?php }?>
    </div>
</div>