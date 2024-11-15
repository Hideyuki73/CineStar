<?php
require_once '../config/db.php';
require_once '../controller/Movie.php';
require_once '../controller/User.php';
require_once '../router.php';

$router = Router::getInstance();

$router->add('GET', '/movies', function () { 
    if(isset($_GET["id"])){
        MovieController::getInstance()->getById($_GET["id"]);
    } else {
        MovieController::getInstance()->list();
    }
});
$router->add('POST', '/movies', function () { MovieController::getInstance()->create();});
$router->add('DELETE', '/movies', function () { MovieController::getInstance()->delete();});
$router->add('PUT', '/movies', function () { MovieController::getInstance()->update();});

$router->add('GET', '/users', function () { 
    if(isset($_GET["id"])){
        UserController::getInstance()->getById($_GET["id"]);
    } elseif (isset($_GET["email"])) {
        UserController::getInstance()->getByEmail($_GET["email"]);
    } else {
        UserController::getInstance()->list();
    }
});

$router->add('POST', '/users/login', function () { 
    UserController::getInstance()->login();
});
$router->add('GET', '/users', function () { UserController::getInstance()->list();});
$router->add('POST', '/users', function () { UserController::getInstance()->create();});
$router->add('DELETE', '/users', function () { UserController::getInstance()->delete();});
$router->add('PUT', '/users', function () { UserController::getInstance()->update();});


Router::getInstance()->process();

