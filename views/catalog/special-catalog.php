<?php
include_once ROOT . '/views/layouts/header.php';
if ((!User::isGuest()) && ($user["specialClient"] == 'yes') && !empty($selectSpecialPrice)) { ?>
    <div class="container specialPricesInIndex">
        <h2>МОИ СПЕЦЦЕНЫ </h2>
        <div class="specialWarning">Внимание! Ваша персональная скидка не распространяется на товары из разделов "Акции" и "Распродажа"</div>
        <div class="row"><?php
                            foreach ($specialItems as $product) {
                                include(ROOT . '/views/catalog/product-card.php');
                                } ?>
        </div>
        <?php ?>
    </div>
<?php } else { ?>
    <main class="about-main">
        <div class="container">
            <?php include ROOT . '/views/layouts/sidebar_menu.php'; ?>
            <div class="main-wrapper">
                <div class="breadcrumb-wrapper">
                    <ul class="breadcrumb">
                        <li><a href="/">Главная / </a></li>
                        <li><span>Ошибка 404</span></li>
                    </ul>
                </div>
                <a href="/"><img src="/template/images/Stock/404.jpg"></a>
            </div>
        </div>
    </main>
<?php }
include_once ROOT . '/views/layouts/footer.php';
?>