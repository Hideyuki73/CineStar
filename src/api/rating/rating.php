<?php
require_once '../config/db.php';
require_once '../controllers/Rating.php';
require_once 'router.php';

header("Content-type: application/json; charset=UTF-8");

$router = new Router();
$ratingController = new ratingController($pdo);

$router->add('get', '/rating', [$ratingController, 'list']);
$router->add('get', '/rating/{id}', [$ratingController, 'getById']);
$router->add('post', '/rating', [$ratingController, 'create']);
$router->add('delete', '/rating/{id}', [$ratingController, 'delete']);
$router->add('put', '/rating/{id}', [$ratingController, 'update']);

$requestedPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$method = $_SERVER['REQUEST_METHOD'];

