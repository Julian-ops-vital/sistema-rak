<?php
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');

// 1) Leer y sanitizar
$data     = json_decode(file_get_contents('php://input'), true);
$nombre   = $conexion->real_escape_string($data['nombre']);
$apellido = $conexion->real_escape_string($data['apellido']);
$correo   = $conexion->real_escape_string($data['correo']);
$pass     = $conexion->real_escape_string($data['password']);
$rol      = (int) $data['rol'];

// Sacar grupo sólo si viene, y escaparlo
$grupo = '';
if ($rol === 3 && isset($data['grupo'])) {
    $grupo = $conexion->real_escape_string($data['grupo']);
}

// 2) Verificar correo duplicado
$check = $conexion->prepare("SELECT id_us FROM usuario WHERE email_us = ? LIMIT 1");
$check->bind_param("s", $correo);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    http_response_code(409);
    echo json_encode(['success'=>false, 'error'=>'El correo ya está registrado']);
    exit;
}
$check->close();

// 3) Insertar en usuario
$sql = "INSERT INTO usuario 
         (nombre_us, apellido_us, email_us, contraseña_us, numero_rol)
        VALUES 
         ('$nombre','$apellido','$correo','$pass',$rol)";
if (! $conexion->query($sql)) {
    http_response_code(500);
    echo json_encode(['success'=>false, 'error'=>$conexion->error]);
    exit;
}
$userId = $conexion->insert_id;

// 4) Insertar en la tabla según rol
switch ($rol) {
  case 1:
    $conexion->query("INSERT INTO administrador (nombre_admin, Id_us) VALUES ('$nombre', $userId)");
    break;
  case 2:
    $conexion->query("INSERT INTO maestro (nombre_mae, Id_us) VALUES ('$nombre',$userId)");
    break;
  case 3:
    $conexion->query("INSERT INTO estudiante (nombre_est, Id_us, grupo_est) VALUES ('$nombre', $userId, '$grupo')");
    break;
}

// 5) Devolver sólo UNA vez el JSON de éxito
echo json_encode(['success'=>true, 'id'=>$userId]);
$conexion->close();