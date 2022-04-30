<?php
/**
 * Контроллер UserController
 */
class UserController {
    /**
     * Action для страницы Регистрация
     */
    public function actionRegister() {
        $title = 'Регистрация на сайте ООО Лидер';
        $description = 'Зарегитсрируйтесь на сайте чтобы иметь возможность получить скидки и участвовать в специальных предложениях';
        if (isset($_POST['submit'])) {
            // Получаем данные из формы
            $tel = $_POST['phone'];
            $sms_varify_form = $_POST['sms_varify_form'];
            $phone = str_replace([' ', '(', ')', '-'], '', $tel);
            require_once(ROOT . '/components/Db.php');
            $con = Db::getConnectionMysqli();
            $checkAuthSms = mysqli_query($con, "select * from user where phone='$phone' and sms_verify='$sms_varify_form'");
            if ($checkAuthSms->num_rows == 0) {
                $errors[] = 'Неверный смс код';
            } else if (empty($sms_varify_form)) {
                $errors[] = 'Введите смс код';
            } else {
                $userId = User::checkUserData($tel, $sms_varify_form);
                User::auth($userId);
                header("Location: /");
            }
        }
        require_once (ROOT . '/views/user/register.php');
        return true;
    }
    
   
    // Action для страницы Вход на сайт
    public function actionLogin() {
        $title = 'Авторизация на сайте ООО Лидер';
        $description = 'Авторизуйтесь на сайте чтобы иметь возможность получить скидки и участвовать в специальных предложениях';
        $sms_varify_form = false;
        if (isset($_POST['submit'])) {
            $telAuth = $_POST['phone'];
            $telAuth_preg_replace = str_replace([' ', '(', ')', '-'], '', $telAuth);
            $sms_varify_form = $_POST['sms_varify_form'];
            $errors = false;
            // Проверяем существует ли пользователь
            $userId = User::checkUserData($telAuth_preg_replace, $sms_varify_form);
            if ($userId == false) {
                // Если данные неправильные - показываем ошибку
                $errors[] = 'Неверный СМС код';
            } else {
                // Если данные правильные, запоминаем пользователя (сессия)
                User::auth($userId);
                // Перенаправляем пользователя в закрытую часть - кабинет
                header("Refresh:0; url= /");
            }
        }
        require_once (ROOT . '/views/user/login.php');
        return true;
    }
    
    // Удаляем данные о пользователе из сессии
    public function actionLogout() {
        // Удаляем информацию о пользователе из сессии
        unset($_SESSION["user"]);
        // Перенаправляем пользователя на главную страницу
        $environment =include_once($_SERVER['DOCUMENT_ROOT'] . '/config/environment.php');
        header("Location:".$environment["base_url"]);
        return true;
    }
}