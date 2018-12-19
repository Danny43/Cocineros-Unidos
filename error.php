<?php
require_once 'DB/CRUD/IngredienteCRUD.php';
session_start();

foreach ($_SESSION['listaDeIngredientes'] as $lista){
    echo $lista->nombre.', ';
}
    

echo 'toda esta madre da error';