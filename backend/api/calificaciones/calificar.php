<?php
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$id   = isset($data['id_ins'])        ? (int)$data['id_ins']        : 0;
$cal  = isset($data['calificacion'])  ? (float)$data['calificacion'] : null;
if (!$id || $cal===null) {
    http_response_code(400);
    echo json_encode(['error'=>'Faltan datos']);
    exit;
}

$sql = "UPDATE tarea SET calificacion_tar = $cal WHERE numero_tar = $id";
if ($conexion->query($sql)) {
    echo json_encode(['success'=>true]);
} else {
    http_response_code(500);
    echo json_encode(['error'=>$conexion->error]);
}
$conexion->close();
