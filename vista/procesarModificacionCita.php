<?php
require_once '../modelo/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCita = $conn->real_escape_string($_POST['id_cita']);
    $idUsuario = $conn->real_escape_string($_POST['id_usuario']);
    $idServicio = $conn->real_escape_string($_POST['id_servicio']);
    $fechaCita = $conn->real_escape_string($_POST['fecha_cita']);
    $horaCita = $conn->real_escape_string($_POST['hora_cita']);
    $estado = $conn->real_escape_string($_POST['estado']);

    $sql = "UPDATE cita 
            SET id_usuario = '$idUsuario', 
                id_servicio = '$idServicio', 
                fecha_cita = '$fechaCita', 
                hora_cita = '$horaCita', 
                estado = '$estado' 
            WHERE id_cita = '$idCita'";

    if ($conn->query($sql)) {
        header("Location: ../vista/gestionCitas.php?mensaje=modificado");
    } else {
        echo "Error al modificar la cita: " . $conn->error;
    }
}

$conn->close();
?>