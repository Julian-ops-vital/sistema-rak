<?php
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
    http_response_code(400);
    echo json_encode(['success'=>false,'error'=>'Falta parámetro id']);
    exit;
}

// Empieza transacción
$conexion->begin_transaction();

try {
    // 1) Borrar en las tablas hijas
    $conexion->query("DELETE FROM estudiante     WHERE Id_us = $id");
    $conexion->query("DELETE FROM maestro        WHERE Id_us = $id");
    $conexion->query("DELETE FROM administrador WHERE Id_us = $id");

    // 2) Borrar al usuario
    $conexion->query("DELETE FROM usuario       WHERE id_us  = $id");

    // 3) Commit si todo fue OK
    $conexion->commit();
    echo json_encode(['success'=>true]);

} catch (Exception $e) {
    // Rollback y error
    $conexion->rollback();
    http_response_code(500);
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
}

$conexion->close();
