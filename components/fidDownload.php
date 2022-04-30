<?php
include_once('Db.php');
$environment = include_once($_SERVER['DOCUMENT_ROOT'] . '/config/environment.php');

try {
    if(isset($_POST['prod_code']) and $_POST['parse_type'] == 'prod') {
        $prod = $_POST['prod_code'];
        $paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
        $params = include($paramsPath);
        $con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 

        $data_fid = mysqli_query($con, 'select * from fids where prod_id ="'.$prod.'" and category_stat = 1 order by date_created desc limit 1');
        $fidArray = [];
        while ($row = $data_fid->fetch_assoc()) {
            $fidArray[] = $row;
        }
        $fid_yml = "<yml_catalog date=\"{$fidArray[0]['date_created']}\">\n";
        $fid_yml .= "  <offer id=\"{$fidArray[0]['prod_id']}\">\n";
        $fid_yml .= "    <url>http://lider-gk24.ru/product/{$fidArray[0]['prod_id']}</url>\n";
        $fid_yml .= "    <price>{$fidArray[0]['price']}</price>\n";
        $fid_yml .= "    <name>{$fidArray[0]['name']}</name>\n";
        $fid_yml .= "    <currencyId>RUB</currencyId>\n";
        $fid_yml .= "    <categoryId>{$fidArray[0]['categoryId']}</categoryId>\n";
        //$fid_yml .= "    <country_of_origin>{$fidArray[0]['country_of_origin']}</country_of_origin>\n";
        $fid_yml .= "    <vendor>{$fidArray[0]['vendor']}</vendor>\n";
        $fid_yml .= "    <picture>{$fidArray[0]['picture']}</picture>\n";
        $fid_yml .= "    <sales_notes>{$fidArray[0]['sales_notes']}</sales_notes>\n";
        $fid_yml .= "    <delivery>true</delivery>\n";
        $fid_yml .= "  </offer>\n";
        $fid_yml .= "</yml_catalog>";
        $fDescriptor = $_SERVER['DOCUMENT_ROOT']."/upload/fids/fid__{$fidArray[0]['prod_id']}.yml";
        if(file_exists($fDescriptor)) {
            unlink($fDescriptor);
        }
        file_put_contents($fDescriptor, $fid_yml, FILE_APPEND | LOCK_EX);
        readfile("/upload/fids/fid__{$fidArray[0]['prod_id']}.yml");
       
        echo $fDescriptor;
    }
    else if(isset($_POST['prod_code']) and $_POST['parse_type'] == 'cat') {
        $cat = $_POST['prod_code'];
        $paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
        $params = include($paramsPath);
        $con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
        $date = mysqli_query($con, 'select date_created from fids where categoryId ="'.$cat.'" and category_stat = 2 order by date_created desc limit 1');
        $fid_date = '';
        foreach($date as $i => $d) {
            $fid_date = $d['date_created'];
        }
        $data_fid = mysqli_query($con, 'select * from fids where categoryId ="'.$cat.'" and category_stat = 2');
        $fidArray = [];
        $fid_yml = "<yml_catalog date=\"{$fid_date}\">\n";
        
        //$data = $data_fid->fetch_assoc();
        while($data = $data_fid->fetch_assoc()) {
            //foreach($data as $key => $line) {
                $fid_yml .= "  <offer id=\"{$data['prod_id']}\">\n";
                $fid_yml .= "    <url>http://lider-gk24.ru/product/{$data['prod_id']}</url>\n";
                $fid_yml .= "    <price>{$data['price']}</price>\n";
                $fid_yml .= "    <name>{$data['name']}</name>\n";
                $fid_yml .= "    <currencyId>RUB</currencyId>\n";
                $fid_yml .= "    <categoryId>{$data['categoryId']}</categoryId>\n";
                //$fid_yml .= "    <country_of_origin>{$fidArray[0]['country_of_origin']}</country_of_origin>\n";
                if(isset($data['vendor'])) {
                    $fid_yml .= "    <vendor>{$data['vendor']}</vendor>\n";
                }
                $fid_yml .= "    <picture>https://lider-gk24.ru/upload/import_files/{$data['picture']}</picture>\n";
                $fid_yml .= "    <sales_notes>{$data['sales_notes']}</sales_notes>\n";
                $fid_yml .= "    <delivery>true</delivery>\n";
                $fid_yml .= "  </offer>\n";
            //}
        }
        
        $fid_yml .= "</yml_catalog>";
        $fDescriptor = $_SERVER['DOCUMENT_ROOT']."/upload/fids/fid__{$cat}.yml";
        if(file_exists($fDescriptor)) {
            unlink($fDescriptor);
        }
        file_put_contents($fDescriptor, $fid_yml, FILE_APPEND | LOCK_EX);
        readfile("/upload/fids/fid__{$cat}.yml");
       
        echo $fDescriptor;
    }
    else if($_POST['parse_type'] == 'all') {
        $paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
        $params = include($paramsPath);
        $con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
        $date = mysqli_query($con, 'select date_created from fids where category_stat = 3 order by date_created desc limit 1');
        $fid_date = '';
        foreach($date as $i => $d) {
            $fid_date = $d['date_created'];
        }
        $data_fid = mysqli_query($con, 'select * from fids where category_stat = 3');
        $fidArray = [];
        $fid_yml = "<yml_catalog date=\"{$fid_date}\">\n";
        
        //$data = $data_fid->fetch_assoc();
        while($data = $data_fid->fetch_assoc()) {
            //foreach($data as $key => $line) {
                $fid_yml .= "  <offer id=\"{$data['prod_id']}\">\n";
                $fid_yml .= "    <url>http://lider-gk24.ru/product/{$data['prod_id']}</url>\n";
                $fid_yml .= "    <price>{$data['price']}</price>\n";
                $fid_yml .= "    <name>{$data['name']}</name>\n";
                $fid_yml .= "    <currencyId>RUB</currencyId>\n";
                $fid_yml .= "    <categoryId>{$data['categoryId']}</categoryId>\n";
                //$fid_yml .= "    <country_of_origin>{$fidArray[0]['country_of_origin']}</country_of_origin>\n";
                if(isset($data['vendor'])) {
                    $fid_yml .= "    <vendor>{$data['vendor']}</vendor>\n";
                }
                $fid_yml .= "    <picture>https://lider-gk24.ru/upload/import_files/{$data['picture']}</picture>\n";
                $fid_yml .= "    <sales_notes>{$data['sales_notes']}</sales_notes>\n";
                $fid_yml .= "    <delivery>true</delivery>\n";
                $fid_yml .= "  </offer>\n";
            //}
        }
        
        $fid_yml .= "</yml_catalog>";
        $fDescriptor = $_SERVER['DOCUMENT_ROOT']."/upload/fids/fid__all.yml";
        if(file_exists($fDescriptor)) {
            unlink($fDescriptor);
        }
        file_put_contents($fDescriptor, $fid_yml, FILE_APPEND | LOCK_EX);
        readfile("/upload/fids/fid__all.yml");
       
        echo $fDescriptor;
    }
} catch (Throwable $e) {
    print "Application called exception: { $e->getMessage() }";
}
?>
 