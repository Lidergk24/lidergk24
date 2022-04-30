<?php
// Общие настройки
//ini_set('display_errors',1);
//error_reporting(E_ALL);
//ini_set('serialize_precision', 14);
//ini_set('precision', 14);
session_start();
// Подключение файлов системы
define('ROOT', dirname(__FILE__));
require_once(ROOT.'/components/Autoload.php');

// Запись времени обращения пользователя к сайту
$VISIT = new Visit(); unset($VISIT);
// Вызов Router
 @$router = new Router();
 @$router->run(); 

