<?php
  $paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
  $params = include($paramsPath);
  $con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']);  
   
    if ( isset ( $_POST['drop'] ) ) {
        
        $query = mysqli_query($con, "SELECT * FROM Product p LEFT JOIN ProductDropOrder pdo ON p.id=pdo.idProduct WHERE pdo.user_id='".$_POST['drop']."'");
        
        foreach ( $query as $itogOne ) { ?>
        
        <div class="table__body">
            <div class="table-body_line">
                <div class="table__td articles-table__name">
                     <p><a href=""><?php echo $itogOne['product_name']; ?></a></p>
                </div>
                <div class="table__td articles-table__title">
                     <p>Цена: <?php echo $itogOne['product_price']; ?> ₽</p>
                </div>
                <div class="table__td articles-table__description">
                     <p>Количество: <?php echo $itogOne['countProduct']; ?></p>
                </div>
                <div class="table__td articles-table__photo">
                     <div>Код товара: <?php echo $itogOne['product_part_number']; ?></div>
                </div>
            </div>
        </div>
            
    <?php } } ?>