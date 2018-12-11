<?php

include_once '/../../Objects/Composicion.php';
include_once '/../../Objects/Receta.php';
include_once 'RecetaCRUD.php';
include_once '/../../Objects/Ingrediente.php';
include_once 'IngredienteCRUD.php';
include_once '/../Connection.php';


    class ComposicionCRUD extends Connection{
        
        function crear($composicion) {

        $this->conectar();

        $sql = "INSERT INTO composicon (ingrediente_nombre, receta_nombre, cantidad) VALUES (?,?,?)";

        $stmt = $this->miConexion->prepare($sql);
        $stmt->bind_param("s  s  i", $composicion->ingrediente_nombre->nombre, $composicion->receta_nombre->receta, $composicion->cantidad);
        $ok = $stmt->execute();

        $this->desconectar();

        return $ok;
    }

    function listar() {

        $arreglo = array();
        $this->conectar();

        $sql = "SELECT * FROM composicion";
        $resultados = $this->miConexion->query($sql);
        while ($fila = $resultados->fetch_assoc()) {
            $composicion = new Composicion();
            
            $ingredienteCRUD = new IngredienteCRUD();
            $ingredienteLista = $ingredienteCRUD->listar();
            
            for($i = 0; $i < count($ingredienteLista); $i++){
                if($fila['ingrediente_nombre'] == $ingredienteLista[i]->nombre){
                    $composicion->ingrediente_nombre = $ingredienteLista[i];
                }
                
            }
            
            $recetaCRUD = new RecetaCRUD();
            $recetaLista = $recetaCRUD->listar();
            
            for($i = 0; $i < count($recetaLista); $i++){
                if($fila['receta_nombre'] == $recetaLista[i]->nombre){
                    $composicion->receta_nombre = $recetaLista[i];
                }
            }
            
            
            $composicion->cantidad = $fila['cantidad'];
            
            $arreglo[] = $composicion;
        }

        $this->desconectar();

        return $arreglo;
    }

    function editar($composicion) {

        $this->conectar();

        $sql = "UPDATE composicion SET cantidad = ?, WHERE ingrediente_nombre = ? AND receta_nombre = ?";

        $stmt = $this->miConexion->prepare($sql);
        $stmt->bind_param("iss", $composicion->cantidad, $composiciom->ingediente_nombre->nombre, $composicion->receta_nombre->nombre);
        $ok = $stmt->execute();

        $this->desconectar();

        return $ok;
    }
    
    //falta terminar esta funcion eliminar
    
     function eliminar($composicion) {

        $this->conectar();

        $sql = "DELETE FROM composicion WHERE ingrediente_nombre = ? AND receta_nombre = ?";

        $stmt = $this->miConexion->prepare($sql);
        $stmt->bind_param("ss", $composicion->ingrediente_nombre->nombre, $composicion->receta_nombre->nombre);
        $ok = $stmt->execute();

        $this->desconectar();

        return $ok;
    }

        
        
    }



?>