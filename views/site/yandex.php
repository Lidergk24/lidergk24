<?php 
header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="utf-8" ?>'."\n".
'<!DOCTYPE yml_catalog SYSTEM "shops.dtd">'."\n\n".
	"<yml_catalog date=\"".date('Y-m-d H:i')."\">\n".
	"<shop>\n".
	"<name>".'ЛИДЕР - HoReCa'."</name>\n".
	"<company>".'ООО ЛИДЕР'."</company>\n".
	"<url>".'https://lider-gk24.ru'."</url>\n\n".
	"<currencies>\n".
	"\t".'<currency id="RUB" rate="1"/>'."\n".
	"</currencies>\n\n".
	"<categories>\n";
    $paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
	$params = include($paramsPath);
	$con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); ;   
    $sql = mysqli_query($con, "SELECT * from Product_category");
    foreach($sql as $category){
        echo "<category id='{$category['cat_id']}'>{$category['cat_name']}</category>";
    }
    echo "</categories>";
	$sql1 = mysqli_query($con, "SELECT id, product_name, product_description, product_category, product_image, product_price, product_article, product_part_number, product_brand, miz_zakaz from Product where miz_zakaz='1' and product_warehouse>0 and product_category 
	
	in(
	    '45a5982b-b787-11ea-80f0-00155d0ae503', 
	    '45a5982a-b787-11ea-80f0-00155d0ae503', 
	    '45a59829-b787-11ea-80f0-00155d0ae503', 
	    '233079b8-97e0-11e9-80e6-00155d0ae503',
	    '233079b7-97e0-11e9-80e6-00155d0ae503',
	    '233079b6-97e0-11e9-80e6-00155d0ae503',
	    '5cfdb553-3aac-11ea-80ee-00155d0ae503',
	    'af161f37-b22e-11e1-a824-e0cb4e34a945',
	    'dba4bd8b-9202-11e7-80d3-00155d0ae503',
	    '153ab88c-95e1-11e2-aa88-5404a6b25ec1',
	    'd4348f33-efbc-11e3-ac89-7446a0fe3124',
	    '35bb1141-70ed-11e6-80fd-f46d0499d05e',
	    'c2a7c717-8ebe-11e6-8103-f46d0499d05e',
	    'af161f5d-b22e-11e1-a824-e0cb4e34a945',
	    'b893fd03-ed76-11e4-8a03-7446a0fe3124',
	    'a917b1e5-b22e-11e1-a824-e0cb4e34a945',
	    'a917b1f1-b22e-11e1-a824-e0cb4e34a945',
	    'dfca0889-fa95-11e3-8a54-7446a0fe3124',
	    'a917b1f7-b22e-11e1-a824-e0cb4e34a945',
	    'a917b1f8-b22e-11e1-a824-e0cb4e34a945',
	    'a917b266-b22e-11e1-a824-e0cb4e34a945',
	    'a917b1f4-b22e-11e1-a824-e0cb4e34a945',
	    'a917b329-b22e-11e1-a824-e0cb4e34a945',
	    '707d2331-5bd8-11e3-8de4-7446a0fe3124',
	    '2f7867e0-d836-11e4-ad58-7446a0fe3124',
	    'af161ea4-b22e-11e1-a824-e0cb4e34a945',
	    '5cfdb548-3aac-11ea-80ee-00155d0ae503',
	    '5cfdb549-3aac-11ea-80ee-00155d0ae503',
	    '2f7867e1-d836-11e4-ad58-7446a0fe3124',
	    '5587122c-3c69-11e3-83fd-7446a0fe3124',
	    '5587122b-3c69-11e3-83fd-7446a0fe3124',
	    '5cfdb54b-3aac-11ea-80ee-00155d0ae503',
	    '6a809c5e-3cda-11ea-80ee-00155d0ae503',
	    '0a05b380-d9e2-11e4-8a45-7446a0fe3124',
	    '0a05b381-d9e2-11e4-8a45-7446a0fe3124',
	    '0a05b383-d9e2-11e4-8a45-7446a0fe3124',
	    '5cfdb558-3aac-11ea-80ee-00155d0ae503',
	    'af161eba-b22e-11e1-a824-e0cb4e34a945',
	    'a917b1eb-b22e-11e1-a824-e0cb4e34a945',
	    'ab4e7f59-ca14-11e3-9243-7446a0fe3124',
	    'a917b247-b22e-11e1-a824-e0cb4e34a945',
	    '82348be8-24f8-11e3-83b6-7446a0fe3124',
	    'bcd528ac-383f-11ea-80ee-00155d0ae503',
	    'bcd528a8-383f-11ea-80ee-00155d0ae503',
	    '55871206-3c69-11e3-83fd-7446a0fe3124',
	    '55871229-3c69-11e3-83fd-7446a0fe3124',
	    '55871227-3c69-11e3-83fd-7446a0fe3124',
	    '55871205-3c69-11e3-83fd-7446a0fe3124',
	    'b0b1d45e-134e-11e5-a56a-7446a0fe3124',
	    '5cfdb550-3aac-11ea-80ee-00155d0ae503',
	    'a917b1e3-b22e-11e1-a824-e0cb4e34a945',
	    '5cfdb556-3aac-11ea-80ee-00155d0ae503',
	    '5cfdb557-3aac-11ea-80ee-00155d0ae503',
	    '5cfdb559-3aac-11ea-80ee-00155d0ae503',
	    '5587121e-3c69-11e3-83fd-7446a0fe3124',
	    'af161eba-b22e-11e1-a824-e0cb4e34a945',
	    '55871216-3c69-11e3-83fd-7446a0fe3124',
	    'a917b1e9-b22e-11e1-a824-e0cb4e34a945',
	    '55871217-3c69-11e3-83fd-7446a0fe3124',
	    '5587121c-3c69-11e3-83fd-7446a0fe3124'
	    
	    )");
	echo "<offers>\n\n";
    foreach($sql1 as $item) {
        if($item['product_price'] !='' && $item['product_image'] !='[{}]'){
        $catIds = $item['product_category'];
        echo "<offer id='{$item['id']}' available='true'>\n";
        echo "\t<url>https://lider-gk24.ru/product/{$item['product_part_number']}</url>\n";
        echo "\t<price>{$item['product_price']}</price>\n";
        echo "\t<currencyId>RUB</currencyId>\n";
        $cat_id = mysqli_query($con, "Select cat_id from Product_category where cat_code='$catIds'");
        foreach($cat_id as $catIdsMarket) {
        echo "\t<categoryId>{$catIdsMarket['cat_id']}</categoryId>\n";
        }
        foreach (json_decode($item['product_image']) as $imagesCategory){
            foreach(array($imagesCategory) as $oneImagescategory){
                if($oneImagescategory->{0} !=''){
                    $imagesO = $oneImagescategory->{0};
                   echo "\t<picture>https://lider-gk24.ru/upload/{$imagesO}</picture>\n";
        }   }   };
        echo "\t<delivery>true</delivery>\n";
        echo "\t<description>{$item['product_description']}</description>\n";
        echo "\t<vendorCode>{$item['product_article']}</vendorCode>\n";
        echo "\t<name>{$item['product_name']}</name>\n";
        echo "\t<sales_notes>Самовывоза нет!</sales_notes>\n";
        echo "</offer>\n"; 
    } }
    echo "</offers>\n\n";
    echo "</shop>\n";
    echo "</yml_catalog>\n";