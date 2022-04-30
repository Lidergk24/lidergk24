<?php
/**
 * Контроллер CartController
 */
class SiteController {
    
    // Главная страница
    public function actionIndex() {
        $mainPageSEO = AdminClass::infoThisBizCat(242);
        $title = $mainPageSEO["4"];//'Одноразовая посуда и другие товары для сегмента HoReCa | «Лидер»';
        $description = $mainPageSEO["5"];//'Интернет-магазин предлагает купить одноразовую посуду, хозтовары и расходные материалы для бизнеса. Высокое качество и быстрая доставка гарантированы.';
        $thisHitsProducts = Product::thisHitsProducts();
        $thissaleProducts = Product::thissaleProducts();
        $latestProducts = Product::getLatestProducts($thisHitsProducts["product_part_number"]);
        $saleProducts = Product::getSaleProducts($thissaleProducts["product_part_number"]);
        $indexBrand = Product::indexBrand();
        $allbaner = Product::allbaner();
        $squareBanner = Product::squareBanner()[0];
        $allBusinessCategories = Category::getAllBusinessCategories(); 
        require_once (ROOT . '/views/site/index.php');
        return true;
    }
    
    // Страница контакты
    public function actionContact() {
        $title = 'Контакты | Интернет магазин Lider-gk24.ru';
        $description = 'г. Москва. ул. Угрешская, д. 2, строение 53, телефоны: 8 (800) 222-32-36 или 8 (495) 308-00-69';
        require_once (ROOT . '/views/site/contact.php');   
        return true;
    }
    
    // Страница доставки
    public function actionDelivery() {
        $title = 'Доставка | Интернет магазин Lider-gk24.ru';
        $description = 'Мы доставляем товар по всей России. Стоимость доставки по Москве Вы найдете в этом разделе';
        require_once (ROOT . '/views/site/delivery.php');
        return true;
    }
    
    // Страница оплаты
    public function actionPay() {
        $title = 'Оплата | Интернет магазин Lider-gk24.ru';
        $description = 'Способы оплаты товара в интернет магазине Лидер';
        require_once (ROOT . '/views/site/pay.php');
        return true;
    }
    
    // Страница о нас
    public function actionAbout() {
        $title = 'О компании | Интернет магазин Lider-gk24.ru';
        $description = 'г. Москва. ул. Угрешская, д. 2, строение 53, телефоны: 8 (800) 222-32-36 или 8 (495) 308-00-69';
        require_once (ROOT . '/views/site/about.php');
        return true;
    }
    
    // Страница брендирования
    public function actionBrendirovanie() {
        $title = 'Брендирование | Интернет магазин Lider-gk24.ru';
        $description = 'Нанесение логотипа (брендирование) бумажных пакетов и стаканов для кофе, а так же другой продукции';
        require_once (ROOT . '/views/site/brendirovanie.php');
        return true;
    }
    
    // Страница поиска
    public function actionSearch() {
         if(isset($_POST['search'])){
             $search = htmlspecialchars($_POST['search'], ENT_QUOTES);
         }
         if(isset($_POST['searchMobile'])){
             $search = htmlspecialchars($_POST['searchMobile'], ENT_QUOTES);
         }
         if(isset($_POST['searchFmobile'])){
             $search = htmlspecialchars($_POST['searchFmobile'], ENT_QUOTES);
         }
         if (!empty($search)) { 
            $trimSearch = htmlspecialchars($search, ENT_QUOTES);
            if (strlen($trimSearch) < 3) {
                $text = '<p>Слишком короткий поисковый запрос.</p>';
            } else if (strlen($search) > 50) {
                $text = '<p>Слишком длинный поисковый запрос.</p>';
            } else { 
             $searchFrom = Product::getSearch($trimSearch);
        }    }
        $title = 'Вы искали: ' . $trimSearch . ' - мы кое-что нашли';
        $description = 'Список товаров по запросу ' . $trimSearch;
        require_once (ROOT . '/views/site/search.php');
        return true;
    }
    
