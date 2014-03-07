<?php
/**
 * Date: 04.07.13
 * Time: 11:00
 * like button click
 *
 * input param (type='get'):
 *      - productId
 *
 * response:
 *      - like count
 */

$r = rand(0, 5);

if ($r > 2) {
    header('HTTP/1.0 200 OK');
    $json = '{
        "message": "OK",
        "count": "' . rand(500, 1000) . '"
    }';
}
else {
    header('HTTP/1.0 202 Not content');
    $json = '{
        "message": "Not content",
        "count": "390"
    }';
}

echo $json;







