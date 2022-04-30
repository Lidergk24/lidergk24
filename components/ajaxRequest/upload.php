<?php
    $paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
    $params = include($paramsPath);
    $environment =include_once($_SERVER['DOCUMENT_ROOT'] . '/config/environment.php');
    $con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
    $user_ids = $_POST['user_ids'];
    $fileName = $_FILES['userfile']["tmp_name"];
    $fileNames = md5(uniqid($fileName)) . '.jpg';
    $uploaddir = $_SERVER['DOCUMENT_ROOT'] .'/upload/images/'.$fileNames;
        if (move_uploaded_file($fileName, $uploaddir)) {
            $sql = mysqli_query($con, "UPDATE `user` SET `user_avatar`='$fileNames' where phone='$user_ids'");
            header("Location:".$environment["base_url"]."/cabinet/");
                } 
?>