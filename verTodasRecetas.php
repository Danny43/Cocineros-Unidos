<?php
require_once 'DB/CRUD/UsuarioCRUD.php';
require_once 'DB/CRUD/IngredienteCRUD.php';
require_once 'DB/CRUD/ComposicionCRUD.php';

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: inicioSesion.php');
}
?>

<!DOCTYPE html>
<html lang="es">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Todas Recetas | Cocineros Unidos</title>

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
                            <a class="nav-link js-scroll-trigger" href="#services">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="#portfolio">Portfolio</a>
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
                                <h2 class="titulo">Todas Recetas</h2>
                                <div class="tarjetaFormulario">
                                    <form action="acciones.php" method="POST">
                                        <table class="table table-warning" >
                                            <thead>
                                                <tr>
                                                    <th scope="col">Nombre</th>
                                                    <th scope="col">Ingredientes</th>
                                                    <th scope="col">Creador</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $recetaCRUD = new RecetaCRUD();
                                                $recetaLista = $recetaCRUD->listar();

                                                foreach ($recetaLista as $receta) {
                                                    
                                                    $ingredientes = '';
                                                    
                                                    $composicionCRUD = new ComposicionCRUD();
                                                    $composicionLista = $composicionCRUD->listar();
                                                    
                                                    foreach ($composicionLista as $composicion) {
                                                        if($composicion->receta_nombre->nombre == $receta->nombre){
                                                            $ingredientes = $ingredientes.$composicion->ingrediente_nombre->nombre.' ';
                                                        }
                                                    }
                                                    
                                                    echo '<tr class="table table-light">
                                                                <td><a href="verReceta.php?id='.$receta->nombre.'">' . $receta->nombre . '</a></td>
                                                                <td>' . $ingredientes . '</td>
                                                                <td><a href="verCocinero.php?id='.$receta->creador->nombre.'">' . $receta->creador->nombre . '</a></td>
                                                              </tr>';
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                            <a href="administracionRecetas.php" class="btn btn-primary">Volver</a>
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
    <script>
        var i = 0;
        var iden = 0;

        function clickaction(b) {
            iden = b;
        }


        $(document).ready(function (e) {


            $('#agregar').click(function (e) {
                var interes = $('#interes').val();
                var gusto = $('#gusto').val();
                var opciones = "<?php
                                                $ingredienteCRUD = new IngredienteCRUD();
                                                $ingredienteLista = $ingredienteCRUD->listar();

                                                foreach ($ingredienteLista as $ingrediente) {
                                                    echo "<option value='" . $ingrediente->nombre . "'>" . $ingrediente->nombre . " (" . $ingrediente->unidad_medida . ")" . "</option>";
                                                }
                                                ?>";

                var filaNueva = "<tr>" +
                        "<td><select onclick=clickaction(this.id) name='ingrediente' id='" + i + "'>" + opciones +
                        "</select></td>" +
                        "<td><input onclick=clickaction(this.id) name class='gusto' id='" + (i + 1) + "' /><div class='textoError' id='" + "g" + (i + 1) + "'></div></td>" +
                        "<td><div class='btn-eliminar btn btn-danger'>Eliminar</div></td>" +
                        "</tr>";
                i = i + 2;
                $('#cuerpo-tabla').append(filaNueva);
                $('#interes').val("");
                $('#gusto').val("");
            });

            $(document).on('click', '.btn-eliminar', function (e) {
                $(this).parent().parent().remove();
            });

        });


    </script>

</html>
