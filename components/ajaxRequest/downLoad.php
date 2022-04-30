<?php
$paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
$params = include($paramsPath);
$con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']);  

$orderDate = $_POST['orderDate'];

if ( strlen ( $orderDate ) == 10 ) {
    
    $data =  date("Y-m-d", strtotime($orderDate));
    $ordersByToday = mysqli_query($con, "SELECT user_name, user_phone, user_email, date, order_number, order_summ, user_operator, user_manager, order_status, order_comment FROM product_order WHERE date like '%$data%'");
       $fp = fopen($_SERVER['DOCUMENT_ROOT'] . '/orders.csv', 'w');
    
       foreach($ordersByToday as $ordersByTodayOne){
    
            if(is_array($ordersByTodayOne)) {
                
                foreach ($ordersByTodayOne as $k=>$v) {
                    $ordersByTodayOne[$k] = iconv('utf-8', 'windows-1251', $v);
                }
                
            }
            
            fputcsv($fp, array_unique($ordersByTodayOne), ';');
            
        }
     
        fclose($fp);
    
} 

    else {
         
           $twoDare = explode('-', $orderDate);
           $dataOrder = date("Y.m.d", strtotime($twoDare[0]));
           $dataOrder2 = date("Y.m.d", strtotime($twoDare[1]));
     
           $ordersByToday = mysqli_query($con, "SELECT user_name, user_phone, user_email, date, order_number, order_summ, user_operator, user_manager, order_status, order_comment FROM product_order WHERE `date` >= '$dataOrder' AND `date` <= '$dataOrder2 23:59:59'");
           
           $fp = fopen($_SERVER['DOCUMENT_ROOT'] . '/orders.csv', 'w');
        
           foreach($ordersByToday as $ordersByTodayOne){
        
                if(is_array($ordersByTodayOne)) {
                    
                    foreach ($ordersByTodayOne as $k=>$v) {
                        $ordersByTodayOne[$k] = iconv('utf-8', 'windows-1251', $v);
                    }
                    
                }
                
                fputcsv($fp, array_unique($ordersByTodayOne), ';'); 
                
            }
         
            fclose($fp);
    }

?>