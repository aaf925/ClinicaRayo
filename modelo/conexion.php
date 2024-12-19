<?php
$server = "localhost";
$user = "root";
$pass = "javisan2711_";
$db = "practica4sio";

// Crear conexión
$conexion = new mysqli($server, $user, $pass, $db);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
} else {
    echo "Conectado";
}
?>