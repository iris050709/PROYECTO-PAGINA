<?php

namespace App\Controllers;
use App\Models\Category;
use App\Models\Product;

class ProductController {

    private $category;
    private $product;
    public function __construct(){
        $this->category = new Category();
        $this->product = new Product();
    }

    public function create(){
        $categories= $this->category->getAll();
        require __DIR__ ."/../Views/products/create.php";
    }

    public function store(){
        $data = $_POST;
        $this->product->create($data);
        header('Location: /products/list');
        exit();
    }

    
    public function delete($id) {
        $this->product->delete($id);
        header('Location: /products/list');
        exit();
    }

    public function list() {
        $products = $this->product->list();
        require __DIR__ . "/../Views/products/list.php";
    }

    // Método para mostrar el formulario de edición
    public function edit($id) {
        $categories = $this->category->getAll();
        $product = $this->product->getById($id); 
        require __DIR__ . "/../Views/products/edit.php";
    }

    // Método para procesar la actualización del producto
    public function update($id) {
        $data = $_POST;
        $this->product->update($id, $data);
        header('Location: /products/list');
        exit();
    }
}