<?php
require_once 'conexion.php';

// Obtener el ID máximo de la tabla citas
$sql_max_id = "SELECT MAX(id_cita) AS max_id FROM cita";
$resultado = $conexion->query($sql_max_id);

if ($resultado && $fila = $resultado->fetch_assoc()) {
    $id_nuevo = ($fila['max_id'] !== NULL) ? $fila['max_id'] + 1 : 1;
} else {
    $id_nuevo = 1;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['accion'] === 'añadir') {
        $id_usuario = $conexion->real_escape_string($_POST['id_usuario']);
        $id_servicio = $conexion->real_escape_string($_POST['id_servicio']);
        $fecha_cita = $conexion->real_escape_string($_POST['fecha_cita']);
        $hora_cita = $conexion->real_escape_string($_POST['hora_cita']);
        $estado = $conexion->real_escape_string($_POST['estado']);

        $sql = "INSERT INTO cita (id_cita, id_usuario, id_servicio, fecha_cita, hora_cita, estado) 
                VALUES ('$id_nuevo', '$id_usuario', '$id_servicio', '$fecha_cita', '$hora_cita', '$estado')";

        if ($conexion->query($sql)) {
            header("Location: gestionCitas.php?mensaje=exito");
        } else {
            echo "Error al añadir la cita: " . $conexion->error;
        }
    }
}
?>
