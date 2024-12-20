<?php
require_once '../modelo/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCita = $conn->real_escape_string($_POST['id_cita']);

    $sql = "DELETE FROM cita WHERE id_cita = '$idCita'";

    if ($conn->query($sql)) {
        header("Location: ../vista/gestionCitas.php?mensaje=eliminada");
    } else {
        echo "Error al eliminar la cita: " . $conn->error;
    }
}

$conn->close();
?>