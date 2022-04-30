<?php

$fp = fopen('/home/l/liderzm5/lider-gk24.ru/public_html/file.csv', 'w');

foreach($ordersByToday as $ordersByTodayOne){ // выгребаю все через модель

    if(is_array($ordersByTodayOne)) {
        foreach ($ordersByTodayOne as $k=>$v) {
            $ordersByTodayOne[$k] = iconv('utf-8', 'windows-1251', $v);
        }
    }
    
    fputcsv($fp, array_unique($ordersByTodayOne), ';'); // пишу в формате csv с параметрами: путь, содержимое, разделитель
}
 
fclose($fp);

  $filename = "file.csv"; //Имя файла для прикрепления
  $to = "ts@lider-gk24.ru"; //Кому
  $from = "OOO LIDER"; //От кого
  $subject = "Отчет о заказах"; //Тема
  $message = "Текстовое сообщение"; //Текст письма
  $boundary = "---"; //Разделитель
  /* Заголовки */
  $headers.= "From: ООО ЛИДЕР <sale@lider-gk24.ru>\r\n"; 
  $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";
  $body = "--$boundary\n";
  /* Присоединяем текстовое сообщение */
  $body .= "Content-type: text/html; charset='utf-8'\n";
  $body .= "Content-Transfer-Encoding: quoted-printablenn";
  $body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode($filename)."?=\n\n";
  $body .= $message."\n";
  $body .= "--$boundary\n";
  $file = fopen($_SERVER['DOCUMENT_ROOT'].$filename, "r"); //Открываем файл
  $text = fread($file, filesize($filename)); //Считываем весь файл
  fclose($file); //Закрываем файл
  /* Добавляем тип содержимого, кодируем текст файла и добавляем в тело письма */
  $body .= "Content-Type: application/octet-stream; name==?utf-8?B?".base64_encode($filename)."?=\n";
  $body .= "Content-Transfer-Encoding: base64\n";
  $body .= "Content-Disposition: attachment; filename==?utf-8?B?".base64_encode($filename)."?=\n\n";
  $body .= chunk_split(base64_encode($text))."\n";
  $body .= "--".$boundary ."--\n";
  mail($to, $subject, $body, $headers); //Отправляем письмо
   

?>