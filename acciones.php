<?php

require_once 'DB/CRUD/UsuarioCRUD.php';
require_once 'DB/CRUD/IngredienteCRUD.php';

session_start();


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
    case'guardarNuevoUsuario':
        guardarNuevoUsuario();
        break;
    case'buscarUsuario':
        buscarUsuario();
        break;
    case'volverbuscarUsuario':
        volverbuscarUsuario();
        break;
    case'eliminarUsuario':
        eliminarUsuario();
        break;
    case'guardarUsuarioEditado':
        guardarUsuarioEditado();
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

function buscarUsuario(){
    
    $usuario = '';
    if (isset($_POST['nombreUsuarioBuscado'])) {
        $usuarioBuscado = $_POST['nombreUsuarioBuscado'];
        $usuarioCRUD = new UsuarioCRUD();
        $usuarioLista = $usuarioCRUD->listar();

        $_SESSION['usuarioEncontrado'] = 'false';
        $_SESSION['usuarioBuscado'] = 'yes';

        foreach ($usuarioLista as $usuario) {
            if ($usuarioBuscado == $usuario->nombre) {

                $_SESSION['nombreUsuario'] = $usuario->nombre;
                $_SESSION['rolUsuario'] = $usuario->rol;
                $_SESSION['usuarioBuscado'] = 'yes';
                $_SESSION['usuarioEncontrado'] = 'true';
                header('Location: buscarUsuarios.php');
            }
        }

        header('Location: buscarUsuarios.php');
    }
    
}

function volverbuscarUsuario(){
    
    $_SESSION['usuarioBuscado'] = 'none';
    $_SESSION['usuarioEncontrado'] = 'false';
    header('Location: buscarUsuarios.php');
    
}

function eliminarUsuario(){
    
    $usuario = new Usuario();
    $usuario->nombre = $_SESSION['nombreUsuario'];
    $usuario->rol = $_SESSION['rolUsuario'];
    $usuarioCRUD = new UsuarioCRUD();
    if($usuarioCRUD->eliminar($usuario)){
        volverbuscarUsuario();
    }else{
        echo 'error al realizar la operacion';
    }
    
    
}

function guardarUsuarioEditado(){
    
    $nuevoNombre = '';
    $nuevoRol = '';
    
    if(isset($_POST['nombreUsuario'])){
        $nuevoNombre = $_POST['nombreUsuario'];
    }
    if(isset($_POST['rolUsuario'])){
        $nuevoRol = $_POST['rolUsuario'];       
    }
    
    $usuarioCRUD = new UsuarioCRUD();
    $usuario = new Usuario();
    $usuario->nombre = $_SESSION['nombreUsuario'];
    $usuario->rol = $nuevoRol;
    
    if($usuarioCRUD->editar($usuario)){
        volverbuscarUsuario();
    }else{
        echo 'error al realizar la operacion';
    }
    
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

function guardarNuevoUsuario(){
    
    $nuevoUsuario = '';
    $nuevaPass = '';
    $nuevoRol = '';
    
    if(isset($_POST['nombreUsuario'])){
        $nuevoUsuario = $_POST['nombreUsuario'];
    }
    if(isset($_POST['passUsuario'])){       
        $nuevaPass = $_POST['passUsuario'];
    }
    if(isset($_POST['rolUsuario'])){
        $nuevoRol = $_POST['rolUsuario'];
    }
    
    $usuarioCRUD = new UsuarioCRUD();
    $usuario = new Usuario();
    
    $usuario->nombre = $nuevoUsuario;
    $usuario->clave = $nuevaPass;
    $usuario->rol = $nuevoRol;
    
    if($usuarioCRUD->crear($usuario)){
        header('Location: administracionUsuarios.php');       
    }else{
        echo 'error al realizar la operacion';
    }
    
}