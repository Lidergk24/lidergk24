<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="utf-8">
   <title><?php echo $title; ?></title>
   <meta name="description" content="<?php echo $description; ?>">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <meta property="og:image" content="path/to/image.jpg">
   <link rel="shortcut icon" href="/template/images/Stock/favicon.svg" type="image/x-icon">
   <meta name="theme-color" content="#000">
   <meta name="msapplication-navbutton-color" content="#000">
   <meta name="apple-mobile-web-app-status-bar-style" content="#000">
   <link rel="stylesheet" href="/template/fonts/Futura/stylesheet.css">
   <link rel="stylesheet" href="/template/css/libs.min.css">
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
   <link rel="stylesheet" href="/template/css/style-v3.min.css">
   <meta name="google-site-verification" content="HQ1e0hTMqRRoARGquG-eVsyZ6Xnj8ce5-uIluLCGH-c" />
   <meta name="yandex-verification" content="7eb1e5cb9043923d" />
   <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-P97NW2V');</script>
    <!-- End Google Tag Manager -->

   <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-225076095-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-225076095-1');
    </script>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P97NW2V"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
   <div class="wrapper">
      <div class="content">
         <div class="mobile-menu">
            <div class="mobile-menu__line">
                <a href="tel:+74953080069" class="contacts-list__phone" style="padding-left:30px; margin: 0 auto">
                     <span class="phone-icon"><img src="/template/images/Stock/phone.png" alt="для Москвы и МО"></span>
                     <span class="phone-text" style="font-size: 13px;">8 (495) 308-00-69</span>
                </a>
               <div class="btn-close__menu" style="margin-right: 10px;"></div>
            </div>

            <ul class="main-menu">
               <ul class="main-menu__item">
                  <ul class="mobile-main-menu-head">
                     <li class="main-menu__item"><a href="/delivery" class="main-menu__links" title="Доставка">Доставка</a></li>
                     <li class="main-menu__item"><a href="/pay" class="main-menu__links" title="Оплата">Оплата</a></li>
                     <li class="main-menu__item"><a href="/contacts" class="main-menu__links" title="Контакты">Контакты</a></li>
                     
                  </ul>
                  <?php $mainCat = Category::CategorySimpleList();
                  for ($i = 0; $i < count($mainCat); $i++) { ?>
                     <li class="new-dropdown-menu-item">
                        <a href="<?php echo '/category/' . $mainCat[$i]["cat_slug"] ?>" class="menu-category__links" title="<?php echo $mainCat[$i]["cat_parent"] ?>"> <?php echo $mainCat[$i]["cat_parent"] ?> </a>
                     </li>
                  <?php } ?>

                  <!-- <li class="new-dropdown-menu-item"><a href="/custom" class="menu-category__links" title="Товары под заказ">Товары под заказ</a></li> -->

               </ul>
            </ul>

         </div>
         <div class="footer__menu_mobile">
            <a href="/" class="menu__fixed" title="Главная">
               <span class="menu__fixed_icon">
                  <img src="/template/images/Stock/home.svg" alt="Домой">
               </span>
               <span class="menu__fixed_text">Главная</span>
            </a>
            <a href="/discount" class="menu__fixed" title="Акции">
               <span class="menu__fixed_icon">
                  <img src="/template/images/Stock/price-tag.svg" alt="Акции">
               </span>
               <span class="menu__fixed_text">Акции</span>
            </a>
            <a href="/cart" class="menu__fixed" title="Корзина">
               <span class="menu__fixed_icon">
                  <img src="/template/images/Stock/cart.svg" alt="Корзина">
               </span>
               <span class="menu__fixed_text">Корзина</span>
            </a>
            <a <?php if (User::isGuest()) {
                  echo 'href="/user/login"';
               } else {
                  echo 'id="cabinet_icon"';
               } ?> class="menu__fixed" title="Кабинет">
               <span class="menu__fixed_icon">
                  <img src="/template/images/Stock/user.svg" alt="Личный кабинет">
               </span>
               <span class="menu__fixed_text">Кабинет</span>
            </a>
         </div>
         <div class="form-search__mobile">
            <form method="post" action="/search" class="form-search">
               <label><input type="text" maxlength="50" name="searchFmobile" class="searchFoterMobile" placeholder="" required autocomplete="off"></label>
               <button type="submit" name="submit" class="btn"><img src="/template/images/Stock/search.png" alt="Поиск"></button>
            </form>
         </div>


         <header class="header">
            <div class="header__top">
               <div class='new-sale'><a class="new-sale-discount" href="/discount">АКЦИИ</a></div>
               <div class="container container-evenly">
                  <div class="main-menu__item"><a class="main-menu__links" title="Наш адрес"><span class="pin" style='background-image:url("/template/images/Stock/pin.svg")'></span>МОСКВА</a></div>
                  <div class="main-menu__item"><a href="/brendirovanie" class="main-menu__links" title="Брендирование">Брендирование</a></div>
                  <div class="main-menu__item"><a href="/delivery" class="main-menu__links" title="Доставка">Доставка</a></div>
                  <div class="main-menu__item"><a href="/pay" class="main-menu__links" title="Оплата">Оплата</a></div>
                  <div class="main-menu__item"><a href="/contacts" class="main-menu__links" title="Контакты">Контакты</a></div>
                    <?php if(AdminController::checkAdmin() === true) { ?>
                        <div class="main-menu__item"><a href="/admin" class="main-menu__links" title="Контакты">Админ</a></div>
                    <?php } ?>
                  <div class="main-menu__item"><a href="/upload/price/price.pdf" download="LIDER-<?php echo Date("m/d/y"); ?>.pdf" class="main-menu__links" title="Скачать прайс"><span class="pin" style='background-image:url("/template/images/Stock/download.svg")'></span>ПРАЙС</a></div>
                  <div class="main-menu__item"><a href='tel:+74953080069' class="main-menu__links" title="Телефон">8&nbsp;(495)&nbsp;308-00-69</a></div>

               </div>
            </div>
            <div class="header__center">
               <div class="container">
                  <div class="header__center_wrapper d-flex flex-column align-items-start">
                     <div class="header__center_bottom header__center_line w-100">
                        <a href="/" class="logo" title="Главная">

                           <span class="logo__img"><img src="/template/images/Stock/logo.png" alt="lider-gk24.ru"></span>
                        </a>
                        <div class="search-menu-container">
                           <div class="menu-button-container">
                              <button class='button-catalog dropdown-T' onclick='dropDownShow()'> <span class='dropdown-T'>Каталог</span></button>
                              <div class="dropdown-container">
                              <ul class="new-dropdown-menu-list dropdown-T">
                              
                                 <li class="new-dropdown-menu-item dropdown-T dropdown-links">
                                    <a href="/category/konteynery-i-upakovka-odnorazovaya" class="menu-category__links" title="ОДНОРАЗОВЫЕ КОНТЕЙНЕРЫ">
                                       КОНТЕЙНЕРЫ ДЛЯ ЕДЫ </a>
                                 </li>
                                 <div class="dropdown-podcat">

                                    <a href="/category/eco" class="h1-podcat-link podcat-link" data-aff_id="контейнеры для еды" title="УПАКОВКА ИЗ ЭКО-КАРТОНА"> Бумажные контейнеры </a>
                                    <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/konteynery-oneclick" class="sub-sub-menu-link">
                                       Контейнеры OneClick </a>
                                    <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/konteynery-dlya-konditerov" class="sub-sub-menu-link">
                                       Контейнеры для кондитеров </a>
                                    <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/konteynery-dlya-supa" class="sub-sub-menu-link">
                                       Контейнеры для супа </a>
                                    <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/konteynery-kruglye-s-prozrachnoy-kryshkoy" class="sub-sub-menu-link">
                                       Контейнеры круглые с прозрачной крышкой </a>
                                    <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/konteynery-na-vynos" class="sub-sub-menu-link">
                                       Контейнеры на вынос </a>
                                    <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/konteynery-s-prozrachnoy-kryshkoy" class="sub-sub-menu-link">
                                       Контейнеры с прозрачной крышкой </a>
                                    <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/konteynery-universal-nye" class="sub-sub-menu-link">
                                       Контейнеры универсальные </a>
                                    <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/salatniki-kruglye-s-prozrachnoy-kryshkoy" class="sub-sub-menu-link">
                                       Салатники круглые с прозрачной крышкой </a>
                                    <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/kontejnery-pryamougol-nye-s-prozrachnoy-kryshkoy" class="sub-sub-menu-link">
                                       Контейнеры прямоугольные с прозрачной крышкой </a>
                                    <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/tarelki-bumazhnye" class="sub-sub-menu-link">
                                       Тарелки бумажные </a>
                                    <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/upakovka-dlya-lapshi" class="sub-sub-menu-link">
                                       Упаковка для лапши </a>
                                    <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/upakovka-dlya-sendvichey-i-rollov" class="sub-sub-menu-link">
                                       Упаковка для сэндвичей и роллов </a>
                                    <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/upakovka-dlya-fast-fuda" class="sub-sub-menu-link">
                                       Упаковка для фаст-фуда </a>

                                    <a href="/category/konteynery-i-upakovka-odnorazovaya" data-aff_id="контейнеры для еды" class="h1-podcat-link podcat-link" title="ОДНОРАЗОВЫЕ КОНТЕЙНЕРЫ"> Пластиковые контейнеры </a>
                                       <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/banki-supovye" class="sub-sub-menu-link">
                                          Банки суповые </a>
                                       <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/vedra-germetichnye" class="sub-sub-menu-link">
                                          Ведра герметичные </a>
                                       <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/kasaletki-formy-alyuminievye" class="sub-sub-menu-link">
                                          Касалетки, формы алюминиевые </a>
                                       <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/konteynery-dlya-goryachego-kruglye-s-kryshkoy" class="sub-sub-menu-link">
                                          Контейнеры для горячего круглые с крышкой </a>
                                       <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/konteynery-dlya-goryachego-pryamougol-nye-s-kryshkoy" class="sub-sub-menu-link">
                                          Контейнеры для горячего прямоугольные с крышкой </a>
                                       <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/konteynery-dlya-konditerskih-izdeliy" class="sub-sub-menu-link">
                                          Контейнеры для кондитерских изделий </a>
                                       <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/konteynery-dlya-sushi" class="sub-sub-menu-link">
                                          Контейнеры для суши </a>
                                       <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/konteynery-pod-zapayku" class="sub-sub-menu-link">
                                          Контейнеры под запайку </a>
                                       <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/konteynery-s-neraz-emnoy-kryshkoy" class="sub-sub-menu-link">
                                          Контейнеры с неразьемной крышкой </a>
                                       <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/konteynery-s-raz-emnoy-kryshkoy" class="sub-sub-menu-link">
                                          Контейнеры с разъемной крышкой </a>
                                       <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/kremanki-stakanchiki-desertnye" class="sub-sub-menu-link">
                                          Креманки, стаканчики десертные </a>
                                       <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/salatniki" class="sub-sub-menu-link">
                                          Салатники </a>
                                       <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/sousniki" class="sub-sub-menu-link">
                                          Соусники </a>
                                       <a class="podcat-link" data-aff_id="контейнеры для еды" href="/podcat/termoboksy" class="sub-sub-menu-link">
                                          Термобоксы </a>
                                 </div>
                                 <li class="new-dropdown-menu-item dropdown-T dropdown-links">
                                    <a href="/category/odnorazovaya-posuda" class="menu-category__links" title="ОДНОРАЗОВАЯ ПОСУДА"> ОДНОРАЗОВАЯ ПОСУДА </a>
                                 </li>
                                 <div class="dropdown-podcat">
                                 <a href="/category/odnorazovaya-posuda" data-aff_id="одноразовая посуда" class="h1-podcat-link podcat-link" title="ОДНОРАЗОВАЯ ПОСУДА"> Одноразовая посуда</a>
                                    <a class="podcat-link" data-aff_id="одноразовая посуда" href="/podcat/butylki" class="sub-sub-menu-link">
                                       Бутылки </a>
                                    <a class="podcat-link" data-aff_id="одноразовая посуда" href="/podcat/derzhateli-dlya-stakanov-iz-pul-perkartona" class="sub-sub-menu-link">
                                       Держатели для стаканов из пульперкартона </a>
                                    <a class="podcat-link" data-aff_id="одноразовая посуда" href="/podcat/podnosy" class="sub-sub-menu-link">
                                       Подносы </a>
                                    <a class="podcat-link" data-aff_id="одноразовая посуда" href="/podcat/posuda-iz-vspenennogo-polistirola" class="sub-sub-menu-link">
                                       Посуда из вспененного полистирола </a>
                                    <a class="podcat-link" data-aff_id="одноразовая посуда" href="/podcat/razmeshivateli" class="sub-sub-menu-link">
                                       Размешиватели </a>
                                    <a class="podcat-link" data-aff_id="одноразовая посуда" href="/podcat/stakany-bumazhnye-i-kryshki-k-nim" class="sub-sub-menu-link">
                                       Стаканы бумажные и крышки к ним </a>
                                    <a class="podcat-link" data-aff_id="одноразовая посуда" href="/podcat/stakany-plastikovye-i-kryshki-k-nim" class="sub-sub-menu-link">
                                       Стаканы пластиковые и крышки к ним </a>
                                    <a class="podcat-link" data-aff_id="одноразовая посуда" href="/podcat/stolovye-pribory" class="sub-sub-menu-link">
                                       Столовые приборы </a>
                                    <a class="podcat-link" data-aff_id="одноразовая посуда" href="/podcat/tarelki-plastikovye" class="sub-sub-menu-link">
                                       Тарелки пластиковые </a>
                                       <a href="/category/bio" data-aff_id="одноразовая посуда" class="h1-podcat-link podcat-link" title="БИОРАЗЛАГАЕМАЯ ПОСУДА"> Биоразлагаемая посуда </a>
                                    <a class="podcat-link" data-aff_id="одноразовая посуда" href="/podcat/biorazlagaemye-konteynery" class="sub-sub-menu-link">
                                       Биоразлагаемые контейнеры </a>
                                    <a class="podcat-link" data-aff_id="одноразовая посуда" href="/podcat/biorazlagaemye-pribory" class="sub-sub-menu-link">
                                       Биоразлагаемые приборы </a>
                                    <a class="podcat-link" data-aff_id="одноразовая посуда" href="/podcat/biorazlagaemye-stakany" class="sub-sub-menu-link">
                                       Биоразлагаемые стаканы </a>
                                    <a class="podcat-link" data-aff_id="одноразовая посуда" href="/podcat/biorazlagaemye-tarelki" class="sub-sub-menu-link">
                                       Биоразлагаемые тарелки </a>
                                   
                                    <a href="/category/posuda-furhet" data-aff_id="одноразовая посуда" class="h1-podcat-link podcat-link" title="ПОСУДА ДЛЯ ФУРШЕТА"> Посуда для фуршета </a>

                                    <a class="podcat-link" data-aff_id="одноразовая посуда" href="/podcat/bokaly" class="sub-sub-menu-link">
                                       Бокалы </a>
                                    <a class="podcat-link" data-aff_id="одноразовая посуда" href="/podcat/tarelki" class="sub-sub-menu-link">
                                       Тарелки </a>
                                    <a class="podcat-link" data-aff_id="одноразовая посуда" href="/podcat/furshetnye-formy" class="sub-sub-menu-link">
                                       Фуршетные формы </a>

                                    
                                 </div>
                                 <li class="new-dropdown-menu-item dropdown-T dropdown-links">
                                    <a href="/category/bytovaya-himiya" class="menu-category__links" title="БЫТОВАЯ ХИМИЯ"> БЫТОВАЯ ХИМИЯ </a>
                                 </li>
                                 <div class="dropdown-podcat">
                                 <a href="/category/bytovaya-himiya" data-aff_id="бытовая химия" class="h1-podcat-link podcat-link" title="БЫТОВАЯ ХИМИЯ"> Бытовая химия </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/zhiroudaliteli" class="sub-sub-menu-link">
                                       Жироудалители </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/antistatiki-kondicionery-dlya-odezhdy" class="sub-sub-menu-link">
                                       Кондиционеры для белья </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/mylo-zhidkoe" class="sub-sub-menu-link">
                                       Мыло жидкое </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/mylo-kuskovoe" class="sub-sub-menu-link">
                                       Мыло кусковое </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/osvezhiteli-vozduha" class="sub-sub-menu-link">
                                       Освежители воздуха </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/osvezhiteli-dlya-unitazov-i-pissuarov" class="sub-sub-menu-link">
                                       Освежители для унитазов и писсуаров </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/otbelivateli" class="sub-sub-menu-link">
                                       Отбеливатели </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/poliroli-dlya-mebeli" class="sub-sub-menu-link">
                                       Полироли для мебели </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/pyatnovyvoditeli" class="sub-sub-menu-link">
                                       Пятновыводители </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/sredstva-dlya-myt-ya-polov-i-napol-nyh-pokrytiy" class="sub-sub-menu-link">
                                       Средства для мытья полов и напольных покрытий </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/sredstva-dlya-myt-ya-posudy" class="sub-sub-menu-link">
                                       Средства для мытья посуды </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/sredstva-dlya-posudomoechnyh-mashin-i-parokonvektomatov" class="sub-sub-menu-link">
                                       Средства для посудомоечных машин и пароконвектоматов </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/sredstva-dlya-stekol-i-zerkal" class="sub-sub-menu-link">
                                       Средства для стекол и зеркал </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/sredstva-dlya-udaleniya-nakipi" class="sub-sub-menu-link">
                                       Средства для удаления накипи </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/sredstva-ot-nasekomyh" class="sub-sub-menu-link">
                                       Средства от насекомых </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/stiral-nye-poroshki" class="sub-sub-menu-link">
                                       Стиральные порошки </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/universal-nye-chistyaschie-sredstva" class="sub-sub-menu-link">
                                       Универсальные чистящие средства </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/chistyaschie-sredstva-dlya-kuhni" class="sub-sub-menu-link">
                                       Чистящие средства для кухни </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/chistyaschie-sredstva-dlya-santehniki" class="sub-sub-menu-link">
                                       Чистящие средства для сантехники </a>
                                    <a href="/category/prof-himiya" data-aff_id="бытовая химия" class="h1-podcat-link podcat-link" title="ПРОФЕССИОНАЛЬНАЯ ХИМИЯ"> Профессиональная химия</a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/prof-akssesuary-dlya-ubokri" class="sub-sub-menu-link">
                                       Акссесуары для уборки </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/prof-zhidkoe-mylo" class="sub-sub-menu-link">
                                       Жидкое мыло </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/prof-zhiroudaliteli" class="sub-sub-menu-link">
                                       Жироудалители </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/prof-sredstva-dlya-myt-ya-polov-i-napol-nyh-pokrytiy" class="sub-sub-menu-link">
                                       Средства для мытья полов и напольных покрытий </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/prof-sredstva-dlya-myt-ya-posudy" class="sub-sub-menu-link">
                                       Средства для мытья посуды </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/prof-sredstva-dlya-stirki" class="sub-sub-menu-link">
                                       Средства для стирки </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/prof-universal-nye-chistyaschie-sredstva" class="sub-sub-menu-link">
                                       Универсальные чистящие средства </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/prof-chistyaschie-sredstva-dlya-santehniki" class="sub-sub-menu-link">
                                       Чистящие средства для сантехники </a>
                                       <a href="/category/desinfection" data-aff_id="бытовая химия" class="h1-podcat-link podcat-link" title="ДЕЗИНФИЦИРУЮЩИЕ СРЕДСТВА"> Дезинфицирующие средства </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/dezinficiruyuschie-sredstva-dlya-poverhnostey" class="sub-sub-menu-link">
                                       Дезинфицирующие средства для поверхностей </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/dezinficiruyuschie-sredstva-dlya-ruk" class="sub-sub-menu-link">
                                       Дезинфицирующие средства для рук </a>
                                    <a class="podcat-link" data-aff_id="бытовая химия" href="/podcat/dispensery-dlya-dezinficiruyuschih-sredstv" class="sub-sub-menu-link">
                                       Диспенсеры для дезинфицирующих средств </a>
                                   
                                 </div>
                                 <li class="new-dropdown-menu-item dropdown-T dropdown-links">
                                    <a href="/category/inventar-i-materialy-dlya-uborki" class="menu-category__links" title="ИНВЕНТАРЬ ДЛЯ УБОРКИ"> ИНВЕНТАРЬ ДЛЯ УБОРКИ </a>
                                 </li>
                                 <div class="dropdown-podcat">
                                 <a href="/category/inventar-i-materialy-dlya-uborki" data-aff_id="инвентарь для уборки" class="h1-podcat-link podcat-link" title="ИНВЕНТАРЬ ДЛЯ УБОРКИ"> Инвентарь для уборки </a>
                                    <a class="podcat-link" data-aff_id="инвентарь для уборки" href="/podcat/baki-i-korziny-dlya-musora" class="sub-sub-menu-link">
                                       Баки и корзины для мусора </a>
                                    <a class="podcat-link" data-aff_id="инвентарь для уборки" href="/podcat/vantuzy-ershi" class="sub-sub-menu-link">
                                       Вантузы, ерши </a>
                                    <a class="podcat-link" data-aff_id="инвентарь для уборки" href="/podcat/vafel-noe-polotno" class="sub-sub-menu-link">
                                       Вафельное полотно </a>
                                    <a class="podcat-link" data-aff_id="инвентарь для уборки" href="/podcat/vedra-telezhki-uborochnye" class="sub-sub-menu-link">
                                       Ведра, тележки уборочные</a>
                                    <a class="podcat-link" data-aff_id="инвентарь для уборки" href="/podcat/veniki-metly" class="sub-sub-menu-link">
                                       Веники, мётлы </a>
                                    <a class="podcat-link" data-aff_id="инвентарь для уборки" href="/podcat/grabli-cherenki" class="sub-sub-menu-link">
                                       Грабли, черенки </a>
                                    <a class="podcat-link" data-aff_id="инвентарь для уборки" href="/podcat/gubki-mochalki" class="sub-sub-menu-link">
                                       Губки, мочалки </a>
                                    <a class="podcat-link" data-aff_id="инвентарь для уборки" href="/podcat/meshki-dlya-musora" class="sub-sub-menu-link">
                                       Мешки для мусора </a>
                                    <a class="podcat-link" data-aff_id="инвентарь для уборки" href="/podcat/mop-rukoyatki-dlya-shvabry" class="sub-sub-menu-link">
                                       Мопы, рукоятки для швабры </a>
                                    <a class="podcat-link" data-aff_id="инвентарь для уборки" href="/podcat/salfetki-universal-nye" class="sub-sub-menu-link">
                                       Салфетки универсальные </a>
                                    <a class="podcat-link" data-aff_id="инвентарь для уборки" href="/podcat/sgony-skrebki" class="sub-sub-menu-link">
                                       Сгоны, скребки </a>
                                    <a class="podcat-link" data-aff_id="инвентарь для уборки" href="/podcat/sovki-schetki" class="sub-sub-menu-link">
                                       Совки, щетки </a>
                                    <a class="podcat-link" data-aff_id="инвентарь для уборки" href="/podcat/tryapki-dlya-pola" class="sub-sub-menu-link">
                                       Тряпки для пола </a>
                                    <a href="/category/dispensery" data-aff_id="инвентарь для уборки"  class="h1-podcat-link podcat-link" title="ДИСПЕНСЕРЫ"> Диспенсеры</a>
                                    <a class="podcat-link" data-aff_id="инвентарь для уборки" href="/podcat/dispensery-dlya-bumazhnyh-polotenec" class="sub-sub-menu-link">
                                       Диспенсеры для бумажных полотенец </a>
                                    <a class="podcat-link" data-aff_id="инвентарь для уборки" href="/podcat/dispensery-dlya-myla" class="sub-sub-menu-link">
                                       Диспенсеры для мыла </a>
                                    <a class="podcat-link" data-aff_id="инвентарь для уборки" href="/podcat/dispensery-dlya-nastol-nyh-salfetok" class="sub-sub-menu-link">
                                       Диспенсеры для настольных салфеток </a>
                                    <a class="podcat-link" data-aff_id="инвентарь для уборки" href="/podcat/dispensery-dlya-osvezhiteley-vozduha" class="sub-sub-menu-link">
                                       Диспенсеры для освежителей воздуха </a>
                                    <a class="podcat-link" data-aff_id="инвентарь для уборки" href="/podcat/dispensery-dlya-protirochnyh-materialov" class="sub-sub-menu-link">
                                       Диспенсеры для протирочных материалов </a>
                                    <a class="podcat-link" data-aff_id="инвентарь для уборки" href="/podcat/dispensery-dlya-tualetnoy-bumagi" class="sub-sub-menu-link">
                                       Диспенсеры для туалетной бумаги </a>

                                   
                                 </div>
                                 <li class="new-dropdown-menu-item dropdown-T dropdown-links">
                                    <a href="/category/gigiena" class="menu-category__links" title="СРЕДСТВА ГИГИЕНЫ"> Средства гигиены </a>
                                 </li>
                                 <div class="dropdown-podcat"> <a class="podcat-link" data-aff_id="средства гигиены" href="/podcat/kosmeticheskie-tovary" class="sub-sub-menu-link">
                                       Одноразовые наборы для гостиниц </a>
                                    <a class="podcat-link" data-aff_id="средства гигиены" href="/podcat/pokrytiya-na-unitaz" class="sub-sub-menu-link">
                                       Покрытия на унитаз </a>
                                    <a class="podcat-link" data-aff_id="средства гигиены" href="/podcat/polotenca-bumazhnye-v-rulonah" class="sub-sub-menu-link">
                                       Полотенца бумажные в рулонах </a>
                                    <a class="podcat-link" data-aff_id="средства гигиены" href="/podcat/polotenca-bumazhnye-listovye" class="sub-sub-menu-link">
                                       Полотенца бумажные листовые </a>
                                    <a class="podcat-link" data-aff_id="средства гигиены" href="/podcat/protirochnye-materialy" class="sub-sub-menu-link">
                                       Протирочные материалы </a>
                                    <a class="podcat-link" data-aff_id="средства гигиены" href="/podcat/salfetki-vlazhnye-i-kosmeticheskie" class="sub-sub-menu-link">
                                       Салфетки влажные и косметические </a>
                                    <a class="podcat-link" data-aff_id="средства гигиены" href="/podcat/salfetki-dlya-dispensera" class="sub-sub-menu-link">
                                       Салфетки для диспенсера </a>
                                    <a class="podcat-link" data-aff_id="средства гигиены" href="/podcat/tualetnaya-bumaga" class="sub-sub-menu-link">
                                       Туалетная бумага </a>
                                 </div>
                                 <li class="new-dropdown-menu-item dropdown-T dropdown-links">
                                    <a href="/category/tovary-dlya-ofisa" class="menu-category__links" title="ТОВАРЫ ДЛЯ ОФИСА"> Канцтовары</a>
                                 </li>
                                 <div class="dropdown-podcat"> <a class="podcat-link" data-aff_id="канцтовары" href="/podcat/blanki-buhgalterskie-knigi-ucheta" class="sub-sub-menu-link">
                                       Бланки бухгалтерские, книги учета </a>
                                    <a class="podcat-link" data-aff_id="канцтовары" href="/podcat/bumaga-bloknoty-tetradi" class="sub-sub-menu-link">
                                       Бумага, блокноты, тетради </a>
                                    <a class="podcat-link" data-aff_id="канцтовары" href="/podcat/zhurnaly-dlya-restoranov" class="sub-sub-menu-link">
                                       Журналы для ресторанов </a>
                                    <a class="podcat-link" data-aff_id="канцтовары" href="/podcat/karandashi-ruchki" class="sub-sub-menu-link">
                                       Карандаши, ручки </a>
                                    <a class="podcat-link" data-aff_id="канцтовары" href="/podcat/lenta-kassovaya-etiketki-cenniki" class="sub-sub-menu-link">
                                       Лента кассовая, этикетки, ценники </a>
                                    <a class="podcat-link" data-aff_id="канцтовары" href="/podcat/markery" class="sub-sub-menu-link">
                                       Маркеры </a>
                                    <a class="podcat-link" data-aff_id="канцтовары" href="/podcat/ofisnye-prinadlezhnosti" class="sub-sub-menu-link">
                                       Офисные принадлежности </a>
                                    <a class="podcat-link" data-aff_id="канцтовары" href="/podcat/papki" class="sub-sub-menu-link">
                                       Папки </a>
                                    <a class="podcat-link" data-aff_id="канцтовары" href="/podcat/skotch-kancelyarskiy-i-upakovochnyy" class="sub-sub-menu-link">
                                       Скотч канцелярский и упаковочный </a>
                                    <a class="podcat-link" data-aff_id="канцтовары" href="/podcat/steplery-skoby" class="sub-sub-menu-link">
                                       Степлеры, скобы </a>
                                 </div>
                                 <li class="new-dropdown-menu-item dropdown-T dropdown-links">
                                    <a href="/category/professional-naya-odezhda" class="menu-category__links" title="ПРОФЕССИОНАЛЬНАЯ ОДЕЖДА"> ОДНОРАЗОВАЯ ОДЕЖДА</a>
                                 </li>
                                 <div class="dropdown-podcat"> 
                                    <a class="podcat-link" data-aff_id="одноразовая одежда" href="/podcat/bahily-i-tapochki" class="sub-sub-menu-link">
                                       Бахилы и тапочки </a>
                                    <a class="podcat-link" data-aff_id="одноразовая одежда" href="/podcat/golovnye-ubory" class="sub-sub-menu-link">
                                       Головные уборы </a>
                                    <a class="podcat-link" data-aff_id="одноразовая одежда" href="/podcat/fartuki-halaty" class="sub-sub-menu-link">
                                       Фартуки, халаты </a>
                                 </div>
                                 <li class="new-dropdown-menu-item dropdown-T dropdown-links">
                                    <a href="/category/upakovka" class="menu-category__links" title="ОДНОРАЗОВАЯ УПАКОВКА"> ОДНОРАЗОВАЯ УПАКОВКА </a>
                                 </li>
                                 <div class="dropdown-podcat"> <a class="podcat-link" data-aff_id="одноразовая упаковка" href="/podcat/bumaga-obertochnaya" class="sub-sub-menu-link">
                                       Бумага оберточная </a>
                                    <a class="podcat-link" data-aff_id="одноразовая упаковка" href="/podcat/gofrokoroba" class="sub-sub-menu-link">
                                       Гофрокороба </a>
                                    <a class="podcat-link" data-aff_id="одноразовая упаковка" href="/podcat/plenka-palletnaya" class="sub-sub-menu-link">
                                       Пленка паллетная </a>
                                    <a class="podcat-link" data-aff_id="одноразовая упаковка" href="/podcat/plenka-pischevaya" class="sub-sub-menu-link">
                                       Пленка пищевая </a>
                                    <a class="podcat-link" data-aff_id="одноразовая упаковка" href="/podcat/podlozhki-iz-vspenennogo-polistirola" class="sub-sub-menu-link">
                                       Подложки из вспененного полистирола </a>
                                    <a class="podcat-link" data-aff_id="одноразовая упаковка" href="/podcat/podlozhki-iz-pul-perkartona" class="sub-sub-menu-link">
                                       Подложки из пульперкартона </a>
                                    <a class="podcat-link" data-aff_id="одноразовая упаковка" href="/podcat/upakovka-dlya-buterbrodov-i-sendvichey" class="sub-sub-menu-link">
                                       Упаковка для бутербродов и сэндвичей </a>
                                    <a class="podcat-link" data-aff_id="одноразовая упаковка" href="/podcat/upakovka-dlya-piccy" class="sub-sub-menu-link">
                                       Упаковка для пиццы </a>
                                    <a class="podcat-link" data-aff_id="одноразовая упаковка" href="/podcat/upakovka-dlya-tortov-i-pirozhennyh" class="sub-sub-menu-link">
                                       Упаковка для тортов и пироженных </a>
                                    <a class="podcat-link" data-aff_id="одноразовая упаковка" href="/podcat/fol-ga" class="sub-sub-menu-link">
                                       Фольга </a>
                                 </div>
                                 <li class="new-dropdown-menu-item dropdown-T dropdown-links">
                                    <a href="/category/paket" class="menu-category__links" title="ПАКЕТЫ"> ПАКЕТЫ </a>
                                 </li>
                                 <div class="dropdown-podcat"> <a class="podcat-link" data-aff_id="пакеты" href="/podcat/pakety-bumazhnye-bez-ruchek" class="sub-sub-menu-link">
                                       Пакеты бумажные без ручек </a>
                                    <a class="podcat-link" data-aff_id="пакеты" href="/podcat/pakety-bumazhnye-s-ruchkami" class="sub-sub-menu-link">
                                       Пакеты бумажные с ручками </a>
                                    <a class="podcat-link" data-aff_id="пакеты" href="/podcat/pakety-bumazhnye-universal-nye" class="sub-sub-menu-link">
                                       Пакеты бумажные универсальные </a>
                                    <a class="podcat-link" data-aff_id="пакеты" href="/podcat/pakety-vakuumnye" class="sub-sub-menu-link">
                                       Пакеты вакуумные </a>
                                    <a class="podcat-link" data-aff_id="пакеты" href="/podcat/pakety-mayka" class="sub-sub-menu-link">
                                       Пакеты майка </a>
                                    <a class="podcat-link" data-aff_id="пакеты" href="/podcat/pakety-fasovochnye" class="sub-sub-menu-link">
                                       Пакеты фасовочные </a>
                                 </div>
                                 <li class="new-dropdown-menu-item dropdown-T dropdown-links">
                                    <a href="/category/pershatki" class="menu-category__links" title="ПЕРЧАТКИ"> ПЕРЧАТКИ </a>
                                 </li>
                                 <div class="dropdown-podcat"> <a class="podcat-link" data-aff_id="перчатки" href="/podcat/vinilovye-perchatki" class="sub-sub-menu-link">
                                       Виниловые перчатки </a>
                                    <a class="podcat-link" data-aff_id="перчатки" href="/podcat/lateksnye-perchatki" class="sub-sub-menu-link">
                                       Латексные перчатки </a>
                                    <a class="podcat-link" data-aff_id="перчатки" href="/podcat/nitrilovye-perchatki" class="sub-sub-menu-link">
                                       Нитриловые перчатки </a>
                                    <a class="podcat-link" data-aff_id="перчатки" href="/podcat/polietilenovye-perchatki" class="sub-sub-menu-link">
                                       Полиэтиленовые перчатки </a>
                                    <a class="podcat-link" data-aff_id="перчатки" href="/podcat/rabochie-perchatki" class="sub-sub-menu-link">
                                       Рабочие перчатки </a>
                                    <a class="podcat-link" data-aff_id="перчатки" href="/podcat/rezinovye-perchatki" class="sub-sub-menu-link">
                                       Резиновые перчатки </a>
                                 </div>

                                 <li class="new-dropdown-menu-item dropdown-T dropdown-links">
                                    <a href="/category/predmety-servirovki-stola" class="menu-category__links" title="ПРЕДМЕТЫ СЕРВИРОВКИ СТОЛА"> ПРЕДМЕТЫ СЕРВИРОВКИ СТОЛА </a>
                                 </li>
                                 <div class="dropdown-podcat"> <a class="podcat-link" data-aff_id="предметы сервировки стола" href="/podcat/dekorativnye-ukrasheniya-iz-dereva" class="sub-sub-menu-link">
                                       Декоративные украшения из дерева </a>
                                    <a class="podcat-link" data-aff_id="предметы сервировки стола" href="/podcat/dekorativnye-ukrasheniya-iz-plastika" class="sub-sub-menu-link">
                                       Декоративные украшения из пластика </a>
                                    <a class="podcat-link" data-aff_id="предметы сервировки стола" href="/podcat/zubochistki" class="sub-sub-menu-link">
                                       Зубочистки </a>
                                    <a class="podcat-link" data-aff_id="предметы сервировки стола" href="/podcat/palochki-dlya-sushi" class="sub-sub-menu-link">
                                       Палочки для суши </a>
                                    <a class="podcat-link" data-aff_id="предметы сервировки стола" href="/podcat/piki-dlya-kanape-iz-bambuka" class="sub-sub-menu-link">
                                       Пики для канапе из бамбука </a>
                                    <a class="podcat-link" data-aff_id="предметы сервировки стола" href="/podcat/piki-dlya-kanape-iz-plastika" class="sub-sub-menu-link">
                                       Пики для канапе из пластика </a>
                                    <a class="podcat-link" data-aff_id="предметы сервировки стола" href="/podcat/porcionnye-sol-sahar-perec" class="sub-sub-menu-link">
                                       Порционные соль, сахар, перец </a>
                                    <a class="podcat-link" data-aff_id="предметы сервировки стола" href="/podcat/salfetki-bumazhnye" class="sub-sub-menu-link">
                                       Салфетки бумажные </a>
                                    <a class="podcat-link" data-aff_id="предметы сервировки стола" href="/podcat/salfetki-servirovochnye" class="sub-sub-menu-link">
                                       Салфетки сервировочные </a>
                                    <a class="podcat-link" data-aff_id="предметы сервировки стола" href="/podcat/svechi" class="sub-sub-menu-link">
                                       Свечи </a>
                                    <a class="podcat-link" data-aff_id="предметы сервировки стола" href="/podcat/skaterti" class="sub-sub-menu-link">
                                       Скатерти </a>
                                    <a class="podcat-link" data-aff_id="предметы сервировки стола" href="/podcat/trubochki-dlya-kokteyley-bumazhnye" class="sub-sub-menu-link">
                                       Трубочки для коктейлей бумажные </a>
                                    <a class="podcat-link" data-aff_id="предметы сервировки стола" href="/podcat/trubochki-dlya-kokteyley-plastikovye" class="sub-sub-menu-link">
                                       Трубочки для коктейлей пластиковые </a>
                                    <a class="podcat-link" data-aff_id="предметы сервировки стола" href="/podcat/shpazhki-dlya-shashlyka" class="sub-sub-menu-link">
                                       Шпажки для шашлыка </a>
                                 </div>
                              
                                
                                 <li class="new-dropdown-menu-item dropdown-T dropdown-links">
                                    <a href="/category/tovary-dliya-konditera" class="menu-category__links" title="ТОВАРЫ ДЛЯ КОНДИТЕРА"> ТОВАРЫ ДЛЯ КОНДИТЕРА </a>
                                 </li>
                                 <div class="dropdown-podcat"> <a class="podcat-link" data-aff_id="товары для кондитера" href="/podcat/bumaga-dlya-vypechki-i-prigotovleniya-pischi" class="sub-sub-menu-link">
                                       Бумага для выпечки и приготовления пищи </a>
                                    <a class="podcat-link" data-aff_id="товары для кондитера" href="/podcat/konditerskie-meshki-i-lenty" class="sub-sub-menu-link">
                                       Кондитерские мешки и ленты </a>
                                    <a class="podcat-link" data-aff_id="товары для кондитера" href="/podcat/podnosy-kond" class="sub-sub-menu-link">
                                       Кондитерские подносы </a>
                                    <a class="podcat-link" data-aff_id="товары для кондитера" href="/podcat/podlozhki-laminirovannye" class="sub-sub-menu-link">
                                       Подложки ламинированные </a>
                                    <a class="podcat-link" data-aff_id="товары для кондитера" href="/podcat/tartaletki" class="sub-sub-menu-link">
                                       Тарталетки </a>
                                    <a class="podcat-link" data-aff_id="товары для кондитера" href="/podcat/formy-dlya-kulichey" class="sub-sub-menu-link">
                                       Формы для куличей </a>
                                    <a class="podcat-link" data-aff_id="товары для кондитера" href="/podcat/formy-dlya-pirogov-i-keksov" class="sub-sub-menu-link">
                                       Формы для пирогов и кексов </a>
                                 </div>
                                 <li class="new-dropdown-menu-item dropdown-T dropdown-links">
                                    <a href="/category/tovary-dlya-kuhni" class="menu-category__links" title="ТОВАРЫ ДЛЯ КУХНИ"> ТОВАРЫ ДЛЯ КУХНИ </a>
                                 </li>
                                 <div class="dropdown-podcat"> <a class="podcat-link" data-aff_id="товары для кухни" href="/podcat/drova-i-ugol" class="sub-sub-menu-link">
                                       Дрова и уголь </a>
                                    <a class="podcat-link" data-aff_id="товары для кухни" href="/podcat/kuhonnye-prinadlezhnosti" class="sub-sub-menu-link">
                                       Кухонные принадлежности </a>
                                    <a class="podcat-link" data-aff_id="товары для кухни" href="/podcat/pakety-dlya-l-da-i-zamorazhivaniya" class="sub-sub-menu-link">
                                       Пакеты для льда и замораживания </a>
                                    <a class="podcat-link" data-aff_id="товары для кухни" href="/podcat/sredstva-dlya-rozzhiga" class="sub-sub-menu-link">
                                       Средства для розжига </a>
                                    <a class="podcat-link" data-aff_id="товары для кухни" href="/podcat/toplivo-dlya-marmitov" class="sub-sub-menu-link">
                                       Топливо для мармитов </a>
                                 </div>
                                
                                 <li class="new-dropdown-menu-item dropdown-T dropdown-links">
                                    <a href="/category/dliya-salonov-krasoty" class="menu-category__links" title="РАСХОДНЫЕ МАТЕРИАЛЫ ДЛЯ САЛОНА КРАСОТЫ"> РАСХОДНЫЕ МАТЕРИАЛЫ ДЛЯ САЛОНА КРАСОТЫ </a>
                                 </li>
                                 <div class="dropdown-podcat"> <a class="podcat-link" data-aff_id="расходные материалы для салона красоты" href="/podcat/dezinfekciya" class="sub-sub-menu-link">
                                       Дезинфекция </a>
                                    <a class="podcat-link" data-aff_id="расходные материалы для салона красоты" href="/podcat/odnorazovaya-odezhda" class="sub-sub-menu-link">
                                       Одноразовая одежда </a>
                                    <a class="podcat-link" data-aff_id="расходные материалы для салона красоты" href="/podcat/odnorazovye-polotenca" class="sub-sub-menu-link">
                                       Одноразовые полотенца </a>
                                    <a class="podcat-link" data-aff_id="расходные материалы для салона красоты" href="/podcat/odnorazovye-prostyni" class="sub-sub-menu-link">
                                       Одноразовые простыни </a>
                                    <a class="podcat-link" data-aff_id="расходные материалы для салона красоты" href="/podcat/rashodnye-materialy" class="sub-sub-menu-link">
                                       Расходные материалы </a>
                                 </div>
                              
                                
                                 

                                 <?php
                                 $id =  $_SESSION['user'];
                                 $user = User::getUserById($id);
                                 $selectINNUser = User::selectINNUser($id);
                                 $selectSpecialPrice = User::selectSpecialPrice($selectINNUser['ur_inn']);
                                 if ((!User::isGuest()) && ($user["specialClient"] == 'yes') && !empty($selectSpecialPrice)) { ?>
                                    <li class="new-dropdown-menu-item "><a href="/special" class="menu-category__links font-700" title="Специальные цены для вашего бизнеса">МОИ СПЕЦЦЕНЫ</a></li>
                                 <?php } ?>
                              </ul>
                              </div>
                           </div>
                           <div class="form-search__wrapper">
                              <form method="post" action="/search" class="form-search">
                                 <label><input type="text" maxlength="50" name="search" class="search" placeholder="" required autocomplete="off"></label>
                                 <button type="submit" name="submit" class="btn btn-loop">🔎︎</button>
                                 <div class="search__result"></div>
                              </form>
                           </div>
                        </div>

                        <div class='login-cart-container'>
                           <?php if (User::isGuest()) { ?>
                              <a href="/user/login" class="header__links" title="Вход">
                                 <span class="header__links_icon"><img src="/template/images/Stock/user.svg" alt="Вход"></span>
                                 <span class="header__links_text">Войти</span>
                              </a>
                           <?php } else { ?>
                              <a href="/cabinet" class="header__links" title="Личный кабинет">
                                 <span class="header__links_icon"><img src="/template/images/Stock/user.svg" alt="Личный кабинет"></span>
                                 <span class="header__links_text">Кабинет</span>
                              </a>
                           <?php } ?>
                           <div>
                              <a href="/cart" class="basket__wrapper">
                                 <div class="basket__icon" title="Корзина">
                                    <img src="/template/images/Stock/cart.svg" alt="Корзина">
                                    <span class="basket__val"><?php echo Cart::countItems(); ?></span>
                                 </div>
                                 <div class="basket__box">

                                    <div class="basket__box_sum" title="Сумма">
                                       <?php
                                       $productsInCart = Cart::getProductsId();
                                       if ($productsInCart) {
                                          $products = Cart::getProducts();
                                          $totalPrice = $products['TotalPrice'];
                                          $allS = Cart::Calculate();
                                          echo $allS->TotalPrice; ?>
                                          <span class="basket__box_sum_currency">₽</span>
                                       <?php } else { ?> <span class="basket__box_sum_currency">0₽</span> <?php } ?>
                                    </div>
                                 </div>
                              </a>
                           </div>
                        </div>
                     </div>
                     <div class="header__center_mobile">
                        <a href="/" class="logo" title="Главная">
                           <span class="logo__img"><img src="/template/images/Stock/logo.png" alt="lider-gk24.ru"></span>
                        </a>
                        <div class="btn-burger">
                        </div>
                        <div class="form-search__wrapper">
                           <form method="post" action="/search" class="form-search">
                              <label><input type="text" maxlength="50" class="search_mobile" name="searchMobile" placeholder="" required></label>
                              <button type="submit" name="submit" class="btn btn-loop">🔎︎</button>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>

               <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/views/cabinet/Index/CabinetMenu.php"); ?>
         </header>