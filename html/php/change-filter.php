<?php
//GET
$lang = $_GET['lang'];
$viewId = $_GET['viewId'];
$styleId = $_GET['styleId'];
$genreId = $_GET['genreId'];


if( $viewId == "none" ){
    $json_data = '{
        "menu": {
            "type":"view",
            "name": "Вид",
            "items": [
                {
                    "id": 1,
                    "name": "Какой-то Вид"
                },
                {
                    "id": 2,
                    "name": "Какой-то Вид"
                },
                {
                    "id": 3,
                    "name": "Какой-то Вид"
                },
                {
                    "id": 4,
                    "name": "Какой-то Вид"
                },
                {
                    "id": 5,
                    "name": "Какой-то Вид"
                },
                {
                    "id": 6,
                    "name": "Какой-то Вид"
                },
                {
                    "id": 7,
                    "name": "Какой-то Вид"
                },
                {
                    "id": 8,
                    "name": "Какой-то Вид"
                }
            ]
        }
    }';
} else if( $styleId == "none" ){
    $json_data = '{
        "menu": {
            "type":"style",
            "name": "Стиль",
            "items": [
                {
                    "id": 1,
                    "name": "Какойто стиль"
                },
                {
                    "id": 2,
                    "name": "Какойто стиль"
                },
                {
                    "id": 3,
                    "name": "Какойто стиль"
                },
                {
                    "id": 4,
                    "name": "Какойто стиль"
                },
                {
                    "id": 5,
                    "name": "Какойто стиль"
                },
                {
                    "id": 6,
                    "name": "Какойто стиль"
                },
                {
                    "id": 7,
                    "name": "Какойто стиль"
                },
                {
                    "id": 8,
                    "name": "Какойто стиль"
                }
            ]
        }
    }';
} else if( $genreId == "none" ){
    $json_data = '{
        "menu": {
            "type":"genre",
            "name": "жанр",
            "items": [
                {
                    "id": 1,
                    "name": "Какойто жанр"
                },
                {
                    "id": 2,
                    "name": "Какойто жанр"
                },
                {
                    "id": 3,
                    "name": "Какойто жанр"
                },
                {
                    "id": 4,
                    "name": "Какойто жанр"
                },
                {
                    "id": 5,
                    "name": "Какойто жанр"
                },
                {
                    "id": 6,
                    "name": "Какойто жанр"
                },
                {
                    "id": 7,
                    "name": "Какойто жанр"
                },
                {
                    "id": 8,
                    "name": "Какойто жанр"
                }
            ]
        }
    }';
}



$json_data = str_replace("\r\n",'',$json_data);
$json_data = str_replace("\n",'',$json_data);
    
echo $json_data;
exit;
?>