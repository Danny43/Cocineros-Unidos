<?php

include_once 'DB/CRUD/UsuarioCRUD.php';
include_once 'Objects/Usuario.php';

session_start();
//importar usuario.php y el crud para comprobar si el usuario esta registrado en la base de datos

if (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {

    case 'iniciarSesion':
        iniciarSesion();
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

    for ($i = 0; $i < count($usuarioLista); $i++) {
        if ($usuarioLista[i]->nombre == $nombreUsuario && $usuarioLista[i]->clave == $pass) {
            $_SESSION['usuario'] = $usuarioLista[i];
            $solicitud = true;
        }
    }

    if ($solicitud) {
        echo 'Has iniciado sesion';
    } else {
        $_SESSION['estadoSesion'] = 'userNotFound';
        header('Location: iniciarSesion.php');
    }
}