<?php
require_once '../config/db.php';
require_once '../controllers/User.php';
require_once 'router.php';

header("Content-type: application/json; charset=UTF-8");

$router = new Router();
$userController = new UserController($pdo);
$movieController = new MovieController($pdo);

$router->add('get', '/users', [$userController, 'list']);
$router->add('get', '/users/{id}', [$userController, 'getById']);
$router->add('post', '/users', [$userController, 'create']);
$router->add('delete', '/users/{id}', [$userController, 'delete']);
$router->add('put', '/users/{id}', [$userController, 'update']);

$router->add('get', '/movies', [$movieController, 'list']);
$router->add('get', '/movies/{id}', [$movieController, 'getById']);
$router->add('post', '/movies', [$movieController, 'create']);
$router->add('delete', '/movies/{id}', [$movieController, 'delete']);
$router->add('put', '/movies/{id}', [$movieController, 'update']);

$requestedPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$method = $_SERVER['REQUEST_METHOD'];

