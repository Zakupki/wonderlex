<?php
    /*
        php for processing getting country

        input parameters
            - country id
    */

    $country = $_POST['country'];

    if ($country == 1) {

        $json_answer = '{
            "list": [
                {
                    "name": "Кривой рог",
                    "value": "1"
                },
                {
                    "name": "Пятихатки",
                    "value": "2"
                },
                {
                    "name": "Апостолово",
                    "value": "3"
                },
                {
                    "name": "Киев",
                    "value": "4"
                },
                {
                    "name": "Днепропетровск",
                    "value": "5"
                },
                {
                    "name": "Апостолово",
                    "value": "3"
                },
                {
                    "name": "Киев",
                    "value": "4"
                },
                {
                    "name": "Днепропетровск",
                    "value": "5"
                }
            ]
        }';
    }
    else {
        $json_answer = '{
            "list": [
                {
                    "name": "Чоп",
                    "value": "7"
                },
                {
                    "name": "Ялта",
                    "value": "8"
                },
                {
                    "name": "Днепродзержинск",
                    "value": "9"
                },
                {
                    "name": "Кировоград",
                    "value": "10"
                },
                {
                    "name": "Харьков",
                    "value": "11"
                }
            ]
        }';
    }

    echo $json_answer;

?>