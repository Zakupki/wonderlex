<?php
//GET
$lang = $_GET['lang'];
$viewId = $_GET['viewId'];
$styleId = $_GET['styleId'];
$genreId = $_GET['genreId'];
$priceStart = $_GET['priceStart'];
$priceFinish = $_GET['priceFinish'];
$yearStart = $_GET['yearStart'];
$yearFinish = $_GET['yearFinish'];

$json_data = '{
    "mode": "all",
    "items" : [
        {
            "painter": {
                "name": "наташа егорова",
                "href": "#"
            },
            "image": {
                "id": "13",
                "url": "pic/gallery2.jpg",
                "href":"#",
                "pictureName": "maya presentation",
                "price": 204
            }
        },
        {
            "painter": {
                "name": "наташа егорова",
                "href": "#"
            },
            "image": {
                "id": "14",
                "url": "pic/gallery1.jpg",
                "href":"#",
                "pictureName": "maya presentation",
                "price": 204
            }
        },
        {
            "painter": {
                "name": "наташа егорова",
                "href": "#"
            },
            "image": {
                "id": "15",
                "url": "pic/gallery5.jpg",
                "href":"#",
                "pictureName": "maya presentation",
                "price": 204
            }
        },
        {
            "painter": {
                "name": "наташа егорова",
                "href": "#"
            },
            "image": {
                "id": "16",
                "url": "pic/gallery3.jpg",
                "href":"#",
                "pictureName": "maya presentation",
                "price": 204
            }
        },
        {
            "painter": {
                "name": "наташа егорова",
                "href": "#"
            },
            "image": {
                "id": "17",
                "url": "pic/gallery4.jpg",
                "href":"#",
                "pictureName": "maya presentation",
                "price": 204
            }
        },
        {
            "painter": {
                "name": "наташа егорова",
                "href": "#"
            },
            "image": {
                "id": "18",
                "url": "pic/gallery8.jpg",
                "href":"#",
                "pictureName": "maya presentation",
                "price": 204
            }
        },
        {
            "painter": {
                "name": "наташа егорова",
                "href": "#"
            },
            "image": {
                "id": "19",
                "url": "pic/gallery5.jpg",
                "href":"#",
                "pictureName": "maya presentation",
                "price": 204
            }
        },
        {
            "painter": {
                "name": "наташа егорова",
                "href": "#"
            },
            "image": {
                "id": "20",
                "url": "pic/gallery10.jpg",
                "href":"#",
                "pictureName": "maya presentation",
                "price": 204
            }
        },
        {
            "painter": {
                "name": "наташа егорова",
                "href": "#"
            },
            "image": {
                "id": "21",
                "url": "pic/gallery11.jpg",
                "href":"#",
                "pictureName": "maya presentation",
                "price": 204
            }
        },
        {
            "painter": {
                "name": "наташа егорова",
                "href": "#"
            },
            "image": {
                "id": "22",
                "url": "pic/gallery1.jpg",
                "href":"#",
                "pictureName": "maya presentation",
                "price": 204
            }
        },
        {
            "painter": {
                "name": "наташа егорова",
                "href": "#"
            },
            "image": {
                "id": "23",
                "url": "pic/gallery7.jpg",
                "href":"#",
                "pictureName": "maya presentation",
                "price": 204
            }
        },
        {
            "painter": {
                "name": "наташа егорова",
                "href": "#"
            },
            "image": {
                "id": "24",
                "url": "pic/gallery6.jpg",
                "href":"#",
                "pictureName": "maya presentation",
                "price": 204
            }
        }
    ]
}';

$json_data = str_replace("\r\n",'',$json_data);
$json_data = str_replace("\n",'',$json_data);
    
echo $json_data;
exit;
?>