<?php

define("PROJECT_ROOT_PATH", __DIR__ . "/../");
 
// include main configuration file
require_once PROJECT_ROOT_PATH . "/config/config.php";
require_once PROJECT_ROOT_PATH . "/config/index.php";
 
// include the base controller file
require_once PROJECT_ROOT_PATH . "/controller/api/BaseController.php";
require_once PROJECT_ROOT_PATH . "/controller/index.php";
require_once PROJECT_ROOT_PATH . "/controller/api/index.php";
 
// include the use model file
require_once PROJECT_ROOT_PATH . "/model/UserModel.php";
require_once PROJECT_ROOT_PATH . "/model/index.php";