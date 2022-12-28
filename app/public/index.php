<?php
require __DIR__ . '/../router.php';

$uri = trim($_SERVER['REQUEST_URI'], '/');

$router = new Router();
$router->route($uri, $_SERVER['REQUEST_METHOD']);