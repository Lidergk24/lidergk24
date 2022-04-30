<?php
   $paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
   $params = include($paramsPath);
   $con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
?>