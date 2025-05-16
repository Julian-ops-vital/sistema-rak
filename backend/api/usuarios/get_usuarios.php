<?php
// Listar todos los usuarios
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');

// Traemos todos los usuarios
$result = $conexion->query("SELECT id_us AS id, nombre_us AS nombre, apellido_us AS apellido, email_us AS correo, numero_rol AS rol FROM usuario");

$usuarios = [];
while($row = $result->fetch_assoc()){
    $usuarios[] = $row;
}

echo json_encode($usuarios);
$conexion->close();
