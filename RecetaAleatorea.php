<?php

require_once '/db/CRUD/RecetaCRUD';
require_once '/db/CRUD/UsuarioCRUD';
require_once '/db/CRUD/ComposicionCRUD';
require_once '/db/CRUD/CalificacionCRUD';

class RecetaAleatorea{
    
public $nombreReceta;
public $nombreCredor;
public $listaIngredientes;
public $calificacion;
public $preparacion;


public function __construct(){
    
    $recetaCRUD = new RecetaCRUD();
    $recetaLista = $recetaCRUD->listar();
    
    $elegida = rand(1, count($recetaLista));
    
    $receta = $recetaLista[$elegida];
    
    $this->nombreReceta = $receta->nombre;
    $this->nombreCredor = $receta->creador->nombre;
    $this->preparacion = $receta->descripcion;
    
    $calificacionCRUD = new CalificacionCRUD();
    $calificacionLista = $calificacionCRUD->listar();
    
    $acumulador = 0;
    $contador = 0;
    
    foreach ($calificacionLista as $cali) {
        
        if($cali->receta_nombre == $receta->nombre){
            $contador += 1;
            $acumulador += $cali->valor;
        }
        
    }
    
    $this->calificacion = $acumulador / $contador;
    
    $composicionCRUD = new ComposicionCRUD();
    $composicionLista = $composicionCRUD->listar();
    
    $listaCositas = array();
    
    foreach ($composicionLista as $compo) {
        
        if($compo->receta_nombre == $receta->nombre){
            $listaCositas[] = $compo->ingrediente_nombre;
        }
        
    }
    
    $this->listaIngredientes = $listaCositas;
    
}


}


