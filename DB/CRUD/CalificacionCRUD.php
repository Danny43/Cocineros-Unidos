<?php

include_once 'Objects/Calificacion.php';
include_once 'Objects/Usuario.php';
include_once 'DB/CRUD/UsuarioCRUD.php';
include_once 'Objects/Receta.php';
include_once 'DB/CRUD/RecetaCRUD.php';
include_once 'DB/Connection.php';

class CalificacionCRUD extends Connection {

    function crear($calificacion) {

        $this->conectar();

        $sql = "INSERT INTO calificacion (usuario_nombre, receta_nombre, valor) VALUES (?,?,?)";

        $stmt = $this->miConexion->prepare($sql);
        $stmt->bind_param("ssi", $calificacion->usuario_nombre->nombre, $calificacion->receta_nombre->nombre, $calificacion->valor);
        $ok = $stmt->execute();

        $this->desconectar();

        return $ok;
    }

    function listar() {

        $arreglo = array();
        $this->conectar();

        $sql = "SELECT * FROM calificacion";
        $resultados = $this->miConexion->query($sql);
        while ($fila = $resultados->fetch_assoc()) {
            $calificacion = new Calificacion();

            $usuarioCRUD = new UsuarioCRUD();
            $usuarioLista = $usuarioCRUD->listar();

            for ($i = 0; $i < count($usuarioLista); $i++) {

                if ($fila['usuario_nombre'] == $usuarioLista[$i]->nombre) {
                    $calificacion->usuario_nombre = $usuarioLista[$i];
                }
            }


            $recetaCRUD = new RecetaCRUD();
            $recetaLista = $recetaCRUD->listar();

            for ($i = 0; $i < count($recetaLista); $i++) {

                if ($fila['receta_nombre'] == $recetaLista[$i]->nombre) {
                    $calificacion->receta_nombre = $recetaLista[$i];
                }
            }


            $calificacion->valor = $fila['valor'];

            $arreglo[] = $calificacion;
        }

        $this->desconectar();

        return $arreglo;
    }

    function editar($calificacion) {

        $this->conectar();

        $sql = "UPDATE calificacion SET valor = ? WHERE usuario_nombre = ? AND receta_nombre = ?";

        $stmt = $this->miConexion->prepare($sql);
        $stmt->bind_param("iss", $calificacion->valor, $calificacion->usuario_nombre->nombre, $calificacion->receta_nombre->nombre);
        $ok = $stmt->execute();

        $this->desconectar();

        return $ok;
    }

    function eliminar($calificacion) {

        $this->conectar();

        $sql = "DELETE FROM calificacion WHERE usuario_nombre = ? AND receta_nombre = ?";

        $stmt = $this->miConexion->prepare($sql);
        $stmt->bind_param("ss", $calificacion->usuario_nombre->nombre, $calificacion->receta_nombre->nombre);
        $ok = $stmt->execute();

        $this->desconectar();

        return $ok;
    }

}

?>
