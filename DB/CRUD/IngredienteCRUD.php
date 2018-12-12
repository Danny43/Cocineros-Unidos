<?php

include_once 'Objects/Ingrediente.php';
include_once 'DB/Connection.php';

    class IngredienteCRUD extends Connection{
        
        function crear($ingrediente) {

        $this->conectar();

        $sql = "INSERT INTO ingrediente (nombre, unidad_medida) VALUES (?,?)";

        $stmt = $this->miConexion->prepare($sql);
        $stmt->bind_param("s  s  s", $ingrediente->nombre, $ingrediente->unidad_medida);
        $ok = $stmt->execute();

        $this->desconectar();

        return $ok;
    }

    function listar() {

        $arreglo = array();
        $this->conectar();

        $sql = "SELECT * FROM ingrediente";
        $resultados = $this->miConexion->query($sql);
        while ($fila = $resultados->fetch_assoc()) {
            $ingrediente = new Ingrediente();
            $ingrediente->nombre = $fila['nombre'];
            $ingrediente->unidad_medida = $fila['unidad_medida'];
            
            $arreglo[] = $ingrediente;
        }

        $this->desconectar();

        return $arreglo;
    }

    function editar($ingrediente) {

        $this->conectar();

        $sql = "UPDATE ingrediente SET unidad_medida = ? WHERE nombre = ?";

        $stmt = $this->miConexion->prepare($sql);
        $stmt->bind_param("ss", $ingrediente->unidad_medida, $ingrediente->nombre);
        $ok = $stmt->execute();

        $this->desconectar();

        return $ok;
    }
    
     function eliminar($ingrediente) {

        $this->conectar();

        $sql = "DELETE FROM ingrediente WHERE nombre = ?";

        $stmt = $this->miConexion->prepare($sql);
        $stmt->bind_param("s", $ingrediente->nombre);
        $ok = $stmt->execute();

        $this->desconectar();

        return $ok;
    }

        
    }

?>