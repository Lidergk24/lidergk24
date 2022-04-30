<?php include ROOT . '/views/layouts/header.php'; ?>
<script type="application/ld+json">
    {
        "@context": "https://schema.org/",
        "@type": "Product",
        "name": "<?php echo $product['product_name']; ?>",
        <?php foreach (json_decode($productsListCategoryOne['product_image']) as $imagesCategory) {
            foreach (array($imagesCategory) as $oneImagescategory) {
                if ($oneImagescategory->{0} != '') { ?> "image": "https://лидер-гк.рф/upload/<?php echo $oneImagescategory->{0}; ?>",
        <?php }
            }
        } ?> "description": "<?php echo $product['product_description'] ?>",
        "sku": "<?php echo $product['barcode'] ?>",
        "brand": {
            "@type": "Brand",
            "name": "<?php echo $product['product_brand'] ?>"
        },
        "offers": {
            "@type": "Offer",
            "url": "https://лидер-гк.рф/product/<?php echo $product['product_part_number']; ?>",
            "priceCurrency": "RUB",
            "price": "<?php echo $product['product_price']; ?>",
            "priceValidUntil": "<?php echo $product['product_date']; ?>",
            "availability": "https://schema.org/InStock",
            "seller": {
                "@type": "Organization",
                "name": "ООО Лидер"
            }
        }
    }
