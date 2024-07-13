<?php

use App\Core\Router; //EL ARCHIVO SE VA A TRABAJAR DENTRO DE ESA CARPETA
use App\Middleware\AuthMiddleware;

$router = new Router();

#$router->add('/lista/usuarios', 'HomeController@index'); //RECIBE EL PATH Y EL CALLBACK
$router->add('/', 'AuthController@showlogin');
$router->add('/postLogin', 'AuthController@login','POST');
$router->add('/register', 'AuthController@showRegister');
$router->add('/register', 'AuthController@sendRegister', 'POST');
$router->add('/home','HomeController@home','GET', [[AuthMiddleware::class, 'handle']]);
$router->add('/logout', 'AuthController@logout');


// Rutas de productos
$router->add('/products/create', 'ProductController@create');
$router->add('/products/create', 'ProductController@store', 'POST');
$router->add('/products/list', 'ProductController@list');
$router->add('/products/delete/{id}', 'ProductController@delete', 'POST');
// Rutas para editar productos
$router->add('/products/edit/{id}', 'ProductController@edit'); // Mostrar formulario de edición
$router->add('/products/update/{id}', 'ProductController@update', 'POST'); // Procesar actualización
return $router; //CTRL - SHIFT, R - F7 PARA LIBERAR EL CACHE, LA INFORMACION QUE SE ALMACENA TEMPORALMENTE

