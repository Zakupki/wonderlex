<?php
    /*
        php for processing scripts profile history page

        input parameters:
            - item id
            - flag (remove, load)
    */

    $id = null;

    if (isset($_POST['ItemId'])) {
        $id = $_POST['ItemId'];
    }

    $flag = $_POST['flag'];

    if ($flag == 'remove') {

        $r = rand(0, 10);

        if ($r < 5) {
            header('HTTP/1.0 200 OK');
        }
        else {
            header('HTTP/1.0 400 Невозможно удалить запись');
        }

    }
    else if ($flag == 'load') {
        $r = rand(0, 5);
        $loadFlag = "more";
        if ($r < 2) {
            $loadFlag = "all";
        }
        $json_answer = '{
            "flag": "' . $loadFlag . '",
            "list": [
                {
                    "id": "1",
                    "img": "pic/profile-history-img.jpg",
                    "itemName": "Жажда общения с методом",
                    "name": "Наташа Егорова",
                    "price": "28 900 грн",
                    "date": "12.07.2012"
                },
                {
                    "id": "2",
                    "img": "pic/profile-history-img.jpg",
                    "itemName": "Жажда общения с методом",
                    "name": "Наташа Егорова",
                    "price": "28 900 грн",
                    "date": "12.07.2012"
                },
                {
                    "id": "3",
                    "img": "pic/profile-history-img.jpg",
                    "itemName": "Жажда общения с методом",
                    "name": "Наташа Егорова",
                    "price": "28 900 грн",
                    "date": "12.07.2012"
                },
                {
                    "id": "4",
                    "img": "pic/profile-history-img.jpg",
                    "itemName": "Жажда общения с методом",
                    "name": "Наташа Егорова",
                    "price": "28 900 грн",
                    "date": "12.07.2012"
                },
                {
                    "id": "5",
                    "img": "pic/profile-history-img.jpg",
                    "itemName": "Жажда общения с методом",
                    "name": "Наташа Егорова",
                    "price": "28 900 грн",
                    "date": "12.07.2012"
                },
                {
                    "id": "5",
                    "img": "pic/profile-history-img.jpg",
                    "itemName": "Жажда общения с методом",
                    "name": "Наташа Егорова",
                    "price": "28 900 грн",
                    "date": "12.07.2012"
                }
            ]
        }';

        echo $json_answer;
    }