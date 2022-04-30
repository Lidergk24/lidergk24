<?php include ROOT . '/views/cabinet/Index/Header.php'; 
    if($user["specialClient"]=='yes'){ ?>
    <ul class="breadcrumb breadcrumb-cabinet">
                <li><a href="/index.php" title="Главная"><span>ГЛАВНАЯ</span></a></li>
                <li><a><span>СПЕЦЦЕНЫ</span></a></li>
    </ul>
    <?php 
        $totalItems = SpecialPriceLogic::getProducts();
	    $SpecialPrices = Array();
	    
	    foreach ($selectSpecialPrice as $next) {
	        
		$code = trim($next['itemPartNumber']);
		$price = trim($next['itemSpecialPrice']);
		if ($code && $price) $SpecialPrices[$code] = $price;
		
	    }
       
	    $specialItems = Special::getProdustsByPartNumbers(array_keys($SpecialPrices));
	    
	    $specialCodes = [];
	    
	    foreach( $selectSpecialPrice as $codes ) {
	        
	        $specialCodes[$k] = $codes["product_part_number"];
	        $k++;
	   
	    }
	    
	    $result = '"'.implode('", "', $specialCodes) . '"';
	    
	    // Получаем все остальные товары кроме тех, у кого специальные цены
	    $allUsedItems = Special::getProdustsNotIn($result, $selectINNUser["ur_inn"]);
	    
	    // Создаю пустой массив для записи
	    $specialCodesAll = [];
	    
	    foreach ( $allUsedItems as $allUsedItemsOne ) {
	          
	         // Забиваем массив через итерацию кодами товаров
    	     $specialCodesAll[$z] = $allUsedItemsOne["itemPartNumber"];
    	     
    	     $z++;

	    }
	    
	    // Подготавливаем аргумент в функцию для выборки IN
	    $segment = '"'.implode('", "', $specialCodesAll) . '"';
	    
	    // Отправляем в функцию данные и получаем результат
	    $thisCodes = Special::allItemsFromCode($segment);
	    
	    // Конец логики получения остальных товаров клиентa

        $paramsPath = $_SERVER['DOCUMENT_ROOT']. '/config/db_params.php';
        $params = include($paramsPath);
        $con = new mysqli($params['host'],$params['user'],$params['password'],$params['dbname']);
        echo 'specialTest';  ?>



         
<?php } ?>