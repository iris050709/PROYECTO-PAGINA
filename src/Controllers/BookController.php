<?php

namespace App\Controllers;

use App\Models\Editorial;
use App\Models\Genre;
use App\Models\Book;

class BookController {

    private $genre;
    private $editorial;
    private $book;

    public function __construct(){
        $this->genre = new Genre();
        $this->editorial = new Editorial();
        $this->book = new Book();
    }

    public function create(){
        $genres = $this->genre->getAll();
        $editorials = $this->editorial->getAll();
        require __DIR__ ."/../Views/books/create.php";
    }

    /*public function store(){
        try {
            $data = $_POST;
    
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $data['image'] = $_FILES['image'];
            } else {
                $data['image'] = null;
            }
    
            $this->book->create($data);
            header('Location: /catalog'); // Redirigir al catálogo después de crear un libro
            exit();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }*/

    public function store() {
        try {
            $data = $_POST;
            
            // Procesar la carga de la imagen
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/uploads/'; // Ruta ajustada
                $imageName = basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $imageName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $data['image'] = 'uploads/' . $imageName;
                } else {
                    throw new \Exception('Error al subir la imagen.');
                }
            } else {
                $data['image'] = null;
            }
            
            $this->book->create($data);
            header('Location: /catalog'); // Redirigir al catálogo después de crear un libro
            exit();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
    

    public function delete($id) {
        try {
            $this->book->delete($id);
            header('Location: /books/list');
            exit();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function list() {
        $books = $this->book->list(); // Obtener los libros
        require __DIR__ . "/../Views/books/list.php"; // Asegúrate de que esta ruta sea correcta
    }
    

    public function edit($id) {
        $genres = $this->genre->getAll();
        $editorials = $this->editorial->getAll();
        $book = $this->book->getById($id); 
        require __DIR__ . "/../Views/books/edit.php";
    }

    /*public function update($id) {
        try {
            $data = $_POST;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $data['image'] = $_FILES['image'];
            } else {
                $data['image'] = null;
            }
            $this->book->update($id, $data);
            header('Location: /catalog'); // Redirigir al catálogo después de actualizar un libro
            exit();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }*/


    public function update($id) {
        try {
            $data = $_POST;
        
            // Procesar la carga de la imagen
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/uploads/'; // Ruta ajustada
                $imageName = basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $imageName;
        
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $data['image'] = 'uploads/' . $imageName;
                } else {
                    throw new \Exception('Error al subir la imagen.');
                }
            } else {
                // Mantener la imagen actual si no se sube una nueva
                $book = $this->book->getById($id);
                $data['image'] = $book['IMAGE'];
            }
        
            $this->book->update($id, $data);
            header('Location: /books/list'); // Redirigir al catálogo después de actualizar un libro
            exit();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
    
}
