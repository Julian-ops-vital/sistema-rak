<?php
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');

$idEst = isset($_GET['id_est']) ? (int)$_GET['id_est'] : 0;
if (!$idEst) {
    http_response_code(400);
    echo json_encode(['error'=>'Falta parámetro id_est']);
    exit;
}

$sql = "
  SELECT 
    t.numero_tar   AS id_ins,
    a.id_act       AS id_act,
    m.nombre_mat   AS materia,
    a.rubrica_act  AS rubrica,
    a.ponderacion_act AS ponderacion,
    t.calificacion_tar AS calificacion
  FROM tarea t
  JOIN actividad a ON t.numero_act = a.id_act
  JOIN materia m   ON a.numero_mat  = m.numero_mat
  WHERE t.id_est = $idEst
  ORDER BY a.numero_mat
";

$result = $conexion->query($sql);
if (!$result) {
    http_response_code(500);
    echo json_encode(['error'=>$conexion->error]);
    exit;
}

$rows = [];
while ($r = $result->fetch_assoc()) {
    $rows[] = [
      'id_ins'     => (int)$r['id_ins'],
      'materia'    => $r['materia'],
      'rubrica'    => $r['rubrica'],
      'ponderacion'=> (float)$r['ponderacion'],
      'calificacion'=> $r['calificacion'] !== null ? (float)$r['calificacion'] : null
    ];
}
echo json_encode($rows);
$conexion->close();
