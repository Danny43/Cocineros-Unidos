
<?php
include_once 'Objects/Usuario.php';
session_start();

if (isset($_SESSION['usuario'])) {
    if ($_SESSION['usuario']->rol != 'administrador') {
        header('Location: mainMenuCocinero.php');
    }
} else {
    header('Location: iniciarSesion.php');
}
?>

<!DOCTYPE html>
<html lang="es">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Administrador</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom fonts for this template -->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

        <!-- Plugin CSS -->
        <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/creative.min.css" rel="stylesheet">

    </head>

    <body id="page-top">

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="index.php"><img src="img/logo.png">  Cocineros Unidos</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="#services">Acerca de Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="administracion.php">Administracion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="cerrarSesion.php">Cerrar Sesion</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <header class="masthead text-center text-white d-flex">
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <h1 class="text-uppercase">
                            <strong>Bienvenido Administrador <?php echo $_SESSION['usuario']->nombre; ?></strong>
                        </h1>
                        <hr>
                    </div>
                    <div class="col-lg-8 mx-auto">
                        <p class="text-faded mb-5">Gracias por preferirnos, se conocedor de la gastronomía a nivel nacional e internacional en la comodidad de tu hogar.</p>
                        <a class="btn btn-primary btn-xl js-scroll-trigger" href="#about"><img src=img/recetario.png /> Recetas</a>
                    </div>
                </div>
            </div>
        </header>

        <section class="bg-primary" id="about">
            <div class="container">
                <div class="row">
                    <div class="col">
                        Foto del chef
                    </div>
                    <div class="col-lg-8 mx-auto text-center">
                        <h2 class="section-heading text-white">¡Receta del Día!</h2>
                        <img src="img/stars.png"/>
                        <hr class="light my-4">
                        <p class="text-faded mb-4">Lista de Ingredientes:</p>
                        <a class="btn btn-light btn-xl js-scroll-trigger" href="#services">Preparación</a>
                    </div>
                    <div class="col">
                        FOTO de la receta
                    </div>
                </div>
            </div>
        </section>

        <section id="services">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="section-heading">LA COCINA A TU SERVICIO</h2>
                        <hr class="my-4">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="service-box mt-5 mx-auto">
                            <i class="fas fa-4x fa-book-open text-primary mb-3 sr-icon-1"></i>
                            <h3 class="mb-3">Wikipedia de las recetas</h3>
                            <p class="text-muted mb-0">Millones de recetas para tu cocina con 1 solo click.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="service-box mt-5 mx-auto">
                            <i class="fas fa-4x fa-users text-primary mb-3 sr-icon-2"></i>
                            <h3 class="mb-3">Cocina Internacional</h3>
                            <p class="text-muted mb-0">Chef de todos los lugares del mundo.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="service-box mt-5 mx-auto">
                            <i class="fas fa-4x fa-plus text-primary mb-3 sr-icon-3"></i>
                            <h3 class="mb-3">Sube tus recetas</h3>
                            <p class="text-muted mb-0">Añade tus propias recetas y se el mejor chef.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="service-box mt-5 mx-auto">
                            <i class="fas fa-4x fa-star text-primary mb-3 sr-icon-4"></i>
                            <h3 class="mb-3">Valoración</h3>
                            <p class="text-muted mb-0">Recetas mejores valoradas para que puedas usar</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="p-0" id="portfolio">
            <div class="container-fluid p-0">
                <div class="row no-gutters popup-gallery">
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="img/2.jpg">
                            <img class="img-fluid" src="img/2.jpg" alt="">
                            <div class="portfolio-box-caption">
                                <div class="portfolio-box-caption-content">
                                    <div class="project-category text-faded">
                                        aprende a hacer:
                                    </div>
                                    <div class="project-name">
                                        Paila Marina
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="img/3.jpg">
                            <img class="img-fluid" src="img/3.jpg" alt="">
                            <div class="portfolio-box-caption">
                                <div class="portfolio-box-caption-content">
                                    <div class="project-category text-faded">
                                        aprende a hacer:
                                    </div>
                                    <div class="project-name">
                                        Salmón pochado con reducción cítrica
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="img/4.jpg">
                            <img class="img-fluid" src="img/4.jpg" alt="">
                            <div class="portfolio-box-caption">
                                <div class="portfolio-box-caption-content">
                                    <div class="project-category text-faded">
                                        aprende a hacer:
                                    </div>
                                    <div class="project-name">
                                        Tilapia con salsa merlot y merquen
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="img/5.jpg">
                            <img class="img-fluid" src="img/5.jpg" alt="">
                            <div class="portfolio-box-caption">
                                <div class="portfolio-box-caption-content">
                                    <div class="project-category text-faded">
                                        aprende a hacer:
                                    </div>
                                    <div class="project-name">
                                        Pan de Pascua
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="img/6.jpg">
                            <img class="img-fluid" src="img/6.jpg" alt="">
                            <div class="portfolio-box-caption">
                                <div class="portfolio-box-caption-content">
                                    <div class="project-category text-faded">
                                        aprende a hacer:
                                    </div>
                                    <div class="project-name">
                                        Cola de Mono
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="img/7.jpg">
                            <img class="img-fluid" src="img/7.jpg" alt="">
                            <div class="portfolio-box-caption">
                                <div class="portfolio-box-caption-content">
                                    <div class="project-category text-faded">
                                        aprende a hacer:
                                    </div>
                                    <div class="project-name">
                                        Anticuchos de Sobrecostilla
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-dark text-white">
            <div class="container text-center">
                <h2 class="mb-4"> Repositorio Github </h2>
                <a class="btn btn-light btn-xl sr-button" href="https://github.com/Danny43/Cocineros-Unidos/">VISITANOS</a>
            </div>
        </section>


        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Plugin JavaScript -->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="vendor/scrollreveal/scrollreveal.min.js"></script>
        <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

        <!-- Custom scripts for this template -->
        <script src="js/creative.min.js"></script>

    </body>

</html>
