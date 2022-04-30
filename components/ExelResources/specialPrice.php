<?php

$paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
$params = include($paramsPath);
$con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
    if ( 0 < $_FILES['file']['error'] ) {
        
            echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
        
        else {
            
            $fileName = $_FILES['filename']['name'];
            
            $fileNames = md5(uniqid($fileName)) . '.xlsx';
            
            move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] .'/components/ExelResources/specialUpload/' . $fileNames);
        }
    
            require_once 'SimpleXLSX.php';
            
            $del = mysqli_query($con, "DELETE FROM `specialPrice`");
            
            if ( $xlsx = SimpleXLSX::parse('specialUpload/' . $fileNames) ) {
                
                foreach ( $xlsx->rows() as $value ) {
                    
                    $partNumber = $value[3];
                    $itemSpecialPrice = $value[4];
                    
                    if ( $value[2] !='' ) {
                        
                        $inn = $value[2]; 
                        $companyName = htmlspecialchars($value[1]);
                        
                      //  $searchINN = mysqli_query($con, "select * from specialPrice where innCompany='$inn'");
                        
                      //  if ( $searchINN->num_rows==0 ) {
                            
                            $insertINN = mysqli_query($con, "INSERT INTO `specialPrice` (`innCompany`, `companyName` ) VALUES ('$inn', '$companyName')");
                            
                      //  } else {
                            
                        //    $updateINN = mysqli_query($con, "UPDATE `specialPrice` set  `companyName`='$companyName' where innCompany='".$inn."'");
                            
                      //  }
                        
                    }
                    
                   // $searchParentINN = mysqli_query($con, "select * from specialPrice where itemPartNumber='$partNumber' and innParent='$inn'");
                    
                   // if ( $searchParentINN->num_rows==0 ) {
                        
                        $insertPrice = mysqli_query($con, "INSERT INTO `specialPrice` (`itemSpecialPrice`, `itemPartNumber`, `innParent` ) VALUES ('$itemSpecialPrice', '$partNumber', '$inn')");
            
                   // } else {
                        
                  //  $updatePrice = mysqli_query($con, "update specialPrice set itemSpecialPrice='$itemSpecialPrice' where itemPartNumber='$partNumber' and innParent='$inn'");
             
                  //  }
                    
                }
            echo "success";
                
            } else {
                
            	echo SimpleXLSX::parseError();
            	echo "error";
            	
            }