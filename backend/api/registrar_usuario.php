<?php
// Crear un nuevo usuario
require_once '../conexion/conexion.php';
header('Content-Type: application/json');

// Leemos JSON del body
$data = json_decode(file_get_contents('php://input'), true);
$nombre   = $conexion->real_escape_string($data['nombre']);
$apellido = $conexion->real_escape_string($data['apellido']);
$correo   = $conexion->real_escape_string($data['correo']);
$pass     = $conexion->real_escape_string($data['password']);   // plaintext sólo pruebas
$rol      = (int)$data['rol'];

$sql = "INSERT INTO usuario (nombre_us, apellido_us, email_us, contraseña_us, numero_rol)
        VALUES ('$nombre', '$apellido', '$correo', '$pass', $rol)";

if($conexion->query($sql)){
    echo json_encode(['success' => true, 'id' => $conexion->insert_id]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $conexion->error]);
}

$conexion->close();
