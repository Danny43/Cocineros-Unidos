<?php
require_once 'DB/CRUD/UsuarioCRUD.php';
require_once 'DB/CRUD/IngredienteCRUD.php';

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

        <title>Nueva Receta | Cocineros Unidos</title>

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
                                <h2 class="titulo">Nueva Receta</h2>
                                <div class="tarjetaFormulario">
                                    <form action="acciones.php" method="POST">
                                        <div class="form-group">
                                            <label for="nombreReceta">Nombre de la receta</label>
                                            <input type="text" class="form-control" name="nombreReceta" id="nombreReceta" placeholder="Ej: Hamburguejas al vapor">
                                        </div>
                                        <div class="form-group">
                                            <div id="agregar" class="btn btn-light">Agregar</div>
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Ingrediente</th>
                                                        <th>Cantidad</th>

                                                    </tr>
                                                </thead>
                                                <tbody id="cuerpo-tabla">
                                                </tbody>
                                            </table>
                                        </div>                                      
                                        <div class="form-group">
                                            <label for="preparacion">Preparacion</label>
                                            <textarea class="form-control" name="preparacion" id="preparacion" rows="3"></textarea>
                                        </div>
                                        <button class="btn btn-primary" type="submit" name="action" value="guardarReceta">Guardar</button>
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
    <script>
        var i = 0;
        

        function clickaction(b) {
            var iden = b-1;
            valorSelect = $('#'+(b-2)).val();
            
            //alert('indenInput= ' +iden+ '  selectValor= ' + valorSelect + ' valoridBoton= '+b );
            $('#'+b).html('');
            $('#'+b).removeClass('btn');
            $('#'+b).removeClass('btn-success');
            document.getElementById(iden).setAttribute("name", valorSelect);
            //$('#'+(b-2)).prop("disabled", true);
            //$('#'+iden).prop("disabled", true);
            //$('#'+iden).
            
        }


        $(document).ready(function (e) {


            $('#agregar').click(function (e) {
                var interes = $('#interes').val();
                var gusto = $('#gusto').val();
                var opciones = "<?php 
            
                $ingredienteCRUD = new IngredienteCRUD();
                $ingredienteLista = $ingredienteCRUD->listar();
                
                foreach ($ingredienteLista as $ingrediente) {
                    echo "<option value='".$ingrediente->nombre."'>".$ingrediente->nombre." (".$ingrediente->unidad_medida.")"."</option>";
                }
            
            
            ?>";

                var filaNueva = "<tr>" +
                        "<td><select name='ingrediente' id='" + i + "'>" + opciones +
                        "</select></td>" +
                        "<td><input name='' id='" + (i + 1) + "' /><div class='textoError' id='" + "g" + (i + 1) + "'></div></td>" +
                        "<td><div class='btn-confirmar btn btn-success' id='"+(i+2)+"' onclick=clickaction(this.id) >Confirmar</div></td>" +
                        "<td><div class='btn-eliminar btn btn-danger'>Eliminar</div></td>" +
                        "</tr>";
                i = i + 3;
                $('#cuerpo-tabla').append(filaNueva);
                //$('#interes').val("");
                //$('#gusto').val("");
            });
            
            $(document).on('click', '.btn-eliminar', function (e) {
            $(this).parent().parent().remove();
            });
            


        });


    </script>

</html>
