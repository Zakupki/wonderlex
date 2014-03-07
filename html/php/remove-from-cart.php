<?php

$lang = $_GET[ 'lang' ];
$id = $_GET[ 'id' ];

$json_data = '{
    "header": "<span class=\"cart__header-count\">6</span> товаров – <span class=\"cart__header-price\">719 700 грн</span>",
    "itemsCount": 6
}';



$json_data = str_replace("\r\n",'',$json_data);
$json_data = str_replace("\n",'',$json_data);

echo $json_data;
exit;
?>