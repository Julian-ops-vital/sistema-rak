<?php
// Crear un nuevo usuario
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');

// Leemos JSON del body
$data = json_decode(file_get_contents('php://input'), true);
$nombre = $conexion->real_escape_string($data['nombre']);

//Verifica materia
$check = $conexion->prepare("SELECT numero_mat FROM materia WHERE nombre_mat = ? LIMIT 1");
$check->bind_param("s", $nombre);
$check->execute();
$check->store_result();

if($check->num_rows > 0){
    http_response_code(409);
    echo json_encode([
        'succes' => false,
        'error' => 'La materia ya existe'
    ]);
    $check->close();
    $conexion->close();
    exit;
}
$check->close();

$sql = "INSERT INTO materia (nombre_mat)
        VALUES ('$nombre')";

if($conexion->query($sql)){
    echo json_encode(['success' => true, 'id' => $conexion->insert_id]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $conexion->error]);
}

$conexion->close();
