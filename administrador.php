<?php

require __DIR__ . "/config/bootstrap.php";

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

if (isset($parsedUri[0]) && $parsedUri[0]) {
    /*if ($parsedUri[1] || isset($parsedUri[1])) {
        $objFeedController->{$parsedUri[0]}($parsedUri[1]);
    } else {
        $objFeedController->{$parsedUri[0]}();
    }*/
    $objFeedController->httpMethod($parsedUri);
} else {
    $objFeedController->sendDefaultView();
}
