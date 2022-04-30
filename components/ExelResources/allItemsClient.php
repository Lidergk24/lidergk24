<?php

$paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
$params = include($paramsPath);
$con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
require_once 'SimpleXLSX.php';

$DELETE = mysqli_query($con, 'DELETE FROM `ProductItemsClient`');

if ( $xlsx = SimpleXLSX::parse('allItems.xlsx') ) {
    
    foreach ( $xlsx->rows() as $value ) {
        
        $partNumber = $value[3];
        
        if ( strlen($value[1]) == 10 || strlen($value[1]) == 12 ) {
            
            $inn = $value[1];
            
            $companyName = htmlspecialchars($value[2]);

           // $searchINN = mysqli_query($con, "select * from ProductItemsClient where innCompany='$inn'");
            
           // if ( $searchINN->num_rows == 0 ) {
                
                $insertINN = mysqli_query($con, "INSERT INTO `ProductItemsClient` (`innCompany`, `companyName` ) VALUES ('$inn', '$companyName')");
                
           // } else {
                
             //   $updateINN = mysqli_query($con, "UPDATE `ProductItemsClient` set `companyName`='$companyName' where innCompany='".$inn."'");
                
          //  } 
            
        } 
        
       // $searchParentINN = mysqli_query($con, "select * from ProductItemsClient where itemPartNumber='$partNumber' and innParent='$inn'");
        
      //  if ( $searchParentINN->num_rows == 0 ) {
            
            $insertPrice = mysqli_query($con, "INSERT INTO `ProductItemsClient` (`itemPartNumber`, `innParent` ) VALUES ('$partNumber', '$inn')");
            echo "INSERT INTO `ProductItemsClient` (`itemPartNumber`, `innParent` ) VALUES ('$partNumber', '$inn')"; echo "<br>";

       // } else {
            
         //   $updatePrice = mysqli_query($con, "update ProductItemsClient set companyName='$companyName' where itemPartNumber='$partNumber' and innParent='$inn'");
 
       // } 
        
    } 
    
} else {
    
	echo SimpleXLSX::parseError();
	
}