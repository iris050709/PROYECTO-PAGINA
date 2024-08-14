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

$user_id = $_SESSION['id'];

$sql = "SELECT b.ID_BOOK, b.NAME, b.DESCRIPTION, b.AUTHOR, b.IMAGE
        FROM book b
        JOIN FAVORITES f ON b.ID_BOOK = f.ID_BOOK
        WHERE f.ID_USER = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favoritos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .card-img-top {
            width: 100%;
            height: 300px;
            object-fit: contain;
            background-color: #f8f9fa; /* Fondo gris claro para mejorar la visualización */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-img-top:hover {
            transform: scale(1.1); /* Escala la imagen al pasar el cursor */
            box-shadow: 0px 4px 8px rgba(0,0,0,0.2); /* Añade sombra de caja */
        }
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
        .container {
            margin-top: 2rem;
        }
        .btn-success {
            background-color: #c62828; /* Botón en rojo oscuro */
            border: none;
        }
        .btn-success:hover {
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
    <h2>Mis Favoritos</h2>
    <div class="row">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="card h-100">';
                
                $imageFile = $row["IMAGE"];
                $src = $imageFile ? htmlspecialchars($imageFile, ENT_QUOTES, 'UTF-8') : '/uploads/default-image.jpg';
                
                echo '<a href="/bookDetails?id=' . $row["ID_BOOK"] . '">';
                echo '<img src="' . $src . '" class="card-img-top" alt="' . htmlspecialchars($row["NAME"], ENT_QUOTES, 'UTF-8') . '">';
                echo '</a>';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($row["NAME"], ENT_QUOTES, 'UTF-8') . '</h5>';
                echo '<p class="card-text">' . htmlspecialchars($row["DESCRIPTION"], ENT_QUOTES, 'UTF-8') . '</p>';
                echo '<p class="card-text"><small class="text-muted">Autor: ' . htmlspecialchars($row["AUTHOR"], ENT_QUOTES, 'UTF-8') . '</small></p>';
                echo '<form action="/removeFavorite" method="post" class="d-inline">';
                echo '<input type="hidden" name="book_id" value="' . $row["ID_BOOK"] . '">';
                echo '<button type="submit" class="btn btn-danger">Eliminar de Favoritos</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "<p>No tienes libros marcados como favoritos.</p>";
        }
        $stmt->close();
        $conn->close();
        ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
