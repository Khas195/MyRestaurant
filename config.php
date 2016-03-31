<?php

// store the main code of the project
defined("HTML_PUBLIC")
or define("HTML_PUBLIC", '../public_html/');
// store img

defined("SERVER_ROOT")
or define("SERVER_ROOT", "http://" . $_SERVER['HTTP_HOST'] . "/MyRestaurant/");
$config = array(

    "paths" => array(
        "image" => SERVER_ROOT . "public_html/img/",
        "css" => SERVER_ROOT . "public_html/css/",
        "js" => SERVER_ROOT . "public_html/javascripts/",
        "lib" => SERVER_ROOT . "resources/lib/",
        "bootstrap" =>SERVER_ROOT."/resources/library/bootstrap/",
        "core" => "../includes/core/",
        "patterns" => "../includes/core/Patterns/",
        "controller" => "../includes/Controller/",
        "model" => "../includes/Model/",
        "view" => "../includes/View/",
        "algorithms" => "../includes/Model/Algorithms/"
    )
);

function FILE_PATH($fileType)
{
    global $config;
    return $config["paths"][$fileType];
}