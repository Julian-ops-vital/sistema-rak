<?php
// Listar todos los usuarios
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');

// Traemos todos los usuarios
$result = $conexion->query("SELECT nombre_mat AS nombre, numero_mat AS id FROM materia");

$usuarios = [];
while($row = $result->fetch_assoc()){
    $usuarios[] = $row;
}

echo json_encode($usuarios);
$conexion->close();
