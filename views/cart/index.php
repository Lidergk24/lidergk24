<?php include ROOT . '/views/layouts/header.php'; ?>
<?php if ($result) { ?>

    <div class="successful-order__info">
        <div class="successful-order__icon"><img src="/template/images/Stock/check.svg" alt="Успешный заказ"></div>
        <h1>Заказ №<?php echo $orderNumber; ?> успешно оформлен</h1>
        <div class="successful-order__text">
            <p>Информация о заказе отправлена вам в SMS и на электронную почту.</p>
            <p>Пожалуйста, ожидайте звонка нашего оператора или свяжитесь с нами самостоятельно по номеру: <a href="tel:+78002223236" class="successful-order__phone">8 (800) 222-32-36</a> (звонок бесплатный по РФ)</p>
        </div>
    </div>
    <script>
        setTimeout(function() {
            location.replace("/");
        }, 5000);
    </script>
<?php } else { ?>
        <div class="container">
            <?php
            $product['product_price'] = '';
            $product['miz_zakaz'] = '';
            if ($productsInCart) { ?>
                <h1>Корзина</h1>

                <div class="shopping-basket__content w-100">

                    <div class="basket__table_wrapper">
                        <div class="basket__table table w-100">
                            <div class="table__head">
                                <div class="table__th basket__table_photo">Фото товара</div>
                                <div class="table__th basket__table_name">Название</div>
                                <div class="table__th basket__table_price">Цена</div>
                                <div class="table__th basket__table_quantity">Количество</div>
                                <div class="table__th basket__table_sum">Сумма</div>
                                <div class="table__th basket__table_delete"></div>
                            </div>

                            <div class="table__body">
                                <?php foreach ($products as &$product) {?>

                                    <div class="table-body_line">
                                        <div class="table__td basket__table_photo posReletive">
                                            <a href="/product/<?php echo $product['product_part_number']; ?>" class="basket__table_img" title="<?php echo $product['product_name']; ?>">
                                                <?php
                                                foreach (json_decode($product['product_image']) as $imagesCategory) {
                                                    foreach (array($imagesCategory) as $oneImagescategory) { ?>
                                                        <img src="/upload/<?php echo $oneImagescategory->{0}; ?>" alt="<?php echo $product['product_name']; ?>">
                                                <?php }
                                                }?>
                                            </a>
                                        </div>
                                        <div class="table__td basket__table_name">
                                            <a href="/product/<?php echo $product['product_part_number']; ?>" class="basket__table_title" title="<?php echo $product['product_name']; ?>"><?php echo $product['product_name']; ?></a>
                                            <?php  if ($product["discount"]["procent_rules"] != 0) {?>
                                                    <div class="sale__text color_red">Скидка -<?php echo $product["discount"]["procent_rules"]; ?>% при покупке <?php if($product["discount"]['conditions_rules'] !== 'Равно') {
                                                        echo mb_strtolower($product["discount"]['conditions_rules']);} else {
                                                            echo 'кратно';
                                                        }; ?> <?php echo $product["discount"]["count_rules"]; ?> шт.</div>

                                             <?php }  else if ($product["discount"]["rub_rules"] != 0) { ?> 
                                            <div class="sale__text color_red">Скидка - <?php echo $product["discount"]["rub_rules"]; ?> ₽ при покупке <?php if($product["discount"]['conditions_rules'] !== 'Равно') {
                                                        echo mb_strtolower($product["discount"]['conditions_rules']);} else {
                                                            echo 'кратно';
                                                        }; ?> <?php echo $product["discount"]["count_rules"]; ?> шт.</div> 
                                            <?php } 
                                              if (strpos($product["product_part_number"], '62-') !== false) { ?>
                                                <div class="sale__text color_red">Товар из категории "Под заказ". <br> Срок поступления вам озвучит оператор</div>
                                            <?php } ?>
                                        </div>
                                        <div class="table__td basket__table_price">
                                        <p class="cart_iteme_price_one">
                                        <?php if($product['cost'] > $product['discount_cost']) { 
                                            echo '<del>' . $product['product_price'] . '</del> <br>';
                                            echo '<b>' .  sprintf("%0.2f", $product['discount_cost'] / $product['count']) . '</b>';
                                        } else {
                                            echo '<b>' . $product['product_price'] . '</b>';
                                        } ?>  ₽ </p>
                                        </div>
                                        <div class="table__td basket__table_quantity">
                                            <div class="amount">
                                                <span class="down cart_down" data-order="<?php echo $product['miz_zakaz']; ?>" data-price="<?php echo $product['product_price']; ?>">-</span>
                                                <input type="text" class="amount__text count_item" name="count_product" maxlength="5" autocomplete="off" data-id="<?php echo $product['id']; ?>" data-product_count="" value="<?php echo $productsInCart[$product['id']]; ?>" <?php if ($product['miz_zakaz'] > 1) {
                                                                                                                                                                                                                                                                                    echo "readonly='readonly'";
                                                                                                                                                                                                                                                                                } ?> />
                                                <span class="up cart_up" data-order="<?php echo $product['miz_zakaz']; ?>" data-price="<?php echo $product['product_price']; ?>">+</span>
                                            </div>
                                        </div>
                                        <div class="table__td basket__table_sum">
                                            <p class="cart_iteme_price"><?php echo sprintf("%0.2f", $product['discount_cost']);?> ₽</p> <br>
                                        </div>
                                        <div class="table__td basket__table_delete">
                                            <a class="btn-delete" title=""><img src="/template/images/Stock/delete.svg" alt="Удалить"></a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="shopping-basket__total">
                        <div class="shopping-basket__attention">
                            <p>Внимание! Минимальная сумма заказа
                                составляет <span class="color_red">3000 ₽!</span></p>
                        </div>

                        <div class="promo__code">
                            <form method="post" class="form-promo__code">
                                <label>
                                    <input type="text" class="input_coupon" placeholder="Введите промокод" <?php if (User::isGuest()) {
                                                                                                                echo "disabled ";
                                                                                                                echo "title='Для использования необходимо авторизоваться'";
                                                                                                            } 
                                                                                                                elseif (User::checkUserForCoupon() === false) {
                                                                                                                    echo "disabled ";
                                                                                                                    echo "title='Промокод нельзя активировать'";
                                                                                                                }
                                                                                                            ?>>
                                    <span class="notification__promo bg-light__green">Купон применен!</span>
                                </label>
                                <button type="submit" class="btn btn_black inputCoupon" <?php if (User::isGuest()) {
                                                                                            echo "disabled ";
                                                                                            echo "title='Для использования необходимо авторизоваться'";
                                                                                        } 
                                                                                            elseif (User::checkUserForCoupon() === false) {
                                                                                                echo "disabled ";
                                                                                                echo "title='Промокод нельзя активировать'";
                                                                                            }
                                                                                        ?>>Применить</button>
                                <?php if (User::isGuest()) { ?>
                                    <span class="warning_coupon">Для применения промокода необходимо
                                        <a href="/user/login"> авторизоваться</a>
                                    </span>
                                <?php } ?>
                                <?php if (User::checkUserForCoupon() === false) { ?>
                                    <span class="warning_coupon">Промокод нельзя активировать
                                    </span>
                                <?php } ?>
                            </form>
                        </div>
                        <div class="shopping-basket__total_list">


                            <?php if (!User::isGuest()) { ?>
                                <div class="shopping-basket__total_item">
                                    <p class="shopping-basket__total_item_name">
                                    </p>

                                </div>
                            <?php } ?>
                            <p class="shopping-basket__total_item nextStep"></p>

                            <div class="shopping-basket__total_item">
                                <p class="shopping-basket__total_item_name">Стоимость товаров:</p>
                                <span class="shopping-basket__total_item_text basket-sum"><?php echo sprintf("%0.2f", $totalPrice);
                                                                                            echo " ₽"; ?></span>
                            </div>

                            <div class="shopping-basket__total_item total-desc">
                                <p class="shopping-basket__total_item_name">Скидка:</p>
                                <span class="shopping-basket__total_item_text procent_discount"></span>
                            </div>
                            <div class="shopping-basket__total_item">
                                <p class="shopping-basket__total_item_name">Доставка:</p>
                                <span class="shopping-basket__total_item_text cart_delivery"></span>
                            </div>
                            <div class="shopping-basket__total_item">
                                <p class="shopping-basket__total_item_name itogSum">ИТОГО:</p>
                                <span class="shopping-basket__total_item_text total-sum itogSum"></span>
                            </div>
                        </div>

                        <div class="button__group">
                            <a href="/cart/order" class="btn btn_red" title="">Оформить заказ</a>
                            <a href="#order__one_click" class="btn btn_black open_modal" title="Купить в 1 клик">Купить в 1 клик</a>
                        </div>
                    </div>

                </div>
        
    </div>

<?php } else { ?>
    <a href="/" style="margin: 0 auto;"><img class="cart_block_empty_hidden" src="/template/images/Stock/empty_cart.png"></a>
<?php } ?>
<?php } ?>
<div class="modal__div" id="order__one_click">
    <div class="modal__wrapper">
        <div class="modal__close"></div>
        <h2 class="modal__title">Купить в 1 клик</h2>

        <div class="modal__description">

            <p>Введите имя и номер телефона. </br>
                Наш оператор свяжется с вами в ближайшее время.</p>
        </div>

        <form method="post" class="form form__modal">

            <label><input type="text" name="userNameOneClick" placeholder="Ваше имя"></label>

            <label><input type="text" name="phone" placeholder="+7 (___) ___ - __ - __"></label>


            <button type="submit" name="submit" class="btn_red btn sendClick" onclick="yaCounter57470944.reachGoal('good_order'); return true;">Заказать</button>
        </form>
    </div>
</div>
<?php include ROOT . '/views/layouts/footer.php'; ?>
<script>
    $('.total-desc').css('display', 'none');
    $('.form__modal').submit(function(e) {
        var errorsForm = false;
        var nameVal = $('input[name="userNameOneClick"]').val();

        if (nameVal.length < 3) {
            errorsForm = true;
            $('[name=userNameOneClick]').css('border', 'red 1px solid');
        } else {
            $('[name=userNameOneClick]').css('border', 'rgba(0,0,0,0.15) 1px solid');
        }

        var phoneVal = $('[name=phone]').val().replace(/[^\d.]/ig, '');

        if (phoneVal.length < 11) {

            errorsForm = true;
            $('[name=phone]').css('border', 'red 1px solid');
        } else {

            $('[name=phone]').css('border', 'rgba(0,0,0,0.15) 1px solid');
        }
        return !errorsForm;
    });
</script>