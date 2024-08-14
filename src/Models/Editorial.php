<?php
namespace App\Models;

use App\Core\Database;

class Editorial {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function create($data) {
        if ($this->exists($data['name'])) {
            throw new \Exception('La editorial ya existe.');
        }
        $sql = "INSERT INTO editorial (NAME) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $data['name']);
        return $stmt->execute();
    }

    public function exists($name) {
        $sql = "SELECT COUNT(*) as count FROM editorial WHERE NAME = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'] > 0;
    }

    public function getAll() {
        $sql = "SELECT * FROM editorial";
        $result = $this->conn->query($sql);

        if ($result === false) {
            die('Error en la consulta SQL: ' . $this->conn->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM editorial WHERE ISBN = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function update($id, $data) {
        if ($this->exists($data['name'])) {
            throw new \Exception('La editorial ya existe.');
        }
        $sql = "UPDATE editorial SET NAME = ? WHERE ISBN = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('si', $data['name'], $id);
        return $stmt->execute();
    }

    public function delete($id) {
        if (!$this->tableExists('editorial')) {
            throw new \Exception('La tabla editorial no existe.');
        }
    
        $sql = "DELETE FROM editorial WHERE ISBN = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
    
    private function tableExists($tableName) {
        $result = $this->conn->query("SHOW TABLES LIKE '{$tableName}'");
        return $result && $result->num_rows > 0;
    }
    
}
