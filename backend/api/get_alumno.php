<?php
// Ya tienes la conexión activa en $conn (asumiendo que usas require_once 'conexion.php')
header('Content-Type: application/json');

// Consulta para obtener todos los estudiantes con su info completa desde usuario
$sql = "SELECT 
            e.id_est,
            u.nombre_us AS nombre,
            u.apellido_us AS apellido,
            e.grado_est,
            e.grupo_est
        FROM estudiante e
        INNER JOIN usuario u ON e.id_us = u.id_us";

$resultado = $conn->query($sql);

// Array para almacenar los datos
$alumnos = [];

if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $alumnos[] = $fila;
    }

    echo json_encode([
        "status" => "success",
        "total" => count($alumnos),
        "data" => $alumnos
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "No hay estudiantes registrados en la base de datos"
    ]);
}

$conn->close();
?>
