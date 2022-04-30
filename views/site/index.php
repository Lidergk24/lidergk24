<?php include_once ROOT . '/views/layouts/header.php';
include_once ROOT. '/views/layouts/business-menu.php';?>
<main class="main-home">
    <div class="container">
        <div class="main-home__slider">
            <?php foreach ($allbaner as $allbanerOne) { ?>
                <a href="<?php echo $allbanerOne['banner_link']; ?>">
                    <div class="slide">
                        <div class="main-home__slider_box">
                            <img src="/upload/banners/<?php echo $allbanerOne['banner_image']; ?>" class="main-home__slider_img" alt="<?php echo $allbanerOne['banner_title']; ?>">
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
        <div class="col-30 banner-2-main-home">
            <div class="banner-products">
                <a href="<?php echo $squareBanner['banner_link'];?>"><img  src="/upload/banners/<?php echo $squareBanner['banner_image']; ?>" class="banner-products__bg home-small-img-banner" alt="<?php echo $squareBanner['banner_title']; ?>"></a>
            </div>
        </div>
</main>
<div class="content-wrapper content-wrapper__hits">
    <div class="container">
        <div class="row">
            <div class="heading-line-100">Хиты продаж</div>
            <?php foreach ($latestProducts as $product) { ?>
                <div class="col-16">
                <?php include ROOT. '/views/catalog/product-card.php';?>
                </div>
            <?php } ?>
    </div>
</div>

<div class="container">
    <a href="/category/eco"><img class="banner-100"src="template/images/Stock/banner-100.png"> </a>
</div>

<div class="content-wrapper content-wrapper__news">
    <div class="container">
        <div class="row">
            <div class="heading-line-100">Товары по акции</div>
            <?php foreach ($saleProducts as $product) { ?>
                <div class="col-16">
                <?php include ROOT. '/views/catalog/product-card.php';?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="category-appointment">
    <div class="container">
    <div class="heading-line-100">Популярные категории</div>
        <div class="row under-heading-line-100">
            <div class="col-25">
                <a href="/podcat/kontejnery-pryamougol-nye-s-prozrachnoy-kryshkoy" class="category-appointment__item bg-gradient__custom " title="БУМАЖНЫЕ КОНТЕЙНЕРЫ">
                <img src= "/template/images/index/containers.jpg"class="category-appointment__item_bg">
                    <span class="category-appointment__item_title"> БУМАЖНЫЕ КОНТЕЙНЕРЫ
                    </span>
                </a>
            </div>
            <div class="col-25">
                <a href="/podcat/pakety-bumazhnye-s-ruchkami" class="category-appointment__item bg-gradient__custom" title="БУМАЖНЫЕ ПАКЕТЫ">
                <img src= "/template/images/index/bags.jpg"class="category-appointment__item_bg">
                    <span class="category-appointment__item_title" >БУМАЖНЫЕ ПАКЕТЫ
                    </span>
                </a>
            </div>
            <div class="col-25">
                <a href="/category/bytovaya-himiya"  class="category-appointment__item bg-gradient__custom" title="БЫТОВАЯ ХИМИЯ">
                <img src= "/template/images/index/him.jpg" class="category-appointment__item_bg">
                    <span class="category-appointment__item_title">БЫТОВАЯ ХИМИЯ
                    </span>
                </a>
            </div>
            <div class="col-25">
                <a href="/podcat/vafel-noe-polotno"  class="category-appointment__item bg-gradient__custom" title="ВАФЕЛЬНОЕ ПОЛОТНО">
                <img src= "/template/images/index/vafel.jpg" class="category-appointment__item_bg">
                    <span class="category-appointment__item_title">ВАФЕЛЬНОЕ ПОЛОТНО
                    </span>
                </a>
            </div>
            <div class="col-25">
                <a href="/podcat/nitrilovye-perchatki" class="category-appointment__item bg-gradient__custom" title="ПЕРЧАТКИ">
                <img src= "/template/images/index/perchatki.jpg" class="category-appointment__item_bg">
                    <span class="category-appointment__item_title">ПЕРЧАТКИ
                    </span>
                </a>
            </div>
            <div class="col-25">
                <a href="/podcat/piki-dlya-kanape-iz-bambuka" class="category-appointment__item bg-gradient__custom" title="ПИКИ ДЛЯ КАНАПЕ">
                    <img src="/template/images/index/piki.jpg" class="category-appointment__item_bg" > 
                    <span class="category-appointment__item_title">ПИКИ ДЛЯ КАНАПЕ
                    </span>
                </a>
            </div>
            <div class="col-25">
                <a href="/podcat/upakovka-dlya-piccy" class="category-appointment__item  bg-gradient__custom" title="УПАКОВКА ДЛЯ ПИЦЦЫ">
                    <img src="/template/images/index/pizza-pak.jpg" class="category-appointment__item_bg" > 
                    <span class="category-appointment__item_title">УПАКОВКА ДЛЯ ПИЦЦЫ
                    </span>
                </a>
            </div>
            <div class="col-25">
                <a href="/podcat/furshetnye-formy" class="category-appointment__item bg-gradient__custom" title="ФУРШЕТНЫЕ ФОРМЫ">
                    <img src= "/template/images/index/furshet-form.jpg" class="category-appointment__item_bg">
                    <span class="category-appointment__item_title">ФУРШЕТНЫЕ ФОРМЫ
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="manufacturers">
    <div class="container">
    <div class="heading-line-100">Популярные бренды</div>
        <div class="manufacturers-slider under-heading-line-100">
            <?php foreach ($indexBrand as $oneBrandSlide) { ?>
                <div class="slide">
                    <a href="/brand/<?php echo $oneBrandSlide['brand_name']; ?>" class="manufacturers__box" title="<?php echo $oneBrandSlide['brand_name']; ?>"><img src="/template/images/Brand/<?php echo $oneBrandSlide['brand_logo']; ?>" alt="<?php echo $oneBrandSlide['brand_name']; ?>"></a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<section class="company-description">
    <div class="container">
        <h1 class="description-h1">Лидер – надёжный поставщик одноразовой посуды, хозтоваров и расходных материалов <span class="arrow-down-main-page"><img class="img-arrow-down" src="/template/images/Stock/arrow-bottom-grey.png"></span></h1>
        <div class="box-text-no-show box-text">
            <p>В компании можно заказать различные товары для сегмента HoReCa. Мы занимаемся снабжением ресторанов,
                кафе, отелей, гостиниц, санаториев, пансионатов, баз отдыха. Работаем с салонами красоты и другими
                объектами сферы Wellness & Spa. Наши заказчики – клининговые компании, пищевые производства, службы
                доставки продуктов, госучреждения. У нас можно приобрести товары, как оптом, так и в розницу. Наша
                главная цель – расширение круга постоянных клиентов, поэтому мы всегда предлагаем выгодные условия и
                предоставляем сервис высокого уровня.</p>
            <h2>Одноразовая посуда в Москве</h2>
            <p>Нашим основным направлением деятельности является продажа одноразовой посуды в Москве с возможной
                доставкой в любой другой регион РФ. В отличие от многих других снабжающих организаций у нас есть
                большое складское помещение, поэтому любые виды одноразовой посуды всегда в наличии.</p>
            <p>Мы продаём одноразовые тарелки, бумажные стаканы, салатники, наборы, подносы, пластиковые контейнеры,
                столовые приборы и много другой одноразовой посуды. Доставка осуществляется 6 раз в неделю. Причём
                можно заказать доставку, как в дневное, так и в ночное время.</p>
            <h2>Интернет-магазин хозтоваров</h2>
            <p>Кроме одноразовой посуды, компания «Лидер» предлагает широкий выбор хозяйственных товаров для
                бизнеса. Мы позиционируем себя как интернет-гипермаркет, где можно приобрести буквально всё:
                хозтовары, канцелярские и другие товары для офиса, бытовую и профессиональную химию, спецодежду,
                диспенсеры, инвентарь для уборки, моющие средства. Всего каталог магазина хозтоваров lider-gk24.ru
                насчитывает более 4 тысяч товарных позиций, разделённых по 20-ти категориям.</p>
            <h2>Расходные материалы для бизнеса</h2>
            <p>Любой бизнес независимо от сферы деятельности и масштабов нуждается в расходных материалах. Это могут
                быть канцтовары, средства уборки, средства индивидуальной защиты. И большая удача для владельцев
                бизнеса, когда приобрести все эти товары можно в одной компании в любых количествах, недорого,
                быстро и с доставкой. Именно такой компанией является «Лидер».</p>
            <p>Мы всегда рады сотрудничеству и делаем своим постоянным клиентам ряд заманчивых предложений:</p>
            <ul>
                <li>закрепление постоянного менеджера и оператора для формирования заказов и помощи в выборе;</li>
                <li>участие в программе лояльности;</li>
                <li>предоставление отсрочки платежа на 14 дней.</li>
            </ul>
            <p>Для всех без исключения покупателей мы обеспечиваем практически моментальную обработку заявок,
                быструю отгрузку заказанного товара и его доставку. Причём по Москве в пределах МКАД доставка
                осуществляется нашей курьерской службой, а в другие регионы России – любой транспортной компанией на
                выбор покупателя. Подробнее об условиях доставки и оплате можно узнать на соответствующих страницах
                сайта или, позвонив по указанным телефонам.</p>
            <p>Работайте с компанией «Лидер» и становитесь лидерами!</p>
        </div>
    </div>
</section>
<?php include ROOT . '/views/layouts/footer.php'; ?>