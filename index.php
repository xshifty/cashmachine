<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', realpath('.') . DS);

include 'app/bootstrap.php';

$app = Bootstrap::init();
$app->run();
