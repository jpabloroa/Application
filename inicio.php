<?php

// First, let's define our list of routes.
// We could put this in a different file and include it in order to separate
// logic and configuration.
$routes = [
    "/" => "administrador/clientes/",
    "/hello" => "perico.php",
    "error_404" => "pages/error_page.php?error=404"
];

// This is our router.
function router($routes)
{
    // Iterate through a given list of routes.
    foreach ($routes as $path => $content) {
        if ($path == "/" . $_REQUEST["view"]) {
            // If the path matches, display its contents and stop the router.
            include($content);
            exit;
        }
    }

    // This can only be reached if none of the routes matched the path.
    include($routes["error_404"]);
}

// Execute the router with our list of routes.
router($routes);
