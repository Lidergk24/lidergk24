<?php


//$totalItems = SpecialPriceLogic::getProducts();

//var_dump($totalItems );
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet(); 
   
    $sheet->setCellValue('A1', 'A1 Cell Data Here'); 
    $sheet->setCellValue('B1', 'B1 Cell Data Here'); 
        
    // Записываем в файл  
    $writer = new Xlsx($spreadsheet); 
       
    // Сохраняем файл с нужным названием в нужную дерикторию
    $writer->save('order.xlsx'); 

?>