<?php
// asignar_grupo.php
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');

// 1) Leer el JSON de entrada
$data = json_decode(file_get_contents('php://input'), true);
$grupo      = $conexion->real_escape_string($data['grupo']);
$numero_act = (int) $data['numero_act'];
$fechafin   = $conexion->real_escape_string($data['fechafin']);  // formato YYYY-MM-DD

if (!$grupo || !$numero_act || !$fechafin) {
    http_response_code(400);
    echo json_encode(['success'=>false, 'error'=>'Faltan parámetros: grupo, numero_act o fechafin']);
    exit;
}

// 2) Obtenemos la fecha de asignación (hoy)
$fechain = date('Y-m-d');

// 3) Buscamos a todos los estudiantes de ese grupo
$stmt = $conexion->prepare("
    SELECT id_est 
      FROM estudiante 
     WHERE grupo_est = ?
");
$stmt->bind_param("s", $grupo);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo json_encode(['success'=>true, 'inserted'=>0, 'message'=>'No hay estudiantes en ese grupo']);
    exit;
}

// 4) Preparamos el INSERT para la tabla `tarea`
$ins = $conexion->prepare("
    INSERT INTO tarea 
      (id_est, numero_act, fechain_tar, fechafin_tar, calificacion_tar) 
    VALUES 
      (?, ?, ?, ?, NULL)
");

// 5) Recorremos cada estudiante e insertamos su tarea
$count = 0;
while ($row = $res->fetch_assoc()) {
    $id_est = (int)$row['id_est'];
    $ins->bind_param("iiss", $id_est, $numero_act, $fechain, $fechafin);
    if ($ins->execute()) {
        $count++;
    }
}

$stmt->close();
$ins->close();
$conexion->close();

// 6) Devolvemos resultado
echo json_encode([
    'success'  => true,
    'inserted' => $count,
    'grupo'    => $grupo,
    'actividad'=> $numero_act
]);
