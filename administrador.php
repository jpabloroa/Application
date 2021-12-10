<?php

echo __DIR__;
require __DIR__ . "/config/bootstrap.php";

echo "no hay error luego de añadir bootsrapp.php";

$URL = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$inputUri = explode('/', $URL);

echo "no hay error lugo de parsear la uri";

for ($i = 0; $i < count($inputUri); $i++) {
    if ($inputUri[$i] == "administrador.php") {
        $k = 0;
        $j = $i + 1;

        echo "no hay error lugo de encontrar admon.php en el parseo";

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

echo "no hay error lugo del loop";

require PROJECT_ROOT_PATH . "/controller/api/UserController.php";
$objFeedController = new UserController();

echo "no hay error lluego de crer el objeto";

if (isset($parsedUri[0]) && $parsedUri[0]) {
    /*if ($parsedUri[1] || isset($parsedUri[1])) {
        $objFeedController->{$parsedUri[0]}($parsedUri[1]);
    } else {
        $objFeedController->{$parsedUri[0]}();
    }*/
    echo "no hay error al disparar httpMethod";
    $objFeedController->httpMethod($parsedUri);
} else {
    $objFeedController->sendDefaultView();
}
?>