<?php
//GET
$input_login = $_GET['input_login'];

if( $input_login == 'test@gmail.com' ) {
    header("HTTP/1.1 200 Пароль был отправлен на ваш e-mail.");
    $json_data = '{
        "userId": 0
    }';
} else {
    header("HTTP/1.1 401 E-mail не зарегистрирован .");
}



$json_data = str_replace("\r\n",'',$json_data);
$json_data = str_replace("\n",'',$json_data);

echo $json_data;
exit;
?>