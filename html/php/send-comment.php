<?php
/*
    php for processing load the list of authors

    last modified 22.02.2013

    input parameters:

        - direction
        - typeOfWork
        - count

    output parameters:

        - data in json format

*/
    $r = rand(0, 7);

    $attitude = $_POST['attitude'];
    $returnClass = '';

    switch ($attitude) {

        case 'neutral':
            $returnClass = 'authors-profile-comments__author-photo_neutral';
            break;

        case 'positive':
            $returnClass = 'authors-profile-comments__author-photo_positive';
            break;

        case 'negative':
            $returnClass = 'authors-profile-comments__author-photo_negative';
            break;
    }

    if ($r < 3) {

        $json_answer = '{
            "statistic":
            {
                "positive": "' . rand(1, 100) . '",
                "negative": "' . rand(1, 100) . '",
                "neutral": "' .rand(1, 100) . '"
            },
            "array" :[
                {
                    "href": "#",
                    "imgPath": "pic/authors-profile-img5.jpg",
                    "description": "' . $_POST['description'] . '",
                    "attitude": "' . $returnClass . '",
                    "date": "12.04.2011",
                    "time": "11:39"
                }
            ]
        }';
        echo $json_answer;
    }
    else if ($r > 4) {
        $json_answer = '{
            "statistic":
            {
                "positive": "' . rand(1, 100) . '",
                "negative": "' . rand(1, 100) . '",
                "neutral": "' .rand(1, 100) . '"
            },
            "array":[
                {
                    "href": "#",
                    "imgPath": "pic/authors-profile-img5.jpg",
                    "description": "' . $_POST['description'] . '",
                    "attitude": "' . $returnClass . '",
                    "date": "12.04.2011",
                    "time": "11:39"
                },
                {
                    "href": "#",
                    "imgPath": "pic/authors-profile-img2.jpg",
                    "description": "' . $_POST['description'] . '",
                    "attitude": "authors-profile-comments__author-photo_positive",
                    "date": "12.04.2011",
                    "time": "11:39"
                },
                {
                    "href": "#",
                    "imgPath": "pic/authors-profile-img3.jpg",
                    "description": "' . $_POST['description'] . '",
                    "attitude": "authors-profile-comments__author-photo_negative",
                    "date": "12.04.2011",
                    "time": "11:39"
                }
            ]
        }';
        echo $json_answer;
    }
    else {
        header('HTTP/1.0 404');
    }



?>