<?php
    $servidor = "LOCALHOST";
    $usuario = "root";
    $contrasena = "root";
    $base = "clinicarayo";

    $conexion = mysqli_connect($servidor, $usuario, $contrasena, $base);

    if ($conexion->connect_errno) {
        die("Error de conexion: " . $conexion->connect_error);
    } else {
        echo "¡Conectado a la base de datos!";
    }
?>