    <?php
// /rak/sistema-rak/backend/api/calificaciones/global.php

require_once '../../conexion/conexion.php';
header('Content-Type: application/json; charset=UTF-8');

// 1) Leer y validar parámetro id_est
$id_est = isset($_GET['id_est']) ? (int) $_GET['id_est'] : 0;
if ($id_est <= 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error'   => 'Falta o es inválido el parámetro id_est'
    ]);
    exit;
}

// 2) Calcular promedio ponderado
//    Suma de (calificación * ponderación / 100) para todas las tareas de ese estudiante
$sql = "
  SELECT 
    ROUND(
      IFNULL(
        SUM(t.`calificación_tar` * a.`ponderacion_act` / 100),
        0
      ), 2
    ) AS promedio
  FROM `tarea` t
  JOIN `actividad` a 
    ON t.`numero_act` = a.`id_act`
  WHERE t.`id_est` = $id_est
";

if (! $res = $conexion->query($sql)) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => $conexion->error
    ]);
    exit;
}

// 3) Extraer resultado
$row = $res->fetch_assoc();
$prom = isset($row['promedio']) ? (float)$row['promedio'] : 0.0;

// 4) Devolver JSON
echo json_encode([
    'success'  => true,
    'promedio' => $prom
]);

$conexion->close();