</script>
<section class="product-section">
    <div class="breadcrumb-wrapper">
        <div class="container">
            <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="/" title="Главная"><span itemprop="name">ГЛАВНАЯ</span></a>
                    <meta itemprop="position" content="1" />
                </li>
                <?php if ($is_custom) { ?>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="/custom" title="ЗАКАЗНЫЕ ПОЗИЦИИ"><span itemprop="name">ЗАКАЗНЫЕ ПОЗИЦИИ</span></a>
                        <meta itemprop="position" content="1" />
                    </li>
                <?php } ?>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="/<?php echo $is_custom ? 'is' : 'category'; ?>/<?php echo $bossCat['cat_slug']; ?>" title="<?php echo $bossCat['cat_name']; ?>"><span itemprop="name"><?php echo $bossCat['cat_name']; ?></span></a>
                    <meta itemprop="position" content="2" />
                </li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="/<?php echo $is_custom ? 'is' : 'podcat'; ?>/<?php echo $searchParentCat['cat_slug']; ?>" title="<?php echo $searchParentCat['cat_name']; ?>"><span itemprop="name"><?php echo $searchParentCat['cat_name']; ?></span></a>
                    <meta itemprop="position" content="3" />
                </li>

            </ul>
        </div>
    </div>
    <div class="container">
        <h1 style="margin: 0 auto;"><?php echo $product['product_name']; ?></h1>
        <div class="mobile-part-number" style="
    font-size: 14px;
    color: #3e3e3e;"> <?php echo $product['product_part_number']; ?></div>
    </div>
    <div class="container" style="margin-top:20px">
        <?php if ($product['product_discount_price']) {
            echo '<span class="product-card-discount-full-condition"> ' . 'Акция! ' . $product['product_discount_price'] . ' ₽' . ' при покупке ' . $product['condition_rules'] . ' ' . $product['count_rules'] . ' '. $izm . ' </span>';
        } ?>
    </div>
    <div class="product-section__wrapper w-100">
        <div class="container <?php if (!$product['drop_date']) { echo 'product-page-container'; }?>">
            <div class="product-section__image">
                <div class="product-section__image_slider">
                    <div class="product-section__image_slider_max">
                        <?php
                        $imgArray = json_decode($product['product_image'], true)[0];
                        foreach ($imgArray as $image) { ?>
                            <div class="slide">
                                <a href="/upload/<?php echo $image; ?>" class="product-gallery" data-fancybox="gallery" title="<?php echo $product['product_name']; ?>">

                                    <?php if ($product['discount'][$product['id']]['procent_rules']) {
                                        echo '<span class="product-card-sign-discount"> -' . $product['discount'][$product['id']]['procent_rules'] . ' % </span>';
                                    } else if ($product['discount'][$product['id']]['rub_rules']) {
                                        echo '<span class="product-card-sign-discount"> -' . $product['discount'][$product['id']]['rub_rules'] . ' ₽' . '</span>';
                                    } ?>
                                    <img src="/upload/<?php echo $image; ?>" alt="<?php echo $product['product_name']; ?>"></a>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="slider-nav">
                        <?php foreach ($imgArray as $image) { ?>
                            <div class="slide">
                                <div class="product-preview">
                                    <img src="/upload/<?php echo $image; ?>" alt="<?php echo $product['product_name']; ?>">
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="product-section__information_quantity product-section-top product-section-attributes-top">
                <ul class="product-characteristics">
                    <div class="product-section__information_quantity_title">Характеристики</div>
                    <?php
                        $i = 0;
                    foreach ($attributeToDisplayInProductPage as $oneAttributeGroup => $attributeGroupArray) {
                        if ($oneAttributeGroup == 'Свойства товара' || $oneAttributeGroup == 'Размеры' || $oneAttributeGroup == "Производитель" ) {
                         foreach ($attributeGroupArray as $attributeGroupInnerArray) {
                        foreach ($attributeGroupInnerArray as $oneAttribute => $oneAttributeValue) {
                            if ($i < 3) { $i++;?>
                          <li>
                                        <p><?php echo $oneAttribute; ?>:</p>
                                        <span><?php echo  $oneAttributeValue; ?></span>

                                </li>
                       <?php } } } }
                    }
                        ?>
                    <a href="#characteristics" class="product-chars-link">Cмотреть все характеристики</a>
                </ul>
                <div class="code-product">Код товара: <?php echo $product['product_part_number']; ?>
                    <?php if (!empty($product["product_brand"])) { ?>
                        <?php if ($brand['brand_logo']) {
                        ?> <a class="product-page-brand" href="/brand/<?php echo $product["product_brand"]; ?>"><img alt="<?php echo $product["product_brand"]; ?>" src="/template/images/Brand/<?php echo $brand['brand_logo']; ?>"></a> <?php } 
                        }
                         else { ?>
                         <div class="brand-dummy"></div>
                         <?php } ?>
                </div>
            </div>
            <?php if (!$product['drop_date']) { ?>
                <div class="product-section__information_quantity product-section-top shadow-50 radius-5">

                    <div class="product__quantity_box product-quantity-flex">
                        <div class="product__quantity_box_group product-card-price">
                            <div class="product__quantity_box_group price-text"></div>
                            <div class="total totalOne">
                                <span class="product-page-discount-block">
                                    <div class="product-page-discount-block-price">Цена</div>
                                    <?php
                                    echo '<div>' . $product['product_site_price'] . ' ₽';
                                    ?> <div class="amount product-page-discount-block-amount"> за
                                        <?php if ($izm != '') {
                                            echo $izm;
                                        } else { ?>
                                            шт. <?php } ?>
                                    </div>
                                </span>
                            </div>
                            <?php
                            $id = User::checkLogged();
                            $user = User::getUserById($id);
                            if ((!User::isGuest()) && ($user["specialClient"] == 'yes') && (!$product['product_discount_price'])) {
                                echo '<span class="product-card-disc-price">' . 'ваша цена: ' . $product['product_price'] . ' ₽' . '</span>';
                            }
                            ?>
                        </div>

                    </div>
                    <div class='product-page-signs'>
                        <?php if ($product['product_warehouse'] > 0) { ?>
                            <span class="product-card-avaiability">В наличии</span>
                            <div class="product__quantity_box_name product-pieces"> <?php echo $left; ?></div>
                        <?php } else { ?>
                            <span class="sign-product-page product-card-avaiability-not-available">Нет в наличии</span>
                        <?php }
                        ?>
                       
                    </div>
                </div>
                <div class="product__quantity_box ">
                    <div class="product__quantity_box_name"></div>
                    <div class="product__quantity_box_group">
                        <div class="amount"> КОЛИЧЕСТВО:
                            <span class="down" data-order="<?php echo $product['miz_zakaz']; ?>">-</span>
                            <input type="text" value="<?php echo $product['miz_zakaz']; ?>" <?php if ($product['miz_zakaz'] > 1) {
                                                                                                echo "readonly='readonly'";
                                                                                            } ?> name="count_product" class="amount__text" />
                            <span class="up" data-order="<?php echo $product['miz_zakaz']; ?>">+</span>
                        </div>
                        <div class="operation">x</div>
                        <div class="product__quantity_box_val"><?php
                                        echo $product['product_price']; ?></div>
                        <div class="equally"></div>
                        <div class="total">ИТОГО:  <span class="totalSpan"><?php
                                                                            echo $product['product_price'] * $product['miz_zakaz']; ?></span> ₽</div>
                    </div>
                </div>
                <?php if (!$product['drop_date'] && $product['product_warehouse'] > 0) { ?>
                    <a href="#" data-id="<?php echo $product['custom_prefix'] . $product['id']; ?>" data-product_count="" class="btn btn_red btn_order btn__add_card add-cart vii" title="Купить">В корзину</a>
                    <a href="/cart/" class="href_cart_click product-page-cart-button">В корзине</a>
                <?php } ?>
                <?php if ($product['product_warehouse'] > 0) { ?>
                    <div class="product__quantity_box_name" style="display: <?php if ($product['product_warehouse'] > 0) {
                                                                                echo "flex";
                                                                            } else {
                                                                                echo "none";
                                                                            } ?>;">
                        <div class="delivery-image-product-page" style="background-image: url('/template/images/Stock/001-truck.svg');"></div>
                        <div>БЛИЖАЙШАЯ ДАТА ДОСТАВКИ
                            <div>в г. Москва </div>
                            <span class="nearestDate" id="nearestDate"> </span>
                        </div>
                    </div>

                <?php } ?>
                <div class="product-card-date-paragraph">Дату доставки вы сможете выбрать самостоятельно во время оформления заказа</div>
        </div>
    <?php } ?>
    </div>
    <div class="container product-section__information" id="characteristics">
        <div class="product-section__information_item">
            <div class="tabs tabs-product">
                <ul class="tabs__caption product-card-tabs-caption">
                    <li class="active">Характеристики</li>
                    <li>Описание</li>
                    <?php if (!empty($compatibleProducts)) { ?><li> Сопутствующие товары</li> <?php } ?>
                </ul>
                <div class="tabs__content active">
                    <ul class="product-characteristics">
                        <?php
                        $i = 1;
                        foreach ($attributeToDisplayInProductPage as $oneAttributeGroup => $attributeGroupArray) {
                        ?>
                            <div class="attributes-heading"><?php echo  $oneAttributeGroup; ?></div>
                            <?php foreach ($attributeGroupArray as $attributeGroupInnerArray) {
                                foreach ($attributeGroupInnerArray as $oneAttribute => $oneAttributeValue) {
                                    $i++; ?>

                                    <li class="li-chars <?php if ($i % 2 != 0) {
                                                            echo 'grey-char';
                                                        } ?>">
                                        <p><?php echo $oneAttribute; ?></p>
                                        <span><?php echo $oneAttributeValue; ?></span>

                                    </li>
                        <?php }
                            }
                        } ?>
                    </ul>
                </div>
                <div class="tabs__content">&#8226;<?php echo str_replace('. ', '.<br>&#8226;', $product['product_description']); ?></div>
                <div class="tabs__content"> <?php if ($product["compatible_product"] != "[null]") { ?>
                        <div class="related-products__line">
                            <div class="related-products">
                                <?php
                                                foreach ($compatibleProducts as $oneCompatibleProduct) {
                                                    foreach (json_decode($oneCompatibleProduct['product_image']) as $similarImgOne) {
                                                        $mbsubstrName = mb_substr($oneCompatibleProduct['product_name'], 0, 40) . "...";
                                ?>

                                        <div class="related-products__wrap">
                                            <a href="/product/<?php echo $oneCompatibleProduct['product_part_number']; ?>" class="related-products__photo" title=""><img src="/upload/<?php echo $similarImgOne->{0}; ?>" alt="<?php echo $oneCompatibleProduct['product_name']; ?>"></a>
                                            <a href="/product/<?php echo $oneCompatibleProduct['product_part_number']; ?>" class="related-products__name" title="<?php echo $oneCompatibleProduct['product_name']; ?>"><?php echo $oneCompatibleProduct['product_name']; ?></a>
                                            <span><?php echo $oneCompatibleProduct['product_price']; ?> ₽</span>
                                            <div class="amount">
                                                <span class="down similarDown" data-order="<?php echo $oneCompatibleProduct['miz_zakaz']; ?>">-</span>
                                                <input type="text" maxlength="5" value="<?php echo $oneCompatibleProduct['miz_zakaz']; ?>" <?php if ($oneCompatibleProduct['miz_zakaz'] > 1) {
                                                                                                                                                echo "readonly='readonly'";
                                                                                                                                            } ?> name="count_product" class="amount__text" />
                                                <span class="up similarUp" data-order="<?php echo $oneCompatibleProduct['miz_zakaz']; ?>">+</span>
                                            </div>

                                            <div class="related-products__sum">
                                                <span><?php echo $oneCompatibleProduct['product_price'] * $oneCompatibleProduct['miz_zakaz']; ?></span> ₽
                                                <input type="hidden" name="simalarHide" value="<?php echo $oneCompatibleProduct['product_price']; ?>">
                                            </div>
                                            <a class="btn btn_red btn_add similar_code" data-id="<?php echo $oneCompatibleProduct['id']; ?>" data-product_count="" title="Добавить"><img src="/template/images/Stock/miniCart.png"></a>
                                        </div>
                            <?php }
                                                }
                                            }
                            ?>
                            </div>
                        </div>
                </div>
            </div>
        </div>
