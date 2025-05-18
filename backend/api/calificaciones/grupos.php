<?php
// backend/api/calificaciones/grupos.php
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');

// 1) Sacamos todos los grupos distintos
$sql = "SELECT DISTINCT grupo_est FROM estudiante ORDER BY grupo_est";
if (!$result = $conexion->query($sql)) {
    http_response_code(500);
    echo json_encode(['error' => $conexion->error]);
    exit;
}

// 2) Construimos el array de grupos
$grupos = [];
while ($row = $result->fetch_assoc()) {
    $grupos[] = $row['grupo_est'];
}

// 3) Devolvemos JSON puro
echo json_encode($grupos);

$conexion->close();
