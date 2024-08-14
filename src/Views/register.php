<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - IVITEC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f5f5f5; /* Fondo gris claro */
        }
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra sutil */
        }
        .card-header {
            background-color: #c62828; /* Rojo oscuro */
            color: #ffffff; /* Texto blanco */
        }
        .card-header h2 {
            margin-bottom: 0;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #c62828; /* Rojo oscuro */
            border-color: #c62828; /* Rojo oscuro */
        }
        .btn-primary:hover {
            background-color: #b71c1c; /* Rojo más oscuro */
            border-color: #b71c1c; /* Rojo más oscuro */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #c62828;">
    <div class="container-fluid">
        <a class="navbar-brand" href="/index" style="color: #ffffff;">Biblioteca IVITEC</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/index" style="color: #ffffff;">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/catalog" style="color: #ffffff;">Catálogo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/quienes_somos" style="color: #ffffff;">Sobre nosotros</a>
                </li>
                <?php
                if (isset($_SESSION['id'])) {
                    $email = $_SESSION['email'];
                    if ($email === 'admin12345@gmail.com') {
                        echo '<li class="nav-item"><a class="nav-link" href="/loansUsers" style="color: #ffffff;">Préstamos de Usuarios</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="/listUsers" style="color: #ffffff;">Lista de Usuarios</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="/books/list" style="color: #ffffff;">Lista de Libros</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="/genres/list" style="color: #ffffff;">Lista de Géneros</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="/editorials/list" style="color: #ffffff;">Lista de Editoriales</a></li>';
                    } else {
                        echo '<li class="nav-item"><a class="nav-link" href="/Favorites" style="color: #ffffff;">Favoritos</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="/loans" style="color: #ffffff;">Préstamos</a></li>';
                    }
                    echo '<li class="nav-item"><a class="nav-link" href="/accountDetails" style="color: #ffffff;">Cuenta</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="/logout" style="color: #ffffff;">Cerrar sesión</a></li>';
                } else {
                    echo '<li class="nav-item"><a class="nav-link" href="/login" style="color: #ffffff;">Iniciar sesión</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="/register" style="color: #ffffff;">Registrarse</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Registro</h2>
                </div>
                <div class="card-body">
                    <form action="/register" method="post">
                        <div class="form-group mb-3">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="apellido">Apellido</label>
                            <input type="text" name="apellido" id="apellido" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="correo">Correo</label>
                            <input type="email" name="correo" id="correo" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="telefono">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="direccion">Dirección</label>
                            <input type="text" name="direccion" id="direccion" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
