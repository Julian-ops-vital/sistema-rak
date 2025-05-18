<?php
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');
//Este archivo toma los id de las materias y estudiantes de la tabla `inscripción` y no de la tabla "estudiante"

// 1) Leer y validar parámetro
$id_est = isset($_GET['id_est']) ? (int)$_GET['id_est'] : 0;
if (!$id_est) {
    http_response_code(400);
    echo json_encode(['error' => 'Falta parámetro id_est']);
    exit;
}

// 2) Consulta: todas las materias en las que está inscrito este alumno
//    Nota: si tu tabla se llama `inscripción` con tilde, ponlo entre backticks. 
//    Aquí asumo que la has renombrado a `inscripcion` sin tilde.
$sql = "
  SELECT 
    i.id_ins        AS id_ins,
    m.numero_mat    AS numero_mat,
    m.nombre_mat    AS nombre_mat
  FROM `inscripción` i
  JOIN materia m 
    ON i.numero_mat = m.numero_mat
  WHERE i.id_est = $id_est
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
