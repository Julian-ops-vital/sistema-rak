<?php
// Eliminar un usuario por ID
require_once '../../conexion/conexion.php';
header('Content-Type: application/json');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if(!$id){
    http_response_code(400);
    echo json_encode(['success'=>false,'error'=>'Falta parámetro id']);
    exit;
}

$sql = "DELETE FROM usuario WHERE id_us = $id";
if($conexion->query($sql)){
    echo json_encode(['success'=>true]);
} else {
    http_response_code(500);
    echo json_encode(['success'=>false,'error'=>$conexion->error]);
}

$conexion->close();
