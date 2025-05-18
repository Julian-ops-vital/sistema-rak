<?php
// Elimina un registro de la tabla `imparte` por su PK numero_imp
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');

// 1) Leer y validar parámetro
$id_imp = isset($_GET['id_imp']) ? (int)$_GET['id_imp'] : 0;
if (!$id_imp) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Falta parámetro id_imp']);
    exit;
}

// 2) Ejecutar DELETE
$sql = "DELETE FROM imparte WHERE numero_imp = $id_imp";
if ($conexion->query($sql)) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $conexion->error]);
}

$conexion->close();
