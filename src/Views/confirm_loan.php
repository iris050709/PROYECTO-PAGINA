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

$book_id = isset($_GET['book_id']) ? intval($_GET['book_id']) : 0;
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

// Obtener los detalles del libro
$sql = "SELECT ID_BOOK, NAME, AUTHOR, IMAGE FROM book WHERE ID_BOOK = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $book_id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();
$stmt->close();

if (!$book) {
    echo "<p>El libro con ID $book_id no existe.</p>";
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Préstamo</title>
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
    <!-- Menú de Navegación -->
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
        <h2>Confirmar Préstamo</h2>
        <div class="row">
            <div class="col-md-6">
                <?php
                // Ruta de la imagen del libro
                $imageFile = !empty($book["IMAGE"]) ? $book["IMAGE"] : '/uploads/default-image.jpg';
                $src = htmlspecialchars($imageFile, ENT_QUOTES, 'UTF-8');
                echo '<img src="' . $src . '" class="img-fluid" alt="' . htmlspecialchars($book['NAME'], ENT_QUOTES, 'UTF-8') . '">';
                ?>
            </div>
            <div class="col-md-6">
                <h3><?php echo htmlspecialchars($book['NAME']); ?></h3>
                <p><strong>Autor:</strong> <?php echo htmlspecialchars($book['AUTHOR']); ?></p>
                <form action="/process_loan" method="post">
                    <div class="mb-3">
                        <label for="return_date" class="form-label">Fecha y Hora de regreso</label>
                        <input type="datetime-local" class="form-control" id="return_date" name="return_date" required>
                    </div>
                    <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book_id); ?>">
                    <button type="submit" class="btn btn-success">Confirmar Préstamo</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
$conn->close();
?>