    //страница скидки
    public function actionDiscount() {
        $title = 'Акции интернет-магазина Лидер г.Москва';
        $description = 'Мы готовы предоставить скидку на наши товары, получить ее довольно просто';
        $allSales = Product::allSalesView();
        require_once (ROOT . '/views/site/discount.php');
        return true;
    }
    
    // Страница политики конфидинциальности
    public function actionPrivacy() {
        $title = 'Политика конфиденциальности | Интернет магазин Lider-gk24.ru';
        $description = 'Политика конфиденциальности при использовании сайта компании Лидер';
        require_once (ROOT . '/views/site/privacy.php');
        return true;
    }
    
    // Страница поиска по брендам
    public function actionBrand() {
        $brandSearch = $_SERVER['REQUEST_URI'];
        $thisBrand = explode('/', $brandSearch);
        $thisBrandReplace = urldecode($thisBrand[2]);
        $brandModel = Product::brandModel($thisBrandReplace);
        $brandDescription = Product::brandDescription($thisBrandReplace);
        $title = 'Товары бренда ' . $brandDescription["brand_name"];
        $description = 'Купить товары ' . $brandDescription["brand_name"] . ' по самым выгодным ценам';
        require_once (ROOT . '/views/site/brand.php');
        return true;
    }
    
    // Страница поставщикам
    public function actionPostavshchikam() {
        $title = 'Поставщикам | Интернет магазин Lider-gk24.ru';
        $description = 'Все что нужно знать для сотрудничества с нашей компанией';
        require_once (ROOT . '/views/site/postavshchikam.php');
        return true;
    }
    
    // Страница ночная доставка
    public function actionNight() {
        $title = 'Ночная доставка | Интернет магазин Lider-gk24.ru';
        $description = 'Ночная доставка товара созданная для рынка HoReCa от компании ЛИДЕР';
        require_once (ROOT . '/views/site/night.php');
        return true;
    }
    
    // Страница вызов менеджера
    public function actionManager() {
        $title = 'Вызов менеджера | Интернет магазин Lider-gk24.ru';
        $description = 'Пригласите менеджера к себе на объект, он привезет с собой договор и образцы товара';
        
        $company  = !empty($_COOKIE['name_company']) ? $_COOKIE['name_company'] : '';
        $clients = !empty($_COOKIE['nameClient']) ? $_COOKIE['nameClient'] : '';
        $clientsphone = !empty($_COOKIE['phone']) ? $_COOKIE['phone'] : '';
        
        if (isset($_POST['submit'])) {
            
            SetCookie("name_company", $_POST['name_company'], time()+31536000);
            SetCookie("nameClient", $_POST['nameClient'], time()+31536000);
            SetCookie("phone", $_POST['phone'], time()+31536000);
            
            $nameCompany = htmlspecialchars($_POST['name_company']);
            $name_manager = htmlspecialchars($_POST['nameClient']);
            $phone = htmlspecialchars($_POST['phone']);
            $phone_manager = preg_replace('/\s+/', '', preg_replace("/[^,.+0-9]/", '', $phone));
            $ckeckBox = implode(' ', $_POST['checkbox']);

            $errors = false;
            if (strlen($name_manager)<3) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            if (strlen($phone_manager)<11) {
                $errors[] = 'Заполните телефон';
            }
            if ($errors == false) {
               $callMeManager = User::callMeManager($nameCompany, $name_manager, $phone_manager, $ckeckBox);
               require_once 'controllers/SMS_auth/sms.ru.php';
               $smsru = new SMSRU('509E0CA3-4EDA-C574-5753-717EC494989F');
               $data = new stdClass();
               $data->to = $phone_manager;
               $data->text = 'Ваша заявка принята. Ожидайте звонка менеджера. ООО “ЛИДЕР”';
               $sms = $smsru->send_one($data);
                $to  = 'sale@lider-gk24.ru'; 
                $subject = "Поступила заявка на вызов менеджера"; 
                $text = "Клиент заказал заявку на вызов менеджера"."<br>";
                $names = "Имя клиента: ".$name_manager."<br>";
                $nameComp = "Название компании: ".$nameCompany."<br>";
                $phonemanagerClients = "Номер клиента: ".$phone."<br>";
                $interestCat = "Интересующие категории: ".$ckeckBox."<br>";
                $message =  $text.$names.$nameComp.$phonemanagerClients.$interestCat;
                $headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
                $headers .= "From: ООО ЛИДЕР <sale@lider-gk24.ru>\r\n"; 
                $headers .= "Reply-To: sale@lider-gk24.ru\r\n"; 
                mail($to, $subject, $message, $headers);
            } 
        }
        require_once (ROOT . '/views/site/manager.php');
        return true;
    } 
    
