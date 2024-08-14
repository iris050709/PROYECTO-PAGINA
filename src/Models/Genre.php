<?php
namespace App\Models;

use App\Core\Database;

class Genre {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Obtener todos los géneros
    public function getAll() {
        $sql = "SELECT * FROM genre";
        $query = $this->conn->query($sql);
        $genres = [];
        while ($row = $query->fetch_assoc()) {
            $genres[] = $row;
        }
        return $genres;
    }

    // Crear un nuevo género
    public function create($data) {
        $sql = "INSERT INTO genre (NAME) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $data['name']);
        return $stmt->execute();
    }
    

    // Obtener un género por ID
    public function getById($id) {
        $sql = "SELECT * FROM genre WHERE ID_GENRE = ?";
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

    // Actualizar un género
    public function update($id, $data) {
        $sql = "UPDATE genre SET NAME = ? WHERE ID_GENRE = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('si', $data['name'], $id);
        return $stmt->execute();
    }
    

    // Eliminar un género
    public function delete($id) {
        $sql = "DELETE FROM genre WHERE ID_GENRE = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    // Verificar si un género ya existe
    public function exists($name) {
        $sql = "SELECT * FROM genre WHERE NAME = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
}
