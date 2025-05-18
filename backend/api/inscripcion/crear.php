<?php
// Crear un nuevo registro en la tabla inscripcion
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');

// 1) Leer y validar input JSON
$data = json_decode(file_get_contents('php://input'), true);
$id_us      = isset($data['id_us'])      ? (int)$data['id_us']      : 0;
$numero_mat = isset($data['numero_mat']) ? (int)$data['numero_mat'] : 0;

if (!$id_us || !$numero_mat) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Faltan parámetros id_us o numero_mat']);
    exit;
}

// 2) Insertar
$stmt = $conexion->prepare("
  INSERT INTO `inscripción` (id_est, numero_mat)
  VALUES (?, ?)
");
$stmt->bind_param("ii", $id_us, $numero_mat);
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'id_ins' => $stmt->insert_id]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conexion->close();
