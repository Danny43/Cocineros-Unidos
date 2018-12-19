<?php

require_once 'DB/CRUD/UsuarioCRUD.php';

session_start();

    if(isset($_SESSION['usuario'])){
        if($_SESSION['usuario']->rol == 'administrador'){
            header('Location: mainMenuAdmin.php');
        }else if($_SESSION['usuario']->rol == 'cocinero'){
            header('Location: mainMenuCocinero.php');
        }
    }

?>

<!DOCTYPE html>
<html lang="es">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Iniciar Sesion | Cocineros Unidos</title>

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

        </style>


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
                       
                    </ul>
                </div>
            </div>
        </nav>

        <header class="masthead text-center text-white d-flex">
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <div class="card w-50 tarjetaInicioSesion animated bounceInDown">
                            <div class="card-body">
                                <img class="logo" src="img/logo.png"/>
                                <h2 class="titulo">Iniciar Sesion</h2>
                                <div class="tarjetaFormulario">
                                    <form action="acciones.php" method="POST" >
                                        <input id="nombreUsuario" name="nombreUsuario" type="text" class="form-control separacion" placeholder="Nombre de Usuario" aria-label="Username" aria-describedby="basic-addon1">
                                        <div id="errorNombre" class="col txtError"></div>
                                        <input id="pass" name="pass" type="password" class="form-control separacion" placeholder="Contraseña" aria-describedby="basic-addon1">
                                        <div id="errorPass" class="col txtError"></div>
                                        <?php

                                        if (isset($_SESSION['estadoSesion'])) {
                                            echo '<div id="errorSesion" class="col txtErrorSesion"> Usuario y/o Contraseña no coincide con nuestros registros </div>';
                                            session_destroy();
                                        }
                                        ?>
                                        <button id="iniciarSesion" name="action" value="iniciarSesion" type="submit" class="btn btn-primary btn-xl js-scroll-trigger separacion">Iniciar Sesion</button>
                                        <p class="text-muted mb-5 separacion">Aún no te haz registrado? <a href="registrarse.php" >Registrate</a></p>
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

        $(document).ready(function (e) {


            $('#iniciarSesion').click(function (e) {
                return validarUsuario() && validarPassword();
            });

            $('#nombreUsuario').focusout(function (e) {
                validarUsuario();
            });

            $('#pass').focusout(function (e) {
                validarPassword();
            });


            function validarUsuario() {
                var nombreUsuario = $('#nombreUsuario').val();
                if (nombreUsuario.length < 3) {
                    $('#nombreUsuario').removeClass('exito');
                    $('#nombreUsuario').addClass('error');
                    $('#errorNombre').html('Para el nombre de usuario son almenos 4 caracteres');
                    return false;
                } else {
                    $('#nombreUsuario').removeClass('error');
                    // $('#nombreUsuario').addClass('exito');
                    $('#errorNombre').html('');
                    return true;
                }
            }
            function validarPassword() {
                var pass = $('#pass').val();
                if (pass.length < 3) {
                    $('#pass').removeClass('exito');
                    $('#pass').addClass('error');
                    $('#errorSesion').html('');
                    $('#errorPass').html('La contraseña debe tener almenos 4 caracteres');
                    return false;
                } else {
                    $('#pass').removeClass('error');
                    // $('#pass').addClass('exito');
                    $('#errorPass').html('');
                    return true;
                }
            }

        });


    </script>

</html>
