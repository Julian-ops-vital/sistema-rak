<?php
// Elimina un registro de la tabla `inscripcion` por su PK id_ins
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');

// 1) Leer y validar parámetro
$id_ins = isset($_GET['id_ins']) ? (int)$_GET['id_ins'] : 0;
if (!$id_ins) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Falta parámetro id_ins']);
    exit;
}

// 2) Ejecutar DELETE
$sql = "DELETE FROM `inscripción` WHERE id_ins = $id_ins";
if ($conexion->query($sql)) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $conexion->error]);
}

$conexion->close();
