<?php

//
if (isset($_SESSION["userControl"]) && $_SESSION["userControl"]) {

    //
    $UserCredentials = $_SESSION["userControl"];

    if (isset($_SESSION["userControl"])) {

        //
        $URL = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $inputUri = explode('/', $URL);

        for ($i = 0; $i < count($inputUri); $i++) {
            if ($inputUri[$i] == "administrador.php") {
                $k = 0;
                $j = $i + 1;

                if ($j < count($inputUri)) {
                    for ($j; $j < count($inputUri); $j++) {
                        $parsedUri[$k] = $inputUri[$j];
                        $k++;
                    }
                } else {

                    require __DIR__ . "/config/bootstrap.php";
                    require PROJECT_ROOT_PATH . "/controller/api/UserController.php";

                    $objFeedController = new UserController();
                    $objFeedController->sendDefaultView();
                }
            }
        }

        require __DIR__ . "/config/bootstrap.php";
        require PROJECT_ROOT_PATH . "/controller/api/UserController.php";
        $objFeedController = new UserController();

        if (isset($parsedUri[0]) && $parsedUri[0] != null) {

            //
            try {
                $objFeedController->httpMethod($parsedUri);
            } catch (Exception $e) {
                $objFeedController->sendOutput(400, [], ["Bad Request", "An error has ocurred during login"], "Detalles: " . $e->getMessage());
            }
        } else {
            $objFeedController->sendDefaultView();
        }
    }
} else {

    require __DIR__ . "/config/bootstrap.php";
    require PROJECT_ROOT_PATH . "/controller/api/UserController.php";

    //
    parse_str($_SERVER['QUERY_STRING'], $urlQuery);
    $objFeedController = new UserController();

    //
    if (isset($urlQuery["key"]) && $urlQuery["key"]) {

        //
        try {

            //
            $queryString = $urlQuery["key"];
            $arrayCredentials = explode(":", $queryString);
            $UserCredentials["user"] = ($arrayCredentials[0] == null || $arrayCredentials[0] == "") ? null : $arrayCredentials[0];
            $UserCredentials["password"] = ($arrayCredentials[1] == null || $arrayCredentials[1] == "") ? null : $arrayCredentials[1];
            $user = $objFeedController->validateCredentials($UserCredentials);

            //
            if (isset($user) && $user) {
                $_SESSION["userControl"] = $user;
                $objFeedController->sendOutput(200, ["user" => $user], ["Login Succesfully"], "Bienvenido $user");
            } else {
                $objFeedController->sendOutput(401, [], ["Unauthorized"], "");
            }
        } catch (Exception $e) {
            $objFeedController->sendOutput(415, [], ["Bad Request", "An error has ocurred during login"], "Detalles: " . $e->getMessage());
        }
    } else {
        $objFeedController->sendOutput(425, [], ["Bad Request"], "");
    }
}
