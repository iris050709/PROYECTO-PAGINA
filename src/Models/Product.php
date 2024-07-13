<?php
namespace App\Models;

use App\Core\Database;

class Product{
    private $conn;

    public function __construct(){
        $this->conn =  Database::getInstance()->getConnection();
    }

    public function create($data){
        $sql = "INSERT INTO products (name, description, price, stock, category_id) 
        VALUES(?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ssiii',
            $data['name'],
            $data['description'],
            $data['price'],
            $data['stock'],
            $data['category']);
        return $stmt->execute();
    }
    public function list() {
        $sql = "SELECT * FROM products";
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
    

    // Método para modificar un producto

    public function update($id, $data) {
        $sql = "UPDATE products SET name = ?, description = ?, price = ?, stock = ?, category_id = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ssiiii', 
            $data['name'], 
            $data['description'], 
            $data['price'], 
            $data['stock'], 
            $data['category'], 
            $id
        );
        return $stmt->execute();
    }

    public function getById($id) {
        $sql = "SELECT * FROM products WHERE id = ?";
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
    
    

    // Método para borrar un producto
    public function delete($id) {
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    
}