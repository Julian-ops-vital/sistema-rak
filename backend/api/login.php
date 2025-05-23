<?php

//Iniciar sesion
session_start();

//Se inlcuye el achivo conexion
require_once '../conexion/conexion.php';

// Se obtienen los datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];

//Prepara la consulta para evitar SQL injection
$stmt = $conexion->prepare("SELECT * FROM usuario WHERE email_us = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

//Verifica si el usuario existe
if ($result->num_rows === 1){
    $usuario = $result->fetch_assoc();

    //Verifica la contraseña
    if($password == $usuario['contraseña_us']){
        //Guarda los datos en sesion
        $_SESSION['usuario_id'] = $usuario['id_us'];
        $_SESSION['usuario_email'] = $usuario['email_us'];
        $_SESSION['usuario_name'] = $usuario['nombre_us'];
        $_SESSION['usuario_rol'] = $usuario['numero_rol'];
        header("Location: /rak/sistema-rak/frontend/pages/home.php");
        exit();
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "El correo no esta registrado";
}

$stmt->close();
$conexion->close();
?>