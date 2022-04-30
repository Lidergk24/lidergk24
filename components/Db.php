<?php
/**
 * Класс Db
 * Компонент для работы с базой данных
 */
class Db {
    /**
     * Устанавливает соединение с базой данных
     * @return \PDO <p>Объект класса PDO для работы с БД</p>
     */
    public static function getConnection() {
        // Получаем параметры подключения из файла
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include ($paramsPath);
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password']);
        $db->exec("set names utf8");
        return $db;
    }
    public static function getConnectionMysqli() {
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include ($paramsPath);
        $sqli_params =  new mysqli($params['host'], $params['user'], $params['password'], $params['user']);
        return $sqli_params;
    }
}