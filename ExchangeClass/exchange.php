<?php
class Exchange1c {
 
        private $mode;
        private $filename;
 
 
        public function __construct() {
            
                // принимаем значение mode
                $this->mode = $_GET['mode'];
                $this->filename = $_GET['filename'];
        }
 
        public function run(){
                $mode = $this->mode;
                // и здесь, в зависимости, что отправла 1С
                // вызываем одноименный метод
                /*
                 * 1. checkauth
                 * 2. init
                 * 3. file
                 * 4.1 import - [filename] => import.xml
                 * 4.2 import - [filename] => offers.xml
                 */
                $this->$mode();
        }
 
 
        /*
         * Этап 1. Авторизовываем 1с клиента
         */
        public function checkauth() {
    
                echo "success\n";
                echo session_name()."\n";
                echo session_id()."\n";
                exit;
        }
 
        /*
         * Этап 2. Говрим 1с, умеем или не умеем работать с архивами
         * в нашем случае - умеем :)
         */
        public function init() {
                $zip = extension_loaded('zip') ? 'yes' : 'no';
                echo 'zip='.$zip."\n";
                echo "file_limit=0\n";
                exit;
        }
 
        /*
         * Этап 3. Принимаем файл и распаковываем его
         */
        public function file() {
 
                // вытаскиваем сырые данные
                $data = file_get_contents('php://input');
 
                //Сохраняем файл импорта в zip архиве
                file_put_contents($this->filename, $data);
               
                // распаковываем
                if(file_exists($this->filename)) {
                        // работаем с zip
                        $zip = new ZipArchive;
                        //все в порядке с архивом
                        if($res = $zip->open($this->filename, ZIPARCHIVE::CREATE)) {
 
                                // распаковываем два файла в формате xml куда-то
                                // в нашем случае в этот же каталог
                                $zip->extractTo($_SERVER['DOCUMENT_ROOT'].'/upload/');
                                $zip->close();
 
                                // удаляем временный файл
                                unlink($this->filename);
                                //Всё получилось?
                                echo "success\n";
                                exit;
                        }
                }
                // если ничего не получилось
                echo "failure\n";
                exit;
        }
 
