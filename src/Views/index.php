<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Biblioteca IVITEC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .navbar {
            background-color: #b71c1c;
            border-bottom: 1px solid #e0e0e0;
        }
        .navbar-brand, .nav-link {
            color: #ffffff;
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #ffebee;
        }
        .image-gallery {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 2rem;
        }
        .image-gallery img {
            height: 400px; /* Ajusta la altura de las imágenes según tus necesidades */
            width: 400px;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .library-details {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 0.5rem;
            margin-top: 2rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .library-details h2 {
            margin-bottom: 1.5rem;
            color: #b71c1c;
        }
        .library-details ul {
            list-style: none;
            padding-left: 0;
        }
        .library-details ul li {
            margin-bottom: 0.5rem;
            color: #757575;
        }
        .btn-primary {
            background-color: #b71c1c;
            border: none;
        }
        .btn-primary:hover {
            background-color: #d32f2f;
        }
        .btn-secondary {
            background-color: #e0e0e0;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #bdbdbd;
        }
        .carousel-item {
            height: 400px; /* Altura fija para la imagen */
            background-color: #e0e0e0; /* Fondo cuando la imagen no llena el contenedor */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .carousel-item img {
            max-width: 100%; /* Ajusta el ancho máximo al 100% del contenedor */
            max-height: 100%; /* Asegura que la altura no exceda los 400px */
            object-fit: contain; /* Contiene la imagen dentro del contenedor */
            border-radius: 0.5rem;
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

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="display-4 text-center">Bienvenido a la Biblioteca IVITEC</h1>
            <p class="text-center lead">Explora nuestra colección de libros y más.</p>
        </div>
    </div>


    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="imagenes/cien_anos_de_soledad.jpg" class="d-block w-100" alt="Cien años de soledad">
            </div>
            <div class="carousel-item">
                <img src="imagenes/la_casa_de_papel.jpg" class="d-block w-100" alt="La Casa de Papel">
            </div>
            <div class="carousel-item">
                <img src="imagenes/la_sombra_del_viento.jpg" class="d-block w-100" alt="La Sombra del Viento">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!--<section class="image-gallery">
        <img src="imagenes/cien_anos_de_soledad.jpg" alt="Cien años de soledad">
        <img src="imagenes/la_casa_de_papel.jpg" alt="La Casa de Papel">
        <img src="imagenes/la_sombra_del_viento.jpg" alt="La Sombra del Viento">
    </section>-->

    <section class="library-details">
        <h2>Detalles de la Biblioteca</h2>
        <p><strong>Horario de Apertura:</strong></p>
        <ul>
            <li>Lunes a Viernes: 09:00 - 18:00</li>
            <li>Sábados: 10:00 - 14:00</li>
            <li>Cerrado: Domingos y Festivos</li>
        </ul>
        <p><strong>Servicios Ofrecidos:</strong></p>
        <ul>
            <li>Préstamo de libros</li>
            <li>Acceso a Internet y áreas de estudio</li>
            <li>Programas y eventos culturales</li>
            <li>Asesoría en investigación y búsqueda de información</li>
        </ul>
        <p><strong>Dirección:</strong></p>
        <p>Avenida de la Cultura, 123 - Ciudad del Libro, CP 45678</p>
        <p><strong>Contacto:</strong></p>
        <p>Teléfono: (123) 456-7890</p>
        <p>Email: contacto@bibliotecaivitec.com</p>
        <a href="/catalog" class="btn btn-primary">Explorar el Catálogo</a>
        <a href="/quienes_somos" class="btn btn-secondary">Conocer Más</a>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-VmmXuR1/XxfQKIv13AZLFnsUPMc82f6ZciSD5WfJGRZ1skLMzt/B4ejb5p4l5kbp" crossorigin="anonymous"></script>
</body>
</html>
