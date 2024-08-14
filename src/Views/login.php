<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        .btn-primary {
            background-color: #c62828; /* Botón en rojo oscuro */
            border: none;
        }
        .btn-primary:hover {
            background-color: #e53935; /* Rojo más claro en hover */
        }
        .card {
            border-radius: 1rem; /* Bordes redondeados */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra sutil */
        }
        .card-header {
            background-color: #c62828; /* Rojo oscuro */
            color: #ffffff; /* Texto blanco */
        }
        .form-control:focus {
            border-color: #c62828; /* Borde rojo oscuro */
            box-shadow: 0 0 0 0.2rem rgba(199, 40, 40, 0.25); /* Sombra de enfoque */
        }
        .alert-danger {
            background-color: #f8d7da; /* Fondo de alerta en rojo claro */
            color: #721c24; /* Texto en rojo oscuro */
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
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h2>Iniciar sesión</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_GET['error'])) {
                            echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8') . '</div>';
                        }
                        ?>
                        <form action="/postLogin" method="post">
                            <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_SERVER['HTTP_REFERER']); ?>">
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Contraseña</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password" class="form-control" required>
                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">Mostrar</button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
                        </form>
                        <p class="mt-3">¿No tienes una cuenta? <a href="/register">Regístrate aquí</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
        }
    </script>
</body>
</html>
