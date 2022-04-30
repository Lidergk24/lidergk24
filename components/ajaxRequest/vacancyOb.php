<?php
        $name = $_POST['name'];
        $job = $_POST['job'];
        $mone = $_POST['mone'];
        $contac = $_POST['contac'];
                $to = array('ya.rustam-kuliev@yandex.ru', 'trofimova@lider-gk24.ru');
                $email_to = implode(',', $to);
                $subject = "Отклик на вакансию с сайта Лидер"; 
                include ($_SERVER['DOCUMENT_ROOT'] ."/tempEmail/vacancy/vacancy.php");
                $message = $content;
                $headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
                $headers .= "From: ООО ЛИДЕР <sale@lider-gk24.ru>\r\n"; 
                $headers .= "Reply-To: LIDER\r\n"; 
                if(mail($email_to, $subject, $message, $headers)){
                    echo "success";
                } 
                
?>