        /*
         * Этап 3 и 4 работаем с файлами обмена
         */
        public function import() {
                // используем читалку xml
                $xml = simplexml_load_file($this->filename);
                $importFile = $_SERVER['DOCUMENT_ROOT'].'/upload/import.xml';
                if(isset($importFile)) {
                       
                        include('DB_param.php');
                        include('ExchangeFunction.php');

       $importFile = $_SERVER['DOCUMENT_ROOT'].'/upload/import.xml';
       $xml_1 = simplexml_load_file($importFile);
       $globalCat = '';
       $arrayAtributs = [];
      
      /**
        * (string) $itog - Получение Ид товара
        * (int) $balance - Получение остатка товара
        */ 
            foreach ($xml_1->Классификатор->Свойства as $atributs=>$value) {
                
                foreach ((Array)$value{0} as $key=>$Atribut) {
                    
                    foreach ($Atribut as $key1=>$value1) {
                        
                        foreach ($value1->ВариантыЗначений as $key2=>$value2) {
                            
                            foreach ($value2->Справочник as $key3=>$value3) {
                                    $myIdAtributs = (array)$value3->ИдЗначения;
                                    $myGroupAtributs = (array)$value1->Наименование;
                                    $myAtributsValue = (array)$value3->Значение;
                                    $arrayAtributs[] = [$myGroupAtributs[0],$myIdAtributs[0],$myAtributsValue[0]];
                            }
                                
                        }
                    }
                }    
            }
                // Разбираем свойства через итерацию и заносим в базу, делаем проверку на insert или update
                
                    for ($y=0; $y< count($arrayAtributs); $y++) {
                      $atributTitle = $arrayAtributs[$y][0];
                      $atributId = $arrayAtributs[$y][1];
                      $atributValue = $arrayAtributs[$y][2];
                      $atributSearch = mysqli_query($con, "select * from Product_atributs where atributId='$atributId'");
                      if ($atributSearch->num_rows !=0) {
    
                        $atribut_update = mysqli_query($con,"UPDATE `Product_atributs` SET `atributTitle`='$atributTitle', `atributValue`='$atributValue' WHERE atributId='$atributId'");
                      }
                      
                      else {
                        $atribut_insert = mysqli_query($con,'INSERT INTO Product_atributs (atributTitle,atributId,atributValue) VALUES ("'.$atributTitle.'","'.$atributId.'","'.$atributValue.'")');
                      }
               
                    }
        // Конец разбора свойств
       
        /**
        * Начало разбора категорий и занесение в базу с проверкой insert или update
        */ 
            foreach ($xml_1->Классификатор->Группы as $category=>$mycat) {
                
                foreach ($mycat->Группа as $parentCat=>$parentValue) {
                    
                   $globalCat = (Array)$parentValue{0}->Наименование[0];
                }
       
                    foreach ($mycat->Группа->Группы->Группа as $mygroup => $value) {
                        
                     $catName = $value->Наименование;
                     $catId = $value->Ид;
                     $globalCatParent = $globalCat[0];
                     $cat_slug = str2url($catName);
                     
                     $catSearch = mysqli_query($con, "select * from Product_category where cat_code='$catId'");
                     
                        if ($catSearch->num_rows>0) {
                            $catSearchUpdate = mysqli_query($con,"UPDATE `Product_category` SET `cat_name`='$catName',`cat_parent`='$globalCatParent', `cat_slug`='$cat_slug' where cat_name='$catId'");
                        } 
                         
                        else {
                             
                            $cat_insert = mysqli_query($con,'INSERT INTO Product_category (cat_code,cat_name,cat_parent,cat_slug) VALUES ("'.$catId.'","'.$catName.'","'.$globalCat[0].'", "'.$cat_slug.'")');
               
                        }
            }
            
            //Конец занесения в базу категорий
            
            /**
             * (string) $itog - Получение Ид товара
             */
             
            foreach ($xml_1 as $myItemName =>$valueItem) {
                
                $tmparray = (array)$valueItem->Товары;
                
                    foreach ($tmparray as $tmpItemdd) {
                        
                        for ($ii=0; $ii<count($tmpItemdd);$ii++) {
                            
                                $abcfff = (array)$tmpItemdd[$ii]->Ид;
                                
                                    foreach ($abcfff as $itog) {
                                        
                                       // echo $itog;
                        }
                        
                            
                }
            }
            
            /**
             * Конец работы с остатками
             */ 
             
           
           
           
             // отсюда разбирается все для задачи, нужны свойства ключ / значение можно через точка-запятую
                foreach ($valueItem->Товары->Товар as $itemVal=>$myVal) {
                  //echo "<pre>";
                  $product_id = $myVal->Ид;
                  $tmpAttr = '';

                  foreach ($myVal->ЗначенияСвойств as $key => $value) {
                      
                    foreach ($value->ЗначенияСвойства as $key2 => $value2) {

                      $x=(Array)$value2;
// это ид-шники 

                      $myid = $x["Ид"];                        
                      $myVall = $x["Значение"];
                      $tmpAttr = ( $tmpAttr ? $tmpAttr.';' : '' ) . $myid.':'.$myVall;
                    }    
                  }

                  $product_id = $myVal->Ид;
                  $product_part_number = trim($myVal->Код);
                  $product_name = htmlspecialchars($myVal->Наименование);
                  $product_price = $myVal->Цена4;
                  $product_old_price = $myVal->Цена3Старая;
                  $priceOpt = $myVal->Оптовая;
                  $price1 = $myVal->Цена1;
                  $price2 = $myVal->Цена2;
                  $price3 = $myVal->Цена3;
                  $product_img = json_encode(array($myVal->Картинка));
                  $productArray = stripslashes($product_img);
                  $brend = $myVal->Бренд;
                  $min_zakaz = $myVal->МинимальныйЗаказ;
                  $similarProduct = json_encode(array($myVal->СовместимаяНоменклатура->Номенклатура));
                  $product_article = $myVal->Артикул;
                  $product_category = $myVal->Группы->Ид;
                  
                  
                  
                  $sendCategory = (Array)$product_category{0};
                  $sendMyCategory = $sendCategory[0];
                  $productDescription = htmlspecialchars($myVal->Описание);
                  $product_slug = str2url($product_name);
                  $ostatok = $myVal->Остаток;
                  $barcode = $myVal->Штрихкод;
                  $dateUpdateFlag = date("Y-m-d H:i:s");
                  
                  $searcBrand = mysqli_query($con,"select brand_name from Product_brand where brand_name='$brend'");
                  
                    if ($searcBrand->num_rows == 0 || $searcBrand->num_rows == NULL || $searcBrand->num_rows == '') {
                        
                        $brand_insert = mysqli_query($con,"INSERT INTO Product_brand (brand_name) VALUES ('".$brend."')");
                        
                    }
                  
                  $searchId = mysqli_query($con,"select * from Product where product_code='$product_id'");
                  
                    if ($searchId->num_rows>0) {
                        
                       $product_update = mysqli_query($con,"UPDATE `Product` SET 
                       `product_description`='$productDescription',
                       `product_price`='$product_price',
                       `product_old_price`='$product_old_price', 
                       `product_part_number`='$product_part_number',
                       `product_date`='$dateUpdateFlag',
                       `product_article`='$product_article',
                       `product_slug`='$product_slug',
                       `product_image`='$productArray',
                       `compatible_product`='$similarProduct', 
                       `product_brand`='$brend',
                       `miz_zakaz`='$min_zakaz',
                       `product_name`='$product_name',
                       `product_category` = '$product_category',
                       `product_atributs`='$tmpAttr',
                       `product_warehouse` = '$ostatok',
                       `barcode` = '$barcode',
                       `priceOpt` = '$priceOpt',
                       `price1` = '$price1',
                       `price2` = '$price2',
                       `price3` = '$price3'
                       
                        where product_code='$product_id'");
                    }
                  
                    else {
                     

                        $product_insert = mysqli_query($con,"INSERT INTO Product (product_code, product_name, product_description, product_category, product_image, product_price, product_warehouse, product_old_price, product_part_number, product_article, product_slug, product_atributs, compatible_product, product_brand, miz_zakaz, barcode, priceOpt, price1, price2, price3) 
                        
                        VALUES (
                            '".$product_id."',
                            '".$product_name."', 
                            '".$productDescription."', 
                            '".$sendMyCategory."',
                            '".$productArray."', 
                            '".$product_price."', 
                            '".$product_old_price."', 
                            '".$ostatok."' , 
                            '".$product_part_number."', 
                            '".$product_article."', 
                            '".$product_slug."', 
                            '".$tmpAttr."', 
                            '".$similarProduct."', 
                            '".$brend."', 
                            '".$miz_zakaz."', 
                            '".$barcode."',
                            '".$priceOpt."',
                            '".$price1."',
                            '".$price2."',
                            '".$price3."'
                            )");

                    }
                    
                }
                
                // Конец разбора товара
            }
        }
                        echo "success\n";
                        echo session_name()."\n";
                        echo session_id()."\n";
                        exit;
 
                }
                
                else{
                        echo "Ошибка загрузки XML\n";
                        foreach (libxml_get_errors() as $error) {
                                echo "\t", $error->message;
                        }
                        exit;
                }
        }
 
}
session_start();
$exaple = new Exchange1c();
$exaple->run();
