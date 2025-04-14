<?php

require_once '../conexion/conexion.php';

//Verifica que el formulario fue enviado por el metodo POST
if($_SERVER["REQUEST_METHOD"] == "POST");{
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $password = $_POST['email'];

}

?>