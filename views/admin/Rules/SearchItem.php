<?php

$paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
$params = include($paramsPath);
$con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
   
    if (isset($_POST['searchItem'])) {

       $searchItem = $_POST['searchItem'];
       $query = mysqli_query($con, "Select * from Product where product_part_number like '%$searchItem%' order by id limit 4");
       
        if ($query->num_rows>0) { 
            foreach ($query as $searchResult) { ?>
               
                    <div class="line">
                        <div class="title_search_ajax"><?php echo $searchResult['product_name']; ?></div>
                        <div class="image_search_ajax">
                            <?php foreach (json_decode($searchResult['product_image']) as $imagesCategory) {
                                    foreach(array($imagesCategory) as $oneImagescategory){ ?>
                                        <img src="/upload/<?php echo $oneImagescategory->{0}; ?>" alt="<?php echo $searchResult['product_name']; ?>" width="70">
                            <?php } } ?>
                        </div>
                        <div class="code_search_ajax">Код товара: <?php echo $searchResult['product_part_number']; ?></div>
                    </div>
                    <?php } ?>
                    <?php } else{ ?>   
                    <div class="line">ничего не найдено</div>
    <?php } } ?>