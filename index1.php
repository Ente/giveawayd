<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/inc/Routes.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/vendor/autoload.php";
use Pecee\SimpleRouter\SimpleRouter as Router;

Router::start();
$debug = Router::startDebug();
echo var_dump($debug);
echo var_dump(Router::debugOutput());

?>