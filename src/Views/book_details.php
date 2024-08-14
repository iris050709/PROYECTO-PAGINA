<?php
session_start(); // Asegúrate de que esta línea esté al principio del archivo

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Verificar si el libro ya está en favoritos
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
$isFavorite = false;
$hasLoan = false;

if ($user_id) {
    $sql = "SELECT * FROM FAVORITES WHERE ID_USER = ? AND ID_BOOK = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $book_id);
    $stmt->execute();
    $isFavorite = $stmt->get_result()->num_rows > 0;
    $stmt->close();

    // Verificar si el libro ya está prestado al usuario
    $sql = "SELECT * FROM LOANS WHERE ID_USER = ? AND ID_BOOK = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $book_id);
    $stmt->execute();
    $hasLoan = $stmt->get_result()->num_rows > 0;
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Libro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f5f5f5; /* Fondo gris claro */
        }
        .navbar {
            background-color: #c62828; /* Rojo oscuro para la barra de navegación */
            border-bottom: 1px solid #e0e0e0; /* Borde gris claro */
        }
        .navbar-brand, .nav-link {
            color: #ffffff; /* Texto blanco en la barra de navegación */
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #ffebee; /* Color rosa claro en hover */
        }
        .book-img {
            width: 100%;
            height: 400px;
            object-fit: contain;
            background-color: #f8f9fa;
        }
        .btn-custom {
            background-color: #c62828; /* Rojo oscuro para los botones */
            border: none;
            color: #ffffff; /* Texto blanco */
        }
        .btn-custom:hover {
            background-color: #e53935; /* Rojo más claro en hover */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/index">Biblioteca IVITEC</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/index">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/catalog">Catálogo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/quienes_somos">Sobre nosotros</a>
                </li>
                <?php
                if (isset($_SESSION['id'])) {
                    $email = $_SESSION['email'];
                    if ($email === 'admin12345@gmail.com') {
                        echo '<li class="nav-item"><a class="nav-link" href="/loansUsers">Préstamos de Usuarios</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="/listUsers">Lista de Usuarios</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="/books/list">Lista de Libros</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="/genres/list">Lista de Géneros</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="/editorials/list">Lista de Editoriales</a></li>';
                    } else {
                        echo '<li class="nav-item"><a class="nav-link" href="/Favorites">Favoritos</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="/loans">Préstamos</a></li>';
                    }
                    echo '<li class="nav-item"><a class="nav-link" href="/accountDetails">Cuenta</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="/logout">Cerrar sesión</a></li>';
                } else {
                    echo '<li class="nav-item"><a class="nav-link" href="/login">Iniciar sesión</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="/register">Registrarse</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4">
    <?php
    // Mostrar los detalles del libro
    $sql = "SELECT ID_BOOK, NAME, DESCRIPTION, AUTHOR, IMAGE FROM book WHERE ID_BOOK = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imageFile = $row["IMAGE"];
        $src = $imageFile ? htmlspecialchars($imageFile, ENT_QUOTES, 'UTF-8') : '/uploads/default-image.jpg';
        echo '<div class="row">';
        echo '<div class="col-md-6">';
        echo '<img src="' . $src . '" class="book-img" alt="' . htmlspecialchars($row["NAME"], ENT_QUOTES, 'UTF-8') . '">';
        echo '</div>';
        echo '<div class="col-md-6">';
        echo '<h2>' . htmlspecialchars($row["NAME"], ENT_QUOTES, 'UTF-8') . '</h2>';
        echo '<p>' . htmlspecialchars($row["DESCRIPTION"], ENT_QUOTES, 'UTF-8') . '</p>';
        echo '<p><strong>Autor:</strong> ' . htmlspecialchars($row["AUTHOR"], ENT_QUOTES, 'UTF-8') . '</p>';

        if ($user_id) {
            $favoriteAction = $isFavorite ? '/removeFavorite' : '/addFavorite';
            $favoriteText = $isFavorite ? 'Eliminar de Favoritos' : 'Agregar a Favoritos';

            echo '<form action="' . $favoriteAction . '" method="post" class="d-inline">';
            echo '<input type="hidden" name="book_id" value="' . $row["ID_BOOK"] . '">';
            echo '<button type="submit" class="btn btn-custom">' . $favoriteText . '</button>';
            echo '</form>';

            if ($hasLoan) {
                echo '<button class="btn btn-custom ms-2" disabled>Ya tiene un préstamo activo</button>';
            } else {
                echo '<form action="/confirm_loan" method="get" class="d-inline ms-2">';
                echo '<input type="hidden" name="book_id" value="' . $row["ID_BOOK"] . '">';
                echo '<button type="submit" class="btn btn-custom">Solicitar Préstamo</button>';
                echo '</form>';
            }
        } else {
            echo '<a href="/login" class="btn btn-custom">Agregar a Favoritos</a>';
            echo '<a href="/login" class="btn btn-custom ms-2">Solicitar Préstamo</a>';
        }

        echo '</div>';
        echo '</div>';
    } else {
        echo "<p>No se encontraron detalles para este libro.</p>";
    }
    $stmt->close();
    $conn->close();
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