</section>
<section class="similar-products">
    <div class="container">
        <h2>Похожие товары</h2>
        <div class="row d-flex similar-products-items">
            <?php foreach ($similarProduct as $product) {
                include(ROOT . '/views/catalog/product-card.php');
            } ?>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>

<script>
    $(".similar_code").click(function() {
        $(this).closest('.related-products__wrap').find('.similar_code').addClass('block_count_cart');
        var count_product = $(this).closest('.related-products__wrap').find('input[name=count_product]').val();
        $(this).closest('.related-products__wrap').find('.similar_code').attr('data-product_count', count_product);
        var id = $(this).attr("data-id");
        cart_add_ajax(id, count_product);
    });

    $(document).ready(function() {
        var $bookmark = $(".breadcrumb-wrapper");
        var y = $bookmark.offset().top;
        $(window).scrollTop(y);

    });

    $(document).on('click', '.up, .down', function() {
        var countUp = $(this).closest('.product__quantity_box_group').find('input[name=count_product]').val();
        var totalOne = parseFloat($('.product__quantity_box_val').html());
        $(this).closest('.product__quantity_box_group').find('.totalSpan').html((countUp * totalOne).toFixed(2));
    });

    $(document).on('click', '.similarUp, .similarDown', function() {
        var countSimilar = $(this).closest('.related-products__wrap').find('input[name=count_product]').val();
        var totalOneSimilar = $(this).closest('.related-products__wrap').find('input[name=simalarHide]').val();
        $(this).closest('.related-products__wrap').find('.related-products__sum span').html((countSimilar * totalOneSimilar).toFixed(2));
    });



    $('.vii').click(function() {

        $('.vii').css('display', 'none');
        $('.href_cart_click').css('display', 'flex');
    });

    $(document).on('click', '.corobUp, .corobDown', function() {

        var corobUp = $(this).closest('.product__quantity_box_group').find('input[name=count_product]').val();
        var totalCorob = parseFloat($('.product__quantity_box_val').html());

        var priceForOne = parseFloat($('.totalOne').html());
        var countForcorob = $('.countForcorob').val();

        $(this).closest('.product__quantity_box_group').find('.totalCorob').html((priceForOne * countForcorob).toFixed(2));
    });
    $(document).ready(function() {

        $('.boxCountWhere').addClass('boxCountWhereBlock');

        $('.wantCorob').click(function() {

            $('.boxCountWhere').removeClass('boxCountWhereBlock');

        });

    });
</script>