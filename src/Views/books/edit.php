<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Libro</title>
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
        .card-header {
            background-color: #c62828; /* Rojo oscuro para el encabezado de la tarjeta */
            color: #ffffff; /* Texto blanco */
        }
        .btn-primary {
            background-color: #c62828; /* Botón en rojo oscuro */
            border: none;
        }
        .btn-primary:hover {
            background-color: #e53935; /* Rojo más claro en hover */
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group img {
            max-width: 200px;
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
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Editar Libro</h2>
                </div>
                <div class="card-body">
                    <form action="/books/update/<?php echo htmlspecialchars($book['ID_BOOK']); ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group mb-3">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($book['NAME']); ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Descripción</label>
                            <textarea class="form-control" id="description" name="description"><?php echo htmlspecialchars($book['DESCRIPTION']); ?></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="author">Autor</label>
                            <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($book['AUTHOR']); ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="<?php echo htmlspecialchars($book['STOCK']); ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="image">Imagen</label>
                            <input type="file" class="form-control" id="image" name="image">
                            <!-- Mostrar la imagen actual -->
                            <?php if (!empty($book['IMAGE'])): ?>
                                <img src="<?php echo htmlspecialchars($book['IMAGE']); ?>" alt="Imagen del Libro" />
                            <?php endif; ?>
                        </div>
                        <div class="form-group mb-3">
                            <label for="editorial">Editorial</label>
                            <select class="form-control" name="editorial" id="editorial" required>
                                <?php foreach($editorials as $editorial): ?>
                                    <option value="<?php echo htmlspecialchars($editorial['ISBN']); ?>" <?php echo $book['ISBN1'] == $editorial['ISBN'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($editorial['NAME']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="genre">Género</label>
                            <select class="form-control" name="genre" id="genre" required>
                                <?php foreach($genres as $genre): ?>
                                    <option value="<?php echo htmlspecialchars($genre['ID_GENRE']); ?>" <?php echo $book['ID_GENRE1'] == $genre['ID_GENRE'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($genre['NAME']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
