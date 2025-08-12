<?php
require __DIR__ . '/vendor/autoload.php';

use Controller\ProductController;
use Model\Connection;

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$database = new Connection();
$db = $database->getConnection();

$controller = new ProductController($db);

$method = $_SERVER['REQUEST_METHOD'];
$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

if ($uri[0] === 'API-SENAI') {
    if ($method === 'GET' && !isset($uri[1])) {
        $controller->listAll();
    } elseif ($method === 'GET' && isset($uri[1])) {
        $controller->show($uri[1]);
    } elseif ($method === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        $controller->create($data);
    } elseif ($method === 'PUT' && isset($uri[1])) {
        $data = json_decode(file_get_contents("php://input"), true);
        $controller->update($uri[1], $data);
    } elseif ($method === 'DELETE' && isset($uri[1])) {
        $controller->delete($uri[1]);
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Rota não encontrada."]);
    }
} else {
    http_response_code(404);
    echo json_encode(["message" => "Endpoint inválido."]);
}

