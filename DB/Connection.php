<?php
class Connection{
    
    public $miConexion;
    
    function conectar(){
        $this->miConexion = new mysqli("localhost", "root", "pone tu contraseña", "bdcocina");
        if ($this->miConexion->connect_errno) {
            echo "Fallo al conectar a MySQL: (" . $this->miConexion->connect_errno . ") ";
        }
    }
    
    function desconectar(){
        if($this->miConexion != null){
            $this->miConexion->close();
        }
    }
    
}

