<?php
require __DIR__ . 
'/vendor/autoload.php';

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

if ($uri[0] === 'API-CARROS') {
    if ($method === 'GET' && !isset($uri[1])) {
        $controller->listAll();
    } elseif ($method === 'GET' && isset($uri[1])) {
        $controller->show();
    } elseif ($method === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        $controller->create($data);
    } elseif ($method === 'PUT' && isset($uri[1])) {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $_GET['id'] ?? null;
        if ($id) {
            $controller->update($id, $data);
        } else {
            http_response_code(400 );
            echo json_encode(["message" => "ID não informado para atualização."]);
        }
    } elseif ($method === 'DELETE' && isset($uri[1])) {
        $id = $_GET["id"] ?? null;
        if ($id) {
            $controller->delete($id);
        } else {
            http_response_code(400 );
            echo json_encode(["message" => "ID não informado para exclusão."]);
        }
    } else {
        http_response_code(404 );
        echo json_encode(["message" => "Rota não encontrada."]);
    }
} else {
    http_response_code(404 );
    echo json_encode(["message" => "Endpoint inválido."]);
}

