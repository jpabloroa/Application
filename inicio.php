<?php

$routes = [

    // Routes
    "/inicio" => "/administrador.php",
    "/" => "/perico.php",
    "/" => "",



    //Error codes
    "error_404" => "/pages/error_page.php"
];

//
foreach ($routes as $path => $content) {

    if ($path == "/" . $_REQUEST["view"]) {

        //
        include(__DIR__ . $content);
        exit;
    }
}

//
include(__DIR__ . $routes["error_404"]);
exit;
