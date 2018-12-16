<?php

require_once 'DB/CRUD/UsuarioCRUD.php';
require_once 'DB/CRUD/IngredienteCRUD.php';

session_start();
//importar usuario.php y el crud para comprobar si el usuario esta registrado en la base de datos

if (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {

    case 'iniciarSesion':
        iniciarSesion();
        break;
    case 'registrarse':
        registrarse();
        break;
    case 'buscarIngrediente':
        buscarIngrediente();
        break;
    case 'volverbuscarIngrediente':
        volverbuscarIngrediente();
        break;
    case 'eliminarIngrediente':
        eliminarIngrediente();
        break;
    case'guardarIngrediente':
        guardarIngrediente();
        break;
    case'guardarIngredienteEditado':
        guardarIngredienteEditado();
        break;
}

function iniciarSesion() {

    $solicitud = false;
    $nombreUsuario = '';
    $pass = '';
    if (isset($_POST['nombreUsuario'])) {
        $nombreUsuario = $_POST['nombreUsuario'];
    }
    if (isset($_POST['pass'])) {
        $pass = $_POST['pass'];
    }

    $usuarioCRUD = new UsuarioCRUD();
    $usuarioLista = $usuarioCRUD->listar();

    foreach ($usuarioLista as $usuario) {
        if ($usuario->nombre == $nombreUsuario && $usuario->clave == $pass) {
            $_SESSION['usuario'] = $usuario;
            $solicitud = true;
        }
    }


    if ($solicitud) {
        if ($_SESSION['usuario']->rol == 'administrador') {
            header('Location: mainMenuAdmin.php');
        } else {
            header('Location: mainMenuCocinero.php');
        }
    } else {
        $_SESSION['estadoSesion'] = 'userNotFound';
        header('Location: iniciarSesion.php');
    }
}

function registrarse() {

    $solicitud = false;
    $nombreUsuario = '';
    $pass = '';
    if (isset($_POST['nombreUsuario'])) {
        $nombreUsuario = $_POST['nombreUsuario'];
    }
    if (isset($_POST['pass'])) {
        $pass = $_POST['pass'];
    }

    $usuarioCRUD = new UsuarioCRUD();

    $usuario = new Usuario();
    $usuario->nombre = $nombreUsuario;
    $usuario->clave = $pass;
    $usuario->rol = 'cocinero';

    $solicitud = $usuarioCRUD->crear($usuario);

    if ($solicitud) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['registro'] = 'exito';
        header('Location: mainMenuCocinero.php');
    } else {
        $_SESSION['registro'] = 'error';
        header('Location: registrarse.php');
    }
}

function buscarIngrediente() {
    $ingrediente = '';
    if (isset($_POST['nombreIngredienteBuscado'])) {
        $ingredienteBuscado = $_POST['nombreIngredienteBuscado'];
        $ingredienteCRUD = new IngredienteCRUD();
        $ingredienteLista = $ingredienteCRUD->listar();

        $_SESSION['ingredienteEncontrado'] = 'false';
        $_SESSION['ingredienteBuscado'] = 'yes';

        foreach ($ingredienteLista as $ingrediente) {
            if ($ingredienteBuscado == $ingrediente->nombre) {

                $_SESSION['nombreIngrediente'] = $ingrediente->nombre;
                $_SESSION['medidaIngrediente'] = $ingrediente->unidad_medida;
                $_SESSION['ingredienteBuscado'] = 'yes';
                $_SESSION['ingredienteEncontrado'] = 'true';
                header('Location: buscarIngredientes.php');
            }
        }

        header('Location: buscarIngredientes.php');
    }
}

function volverbuscarIngrediente() {
    $_SESSION['ingredienteBuscado'] = 'none';
    $_SESSION['ingredienteEncontrado'] = 'false';
    header('Location: buscarIngredientes.php');
}

function eliminarIngrediente(){
    $ingrediente = new Ingrediente();
    $ingrediente->nombre = $_SESSION['nombreIngrediente'];
    $ingrediente->unidad_medida = $_SESSION['medidaIngrediente'];
    $ingredienteCRUD = new IngredienteCRUD();
    if($ingredienteCRUD->eliminar($ingrediente)){
        volverbuscarIngrediente();
    }else{
        echo 'error al realizar la operacion';
    }
    
}

function guardarIngrediente(){
    $nombreNuevo = '';
    $unidadNueva = '';
    
    if(isset($_POST['nombreIngrediente'])){
        $nombreNuevo = $_POST['nombreIngrediente'];
    }
    if(isset($_POST['unidadMedida'])){
        $unidadNueva = $_POST['unidadMedida'];
    }
    
    $ingredienteNuevo = new Ingrediente();
    $ingredienteNuevo->nombre = $nombreNuevo;
    $ingredienteNuevo->unidad_medida = $unidadNueva;
    
    $ingredienteCRUD = new IngredienteCRUD();
    if($ingredienteCRUD->crear($ingredienteNuevo)){
        header('Location: administracionIngredientes.php');
    }else{
        echo 'error al realizar la operacion';
    }
    
}

function guardarIngredienteEditado(){
    
    $nuevoNombre = '';
    $nuevaUnidad = '';
    
    if(isset($_POST['nombreIngrediente'])){
        $nuevoNombre = $_POST['nombreIngrediente'];
    }
    if(isset($_POST['unidadMedida'])){
        $nuevaUnidad = $_POST['unidadMedida'];       
    }
    
    $ingredienteCRUD = new IngredienteCRUD();
    $ingrediente = new Ingrediente();
    $ingrediente->nombre = $_SESSION['nombreIngrediente'];
    $ingrediente->unidad_medida = $nuevaUnidad;
    
    if($ingredienteCRUD->editar($ingrediente)){
        volverbuscarIngrediente();
    }else{
        echo 'error al realizar la operacion';
    }
    
}