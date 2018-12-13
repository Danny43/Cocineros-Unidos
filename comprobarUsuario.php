<?php

$usuario = $_REQUEST['usuario'];
$db = new mysqli("localhost", "root", "kenblock43", "bdcocina");
$query = "SELECT * FROM usuario WEHRE nombre = '$usuario'";
$db->query($query);


if ($db->affected_rows == 0) {
    echo '';
    header('Location: error.php');
}else {
    echo 'Este Usuario ya se encuentra registrado';
        header('Location: error.php');
}

?>