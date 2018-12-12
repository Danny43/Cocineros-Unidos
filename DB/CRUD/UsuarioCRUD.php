<?php

include_once 'Objects/Usuario.php';
include_once 'DB/Connection.php';

class UsuarioCRUD extends Connection {

    function crear($usuario) {

        $this->conectar();

        $sql = "INSERT INTO usuario (nombre, clave, rol) VALUES (?,?,?)";

        $stmt = $this->miConexion->prepare($sql);
        $stmt->bind_param("sss", $usuario->nombre, $usuario->clave, $usuario->rol);
        $ok = $stmt->execute();

        $this->desconectar();

        return $ok;
    }

    function listar() {

        $arreglo = array();
        $this->conectar();

        $sql = "SELECT * FROM usuario";
        $resultados = $this->miConexion->query($sql);
        while ($fila = $resultados->fetch_assoc()) {
            $usuario = new Usuario();
            $usuario->nombre = $fila['nombre'];
            $usuario->clave = $fila['clave'];
            $usuario->rol = $fila['rol'];

            $arreglo[] = $usuario;
        }

        $this->desconectar();

        return $arreglo;
    }

    function editar($usuario) {

        $this->conectar();

        $sql = "UPDATE usuario SET clave = ?, rol = ? WHERE nombre = ?";

        $stmt = $this->miConexion->prepare($sql);
        $stmt->bind_param("sss", $usuario->clave, $usuario->rol, $usuario->nombre);
        $ok = $stmt->execute();

        $this->desconectar();

        return $ok;
    }
    
     function eliminar($usuario) {

        $this->conectar();

        $sql = "DELETE FROM usuario WHERE nombre = ?";

        $stmt = $this->miConexion->prepare($sql);
        $stmt->bind_param("s", $usuario->nombre);
        $ok = $stmt->execute();

        $this->desconectar();

        return $ok;
    }

}

