<?php
$paramsPath = $_SERVER['DOCUMENT_ROOT']. '/config/db_params.php';
$params = include($paramsPath);
$con = new mysqli($params['host'],$params['user'],$params['password'],$params['dbname']);  
if(isset($_POST['tel']) && $_POST['tel'] != ''){
    $tel = $_POST['tel'];
    $phone= str_replace([' ', '(', ')', '-'], '', $tel);
    $query = mysqli_query($con, "SELECT * FROM user WHERE phone='$phone'");
    $response = [];
    if ($query->num_rows==0) {
        require_once 'SMS_auth/sms.ru.php';
        $smsru = new SMSRU('509E0CA3-4EDA-C574-5753-717EC494989F'); 
        $data = new stdClass();
        $data->to = $phone;
        $secure_code_sms = rand(1111,9999);
        $data->text = 'Код подтверждения: '.$secure_code_sms;
        $sms = $smsru->send_one($data);
        $transTableUpdate = mysqli_query($con, "INSERT INTO 
        `UserTransTable`(`transPhone`, `transCode`) VALUES ('$phone', '$secure_code_sms')");
                $response = [
                'status' => 'success',
            ];
    }
    else {
            require_once 'SMS_auth/sms.ru.php';
            $smsru = new SMSRU('509E0CA3-4EDA-C574-5753-717EC494989F'); 
            $data = new stdClass();
            $data->to = $phone;
            $secure_code_sms = rand(1111,9999);
            $data->text = 'Код подтверждения: '.$secure_code_sms;
            $sms = $smsru->send_one($data);
            $updateSmsVerify = mysqli_query($con,"UPDATE `user` SET `sms_verify`=$secure_code_sms WHERE phone='$phone'"); 
            $response = [
                'status' => 'success',
            ];
        }
        
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
    
if(isset($_POST['smsCode'])){
    $smsCode = $_POST['smsCode'];
    $transPhone = str_replace([' ', '(', ')', '-'], '', $_POST['transPhone']);
    $query = mysqli_query($con, "SELECT * FROM user WHERE phone='$transPhone' and sms_verify='$smsCode'");
if ($query->num_rows > 0) {
    $response = [
        'status' => 'smsOk'
    ];
} else {
    $queryNew = mysqli_query($con, "SELECT * FROM UserTransTable WHERE transPhone='$transPhone' and transCode='$smsCode'");
    if ($queryNew->num_rows > 0) {
        $role = 'user';
        $registration_date = date("d.m.Y");
        $smsValid = mysqli_query($con, "INSERT INTO user (name, phone, role, sms_verify, registration_date) VALUES ('','$transPhone', '$role', $smsCode, '$registration_date')");
        $response = [
            'status' => 'smsOk'
        ];
    } else {
        $response = [
            'status' => 'smsError'
        ];
    }
}
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
