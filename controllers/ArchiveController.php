<?php

class ArchiveController
{
    //не удалять продукты если их число больше .
    private static $MAX_PROD_TO_REMOVE = 20;
    private $mode;
    //date is for testing
    private $date;

    public function __construct()
    {
        // принимаем значение mode
        $this->mode = $_GET['mode'];
        if (isset($_GET['date']))  {
            $this->date = $_GET['date'];
        } else {
            $this->date = date_create()->format('Y-m-d');
        }
        
    }


    public function actionArchiveProducts()
    {
        $mode = $this->mode;
        $this->$mode();
    }

    //нужна для протокола 1С
    public function checkauth()
    {

        echo "success\n";
        echo session_name() . "\n";
        echo session_id() . "\n";
        error_log('checkauth');
        exit;
    }

    //нужна для протокола 1С
    public function init()
    {
        $zip = extension_loaded('zip') ? 'yes' : 'no';
        echo 'zip=' . $zip . "\n";
        echo "file_limit=0\n";
        error_log('init');
        exit;
    }
    //нужна для протокола 1С
    public function file()
    {
        echo "success\n";
        error_log('file');
        exit;
    }

    //эта функция собственно архивирует продукты 
    public function import()
    {
        error_log('import');
        $old_product_ids = Product::findProductIdsLoadedBeforeDate($this->date);
        if(!$old_product_ids) {
            echo 'failed to get old product ids';
            return false;
        }
        if (count($old_product_ids) > self::$MAX_PROD_TO_REMOVE) {
            error_log('слишком много продуктов для удаления: '. print_r(count($old_product_ids), true));
            echo "failure\n слишком много продуктов для удаления: ". print_r(count($old_product_ids), true);
            exit;
        } 
       
        foreach ($old_product_ids as $one_product_id) {
            $product =  Product::findProductById($one_product_id);
            $archive_res = Product::archiveProduct($product);
            if ($archive_res == false) {
                error_log('не удалось удалить продукт: '. print_r($one_product_id, true));
            }
        }

        echo "success\n";
        echo session_name() . "\n"; 
        echo session_id() . "\n";
        exit;
    }
}
