<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCita = $conexion->real_escape_string($_POST['id_cita']);
    $idUsuario = $conexion->real_escape_string($_POST['id_usuario']);
    $idServicio = $conexion->real_escape_string($_POST['id_servicio']);
    $fechaCita = $conexion->real_escape_string($_POST['fecha_cita']);
    $horaCita = $conexion->real_escape_string($_POST['hora_cita']);
    $estado = $conexion->real_escape_string($_POST['estado']);

    $sql = "UPDATE cita 
            SET id_usuario = '$idUsuario', 
                id_servicio = '$idServicio', 
                fecha_cita = '$fechaCita', 
                hora_cita = '$horaCita', 
                estado = '$estado' 
            WHERE id_cita = '$idCita'";

    if ($conexion->query($sql)) {
        header("Location: gestionCitas.php?mensaje=modificado");
    } else {
        echo "Error al modificar la cita: " . $conexion->error;
    }
}

$conexion->close();
?>
