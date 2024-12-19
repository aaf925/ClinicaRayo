<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCita = $conexion->real_escape_string($_POST['id_cita']);

    $sql = "DELETE FROM cita WHERE id_cita = '$idCita'";

    if ($conexion->query($sql)) {
        header("Location: gestionCitas.php?mensaje=eliminada");
    } else {
        echo "Error al eliminar la cita: " . $conexion->error;
    }
}

$conexion->close();
?>
