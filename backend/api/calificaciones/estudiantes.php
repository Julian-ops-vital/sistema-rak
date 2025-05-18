<?php
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');

if (isset($_GET['grupo'])) {
    $grupo = $conexion->real_escape_string($_GET['grupo']);
    $sql = "SELECT e.id_est AS id, u.nombre_us AS nombre, u.apellido_us AS apellido
            FROM estudiante e
            JOIN usuario u ON e.id_us = u.id_us
            WHERE e.grupo_est = '$grupo'
            ORDER BY u.nombre_us, u.apellido_us";
} elseif (isset($_GET['id_est'])) {
    $id = (int)$_GET['id_est'];
    $sql = "SELECT e.id_est AS id, u.nombre_us AS nombre, u.apellido_us AS apellido
            FROM estudiante e
            JOIN usuario u ON e.id_us = u.id_us
            WHERE e.id_est = $id";
} else {
    http_response_code(400);
    echo json_encode(['error'=>'Falta parámetro grupo o id_est']);
    exit;
}

$result = $conexion->query($sql);
if (!$result) {
    http_response_code(500);
    echo json_encode(['error'=>$conexion->error]);
    exit;
}

$rows = [];
while ($r = $result->fetch_assoc()) {
    $rows[] = [
      'id'       => (int)$r['id'],
      'nombre'   => $r['nombre'],
      'apellido' => $r['apellido']
    ];
}
echo json_encode($rows);
$conexion->close();
