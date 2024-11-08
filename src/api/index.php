<?php
require_once '../config/db.php';
require_once '../controller/Movie.php';
require_once '../controller/Rating.php';
require_once '../controller/User.php';
require_once '../router.php';

header("Content-type: application/json; charset=UTF-8");

$router = new Router();
$movieController = new MovieController($pdo);
$ratingController = new ratingController($pdo);
$userController = new UserController($pdo);

$router->add('get', '/users', [$userController, 'list']);
$router->add('get', '/users/{id}', [$userController, 'getById']);
$router->add('post', '/users', [$userController, 'create']);
$router->add('delete', '/users/{id}', [$userController, 'delete']);
$router->add('put', '/users/{id}', [$userController, 'update']);

$router->add('get', '/rating', [$ratingController, 'list']);
$router->add('get', '/rating/{id}', [$ratingController, 'getById']);
$router->add('post', '/rating', [$ratingController, 'create']);
$router->add('delete', '/rating/{id}', [$ratingController, 'delete']);
$router->add('put', '/rating/{id}', [$ratingController, 'update']);

$router->add('get', '/movies', [$movieController, 'list']);
$router->add('get', '/movies/{id}', [$movieController, 'getById']);
$router->add('post', '/movies', [$movieController, 'create']);
$router->add('delete', '/movies/{id}', [$movieController, 'delete']);
$router->add('put', '/movies/{id}', [$movieController, 'update']);

$requestedPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$method = $_SERVER['REQUEST_METHOD'];

