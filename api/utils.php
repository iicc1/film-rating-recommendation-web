<?php

//echo json_encode($_FILES["image"]);

function generateRandomString($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getExtension($mime_type){
    $extensions = array('image/jpeg' => '.jpg',
                        'image/png' => '.png'
                       );
    return $extensions[$mime_type];
}

function number_format(number) {
    return (float)$number, 2, '.', '');
}


?>