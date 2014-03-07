<?php
//GET
$input_password = $_GET['input_password'];
$input_login = $_GET['input_login'];


    header("HTTP/1.1 200 спасибо за регистрацию.");
    $json_data = '{
        "userId": 0
    }';




$json_data = str_replace("\r\n",'',$json_data);
$json_data = str_replace("\n",'',$json_data);

echo $json_data;
exit;
?>