<?php

//Habilita CORS para poder usarlo desde el frontend
header("Access-control-Allow-Origin *");
header("Content-Type: application/json");

//Se inlcuye el achivo conexion
require_once(../conexion/conexion.php);

?>