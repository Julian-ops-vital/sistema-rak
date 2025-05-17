<?php
// Crear un nuevo usuario
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');

// Leemos JSON del body
$data = json_decode(file_get_contents('php://input'), true);
$materia = (int)$data['materia'];
$rubrica     = $conexion->real_escape_string($data['rubrica']);
$objetivo    = $conexion->real_escape_string($data['objetivo']);
$ponderacion = (float)$data['ponderacion'];

$sql = "INSERT INTO actividad (numero_mat, rubrica_act, objetivo_act, ponderacion_act)
        VALUES ($materia, '$rubrica', '$objetivo', $ponderacion)";

if($conexion->query($sql)){
    echo json_encode(['success' => true, 'id' => $conexion->insert_id]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $conexion->error]);
}

$conexion->close();
