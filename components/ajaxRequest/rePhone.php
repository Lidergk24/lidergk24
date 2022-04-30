<?php

$paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
$params = include($paramsPath);
$con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 

    $newPhone = str_replace([' ', '(', ')', '-'], '', $_POST['nPhone']);
    
    $oldPhone = str_replace([' ', '(', ')', '-'], '', $_POST['oPhone']);
 
    $update = mysqli_query($con, "UPDATE user SET phone = REPLACE(phone, '$oldPhone', '$newPhone') WHERE phone LIKE '%$oldPhone%'");
    
        if ( $update ) {
            
            echo "yes";
            
        }
        
?>