<?php
// Listar todos los usuarios
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');

// Traemos todos los usuarios
$result = $conexion->query("SELECT id_act AS id, numero_mat AS materia, rubrica_act AS rubrica, objetivo_act AS objetivo, ponderacion_act AS ponderacion FROM actividad");

$usuarios = [];
while($row = $result->fetch_assoc()){
    $usuarios[] = $row;
}

echo json_encode($usuarios);
$conexion->close();
