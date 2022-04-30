<?php

$paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
$params = include($paramsPath);
$con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 

$managerUp = $_POST['manage'];
$phone = $_POST['phone'];

$managerUpdate = mysqli_query($con, "UPDATE `user` SET `user_manager`='$managerUp' WHERE phone='$phone'");
if($managerUpdate){
    echo "success";
}
?>