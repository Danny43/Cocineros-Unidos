<?php

require_once 'DB/CRUD/RecetaCRUD.php';
require_once 'DB/CRUD/UsuarioCRUD.php';
require_once 'DB/CRUD/ComposicionCRUD.php';
require_once 'DB/CRUD/CalificacionCRUD.php';

class RecetaAleatorea{
    
public $nombreReceta;
public $nombreCredor;
public $listaIngredientes;
public $calificacion;
public $preparacion;


public function __construct(){
    
    $recetaCRUD = new RecetaCRUD();
    $recetaLista = $recetaCRUD->listar();
    
    
    again:
    $elegida = rand(1, count($recetaLista));
    
    $receta = 'none';
    $con = 0;
    foreach ($recetaLista as $rec) {
        
        if($con == $elegida){
            $receta = $rec;
        }
        
        $con += 1;
        
    }
    
    if($receta == 'none'){
        goto again;
    }
    
    
    $this->nombreReceta = $receta->nombre;
    $this->nombreCredor = $receta->creador->nombre;
    $this->preparacion = $receta->descripcion;
    
    $calificacionCRUD = new CalificacionCRUD();
    $calificacionLista = $calificacionCRUD->listar();
    
    $acumulador = 0;
    $contador = 0;
    
    foreach ($calificacionLista as $cali) {
        
        if($cali->receta_nombre->nombre == $receta->nombre){
            $contador += 1;
            $acumulador += $cali->valor;
        }
        
    }
    
    $this->calificacion = $acumulador / $contador;
    
    $composicionCRUD = new ComposicionCRUD();
    $composicionLista = $composicionCRUD->listar();
    
    $listaCositas = array();
    
    foreach ($composicionLista as $compo) {
        
        if($compo->receta_nombre->nombre == $receta->nombre){
            $listaCositas[] = $compo->ingrediente_nombre;
        }
        
    }
    
    $this->listaIngredientes = $listaCositas;
    
}


}


