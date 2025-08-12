<?php
namespace Model;

use PDO;
use PDOException;

class Connection {
    private $host = "127.0.0.1";
    private $db_name = "apirest"; // sem espaço
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo json_encode(["error" => "Erro na conexão: " . $exception->getMessage()]);
            exit;
        }
        return $this->conn;
    }
}
