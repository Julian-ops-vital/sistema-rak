<?php
require_once 'conexion.php'; // Incluye tu conexión ya configurada

header('Content-Type: application/json');

// Verifica si mandaron el parámetro ID
if (!isset($_GET['id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Falta el parámetro 'id'"
    ]);
    exit;
}

$id = intval($_GET['id']); // Sanitiza el ID

// Consulta con JOIN para obtener info del estudiante y usuario
$sql = "SELECT 
            e.id_est,
            u.nombre_us AS nombre,
            u.apellido_us AS apellido,
            e.grado_est,
            e.grupo_est
        FROM estudiante e
        INNER JOIN usuario u ON e.id_us = u.id_us
        WHERE e.id_est = $id";

$resultado = $conn->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    $alumno = $resultado->fetch_assoc();
    echo json_encode([
        "status" => "success",
        "data" => $alumno
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No se encontró ningún alumno con el ID $id"
    ]);
}

$conn->close();
?>