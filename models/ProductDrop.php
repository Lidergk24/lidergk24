<?php
/**
 * Класс ProductDrop - модель для работы с сохранённым сожержимым корзины
 */
class ProductDrop {
    /**
     * Сохраняет корзину в отдельную таблицу (для отправки мотивационного купона)
     */
    public function save( $user_id, $products ) {
        $db = Db::getConnection();
        $sql = 'DELETE FROM ProductDropOrder WHERE user_id=:user_id;';
        $result = $db->prepare($sql);
        $result->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $result->execute();

	if ($products) foreach ($products as $pid=>$cnt) {
	        $sql = 'INSERT INTO ProductDropOrder (user_id, idProduct, countProduct) VALUES (:user_id, :idProduct, :countProduct);';
	        $result = $db->prepare($sql);
	        $result->bindParam(':user_id', $user_id, PDO::PARAM_INT);
	        $result->bindParam(':idProduct', $pid, PDO::PARAM_INT);
	        $result->bindParam(':countProduct', $cnt, PDO::PARAM_INT);
	        $result->execute();
	}
    }
    
    /**
     * Восстанавливает сохранённые товары в переменную сессии
     */
    public function restore( $user_id ) {
	if (!isset($_SESSION)) return;
	
        $db = Db::getConnection();
        $sql = 'SELECT user_id, idProduct, countProduct FROM ProductDropOrder WHERE user_id=:user_id;';
        $result = $db->prepare($sql);
        $result->bindParam(':user_id', $user_id, PDO::PARAM_INT);

	$products = Array();
        $result->execute();
        while ($row = $result->fetch()) $products[ $row['idProduct'] ] = $row['countProduct'];
	
	$_SESSION['user'] = $user_id;
	$_SESSION['products'] = $products;
    }

    /**
     * Получение списка пользователей, у которых есть сохранённые товары
     */
    public function get_users($time_diff) {
        $db = Db::getConnection();
        $sql = 'SELECT pdo.user_id, u.last_visit FROM ProductDropOrder pdo LEFT JOIN user u ON u.id=pdo.user_id WHERE TIME_TO_SEC(timediff(NOW(),u.last_visit)) > :time_diff GROUP BY pdo.user_id, u.last_visit;';
        $result = $db->prepare($sql);
        $result->bindParam(':time_diff', $time_diff, PDO::PARAM_INT);

	$users = Array();
        $result->execute();
        while ($row = $result->fetch()) $users[$row['user_id']] = $row['last_visit'];
	return $users;
    }    

    /**
     * Очищает сохранённые товары
     */
    public function clear( $user_id ) {
        $this->save( $user_id, Array() );
    }

}