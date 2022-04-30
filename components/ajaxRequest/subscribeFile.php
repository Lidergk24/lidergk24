<?php
$paramsPath = $_SERVER['DOCUMENT_ROOT'] . '/config/db_params.php';
$params = include($paramsPath);
$con = new mysqli($params['host'], $params['user'], $params['password'], $params['dbname']);
$name = $_POST['name'];
$mail = $_POST['mail'];
if (isset($name) && isset($mail)) {
  $searchMail = mysqli_query($con, "SELECT * FROM `subscribe` WHERE email='$mail'");
  $coupon = rand(11111, 99999);

  if ($searchMail->num_rows == 0) {
    echo json_encode(array('result' => 'success'));
    $insertEmail = mysqli_query($con, 'INSERT INTO subscribe (name, email, send_status, coupon, discount, coupon_activate) VALUES ("' . $name . '","' . $mail . '", "OK", "' . $coupon . '", "5","0")');
    $to = array('sale@lider-gk24.ru', $mail);
    $email_to = implode(',', $to);
    $subject = "Подписка на скидку";
    include( $_SERVER['DOCUMENT_ROOT'] . "/tempEmail/subscribe/subscribe.php");
    $message = $content;
    $headers  = "Content-type: text/html; charset=utf-8 \r\n";
    $headers .= "From: ООО ЛИДЕР <sale@lider-gk24.ru>\r\n";
    $headers .= "Reply-To: LIDER\r\n";
    mail($email_to, $subject, $message, $headers);
  } else {
    echo json_encode(array('result' => 'Вы уже подписаны'));
  }
} else {
  echo "Error";
}
