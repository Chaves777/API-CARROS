<?php
namespace Model;

use PDO;

class Product {
    private $conn;
    private $table_name = "estoque"; 
    public $id;
    public $name;
    public $descricao;
    public $preco;
    public $quantidade;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (name, descricao, preco, quantidade) VALUES (:name, :descricao, :preco, :quantidade)";

        $stmt = $this->conn->prepare($query);

        $this->sanitize();

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":quantidade", $this->quantidade);

        return $stmt->execute();
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET name=:name, descricao=:descricao, preco=:preco, quantidade=:quantidade WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $this->sanitize();

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":preco", $this->preco);
        $stmt->bindParam(":quantidade", $this->quantidade);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        return $stmt->execute();
    }

    private function sanitize() {
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->preco = htmlspecialchars(strip_tags($this->preco));
        $this->quantidade = htmlspecialchars(strip_tags($this->quantidade));
    }
}

