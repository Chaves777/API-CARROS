<?php
namespace Controller;

use Model\Product;

class ProductController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function listAll() {
        $product = new Product($this->db);
        $stmt = $product->readAll();
        echo json_encode($stmt->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function show($id) {
        $product = new Product($this->db);
        $product->id = $id;
        $stmt = $product->readOne();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($data) {
            echo json_encode($data);
        } else {
            http_response_code(404 );
            echo json_encode(["message" => "Produto não encontrado."]);
        }
    }

    public function create($data) {
        $product = new Product($this->db);
        $product->marca = $data["marca"] ?? "";
        $product->name = $data["name"] ?? "";
        $product->descricao = $data["descricao"] ?? "";
        $product->preco = $data["preco"] ?? 0;
        $product->quantidade = $data["quantidade"] ?? 0;


        if ($product->create()) {
            http_response_code(201 );
            echo json_encode(["message" => "Produto criado com sucesso."]);
        } else {
            http_response_code(400 );
            echo json_encode(["message" => "Não foi possível criar o produto."]);
        }
    }

    public function update($id, $data) {
        $product = new Product($this->db);
        $product->id = $id;
        $product->marca = $data["marca"] ?? "";
        $product->name = $data["name"] ?? "";
        $product->descricao = $data["descricao"] ?? "";
        $product->preco = $data["preco"] ?? 0;
        $product->quantidade = $data["quantidade"] ?? 0;

        if ($product->update()) {
            echo json_encode(["message" => "Produto atualizado com sucesso."]);
        } else {
            http_response_code(400 );
            echo json_encode(["message" => "Não foi possível atualizar o produto."]);
        }
    }

    public function delete($id) {
        $product = new Product($this->db);
        $product->id = $id;

        if ($product->delete()) {
            echo json_encode(["message" => "Produto excluído com sucesso."]);
        } else {
            http_response_code(400 );
            echo json_encode(["message" => "Não foi possível excluir o produto."]);
        }
    }
}
    