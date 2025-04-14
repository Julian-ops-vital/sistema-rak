<?php

require_once '../conexion/conexion.php';

//Verifica que el formulario fue enviado por el metodo POST
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST['nombre'];
    $lastName = $_POST['apellido'];
    $email = $_POST['email'];
    $password = $_POST['email'];

    //Verifica si el usuario existe por el correo
    $checkQuery = "SELECT * FROM usuario WHERE email_us = ?";
    $stmt = $conexion->prepare($checkQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if($resultado->num_rows > 0) {
        echo "El usuario ya esta registrado.";
    }

    //Hashea la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    //Insertar usuario con rol 3 (alumno)
    $insertQuery = "INSERT INTO usuario (numero_rol, email_us, contraseña_us, nombre_us, apellido_us) VALUES (3, ?, ?, ?, ?)";
    $stmt =$conexion->prepare($insertQuery);
    $stmt->bind_param("ssss", $email, $hashedPassword, $name, $lastName);

    if ($stmt->execute()){
        echo "Registro exitoso.";
    } else {
        echo "Error al registrar al alumno" . $stmt->error; 
    }

    $stmt->close();
} else {
    echo "Acceso no autorizado";
}

?>