<?php
//GET
$input_password = $_GET['input_password'];
$input_login = $_GET['input_login'];

if( $input_login == 'test@gmail.com' && $input_password == '1111' ) {
    header("HTTP/1.1 200 Добро пожаловать.");
    $json_data = '{
        "userId": 0
    }';
} else {
    header("HTTP/1.1 401 Логин/пароль неверный.");
}



$json_data = str_replace("\r\n",'',$json_data);
$json_data = str_replace("\n",'',$json_data);

echo $json_data;
exit;
?>