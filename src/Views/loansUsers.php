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

// Obtener los préstamos de todos los usuarios
$sql = "SELECT l.ID_LOAN, l.ID_BOOK, b.NAME, b.AUTHOR, l.LOAN_DATE, l.RETURN_DATE, u.FIRST_NAME, u.LAST_NAME
        FROM loans l
        JOIN book b ON l.ID_BOOK = b.ID_BOOK
        JOIN users u ON l.ID_USER = u.ID_USER";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Préstamos</title>
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
        .btn-warning {
            background-color: #f57f17; /* Color naranja para el botón de editar */
            border: none;
        }
        .btn-warning:hover {
            background-color: #f57f17; /* Mismo color en hover para el botón de editar */
        }
        .btn-danger {
            background-color: #d32f2f; /* Color rojo oscuro para el botón de eliminar */
            border: none;
        }
        .btn-danger:hover {
            background-color: #c62828; /* Rojo más oscuro en hover para el botón de eliminar */
        }
        .table thead th {
            background-color: #c62828; /* Rojo oscuro para el encabezado de la tabla */
            color: #ffffff; /* Texto blanco en el encabezado */
        }
        .card-header {
            background-color: #c62828; /* Rojo oscuro para el encabezado del card */
            color: #ffffff; /* Texto blanco en el encabezado del card */
        }
        .card-body {
            background-color: #ffffff; /* Fondo blanco para el cuerpo del card */
            border: 1px solid #e0e0e0; /* Borde gris claro para el cuerpo del card */
            border-radius: 0.375rem; /* Radio del borde para el card */
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
    <div class="card">
        <div class="card-header">
            <h2 class="text-center">Lista de Préstamos</h2>
        </div>
        <div class="card-body">
            <?php if ($result->num_rows > 0): ?>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nombre del Libro</th>
                            <th>Autor</th>
                            <th>Fecha de Préstamo</th>
                            <th>Fecha de Regreso</th>
                            <th>Nombre del Usuario</th>
                            <th>Apellido del Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['NAME']); ?></td>
                                <td><?php echo htmlspecialchars($row['AUTHOR']); ?></td>
                                <td><?php echo htmlspecialchars($row['LOAN_DATE']); ?></td>
                                <td><?php echo htmlspecialchars($row['RETURN_DATE']); ?></td>
                                <td><?php echo htmlspecialchars($row['FIRST_NAME']); ?></td>
                                <td><?php echo htmlspecialchars($row['LAST_NAME']); ?></td>
                                <td>
                                    <form action="/deleteLoan" method="post" style="display:inline;">
                                        <input type="hidden" name="loan_id" value="<?php echo htmlspecialchars($row['ID_LOAN']); ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay préstamos activos en este momento.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
$conn->close();
?>