<?php

use App\Core\Router;
use App\Middleware\AuthMiddleware;

$router = new Router();

$router->add('/login', 'AuthController@showLogin');
$router->add('/postLogin', 'AuthController@login', 'POST');
$router->add('/register', 'AuthController@showRegister');
$router->add('/register', 'AuthController@sendRegister', 'POST');
$router->add('/home', 'HomeController@home', 'GET', [[AuthMiddleware::class, 'handle']]);
$router->add('/logout', 'AuthController@logout');
$router->add('/index', 'AuthController@showIndex');
$router->add('/catalog', 'AuthController@showCatalog');
$router->add('/bookDetails', 'AuthController@showBook');
$router->add('/confirm_loan', 'AuthController@showConfirmBook');
$router->add('/loans', 'AuthController@showLoans');
$router->add('/loansUsers', 'AuthController@showLoansUsers');
$router->add('/process_loan', 'AuthController@process_loan', 'POST');
$router->add('/addFavorite', 'AuthController@addFavorite', 'POST');
$router->add('/Favorites', 'AuthController@showFavorites');
$router->add('/removeFavorite', 'AuthController@removeFavorite', 'POST');
$router->add('/requestLoan', 'AuthController@requestLoan', 'POST');
$router->add('/deleteLoan', 'AuthController@deleteLoan', 'POST');
// Mostrar el formulario de edición de usuario
$router->add('/editUser', 'AuthController@showEditUser');

// Procesar la actualización de usuario
$router->add('/updateUser', 'AuthController@updateUser', 'POST');

// Procesar la eliminación de usuario
$router->add('/deleteUser', 'AuthController@deleteUser', 'POST');

// Mostrar la lista de usuarios
$router->add('/listUsers', 'AuthController@listUsers');

$router->add('/quienes_somos', 'AuthController@showQuienesSomos');

$router->add('/accountDetails', 'AuthController@showAccountDetails');
$router->add('/changePassword', 'AuthController@showChangePassword');
$router->add('/changePassword', 'AuthController@changePassword', 'POST');

// Rutas de productos
$router->add('/books/create', 'BookController@create');
$router->add('/books/create', 'BookController@store', 'POST');
$router->add('/books/list', 'BookController@list');
$router->add('/books/delete/{id}', 'BookController@delete', 'POST');
$router->add('/books/edit/{id}', 'BookController@edit');
$router->add('/books/update/{id}', 'BookController@update', 'POST');


$router->add('/genres/create', 'GenreController@create');
$router->add('/genres/create', 'GenreController@store', 'POST');
$router->add('/genres/list', 'GenreController@list');
$router->add('/genres/delete/{id}', 'GenreController@delete', 'POST');
$router->add('/genres/edit/{id}', 'GenreController@edit');
$router->add('/genres/update/{id}', 'GenreController@update', 'POST');


$router->add('/editorials/create', 'EditorialController@create');
$router->add('/editorials/store', 'EditorialController@store', 'POST');
$router->add('/editorials/list', 'EditorialController@list');
$router->add('/editorials/delete/{id}', 'EditorialController@delete', 'POST');
$router->add('/editorials/edit/{id}', 'EditorialController@edit');
$router->add('/editorials/update/{id}', 'EditorialController@update', 'POST');



return $router;

