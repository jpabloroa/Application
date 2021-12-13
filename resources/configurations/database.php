<?php

require __DIR__ . "/config/bootstrap.php";

//
session_start();

//
if (isset($_SESSION["userControl"])) {

    //
    $UserCredentials = $_SESSION["userControl"];

    if (isset($_SESSION["userControl"])) {

        //
        require PROJECT_ROOT_PATH . "/controller/api/UserController.php";
        $objFeedController = new UserController();

        if (isset($view) && $view != null) {

            //
            if ($view == "finalize") {

                //
                $objFeedController->closeSession();
            } else {

                //
                $objFeedController->viewDataBase($parsedUri);
            }
        } else {

            //
            $objFeedController->sendResponse(404, [], ["Not Found"], "");
        }
    }
} else {

    require PROJECT_ROOT_PATH . "/controller/api/UserController.php";

    //
    parse_str($_SERVER['QUERY_STRING'], $urlQuery);
    $objFeedController = new UserController();

    //
    if (isset($urlQuery["key"]) && $urlQuery["key"]) {

        //
        $queryString = $urlQuery["key"];

        //
        $arrayCredentials = explode(":", $queryString);
        $UserCredentials["user"] = ($arrayCredentials[0] == null || $arrayCredentials[0] == "") ? null : $arrayCredentials[0];
        $UserCredentials["password"] = ($arrayCredentials[1] == null || $arrayCredentials[1] == "") ? null : $arrayCredentials[1];
        $objFeedController->validateCredentials($UserCredentials);
    } else {
        $objFeedController->sendResponse(400, [], ["Bad Request"], "No se ha iniciado sesión");
    }
}