    // Страница брендов
    public function actionBrandy() {
        $title = 'Бренды | Интернет магазин Lider-gk24.ru';
        $description = 'В нашем интернет магазине представлено более 150 брендов разных производителей';
        $allBrands = Category::allBrands();
        require_once (ROOT . '/views/site/brandy.php');
        return true;
    }
    
    // Формирование гугл фид
    public function actionGoogle() {
        require_once (ROOT . '/views/site/google.php');
        return true;
    }
    
    // Формирование фида яндекс маркет
    public function actionYandex() {
        require_once (ROOT . '/views/site/yandex.php');
        return true;
    }
    
    // Формирование карты сайта для яндекс
    public function actionSitemap() {
        require_once (ROOT . '/views/site/sitemap.php');
        return true;
    }
    
    // Пользовательское соглашение
    public function actionAgreement() {
        $title = 'Пользовательское соглашение | Интернет магазин Lider-gk24.ru';
        $description = 'Находясь на сайте нашей компании Вы соглашаетесь с пользовательским соглашением';
        require_once (ROOT . '/views/site/agreement.php');
        return true;
    }
    
    // Страница регионам
    public function actionRegion() {
        $title = 'Регионам | Интернет магазин Lider-gk24.ru';
        $description = 'Наша компания осуществляет доставку бытовой и профессиональной химии по всей территории России';
        require_once (ROOT . '/views/site/region.php');
        return true;
    }
    
    // Страница вакансий
    public function actionVacancy() {
        $title = 'Вакансии | Интернет магазин Lider-gk24.ru';
        $description = 'Мы всегда ищем специалистов в данной области. Если Вы хотите работать в ООО Лидер - Вам сюда.';
        require_once (ROOT . '/views/site/vacancy.php');
        return true;
    }
    
    // Страница отсрочки платежа
    public function actionPostponement() {
        $title = 'Возврат товара | Интернет магазин Lider-gk24.ru';
        $description = 'Возврат купленных ранее товаров';
        require_once (ROOT . '/views/site/postponement.php');
        return true;
    }
    
    // формирование отчета
    public function actionSelling() {
        $ordersByToday = Order::ordersByToday();
        require_once (ROOT . '/views/site/selling.php');
        return true;
    }
    
    // Ajax запрос на сортировку банеров
    public function actionSortbaner() {
        $sortBanersIds = $_POST['id'];
        $sortBaners = $_POST['sort'];
        $sortBanersThis = AdminClass::sortBanersThis($sortBanersIds, $sortBaners);
        return true;
    }
    
    // Ajax запрос на сортировку акций
    public function actionSortsales() {
        $sortBanersIds = $_POST['id'];
        $sortBaners = $_POST['sort'];
        $sortBanersThis = AdminClass::sortSales($sortBanersIds, $sortBaners);
        return true;
    }
    
    // Ajax запрос на удаление банера
    public function actionDeletebaner() {
        $deleteBanersIds = $_POST['ids'];
        $imageDeleteIds = $_POST['imageDeleteIds'];
        $filepath = dirname(__DIR__).'/upload/banners/'.$imageDeleteIds;
        unlink($filepath);
        $deleteBanersIdsfunction = AdminClass::deleteBanersIdsfunction($deleteBanersIds);
        echo "success";
        return true;
    }
    
