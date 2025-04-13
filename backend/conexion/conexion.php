<?php
//Conexion a la base de datos

$server = 'localhost';
$port = '3307';
$user ='root';
$password = '';
$database = 'sistema_rak';

// Crear conexión
$conexion = new mysqli($server, $user, $password, $database );

// Verificar conexión
if ($conexion ->connect_error){
    die("Error de connexion: " . $conexion->connect_error)
}

