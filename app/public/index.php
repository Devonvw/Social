<?php
require __DIR__ . '/../router.php';

$uri = trim(strtok($_SERVER["REQUEST_URI"], '?'), '/');
parse_str($_SERVER['QUERY_STRING'], $params);

$router = new Router();
$router->route($uri, $params, $_SERVER['REQUEST_METHOD']);