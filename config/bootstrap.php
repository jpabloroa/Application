<?php

define("PROJECT_ROOT_PATH", __DIR__ . "/../");
 
// include main configuration file
require_once PROJECT_ROOT_PATH . "/Config/config.php";
 
// include the base controller file
require_once PROJECT_ROOT_PATH . "/Controlador/api/BaseController.php";
 
// include the use model file
require_once PROJECT_ROOT_PATH . "/Modelo/UserModel.php";