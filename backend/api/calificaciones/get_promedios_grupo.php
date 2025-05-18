<?php
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');

$grupo = isset($_GET['grupo']) ? $conexion->real_escape_string($_GET['grupo']) : '';
if (!$grupo) {
    http_response_code(400);
    echo json_encode(['error'=>'Falta parámetro grupo']);
    exit;
}

$sql = "
 SELECT 
   e.id_est     AS id_est,
   u.nombre_us  AS nombre,
   u.apellido_us AS apellido,
   ROUND(
     SUM(t.`calificación_tar` * a.ponderacion_act / 100)
     ,2
   ) AS promedio
 FROM estudiante e
 JOIN usuario u ON e.id_us = u.id_us
 LEFT JOIN tarea t ON e.id_est = t.id_est
 LEFT JOIN actividad a ON t.numero_act = a.id_act
 WHERE e.grupo_est = '$grupo'
 GROUP BY e.id_est
 ORDER BY u.nombre_us, u.apellido_us
";

$result = $conexion->query($sql);
if(!$result){
  http_response_code(500);
  echo json_encode(['error'=>$conexion->error]);
  exit;
}

$rows = [];
while($r = $result->fetch_assoc()){
  $rows[] = [
    'id_est'   => (int)$r['id_est'],
    'nombre'   => $r['nombre'],
    'apellido' => $r['apellido'],
    'promedio' => (float)$r['promedio']
  ];
}
echo json_encode($rows);
$conexion->close();
