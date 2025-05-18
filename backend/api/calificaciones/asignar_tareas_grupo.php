<?php
header('Content-Type: application/json');
require_once '../../conexion/conexion.php';

// asignar_tareas_grupo.php
$data = json_decode(file_get_contents('php://input'), true);
$grupo     = $data['grupo']     ?? null;
$id_act    = $data['actividad'] ?? null;
$fecha_lim = $data['fecha']     ?? null;

if (!$grupo || !$id_act || !$fecha_lim) {
  http_response_code(400);
  echo json_encode(['error'=>'Faltan datos obligatorios']);
  exit;
}

// 2) Traer todos los estudiantes del grupo
$sql = "SELECT id_est FROM estudiante WHERE grupo_est = '$grupo'";
$res = $conexion->query($sql);
if (!$res) {
  http_response_code(500);
  echo json_encode(['success'=>false, 'error'=>$conexion->error]);
  exit;
}

// 3) Insertar tarea para cada uno en transacción
$conexion->begin_transaction();
try {
  while ($row = $res->fetch_assoc()) {
    $id_est = (int)$row['id_est'];
    $now    = date('Y-m-d H:i:s');
    $ins = "INSERT INTO tarea (numero_act, id_est, fechain_tar, fechafin_tar)
            VALUES ($id_act, $id_est, '$now', '$fecha_lim')";
    if (!$conexion->query($ins)) {
      throw new Exception($conexion->error);
    }
  }
  $conexion->commit();
  echo json_encode(['success'=>true]);
} catch (Exception $e) {
  $conexion->rollback();
  http_response_code(500);
  echo json_encode(['success'=>false, 'error'=>$e->getMessage()]);
}

$conexion->close();
