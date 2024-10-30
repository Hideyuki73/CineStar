<?php
require_once '../config/db.php';
require_once '../controllers/User.php';

header("Content-type: application/json; charset=UTF-8");

$userController = new UserController($pdo);
$movieController = new MovieController($pdo);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $userController->create();
        break;
    case 'GET':
        if (isset($_GET['id'])) {
            $userController->getById($_GET['id']);
        } else {
            $userController->list();
        }
        break;
    case 'PUT':
        $userController->update();
        break;
    case 'DELETE':
        $userController->delete();
        break;
    default:
        http_response_code(405);
        echo json_encode(["message" => "Método não permitido"]);
        break;
}