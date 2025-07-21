<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Model/User.php';
require_once __DIR__ . '/Controller/UserController.php';

use Controller\UserController;

$method = $_SERVER['REQUEST_METHOD'];

$userController = new UserController();

switch ($method) {
    case 'GET':
        $userController->getUsers();
        break;
    case 'POST':
        $userController->createUser();
        break;
    default:
        echo json_encode(["message" => "Method not allowed"]);
        break;
}

if (empty($usuario)) {
    echo "Vazio!";
}
