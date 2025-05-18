<?php
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');
//Este archivo toma los maestros de la tabla "maestro" y no de la tabla "usuario"

// 1) Si llega id_mae en la URL, úsalo para filtrar; si no, trae todos
$id_mae = isset($_GET['id_mae']) ? (int)$_GET['id_mae'] : null;

if ($id_mae) {
    // Prepared statement para seguridad
    $stmt = $conexion->prepare("
      SELECT 
        m.id_mae   AS id,
        u.nombre_us  AS nombre,
        u.apellido_us AS apellido
      FROM maestro m
      JOIN usuario u ON m.id_us = u.id_us
      WHERE m.id_mae = ?
      ORDER BY u.nombre_us, u.apellido_us
    ");
    $stmt->bind_param("i", $id_mae);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Sin filtro: todos
    $sql = "
      SELECT 
        m.id_mae   AS id,
        u.nombre_us  AS nombre,
        u.apellido_us AS apellido
      FROM maestro m
      JOIN usuario u ON m.id_us = u.id_us
      ORDER BY u.nombre_us, u.apellido_us
    ";
    $result = $conexion->query($sql);
}

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => $conexion->error]);
    exit;
}

// 2) Construye el JSON
$rows = [];
while ($r = $result->fetch_assoc()) {
    $rows[] = [
      'id'       => (int)$r['id'],
      'nombre'   => $r['nombre'],
      'apellido' => $r['apellido']
    ];
}

echo json_encode($rows);
$conexion->close();
