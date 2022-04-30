<?php include ROOT . '/views/cabinet/Index/Header.php'; ?>
<main class="main-cabinet-user main-cabinet-user-view">
    <div class="container">
        <div class="cabinet-sidebar">
            <div class="btn-close__menu"></div>
            <?php include ROOT . '/views/cabinet/Index/CabinetMenu.php'; ?>
            <?php include ROOT . '/views/cabinet/Index/CabinetMenuSideBar.php'; ?>
                </div>
                <div class="main-cabinet-user__content">
                    <ul class="breadcrumb breadcrumb-cabinet">
                        <li><a href="/cabinet" title="Главная"><span>ГЛАВНАЯ</span></a></li>
                        <li><a href="/cabinet/history" title="Заказы"><span>заказы</span></a></li>
                    </ul>

                    <h1>Просмотр заказа №<?php echo $oneItembill["order_number"]; ?></h1>

                    <div class="main-cabinet-user-view__title">Дата заказа <?php echo $oneItembill['date']; ?></div>

                    

                    <div class="main-cabinet-user-view__title">Товары в заказе</div>
                    <div class="basket__table basket__table_view table w-100">
                        <div class="table__head">
                            <div class="table__th basket__table_photo">Фото товара</div>
                            <div class="table__th basket__table_article">Артикул</div>
                            <div class="table__th basket__table_name">Название</div>
                            <div class="table__th basket__table_price">Цена</div>
                            <div class="table__th basket__table_quantity">Количество</div>
                            <div class="table__th basket__table_sum">Сумма</div>
                        </div>

                        <div class="table__body">
                              <?php if (!empty($order_items)) { $view_order_items = $order_items; } else {$view_order_items = $products;}; ?> 
                              <?php foreach ($view_order_items as $order_item): ?>
                            <div class="table-body_line">
                                <div class="table__td basket__table_photo">
                                    <a href="#" class="basket__table_img" title="">
                                     <?php foreach (json_decode($order_item['product_image']) as $imagesCategory){
                        foreach(array($imagesCategory) as $oneImagescategory){ ?>
                          <img src="/upload/<?php echo $oneImagescategory->{0}; ?>" alt="<?php echo $order_item['product_name']; ?>">
                  <?php } } ?>
                                    </a>
                                </div>
                                <div class="table__td basket__table_article">
                                    <p><?php echo $order_item['product_part_number']; ?></p>
                                </div>
                                <div class="table__td basket__table_name">
                                    <a href="/product/<?php echo $order_item['product_part_number']; ?>" class="basket__table_title" title="<?php echo $order_item['product_name']; ?>"><?php echo $order_item['product_name']; ?></a>
                                </div>
                                <div class="table__td basket__table_price">
                                    <p><?php  if (!empty($order_items)) { if (!$order_item['discount_price'] > 0) {
                                        echo $order_item['price_at_order_time'] . ' ₽';
                                    }  else {echo '<del>'.$order_item['price_at_order_time']. '</del>'; echo '<span style="color:red">'.'<br>'.$order_item['discount_price']. ' ₽'. '</span>';}}else {echo '';} ?></p>
                                </div>
                                <div class="table__td basket__table_quantity">
                                    <p><?php echo $productsQuantity[$order_item['id']]; ?> шт</p>
                                </div>
                                <div class="table__td basket__table_sum">
                                    <p><?php if (!empty($order_items)) { if (!$order_item['discount_price'] > 0) {
                                        echo $order_item['price_at_order_time'] *$order_item['quantity'] . ' ₽';} else {
                                            echo $order_item['discount_price'] *$order_item['quantity'] . ' ₽';
                                        } } else {echo '';}?> </p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="w-100 total-sum__line">
                        <a href="/cabinet/repeat/<?php echo $oneItembill["order_number"]; ?>" class="btn btn_cabinet_add">Повторить заказ</a>
                        <div class="total-sum">
                            <p>Итого:</p>
                            <div class="total-sum__val"><?php echo $oneItembill['order_summ']; ?> ₽</div>
                        </div>
                    </div>

                </div>
            </div>
        </main>


<?php include ROOT . '/views/cabinet/Index/Footer.php'; ?>