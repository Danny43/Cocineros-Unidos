<?php

include_once '../../Objects/Usuario.php';
include_once '../Connection.php';


    class UsuarioCRUD extends Connection{
        
         function crear($ingrediente) {

        $this->conectar();
        

        $sql = "INSERT INTO usuario (nombre, clave, rol)
                VALUES (?,?,?)";

        $stmt = $this->miConexion->prepare($sql);
        $stmt->bind_param("s  s  s", $ingrediente->nombre, $ingrediente->unidad);
        $ok = $stmt->execute();

        
        $this->desconectar();


        return $ok;
    }
    
    
        
        
    }


?>