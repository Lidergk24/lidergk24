<?php

$paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
$params = include($paramsPath);
$con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
    if(isset($_POST['operator']) && $_POST['operator'] !=''){
        
       
        $operatorUp = $_POST['operator'];
        
        $infoByOperator = mysqli_query($con, "select * from Operator where operator_name='$operatorUp'");
        $infoByOperatorS = mysqli_fetch_assoc($infoByOperator);
        $order_number = $_POST['order_number'];
        $phone = $_POST['phone'];
        $operatorDob = $infoByOperatorS['operator_dob'];
        $operatorUpdate = mysqli_query($con, "UPDATE `product_order` SET `user_operator`='$operatorUp' WHERE order_number='$order_number'");
    } 
  
    if(isset($_POST['comment']) && $_POST['comment'] !=''){
     
        $commentOperator = $_POST['comment'];
        $nomer = $_POST['nomer'];
        $operatorUpdate = mysqli_query($con, "UPDATE `product_order` SET `order_comment`='$commentOperator' WHERE order_number='$nomer'");
   }
   
    if(isset($_POST['status']) && $_POST['status'] !=''){
   
        $statusOrder = $_POST['status'];
        $statusOrderNumber = $_POST['order_num'];
        $color = $_POST['color'];
        $operatorUpdate = mysqli_query($con, "UPDATE `product_order` SET `order_status`='$statusOrder', `statusColor`='$color' WHERE order_number='$statusOrderNumber'");
        if($operatorUpdate){
            echo "готово";
        }
       
   }
   
   if(isset($_POST['manager']) && $_POST['manager'] !=''){
        $manager = $_POST['manager'];
        $phone = $_POST['phone'];
        $order_numberManager = $_POST['order_numberManager'];
        $operatorUpdate = mysqli_query($con, "UPDATE `product_order` SET `user_manager`='$manager' WHERE order_number='$order_numberManager'");
        $managerUpdate = mysqli_query($con, "UPDATE `user` SET `user_manager`='$manager' WHERE phone='$phone'");

        if($operatorUpdate){
            echo "готово";
        }
       
   }
   
?>