<?php
    /*
        php for basket3_purchase2.html page, need for get new summ

        input parameters:
            - form parameters

        output parameters:
            - new summ in json format

    */

    $r = rand(300, 500);

    $json_answer = '{
        "newSumm": "' . $r . '"
    }';

    echo $json_answer;
?>