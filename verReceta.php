<?php
include_once 'Objects/Usuario.php';
require_once 'DB/CRUD/RecetaCRUD.php';
require_once 'DB/CRUD/UsuarioCRUD.php';
require_once 'DB/CRUD/ComposicionCRUD.php';
require_once 'DB/CRUD/CalificacionCRUD.php';

session_start();

if (isset($_SESSION['usuario'])) {
    
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

        <title>Ver Receta | Cocineros Unidos</title>

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
                            }else{
                                echo '<a class="nav-link js-scroll-trigger" href="listaRecetasPuntuadas.php">Top Recetas</a>';
                            }
                            ?>
                            
                        </li>
                        <li class="nav-item">
                            <?php
                            if ($_SESSION['usuario']->rol == 'administrador') {
                                echo '<a class="nav-link js-scroll-trigger" href="administracion.php">Administracion</a>';
                            }else{
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
                                <h2 class="titulo">Ver Receta</h2>
                                <div class="tarjetaFormulario">
                                    <form action="acciones.php" method="POST">
                                        <div class="form-group">
                                            <label for="nombreReceta">Nombre de la receta</label>
                                            <p id="nombreReceta"><?php
                                                if (isset($_GET['id'])) {
                                                    echo $_GET['id'];
                                                } else {

                                                    echo $_SESSION['idReceta'];
                                                }
                                                ?></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="nombreReceta">Mi Puntuacion</label>
                                            <input id="miValorReceta" name="miValorReceta" type="number" value="<?php
                                            $calificacionCRUD = new CalificacionCRUD();
                                            $calificacionLista = $calificacionCRUD->listar();

                                            if (isset($_GET['id'])) {

                                                $_SESSION['idReceta'] = $_GET['id'];
                                            }

                                            $calificada = false;

                                            foreach ($calificacionLista as $calificacion) {

                                                if (isset($_GET['id'])) {
                                                    if ($calificacion->receta_nombre->nombre == $_GET['id'] && $calificacion->usuario_nombre->nombre == $_SESSION['usuario']->nombre) {
                                                        $calificada = true;
                                                        echo $calificacion->valor;
                                                    }
                                                } else {
                                                    if ($calificacion->receta_nombre->nombre == $_SESSION['idReceta'] && $calificacion->usuario_nombre->nombre == $_SESSION['usuario']->nombre) {
                                                        $calificada = true;
                                                        echo $calificacion->valor;
                                                    }
                                                }
                                            }

                                            if (!$calificada) {

                                                echo '0';
                                            }
                                            ?>">
                                            <button class="btn btn-primary" type="submit" name="action" value="calificar">Calificar</button>
                                        </div>

                                        <div class="form-group">                                            
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Ingrediente</th>
                                                        <th>Cantidad</th>

                                                    </tr>
                                                </thead>
                                                <tbody id="cuerpo-tabla">

                                                    <?php
                                                    $recetaCRUD = new RecetaCRUD();
                                                    $recetaLista = $recetaCRUD->listar();
                                                    $recetaAct = null;

                                                    foreach ($recetaLista as $receta) {

                                                        if (isset($_GET['id'])) {
                                                            if ($receta->nombre == $_GET['id']) {
                                                                $recetaAct = $receta;
                                                                $composicionCRUD = new ComposicionCRUD();
                                                                $composicionLista = $composicionCRUD->listar();
                                                                foreach ($composicionLista as $composicion) {
                                                                    if ($composicion->receta_nombre->nombre == $receta->nombre) {
                                                                        echo '<tr>';
                                                                        echo '<td>' . $composicion->ingrediente_nombre->nombre . '</td>';
                                                                        echo '<td>' . $composicion->cantidad . '</td>';
                                                                        echo '</tr>';
                                                                    }
                                                                }
                                                            }
                                                        } else {

                                                            if ($receta->nombre == $_SESSION['idReceta']) {
                                                                $recetaAct = $receta;
                                                                $composicionCRUD = new ComposicionCRUD();
                                                                $composicionLista = $composicionCRUD->listar();
                                                                foreach ($composicionLista as $composicion) {
                                                                    if ($composicion->receta_nombre->nombre == $receta->nombre) {
                                                                        echo '<tr>';
                                                                        echo '<td>' . $composicion->ingrediente_nombre->nombre . '</td>';
                                                                        echo '<td>' . $composicion->cantidad . '</td>';
                                                                        echo '</tr>';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>                                      
                                        <div class="form-group">
                                            <label for="preparacion">Preparacion</label>
                                            <p id="preparacion"><?php
                                                $recetaCRUD = new RecetaCRUD();
                                                $recetaLista = $recetaCRUD->listar();

                                                foreach ($recetaLista as $receta) {

                                                    if (isset($_GET['id'])) {
                                                        if ($receta->nombre == $_GET['id']) {
                                                            echo $receta->descripcion;
                                                        }
                                                    } else {
                                                        if ($receta->nombre == $_SESSION['idReceta']) {
                                                            echo $receta->descripcion;
                                                        }
                                                    }
                                                }
                                                ?></p>
                                        </div>
                                        <?php
                                        if (isset($_SESSION['usuario'])) {
                                            if ($_SESSION['usuario']->rol != 'administrador') {
                                                echo '<a class="btn btn-primary" href="#">Aun no se a donde va</a>';
                                            } else {

                                                echo '<a class="btn btn-primary" href="verTodasRecetas.php">Volver</a>';
                                            }
                                        } else {
                                            
                                        }
                                        ?>

                                    </form>
                                </div>
                            </div>
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
