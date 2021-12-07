<?php

require __DIR__ . "/config/bootstrap.php";

$URL = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$inputUri = explode('/', $URL);

for ($i = 0; $i < count($inputUri); $i++) {
    if ($inputUri[$i] == "index.php") {
        $k = 0;
        $j = $i + 1;
        if ($j < count($inputUri)) {
            for ($j; $j < count($inputUri); $j++) {
                $parsedUri[$k] = $inputUri[$j];
                $k++;
            }
        } else {

            //
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                $link = "https";
            } else {
                $link = "http";
            }

            // Here append the common URL characters.
            $link .= "://";

            // Append the host(domain name, ip) to the URL.
            $link .= $_SERVER['HTTP_HOST'];

            // Append the requested resource location to the URL
            $link .= substr($URL, 0, -9) . "index.html";

            //
            header("location: $link");
            exit;
        }
    }
}

require PROJECT_ROOT_PATH . "/controller/api/UserController.php";

if (isset($parsedUri[0]) && $parsedUri[0] == "root") {
    $objFeedController = new UserController();
    $objFeedController->{$parsedUri[0]}();
} else {
    if (isset($parsedUri[1])) {     
        $objFeedController = new UserController();
        $objFeedController->httpMethod($parsedUri);
    } else {
    }
}