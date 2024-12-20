<?php
require_once '../modelo/conexion.php';

if (isset($_GET['fecha'])) {
    $fecha = $conn->real_escape_string($_GET['fecha']);
    $sql = "SELECT TIME_FORMAT(hora_cita, '%H:%i') AS hora_cita FROM cita WHERE fecha_cita = '$fecha'";
    $resultado = $conn->query($sql);

    $horasOcupadas = [];
    if ($resultado && $resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $horasOcupadas[] = $fila['hora_cita']; // Ejemplo: '08:00'
        }
    }

    header('Content-Type: application/json');
    echo json_encode($horasOcupadas);
    exit();
} else {
    header('Content-Type: application/json');
    echo json_encode([]);
    exit();
}
?>