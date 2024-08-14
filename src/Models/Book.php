<?php
namespace App\Models;

use App\Core\Database;

class Book {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    /*public function create($data) {
        // Verificar si el nombre del libro ya existe
        if ($this->existsByName($data['name'])) {
            throw new \Exception('El nombre del libro ya existe.');
        }
    
        // Manejar la conversión de la imagen a base64
        $imageData = null;
        if (isset($data['image']) && is_array($data['image']) && $data['image']['error'] === UPLOAD_ERR_OK) {
            $imageData = $this->convertImageToBase64($data['image']);
        }
    
        // Consulta SQL para insertar el libro
        $sql = "INSERT INTO book (NAME, DESCRIPTION, AUTHOR, STOCK, IMAGE, ISBN1, ID_GENRE1) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('sssisii', 
            $data['name'], 
            $data['description'], 
            $data['author'], 
            $data['stock'], 
            $imageData, 
            $data['editorial'],
            $data['genre']
        );
        return $stmt->execute();
    }*/


    public function create($data) {
        // Verificar si el nombre del libro ya existe
        if ($this->existsByName($data['name'])) {
            throw new \Exception('El nombre del libro ya existe.');
        }
    
        // Consulta SQL para insertar el libro
        $sql = "INSERT INTO book (NAME, DESCRIPTION, AUTHOR, STOCK, IMAGE, ISBN1, ID_GENRE1) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('sssisii', 
            $data['name'], 
            $data['description'], 
            $data['author'], 
            $data['stock'], 
            $data['image'],  // Guardar la ruta de la imagen
            $data['editorial'],
            $data['genre']
        );
        return $stmt->execute();
    }
    
    
    // Función para convertir la imagen a base64
    private function convertImageToBase64($image) {
        $imageData = file_get_contents($image['tmp_name']);
        return base64_encode($imageData);
    }
    

    public function list() {
        $sql = "SELECT * FROM book";
        $result = $this->conn->query($sql);
    
        if ($result === false) {
            die('Error en la consulta SQL: ' . $this->conn->error);
        }
    
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
    
    

    /*public function update($id, $data) {
        // Verificar si el nombre del libro ya existe (excluyendo el libro actual)
        if ($this->existsByName($data['name'], $id)) {
            throw new \Exception('El nombre del libro ya existe.');
        }
    
        // Manejar la conversión de la imagen a base64 si hay una imagen nueva
        $imageData = null;
        if (isset($data['image']) && is_array($data['image']) && $data['image']['error'] === UPLOAD_ERR_OK) {
            $imageData = $this->convertImageToBase64($data['image']);
        } else {
            // Obtener la imagen actual si no se ha subido una nueva
            $book = $this->getById($id);
            $imageData = $book['IMAGE'];
        }
    
        // Consulta SQL para actualizar el libro
        $sql = "UPDATE book SET NAME = ?, DESCRIPTION = ?, AUTHOR = ?, STOCK = ?, IMAGE = ?, ISBN1 = ?, ID_GENRE1 = ? WHERE ID_BOOK = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('sssisiis', 
            $data['name'], 
            $data['description'], 
            $data['author'], 
            $data['stock'], 
            $imageData, // Imagen en base64
            $data['editorial'], 
            $data['genre'], 
            $id
        );
    
        return $stmt->execute();
    }*/

    public function update($id, $data) {
        // Verificar si el nombre del libro ya existe (excluyendo el libro actual)
        if ($this->existsByName($data['name'], $id)) {
            throw new \Exception('El nombre del libro ya existe.');
        }
    
        // Consulta SQL para actualizar el libro
        $sql = "UPDATE book SET NAME = ?, DESCRIPTION = ?, AUTHOR = ?, STOCK = ?, IMAGE = ?, ISBN1 = ?, ID_GENRE1 = ? WHERE ID_BOOK = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('sssisiis', 
            $data['name'], 
            $data['description'], 
            $data['author'], 
            $data['stock'], 
            $data['image'],  // Actualizar la ruta de la imagen
            $data['editorial'], 
            $data['genre'], 
            $id
        );
    
        return $stmt->execute();
    }
    
    
    

    public function getById($id) {
        $sql = "SELECT * FROM book WHERE ID_BOOK = ?";
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

    public function delete($id) {
        $sql = "DELETE FROM book WHERE ID_BOOK = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function deleteByEditorialId($editorialId) {
        $sql = "DELETE FROM book WHERE ISBN1 = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $editorialId);
        return $stmt->execute();
    }

    public function deleteByGenreId($genreId) {
        $sql = "DELETE FROM book WHERE ID_GENRE1 = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $genreId);
        return $stmt->execute();
    }

    public function existsByName($name, $excludeId = null) {
        $sql = "SELECT COUNT(*) as count FROM book WHERE NAME = ?";
        if ($excludeId) {
            $sql .= " AND ID_BOOK != ?";
        }
        $stmt = $this->conn->prepare($sql);
        if ($excludeId) {
            $stmt->bind_param('si', $name, $excludeId);
        } else {
            $stmt->bind_param('s', $name);
        }
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'] > 0;
    }
}
