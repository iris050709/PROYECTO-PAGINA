<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f5f5f5; /* Fondo gris claro */
        }

        .navbar {
            background-color: #b71c1c; /* Rojo oscuro para la barra de navegación */
        }

        .navbar-brand, .nav-link {
            color: #ffffff; /* Texto blanco en la barra de navegación */
        }

        .navbar-brand:hover, .nav-link:hover {
            color: #ffebee; /* Color rosa claro en hover */
        }

        .card {
            border: 1px solid #e0e0e0; /* Borde gris claro para las tarjetas */
            border-radius: 8px; /* Bordes redondeados para las tarjetas */
        }

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

        .card-body {
            background-color: #ffffff; /* Fondo blanco para el cuerpo de la tarjeta */
        }

        .card-title {
            color: #b71c1c; /* Título de la tarjeta en rojo oscuro */
        }

        .card-text {
            color: #757575; /* Color gris para el texto */
        }

        .no-results {
            text-align: center;
            margin-top: 20px;
            color: #b71c1c; /* Color rojo oscuro para el texto de no resultados */
        }

        .input-group .form-control {
            border-radius: 0.25rem 0 0 0.25rem; /* Bordes redondeados para el input de búsqueda */
        }

        .input-group .btn-primary {
            border-radius: 0; /* Bordes sin redondear para el botón de búsqueda */
        }

        .input-group .btn-secondary {
            border-radius: 0 0.25rem 0.25rem 0; /* Bordes redondeados para el botón de borrar */
        }

        .btn-primary {
            background-color: #b71c1c; /* Botón de búsqueda en rojo oscuro */
            border: none;
        }

        .btn-primary:hover {
            background-color: #d32f2f; /* Rojo más claro en hover */
        }

        .btn-secondary {
            background-color: #e0e0e0; /* Color gris claro para el botón de borrar */
            border: none;
        }

        .btn-secondary:hover {
            background-color: #bdbdbd; /* Gris más oscuro en hover */
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
    <h2>Catálogo</h2>
    <!-- Formulario de búsqueda -->
    <form method="GET" action="/catalog" id="searchForm">
        <div class="input-group mb-4">
            <input type="text" id="searchInput" class="form-control" name="search" placeholder="Buscar por nombre o autor" value="<?php echo htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            <button class="btn btn-primary" type="submit">Buscar</button>
            <button class="btn btn-secondary" type="button" id="clearSearch">Borrar</button>
        </div>
    </form>

    <div class="row">
        <?php
        // Conexión a la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "biblioteca";

        // Crear la conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Obtener término de búsqueda
        $searchTerm = $_GET['search'] ?? '';

        // Consulta a la base de datos con búsqueda
        $sql = "SELECT ID_BOOK, NAME, DESCRIPTION, AUTHOR, IMAGE FROM book WHERE NAME LIKE ? OR AUTHOR LIKE ?";
        $stmt = $conn->prepare($sql);
        $searchTermLike = '%' . $searchTerm . '%';
        $stmt->bind_param('ss', $searchTermLike, $searchTermLike);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Mostrar datos de cada fila
            while($row = $result->fetch_assoc()) {
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="card h-100">';
                
                $imageFile = $row["IMAGE"];
                if ($imageFile) {
                    $src = htmlspecialchars($imageFile, ENT_QUOTES, 'UTF-8');
                } else {
                    $src = '/uploads/default-image.jpg'; // Imagen predeterminada
                }
                
                echo '<a href="/bookDetails?id=' . $row["ID_BOOK"] . '">';
                echo '<img src="' . $src . '" class="card-img-top" alt="' . htmlspecialchars($row["NAME"], ENT_QUOTES, 'UTF-8') . '">';
                echo '</a>';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($row["NAME"], ENT_QUOTES, 'UTF-8') . '</h5>';
                echo '<p class="card-text">' . htmlspecialchars($row["DESCRIPTION"], ENT_QUOTES, 'UTF-8') . '</p>';
                echo '<p class="card-text"><small class="text-muted">Autor: ' . htmlspecialchars($row["AUTHOR"], ENT_QUOTES, 'UTF-8') . '</small></p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="no-results">';
            echo '<p class="text-warning">No se encontraron resultados para "<strong>' . htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8') . '</strong>".</p>';
            echo '<p>Intenta con otros términos de búsqueda.</p>';
            echo '</div>';
        }
        $stmt->close();
        $conn->close();
        ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchInput');
        const clearSearchButton = document.getElementById('clearSearch');

        clearSearchButton.addEventListener('click', () => {
            searchInput.value = '';
            const url = new URL(window.location.href);
            url.searchParams.delete('search');
            window.location.href = url.toString();
        });
    });
</script>
</body>
</html>
