<?php

$lang = $_GET[ 'lang' ];

$json_data = '{ "html": "
    <form class=\"login\" action=\"php\/login.php\" data-php=\"php\/remind-password.php\" novalidate=\"novalidate\" data-empty=\"заполните<br \/> поле\"  data-mail=\"введите<br \/> e-mail\">
        <fieldset class=\"login__layout\">
            <label class=\"login__label login__label_mail\" for=\"input_login\">Логин</label>
            <input type=\"email\" class=\"login__input email\" id=\"input_login\" name=\"input_login\" required=\"required\" placeholder=\"ВАШ E-MAIL\">
        </fieldset>
        <fieldset class=\"login__layout\">
            <label class=\"login__label login__label_password\" for=\"input_password\">Пароль</label>
            <input type=\"password\" class=\"login__input login__input_pass\" id=\"input_password\" name=\"input_password\" required=\"required\" placeholder=\"Пароль\">
        </fieldset>
        <fieldset class=\"login__layout\">
            <input class=\"login__send\" id=\"login__send\" type=\"submit\" value=\"Войти\" />
            <input class=\"login__send login__reminder\" id=\"login__reminder\" type=\"button\" value=\"Отправить пароль\" />
        </fieldset>
        <a class=\"login__forgot-pass\" href=\"#\">Забыли пароль?</a>
    </form>
" }';



$json_data = str_replace("\r\n",'',$json_data);
$json_data = str_replace("\n",'',$json_data);
    
echo $json_data;
exit;
?>