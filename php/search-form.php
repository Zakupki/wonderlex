<?php

$lang = $_GET[ 'lang' ];

$json_data = '{ "html": "
        <form class=\"search-form\" action=\"php\/search.php\" novalidate=\"novalidate\" data-empty=\"заполните<br \/> поле\">
            <div class=\"search-form__item\">
                <label class=\"search-form__label\">поиск:</label>
                <div class=\"switch\">
                    <div class=\"switch__txt switch__txt_active\">по работам</div>
                    <div class=\"switch__slider\"><div></div></div>
                    <div class=\"switch__txt\">по авторам</div>
                    <input class=\"switch__radio\" type=\"radio\" name=\"search\" value=\"work\" checked=\"checked\">
                    <input class=\"switch__radio\" type=\"radio\" name=\"search\" value=\"authos\">
                </div>
            </div>
            <div class=\"search-form__item\">
                <input type=\"search\" id=\"search-form__search-txt\" class=\"search-form__search-txt\" placeholder=\"поиск\">
            </div>
            <div class=\"search-form__txt\">Для поиска нажмите Enter</div>
        </form>

" }';



$json_data = str_replace("\r\n",'',$json_data);
$json_data = str_replace("\n",'',$json_data);
    
echo $json_data;
exit;
?>