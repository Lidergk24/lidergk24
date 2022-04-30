<?php
/**
 * Класс Visit - модель для фиксирования времени обращения пользователя к сайту
 */
class Visit {
    /**
     * Обновление даты посещения пользователя
     */
    function __construct () {
	if (@$_SESSION['user'])
		User::lastVisitUpdate($_SESSION['user']);
    }
   
}