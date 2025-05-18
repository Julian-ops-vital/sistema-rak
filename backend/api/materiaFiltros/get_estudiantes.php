<?php
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');
//Este archivo toma los maestros de la tabla "estudiante" y no de la tabla "usuario"

$id_est = isset($_GET['id_est']) ? (int)$_GET['id_est'] : null;

if ($id_est) {
    $stmt = $conexion->prepare("
      SELECT 
        e.id_est      AS id,
        u.nombre_us   AS nombre,
        u.apellido_us AS apellido,
        e.grado_est   AS grado,
        e.grupo_est   AS grupo
      FROM estudiante e
      JOIN usuario u ON e.id_us = u.id_us
      WHERE e.id_est = ?
      ORDER BY u.nombre_us
    ");
    $stmt->bind_param("i", $id_est);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "
      SELECT 
        e.id_est      AS id,
        u.nombre_us   AS nombre,
        u.apellido_us AS apellido,
        e.grado_est   AS grado,
        e.grupo_est   AS grupo
      FROM estudiante e
      JOIN usuario u ON e.id_us = u.id_us
      ORDER BY e.grado_est, e.grupo_est, u.nombre_us
    ";
    $result = $conexion->query($sql);
}

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => $conexion->error]);
    exit;
}

$rows = [];
while ($r = $result->fetch_assoc()) {
    $rows[] = [
      'id'       => (int)$r['id'],
      'nombre'   => $r['nombre'],
      'apellido' => $r['apellido'],
      'grado'    => $r['grado'],
      'grupo'    => $r['grupo']
    ];
}

echo json_encode($rows);
$conexion->close();
