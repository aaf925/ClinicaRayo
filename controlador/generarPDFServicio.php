<?php
require('../fpdf/fpdf.php');
include_once('../modelo/conexion.php');

// Verificar si el usuario está autenticado
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../controlador/inicioUsuarioNoRegistrado.php");
    exit();
}

// Obtener el ID del usuario autenticado
$id_usuario = $_SESSION['id_usuario'];

// Consultar los datos del usuario
$query = "SELECT nombre, apellido, email, telefono FROM usuario WHERE id_usuario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Generar el PDF si se recibe un ID de cita
if (isset($_GET['id_cita'])) {
    $id_cita = intval($_GET['id_cita']);

    // Consultar la cita específica
    $query_cita = "
        SELECT lugar, fecha, hora, asistencia, atendido_por, calificacion
        FROM historial_cita
        WHERE id_cita = ? AND id_usuario = ?";
    $stmt_cita = $conn->prepare($query_cita);
    $stmt_cita->bind_param("ii", $id_cita, $id_usuario);
    $stmt_cita->execute();
    $result_cita = $stmt_cita->get_result();
    $cita = $result_cita->fetch_assoc();
    $stmt_cita->close();

    if ($cita) {
        // Crear el PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 20);

        // Logo
        $pdf->Image('../controlador/images/LogoAzul.png', 10, 10, 30);
        $pdf->SetY(20);

        // Encabezado
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(190, 10, utf8_decode('HISTORIAL DE CITA'), 0, 1, 'C');
        $pdf->Ln(10);

        // Datos del cliente
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->Cell(0, 10, utf8_decode('DATOS DEL CLIENTE'), 1, 1, 'C', true);
        $pdf->Cell(100, 8, utf8_decode('Nombre: ' . $user['nombre'] . ' ' . $user['apellido']), 0, 1);
        $pdf->Cell(100, 8, utf8_decode('Email: ' . $user['email']), 0, 1);
        $pdf->Cell(100, 8, utf8_decode('Teléfono: ' . $user['telefono']), 0, 1);
        $pdf->Ln(10);

        // Datos de la cita
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode('DETALLES DE LA CITA'), 1, 1, 'C', true);
        $pdf->Ln(5);
        $pdf->Cell(100, 8, utf8_decode('Lugar: ' . $cita['lugar']), 0, 1);
        $pdf->Cell(100, 8, utf8_decode('Fecha: ' . $cita['fecha']), 0, 1);
        $pdf->Cell(100, 8, utf8_decode('Hora: ' . $cita['hora']), 0, 1);
        $pdf->Cell(100, 8, utf8_decode('Asistencia: ' . ($cita['asistencia'] ? 'Sí' : 'No')), 0, 1);
        $pdf->Cell(100, 8, utf8_decode('Atendido por: ' . $cita['atendido_por']), 0, 1);
        $pdf->Ln(10);

        // Salida del PDF
        $pdf->Output('D', 'Cita_' . $id_cita . '.pdf');
        exit();
    }
}
?>