    // Ajax запрос на удаление акции
    public function actionSalesdel() {
        $deleteBanersIds = $_POST['ids'];
        $imageDeleteIds = $_POST['imageDeleteIds'];
        $filepath = dirname(__DIR__).'/upload/banners/'.$imageDeleteIds;
        unlink($filepath);
        $deleteBanersIdsfunction = AdminClass::deleteSales($deleteBanersIds);
        echo "success";
        return true;
    }
    
    // Отправка реквизитов на смс или почту
    public function actionSendproperty() {
        
        if(isset($_POST['phone'])){
            
            $sendProp = $_POST['phone'];
            require_once ($_SERVER['DOCUMENT_ROOT'] .'/controllers/SMS_auth/sms.ru.php');
                        $smsru = new SMSRU('509E0CA3-4EDA-C574-5753-717EC494989F'); 
                        $data = new stdClass();
                        $data->to = $sendProp;
                        $data->text = 'ООО ЛИДЕР'.PHP_EOL.'ИНН 7724421380'.PHP_EOL.'КПП 772401001'.PHP_EOL.'ОГРН 5177746038025'.PHP_EOL.'Р/C 40702810902370002844'.PHP_EOL.'в АО «АЛЬФА-БАНК» г.МОСКВА'.PHP_EOL.'БИК 044525593'.PHP_EOL.'К/С 30101810200000000593'.PHP_EOL.'ОКПО 19743838'.PHP_EOL.'+7 (495) 308-00-69'.PHP_EOL.'Генеральный директор Павлов Анатолий Владимирович, действующий на основании Устава.';
                        $sms = $smsru->send_one($data); 
                        if($sms){
                            echo "success";
                        }
        }
        
        if(isset($_POST['email'])){
            
            $sendPropEmail = $_POST['email'];
            
            $to  = $sendPropEmail; 
            $subject = "Реквизиты ООО Лидер"; 

            $message = ' 
            <p>Реквизиты ООО "Лидер"</p></br> 
            <p>ИНН 7724421380</p></br>     
            <p>КПП 772401001</p></br>
            <p>ОГРН 5177746038025</p></br>
            <p>Р/C 40702810902370002844</p></br>
            <p>в АО «АЛЬФА-БАНК» г. МОСКВА</p></br>
            <p>БИК 044525593</p></br>
            <p>К/С 30101810200000000593</p></br>
            <p>ОКПО 19743838</p></br>
            <p>+7 (495) 308-00-69</p></br>
            <p>Генеральный директор Павлов Анатолий Владимирович, действующий на основании Устава.</p>
            ';
            $headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
            $headers .= "From: ООО ЛИДЕР <sale@lider-gk24.ru>\r\n"; 
            $headers .= "Reply-To: sale@lider-gk24.ru\r\n"; 
            
            mail($to, $subject, $message, $headers);
            
            if(mail){
                 echo "success";
            }
        }
        return true;
    }
    
    // Страница программы лояльности
    public function actionLoyalty() {
        $title = 'Программа лояльности компании Лидер';
        $description = 'Станьте нашим клиентом и накапливайте скидку. Получайте товары со скидкой до 15%';
        require_once (ROOT . '/views/site/Loyalty/Loyalty.php');
        return true;
    }  
    
    // Страница по категориям для бизнеса
    public function actionBusiness() {
        $bizCategory = explode('/', $_SERVER['REQUEST_URI']); 
        $infoCat = Category::infoCat($bizCategory[2]);
        $title = $infoCat['categoryTitle'];
        $description = $infoCat['categoryDescription'];
        $infoPatentCat = Category::infoPatentCat($infoCat["categoryName"]);
        require_once (ROOT . '/views/site/Business/Business.php');
        return true;
    }  
    
}