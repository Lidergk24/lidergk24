<?php
header('Content-Type: text/xml; charset=utf-8');
echo '<?xml version="1.0"?>'."\n".
'<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">'."\n".
	'<channel>'."\n".
		'<title>ООО ЛИДЕР</title>'."\n".
		'<link>https://lider-gk24.ru</link>'."\n".
		'<description>Одноразовая посуда - снабжение ресторанов и кафе. Рынок HoReCa</description>'."\n";
		$paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
		$params = include($paramsPath);
		$con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']); 
		$sql = mysqli_query($con, "SELECT id, product_name, product_description, product_image, product_price, product_article, product_part_number, product_brand, barcode from Product where product_warehouse>0");
        while ($rest = mysqli_fetch_assoc($sql)) {
            if($rest['product_price'] !='' && $rest['product_image'] !='[{}]') {
		echo '<item>'."\n";
		echo "<g:id>{$rest['id']}</g:id>"."\n";
		echo "<g:title>{$rest['product_name']}</g:title>"."\n";
    	    if($rest['product_description'] ==''){
    		     echo "<g:description>Товар {$rest['product_name']} оптовые цены и быстрая доставка</g:description>"."\n";
    	    } else {
    		     echo "<g:description>{$rest['product_description']}</g:description>"."\n";
    	    }
		echo "<g:link>https://lider-gk24.ru/product/{$rest['product_part_number']}</g:link>"."\n";
		foreach (json_decode($rest['product_image']) as $imagesCategory){
            foreach(array($imagesCategory) as $oneImagescategory){
                if($oneImagescategory->{0} !=''){
                    $imagesO = $oneImagescategory->{0};
                    echo "<g:image_link>https://lider-gk24.ru/upload/$imagesO</g:image_link>"."\n";
        }   }   };
		echo "<g:condition>new</g:condition>"."\n";
		echo "<g:availability>in_stock</g:availability>"."\n";
			echo "<g:price>{$rest['product_price']} RUB</g:price>"."\n";
			echo "<g:country>RU</g:country>"."\n";
			echo "<g:brand>{$rest['product_brand']}</g:brand>"."\n";
			echo "<g:gtin>{$rest['barcode']}</g:gtin>"."\n";
		echo '</item>'."\n";
		} };
	echo '</channel>'.
'</rss>';
?>