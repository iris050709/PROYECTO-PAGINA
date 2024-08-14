<?php

namespace App\Controllers;

use App\Models\Genre;
use App\Models\Book;

class GenreController {

    private $genre;
    private $book;

    public function __construct() {
        $this->genre = new Genre();
        $this->book = new Book();
    }

    // Mostrar formulario para crear un nuevo género
    public function create() {
        require __DIR__ . '/../Views/genres/create.php';
    }

    // Almacenar un nuevo género
    public function store() {
        try {
            $data = $_POST;
            if (empty($data['name'])) {
                throw new \Exception('El nombre del género no puede estar vacío.');
            }
            if ($this->genre->exists($data['name'])) {
                throw new \Exception('El género ya existe.');
            }
            $this->genre->create($data);
            header('Location: /genres/list');
            exit();
        } catch (\Exception $e) {
            $error_message = $e->getMessage();
            require __DIR__ . "/../Views/genres/create.php";
        }
    }

    // Listar todos los géneros
    public function list() {
        $genres = $this->genre->getAll();
        require __DIR__ . '/../Views/genres/list.php';
    }

    // Mostrar formulario para editar un género
    public function edit($id) {
        $genre = $this->genre->getById($id);
        require __DIR__ . '/../Views/genres/edit.php';
    }

    // Actualizar un género
    public function update($id) {
        try {
            $data = $_POST;
            if (empty($data['name'])) {
                throw new \Exception('El nombre no puede estar vacío.');
            }
            $this->genre->update($id, $data);
            header('Location: /genres/list');
            exit();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    

    // Eliminar un género
    public function delete($id) {
        try {
            // Primero, maneja los libros asociados con este género
            $this->book->deleteByGenreId($id);

            // Luego, elimina el género
            $this->genre->delete($id);
            header('Location: /genres/list');
            exit();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
