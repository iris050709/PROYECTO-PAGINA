<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¿Quiénes Somos? - IVITEC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f5f5f5; /* Fondo gris claro */
        }
        .navbar {
            background-color: #c62828; /* Rojo oscuro */
        }
        .navbar-brand, .nav-link {
            color: #ffffff; /* Texto blanco */
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #ffebee; /* Rosa claro en hover */
        }
        .container {
            margin-top: 2rem;
        }
        .section-title {
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-size: 2rem;
            font-weight: bold;
            color: #c62828; /* Rojo oscuro */
        }
        .section-content {
            margin-bottom: 2rem;
            padding: 1rem;
            background-color: #ffffff; /* Fondo blanco para las secciones */
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra sutil */
        }
        .section-content p, .section-content ul {
            font-size: 1.1rem;
            color: #333; /* Texto gris oscuro */
        }
        .section-content ul {
            margin-left: 2rem;
        }
        .contact-info {
            background-color: #ffffff; /* Fondo blanco para la sección de contacto */
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra sutil */
            margin-top: 2rem;
        }
        .contact-info a {
            color: #c62828; /* Rojo oscuro */
            text-decoration: none;
        }
        .contact-info a:hover {
            text-decoration: underline;
        }
        .map-container {
            margin-top: 1rem;
            margin-bottom: 2rem;
        }
        .map-container iframe {
            width: 100%;
            height: 400px;
            border: 0;
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

<div class="container">
    <h1 class="section-title">¿Quiénes Somos?</h1>
    
    <section class="section-content">
        <h2>Misión</h2>
        <p>En IVITEC, nos dedicamos a transformar el mundo digital a través de la innovación y la creatividad. Proporcionamos soluciones web personalizadas y conectadas a bases de datos para impulsar el crecimiento y el éxito de empresas de todos los sectores. Nos esforzamos por lograr la excelencia tecnológica y brindar un servicio excepcional atrayendo y desarrollando talentos que compartan nuestra pasión.</p>
    </section>

    <section class="section-content">
        <h2>Visión</h2>
        <p>Ser líderes en la transformación digital global y crear un futuro brillante a través de la innovación y la creatividad. Convertirnos en el referente de soluciones tecnológicas personalizadas, conectando empresas con infinitas posibilidades y ayudando a nuestros clientes a tener éxito en un mundo digital en constante evolución.</p>
    </section>

    <section class="section-content">
        <h2>Objetivo General</h2>
        <p>Desarrollar y ofrecer soluciones innovadoras y eficientes para abordar desafíos actuales, así como también satisfacer las necesidades de nuestros clientes y del mercado, contribuyendo al desarrollo de nuevas ideas y mejorando la calidad de vida en las comunidades que servimos y el facilitar el acceso a la información para así mismo promover el aprendizaje.</p>
    </section>

    <section class="section-content">
        <h2>Objetivos Específicos</h2>
        <ul>
            <li>Ofrecer soluciones personalizadas y adaptadas en base a las necesidades específicas de cada cliente para maximizar su satisfacción.</li>
            <li>Realizar un análisis detallado mediante encuestas para identificar y comprender mejor las necesidades y expectativas de nuestros clientes, con el fin de poder mejorar las soluciones ofrecidas.</li>
            <li>Implementar herramientas de evaluación en base a la experiencia de nuestros clientes permitiendo los puntos débiles y fomentando los estándares de seguridad, con el fin de que operen en un entorno seguro y regulado.</li>
            <li>Diseñar soluciones escalables para obtener un crecimiento rápido y eficiente en el negocio de los clientes, a medida que sus necesidades aumenten.</li>
            <li>Garantizar que todas las propuestas que se tengan hacia el cliente sean claras, eficientes y fáciles de entender para así mismo ir mejorando la confianza de nuestros clientes hacia nuestra empresa.</li>
            <li>Crear u ofrecer algún programa para poder tener un mejor control tanto de atención como para que los clientes tengan una mejor capacitación de recursos educativos para poder maximizar su uso y el poder obtener beneficios.</li>
        </ul>
    </section>
    
    <section class="contact-info">
        <h2>Contacto</h2>
        <p>Para cualquier consulta o información adicional, puedes contactarnos a través de los siguientes medios:</p>
        <p><strong>Teléfono:</strong> 7227943150</p>
        <p><strong>Correo electrónico:</strong> <a href="mailto:ic8281932@gmail.com">ic8281932@gmail.com</a></p>
        <p><strong>Ubicación:</strong></p>
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15058.652882315831!2d-99.4760198!3d19.3404149!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d20a1464000001%3A0x1c254456341588a0!2sUniversidad%20Tecnol%C3%B3gica%20del%20Valle%20de%20Toluca!5e0!3m2!1ses-419!2smx!4v1723261021976!5m2!1ses-419!2smx" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>        
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
