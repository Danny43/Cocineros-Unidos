<?php

require_once 'DB/CRUD/UsuarioCRUD.php';

session_start();
//importar usuario.php y el crud para comprobar si el usuario esta registrado en la base de datos

if (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {

    case 'iniciarSesion':
        iniciarSesion();
        break;
    case 'registrarse';
        registrarse();
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
