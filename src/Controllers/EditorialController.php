<?php
namespace App\Controllers;

use App\Models\Editorial;
use App\Models\Book;

class EditorialController {
    private $editorial;
    private $book;

    public function __construct(){
        $this->editorial = new Editorial();
        $this->book = new Book();
    }

    public function create() {
        require __DIR__ . "/../Views/editorials/create.php";
    }

    public function store() {
        try {
            $data = $_POST;
            $this->editorial->create($data);
            header('Location: /editorials/list');
            exit();
        } catch (\Exception $e) {
            $error = $e->getMessage();
            require __DIR__ . "/../Views/editorials/create.php";
        }
    }

    public function list() {
        $editorials = $this->editorial->getAll();
        require __DIR__ . "/../Views/editorials/list.php";
    }

    public function edit($id) {
        $editorial = $this->editorial->getById($id); 
        require __DIR__ . "/../Views/editorials/edit.php";
    }

    public function update($id) {
        try {
            $data = $_POST;
            $this->editorial->update($id, $data);
            header('Location: /editorials/list');
            exit();
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $editorial = $this->editorial->getById($id);
            require __DIR__ . "/../Views/editorials/edit.php";
        }
    }

    public function delete($id) {
        try {
            // Primero elimina los libros asociados a la editorial (si es necesario)
            $this->book->deleteByEditorialId($id);
    
            // Luego elimina la editorial
            $this->editorial->delete($id);
    
            // Redirige a la lista de editoriales
            header('Location: /editorials/list');
            exit();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
    
}
