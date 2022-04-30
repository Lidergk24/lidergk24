<?php
session_start();

// Подключение файлов системы
define('ROOT', dirname(__FILE__)."/../../");
require_once(ROOT.'/components/Autoload.php');

// Запись времени обращения пользователя к сайту
$VISIT = new Visit(); unset($VISIT);

$paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
$params = include($paramsPath);
$con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 

if (isset ($_POST['search'])) {

    $ajax = htmlspecialchars($_POST['search'], ENT_QUOTES);

    $query = mysqli_query($con, "SELECT id, product_name, product_image, product_part_number, product_price, price1, price2, price3, priceOpt, product_date, miz_zakaz FROM `Product` t WHERE product_part_number like '%$ajax%' or product_name like '%$ajax%' order by id limit 5");
    
    if ($query->num_rows > 0) {

        foreach ($query as $searchResult) {
            $searchResult['product_site_price'] = $searchResult['product_price'];
    		$searchResult['product_price'] = Special::getUserPrice($searchResult);
            

	?>

            <div class="search__result_line">
                <a href="/product/<?php echo $searchResult['product_part_number']; ?>" class="search__result_image"
                   title="<?php echo $searchResult['product_name']; ?>">
                    <?php foreach (json_decode($searchResult['product_image']) as $imagesCategory) {
                        foreach (array($imagesCategory) as $oneImagescategory) { ?>
                            <img src="/upload/<?php echo $oneImagescategory->{0}; ?>"
                                 alt="<?php echo $searchResult['product_name']; ?>">
                        <?php }
                    } ?>
                </a>
                <div class="search__result_line-content">
                    <a href="/product/<?php echo $searchResult['product_part_number']; ?>"
                       class="search__result_links-wrap">
                        <div class="product-card__article"><?php echo $searchResult['product_name']; ?></div>
                        <div class="code_search_ajax">Код
                            товара: <?php echo $searchResult['product_part_number']; ?></div>
                        <div class="price">
                        <span><?php
                                        $id = User::checkLogged();
                                        $user = User::getUserById($id);
                                        if ((!User::isGuest()) && ($user["specialClient"] == 'yes')) {
                                            echo  '<strike style="color:grey;padding-right: 5px;">' . $searchResult['product_site_price'] . '</strike>';
                                        } ?></span>
                            <?php echo $searchResult['product_price']; ?>
                            <div class="price__currency">₽</div>
                        </div>
                        
                    </a>
                </div>
            </div>
        <?php }
    } ?>
    <div class="line"><a href="" class="all_result">Показать все результаты</a></div>

    <script>

        $('.all_result').click(function (e) {

            e.preventDefault();

            $('.form-search button[type="submit"]').click();

        });

        $('.search__add_card').click(function (e) {

            e.preventDefault();
            var countProductSearch = $(this).closest('.search__add_card').attr('data-product_count');
            $(this).closest('.search__result_line').addClass('block_count_cart');
            var id = $(this).attr("data-id");
            cart_add_ajax(id, countProductSearch);

        });

    </script>

<?php } else { ?>

    <div class="line">ничего не найдено</div>

<?php } ?>