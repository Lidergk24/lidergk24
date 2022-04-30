<?php

$paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
$params = include($paramsPath);
$con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 

if (isset($_POST['phone'])) {

    $phone = $_POST['phone'];
    
    $query = mysqli_query($con, "SELECT * from user where phone like '%$phone%' limit 5");
    
    foreach ( $query as $one ){
        
      echo 'ID клиента: '.$one['id'].'| по номеру: '.$one['phone']; ?> <br> <br> <?php 
        
    }

}



?>