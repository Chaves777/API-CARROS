<?php

namespace Controller;

use Model\User;

class UserController
{
    // Função para pegar todos os usuários
    public function getUsers()
    {
        $user = new User();
        $users = $user->getUsers();

        if ($users) {
            // Envia a resposta JSON
            header('Content-Type: application/json', true,200);
            echo json_encode($users);
        } else {
            header('Content-Type: application/json', true,200);
            echo json_encode(["message" => "No users found"]);
        }
    }

    // Função para criar um usuário
    public function createUser()
    {
        // Obtém os dados da requisição
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->name) && isset($data->email)) {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;

            if ($user->createUser()) {
                header('Content-Type: application/json', true,200);
                echo json_encode(["message" => "User created successfully"]);
            } else {
                header('Content-Type: application/json', true,200);
                echo json_encode(["message" => "Failed to create user"]);
            }
        } else {
            header('Content-Type: application/json', true,200);
            echo json_encode(["message" => "Invalid input"]);
        }
    }
    public function updateUser()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->id) && isset($data->name) && isset($data->email)) {
            $user = new User();
            $user->id = $data->id;
            $user->name = $data->name;
            $user->email = $data->email;

             if ($user->updateUser()) {
                header('Content-Type: application/json', true,200);
                echo json_encode(["message" => "User updated successfully"]);
            } else {
                header('Content-Type: application/json', true,200);
                echo json_encode(["message" => "Failed to update user"]);
            }
        } else {
            header('Content-Type: application/json', true,200);
            echo json_encode(["message" => "Invalid input"]);
        }
    }

    public function deleteUser()
    {
        
        $id = $_GET['id'] ?? null;

        if ($id) {
            $user = new User();
            $user->id = $id;

            if ($user->deleteUser()) {
                header('Content-Type: application/json', true,200);
                echo json_encode(["message" => "User deleted successfully"]);
            } else {
                header('Content-Type: application/json', true,200);
                echo json_encode(["message" => "Failed to delete user"]);
            }
        } else {
            header('Content-Type: application/json', true,200);
            echo json_encode(["message" => "Invalid id"]);
        }

    }
}
