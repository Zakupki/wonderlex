<?php

$lang = $_GET[ 'lang' ];

$json_data = '{ "html": "
    <div class=\"registration\">
        <form class=\"login\" action=\"php\/registration.php\" novalidate=\"novalidate\" data-empty=\"заполните<br \/> поле\"  data-mail=\"введите<br \/> e-mail\">
            <fieldset class=\"login__layout\">
                <label class=\"login__label login__label_name\" for=\"input_name\">Имя</label>
                <input type=\"text\" class=\"login__input\" id=\"input_name\" name=\"input_name\" required=\"required\" placeholder=\"Имя\">
            </fieldset>
            <fieldset class=\"login__layout\">
                <label class=\"login__label login__label_mail\" for=\"input_login\">Логин</label>
                <input type=\"email\" class=\"login__input email\" id=\"input_login\" name=\"input_login\" required=\"required\" placeholder=\"ВАШ E-MAIL\">
            </fieldset>
            <fieldset class=\"login__layout\">
                <label class=\"login__label login__label_password\" for=\"input_password\">Пароль</label>
                <input type=\"password\" class=\"login__input login__input_pass\" id=\"input_password\" name=\"input_password\" required=\"required\" placeholder=\"Пароль\">
            </fieldset>
            <fieldset class=\"login__layout\">
                <label class=\"login__label login__label_password\" for=\"input_password_repeat\">Пароль</label>
                <input type=\"password\" class=\"login__input login__input_pass\" id=\"input_password_repeat\" name=\"input_password_repeat\" required=\"required\" placeholder=\"повторите пароль\">
            </fieldset>
            <div class=\"login-check\"><input type=\"checkbox\" value=\"1\" class=\"niceCheck\" id=\"login__check\" name=\"login__check\" /><label for=\"login__check\">согласен с соглашением</label></div>
            <fieldset class=\"login__layout\">
                <input class=\"login__send\" id=\"login__send\"  type=\"submit\" value=\"Зарегистрироваться\" />
            </fieldset>
        </form>
        <div class=\"registration__aside\">
            <div class=\"scroll\">
                <div>
                    <h1>пользовательское соглашение</h1>
                    <p>Мониторинг активности повсеместно оправдывает культурный портрет потребителя,
                        используя опыт предыдущих кампаний. Искусство медиапланирования экономит потребительский
                        целевой трафик, осознавая социальную ответственность бизнеса. Пак-шот консолидирует
                        сублимированный медийный канал, полагаясь на инсайдерскую информацию. В соответствии с
                        законом Ципфа, ребрендинг не так уж очевиден. Информационная связь с потребителем, безусловно,
                        многопланово раскручивает продуктовый ассортимент, используя опыт Мониторинг активности
                        повсеместно оправдывает культурный портрет потребителя, используя опыт предыдущих кампаний.
                        Искусство медиапланирования экономит потребительский целевой трафик, осознавая социальную
                        ответственность бизнеса. Пак-шот консолидирует сублимированный медийный канал, полагаясь на
                        инсайдерскую информацию. В соответствии с законом Ципфа, ребрендинг не так уж очевиден.
                        Информационная связь с потребителем, безусловно, многопланово раскручивает продуктовый
                        ассортимент, используя опыт Мониторинг активности повсеместно оправдывает культурный портрет
                        потребителя, используя опыт предыдущих кампаний. Искусство медиапланирования экономит
                        потребительский целевой трафик, осознавая социальную ответственность бизнеса. Пак-шот
                        консолидирует сублимированный медийный канал, полагаясь на инсайдерскую информацию. В
                        соответствии с законом Ципфа, ребрендинг не так уж очевиден. Информационная связь с
                        потребителем, безусловно, многопланово раскручивает продуктовый ассортимент, используя опыт</p>
                </div>
            </div>
            <a class=\"pdf-btn\" href=\"#\">Скачать pdf</a>
            <dl class=\"registration__social\">
                <dt>Войти как пользователь:</dt>
                <dd><a class=\"facebook\" href=\"#\">fasebook</a></dd>
                <dd><a class=\"vk\" href=\"#\">fasebook</a></dd>
                <dd><a class=\"tweeter\" href=\"#\">fasebook</a></dd>
            </dl>
        </div>
" }';



$json_data = str_replace("\r\n",'',$json_data);
$json_data = str_replace("\n",'',$json_data);
    
echo $json_data;
exit;
?>