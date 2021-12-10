<?php

require __DIR__ . "/config/bootstrap.php";

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

                    require PROJECT_ROOT_PATH . "/controller/api/UserController.php";

                    $objFeedController = new UserController();
                    $objFeedController->sendDefaultView();
                }
            }
        }

        require PROJECT_ROOT_PATH . "/controller/api/UserController.php";
        $objFeedController = new UserController();

        if (isset($parsedUri[0]) && $parsedUri[0] != null) {

            //
            try {
                $objFeedController->httpMethod($parsedUri);
            } catch (Exception $e) {
                echo "Error! detalles:" . $e->getMessage();
            }
        } else {
            $objFeedController->sendDefaultView();
        }
    }
} else {

    require PROJECT_ROOT_PATH . "/controller/api/UserController.php";

    echo $_SERVER['QUERY_STRING'];
    /*
    //
    $urlQuery = $_SERVER['QUERY_STRING'];

    //
    if (isset($urlQuery["key"]) && $urlQuery["key"]) {

        //
        $queryString = $urlQuery["key"];
        $UserCredentials = explode(":", $queryString);
        $objFeedController = new UserController();
        $user = $objFeedController->validateCredentials($UserCredentials);

        //
        if (isset($user) && $user) {
            $_SESSION["userControl"] = $user;
        } else {
            $objFeedController = new UserController();
            $objFeedController->sendOutput(401, [], ["Unauthorized"], "");
        }
    } else {
        $objFeedController = new UserController();
        $objFeedController->sendOutput(400, [], ["Bad Request"], "");
    }*/
}
