<?php

$paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
$params = include($paramsPath);
$con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
    var_dump($_POST);
    $inn = $_POST['inn'];
    
    $sqlDate = mysqli_query($con, "SELECT user_id from user_ur where ur_phone = $inn");
    
    $sqlDate1 = mysqli_fetch_assoc($sqlDate);
    
    $id = $sqlDate1["user_id"];

        if ( isset ( $_POST['m'] ) ) {
            
            $manager = $_POST['m'];
            
            $managerBase = mysqli_query($con, "UPDATE `user` SET `user_manager`='$manager' WHERE id=$id");
            
            echo "success";
            
        }
         
        if ( isset ( $_POST['o'] ) ) {
             
            $operator = $_POST['o'];
            
            $managerBase = mysqli_query($con, "UPDATE `user` SET `user_operator`='$operator' WHERE id=$id");
            
            echo "success";
             
        }
        
        if ( isset ( $_POST['s'] ) ) {
             
            $s = $_POST['s'];

            $statBase = mysqli_query($con, "UPDATE `user` SET `specialClient`='$s' WHERE id=$id");
            
            echo "success";
             
        }
        
        if ( isset ( $_POST['cena'] ) ) {
             
            $c = $_POST['cena'];
            
            $statBase = mysqli_query($con, "UPDATE `user` SET `specialClientPrice`='$c' WHERE id=$id");
            
            echo "success";
             
        }

?>