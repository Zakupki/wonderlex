<?php
    /*
     *  php for save profile settings
     *      input parameters
     *          - form data
     *      output parameter
     *          - message
    */

    $r = rand(0, 10);

    if ($r < 5) {
        header('HTTP/1.0 200 Данные успешно сохранены');
        $json = '{
            "href": "http://google.com",
            "title": "Вернуться",
            "message": "Данные успешно сохранены"
        }';
        echo  $json;
    }
    else {
        header('HTTP/1.0 400 Ошибка сохранения данных');
        $json = '{
            "message": "Ошибка сохранения данные"
        }';
        echo  $json;
    }

?>
