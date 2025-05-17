<?php
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');

// Seleccionamos el nombre de la materia en lugar de su ID
$sql = "
  SELECT 
    a.id_act   AS id,
    m.nombre_mat   AS materia,    -- aquí el nombre
    a.rubrica_act  AS rubrica,
    a.objetivo_act AS objetivo,
    a.ponderacion_act AS ponderacion
  FROM actividad AS a
  JOIN materia   AS m ON a.numero_mat = m.numero_mat
  ORDER BY a.id_act
";

$result = $conexion->query($sql);
if (!$result) {
  http_response_code(500);
  echo json_encode(['success'=>false, 'error'=>$conexion->error]);
  exit;
}

$actividades = [];
while ($row = $result->fetch_assoc()) {
  $actividades[] = $row;
}

echo json_encode($actividades);
$conexion->close();
