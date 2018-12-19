<?php
require_once 'DB/CRUD/UsuarioCRUD.php';
require_once 'DB/CRUD/IngredienteCRUD.php';
require_once 'DB/CRUD/ComposicionCRUD.php';
require_once 'DB/CRUD/CalificacionCRUD.php';

session_start();

if (!isset($_SESSION['usuario'])) {
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

        <title>Top Recetas | Cocineros Unidos</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Animaciones -->

        <link href="css/animate.css" rel="stylesheet">

        <!-- Custom fonts for this template -->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

        <!-- Plugin CSS -->
        <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/creative.min.css" rel="stylesheet">
        <link href="css/errores.css" rel="stylesheet">

        <style>
            .tarjetaInicioSesion{

                margin: auto;
                height: 500px;
            }
            .titulo{
                color: gray;
            }
            .tarjetaFormulario{
                margin-top: 20px;
            }
            .separacion{
                margin-top: 40px;
            }
            .logo{
                height: 64px;
                width: 64px;
                margin-top: 10px;
            }
            .text-white {
                color: gray!important;
            }

        </style>


    </head>

    <body id="page-top">

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="index.php"><img src="img/logo.png">Cocineros Unidos</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="nuevaReceta.php">Nueva Receta</a>
                        </li>
                        <li class="nav-item">
                            <?php
                            if ($_SESSION['usuario']->rol == 'administrador') {
                                echo '<a class="nav-link js-scroll-trigger" href="#services">Services</a>';
                            } else {
                                echo '<a class="nav-link js-scroll-trigger" href="listaRecetasPuntuadas.php">Top Recetas</a>';
                            }
                            ?>

                        </li>
                        <li class="nav-item">
                            <?php
                            if ($_SESSION['usuario']->rol == 'administrador') {
                                echo '<a class="nav-link js-scroll-trigger" href="administracion.php">Administracion</a>';
                            } else {
                                echo '<a class="nav-link js-scroll-trigger" href="">Portfolio</a>';
                            }
                            ?>


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
                        <div class="card w-100 tarjetaInicioSesion animated bounceInDown">
                            <div class="card-body">
                                <img class="logo" src="img/logo.png"/>
                                <h2 class="titulo"><?php
                                    $usuarioCRUD = new UsuarioCRUD();
                                    $usuarioLista = $usuarioCRUD->listar();
                                    $chef = '';
                                    foreach ($usuarioLista as $usuario) {

                                        if ($usuario->nombre == $_GET['id']) {
                                            $chef = $usuario;
                                        }
                                    }

                                    echo $chef->nombre;
                                    ?></h2>
                                <div class="tarjetaFormulario">
                                    <div class="row">
                                        <div class="col-md-6 mx-auto">
                                            <h4 class="section-heading text-white">Tipo de Usuario</h4>
                                            <p> <?php echo $chef->rol; ?> </p>
                                            <h4 class="section-heading text-white">Puntuación General:</h4>
                                            <p> <?php
                                                $calificacionCRUD = new CalificacionCRUD();
                                                $calificacionLista = $calificacionCRUD->listar();
                                                $contador = 0;
                                                $acumulador = 0;
                                                foreach ($calificacionLista as $cali) {

                                                    if ($cali->usuario_nombre->nombre == $chef->nombre) {
                                                        $acumulador += $cali->valor;
                                                        $contador += 1;
                                                    }
                                                }

                                                echo $acumulador / $contador;
                                                ?> </p>
                                        </div>
                                        <div class="col-md-6 mx-auto">
                                            <h4 class="section-heading text-white">Cantidad de Recetas:</h4>
                                            <p> <?php
                                                $recetaCRUD = new RecetaCRUD();
                                                $recetaLista = $recetaCRUD->listar();
                                                $canti = 0;
                                                foreach ($recetaLista as $rec) {
                                                    if ($rec->creador->nombre == $chef->nombre) {
                                                        $canti += 1;
                                                    }
                                                }
                                                
                                                echo $canti;
                                                
                                                ?> </p>
                                            <!--<h4 class="section-heading text-white">puntuación:</h4>
                                            <p> valoracion receta </p>-->
                                        </div>
                                    </div>
                                </div>
                            </div>                           
                            <a href="listaRecetasPuntuadas.php" class="btn btn-primary">volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>


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
