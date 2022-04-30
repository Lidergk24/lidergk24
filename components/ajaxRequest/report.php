<?php

$paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
$params = include($paramsPath);
$con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
$environment = include_once($_SERVER['DOCUMENT_ROOT'] . '/config/environment.php');

$dataS = $_POST['dataS'];

    if ( strlen ( $dataS ) == 10 ) 
    {
       $data =  date("Y-m-d", strtotime($dataS));
       $dataUser = date("d.m.y", strtotime($dataS));
       $totalOrdersToday = mysqli_query($con, "SELECT * from product_order where date like '%$data%'");
       $TotalSummToday =  mysqli_query($con, "SELECT SUM(order_summ) from product_order where date like '%$data%'");
       $TotalSummTodayFetch = mysqli_fetch_assoc($TotalSummToday);
       $newClients = mysqli_query($con, "SELECT * FROM user where registration_date like '%$dataUser%'");
      
    ?>
    <a class="download">Получить отчет по заказам</a>
    <p>Всего заказов за день: <?php echo $totalOrdersToday->num_rows; ?></p>
    <p>Сумма заказов за день: <?php echo round($TotalSummTodayFetch["SUM(order_summ)"], 2); ?> ₽</p>
    <p>Зарегистрировано новых клиентов: <?php echo $newClients->num_rows; ?></p>
    <script>
       $('.download').click(function(){
           var thisTime = $('.dateZak').val();
           $.ajax({
                   type: 'post',
                   url: "/components/ajaxRequest/downLoad.php", 
                   data: { orderDate: thisTime }, 
                    success: function() {
                        $(".download").html("<a class='download' href='<?php  echo $environment["base_url"]; ?>/orders.csv' download>Скачать файл</a>"); 
                    }
            }) 
       });
    </script>
<?php } else {
    
       $twoDare = explode('-', $dataS);
       $date1 = date("Y-m-d", strtotime($twoDare[0]));
       $date2 = date("Y-m-d", strtotime($twoDare[1]));
       
       $userTotal = date("d.m.y", strtotime($twoDare[0]));
       $userTotal1 = date("d.m.y", strtotime($twoDare[1]));
       
       $TotalSummToday =  mysqli_query($con, "SELECT SUM(order_summ) from product_order where `date` >= '$date1' AND `date` <= '$date2 23:59:59'");
       
       $totalOrdersToday = mysqli_query($con, "SELECT * from product_order where `date` >= '$date1' AND `date` <= '$date2 23:59:59'");
       $TotalSummTodayFetch = mysqli_fetch_assoc($TotalSummToday);
       
       $newClients = mysqli_query($con, "SELECT * FROM user WHERE (registration_date >= '$userTotal' AND registration_date <= '$userTotal1')");

       ?>
       <a class="download">Получить отчет по заказам</a>
       <p>Всего заказов за период: <?php echo $totalOrdersToday->num_rows; ?></p>
       <p>Сумма заказов за период: <?php echo round($TotalSummTodayFetch["SUM(order_summ)"], 2); ?> ₽</p>
       <p>Зарегистрировано клиентов: <?php echo $newClients->num_rows; ?></p>
       <script>
         $('.download').click(function(){
            var thisTime = $('.dateZak').val();
            $.ajax({
                   type: 'post',
                   url: "/components/ajaxRequest/downLoad.php", 
                   data: { orderDate: thisTime }, 
                    success: function() {
                        $(".download").html("<a class='download' href='<?php echo $environment["base_url"]; ?>/orders.csv' download>Скачать файл</a>"); 
                    }
            }) 
        });
    </script>
<?php } ?>