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
            header('Content-Type: application/json');
            echo json_encode($users);
        } else {
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
                echo json_encode(["message" => "User created successfully"]);
            } else {
                echo json_encode(["message" => "Failed to create user"]);
            }
        } else {
            echo json_encode(["message" => "Invalid input"]);
        }
    }
}
