<?php
    /*
        php for processing ajax form
            input parameter:
                - form data
            output parameter:
                - message
                - href (json)
    */

    $r = rand(0, 5);
    $json_answer = '';

    if ($r < 5) {
        header('HTTP/1.0 200 Спасибо! Ваш заказ принят');
        $json_answer = '{
            "href": "http://google.com",
            "title": "Вернуться в корзину"
        }';
    }
    else {
        header('HTTP/1.0 400 Ошибка обработки заказа');
        $json_answer = '{}';
    }

    echo $json_answer;