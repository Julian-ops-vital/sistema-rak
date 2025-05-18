<?php
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');
//Este archivo toma los id de las materias y maestros de la tabla "imparte" y no de la tabla "maestro"

// 1) Leer y validar parámetro
$id_mae = isset($_GET['id_mae']) ? (int)$_GET['id_mae'] : 0;
if (!$id_mae) {
    http_response_code(400);
    echo json_encode(['error' => 'Falta parámetro id_mae']);
    exit;
}

// 2) Consulta: todas las materias que imparte este maestro
$sql = "
  SELECT 
    i.numero_imp   AS id_imp,
    m.numero_mat   AS numero_mat,
    m.nombre_mat   AS nombre_mat
  FROM imparte i
  JOIN materia m 
    ON i.numero_mat = m.numero_mat
  WHERE i.id_mae = $id_mae
";
$result = $conexion->query($sql);
if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => $conexion->error]);
    exit;
}

// 3) Recoger resultados
$rows = [];
while ($r = $result->fetch_assoc()) {
    $rows[] = $r;
}

// 4) Devolver JSON
echo json_encode($rows);
$conexion->close();
