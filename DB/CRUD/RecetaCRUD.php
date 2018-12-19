<?php

include_once 'Objects/Receta.php';
include_once 'Objects/Usuario.php';
include_once 'DB/CRUD/UsuarioCRUD.php';
include_once 'DB/Connection.php';

class RecetaCRUD extends Connection {

    function crear($receta) {

        $this->conectar();

        $sql = "INSERT INTO receta (nombre, descripcion, creador) VALUES (?,?,?)";

        
        $stmt = $this->miConexion->prepare($sql);
        $stmt->bind_param("sss", $receta->nombre, $receta->descripcion, $receta->creador->nombre);
        $ok = $stmt->execute();

        $this->desconectar();

        return $ok;
    }

    function listar() {

        $arreglo = array();
        $this->conectar();

        $sql = "SELECT * FROM receta";
        $resultados = $this->miConexion->query($sql);
        while ($fila = $resultados->fetch_assoc()) {
            $receta = new Receta();
            $receta->nombre = $fila['nombre'];
            $receta->descripcion = $fila['descripcion'];


            $creadorCRUD = new UsuarioCRUD();
            $creadorLista = $creadorCRUD->listar();

            for ($i = 0; $i < count($creadorLista); $i++) {

                if ($fila['creador'] == $creadorLista[$i]->nombre) {

                    $receta->creador = $creadorLista[$i];
                }
            }


            $arreglo[] = $receta;
        }

        $this->desconectar();

        return $arreglo;
    }

    function editar($receta) {

        $this->conectar();

        $sql = "UPDATE receta SET descripcion = ?, creador = ? WHERE nombre = ?";

        $stmt = $this->miConexion->prepare($sql);
        $stmt->bind_param("sss", $receta->descripcion, $receta->creador->nombre, $receta->nombre);
        $ok = $stmt->execute();

        $this->desconectar();

        return $ok;
    }

    function eliminar($receta) {

        $this->conectar();

        $sql = "DELETE FROM receta WHERE nombre = ?";

        $stmt = $this->miConexion->prepare($sql);
        $stmt->bind_param("s", $receta->nombre);
        $ok = $stmt->execute();

        $this->desconectar();

        return $ok;
    }

}

?>