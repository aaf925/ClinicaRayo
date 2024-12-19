<?php
require('../fpdf/fpdf.php');
include_once('../modelo/conexion.php');

session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../controlador/inicioUsuarioNoRegistrado.php");
    exit();
}

// Verificar que se haya pasado un ID de compra válido
if (!isset($_GET['id_compra'])) {
    die("No se especificó una compra válida.");
}

$id_usuario = $_SESSION['id_usuario'];
$id_compra = intval($_GET['id_compra']);

// Consultar los datos de la compra
$query = "
    SELECT id_compra, fecha, precio_total, productos, calificacion
    FROM historial_compra
    WHERE id_compra = ? AND id_usuario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $id_compra, $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$compra = $result->fetch_assoc();

// Si no se encuentra la compra, mostrar error
if (!$compra) {
    die("No se encontró la compra especificada o no tiene permiso para acceder a ella.");
}

// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Encabezado
$pdf->Cell(0, 10, 'Ticket de Compra', 0, 1, 'C');
$pdf->Ln(10);

// Detalles de la compra
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 10, 'ID de Compra:', 0, 0);
$pdf->Cell(0, 10, $compra['id_compra'], 0, 1);

$pdf->Cell(40, 10, 'Fecha:', 0, 0);
$pdf->Cell(0, 10, $compra['fecha'], 0, 1);

$pdf->Cell(40, 10, 'Precio Total:', 0, 0);
$pdf->Cell(0, 10, number_format($compra['precio_total'], 2) . ' €', 0, 1);

$pdf->Cell(40, 10, 'Productos:', 0, 0);
$pdf->Cell(0, 10, $compra['productos'], 0, 1);

$pdf->Cell(40, 10, 'Calificacion:', 0, 0);
$pdf->Cell(0, 10, str_repeat('★', $compra['calificacion']), 0, 1);

// Salida del PDF
$pdf->Output('D', 'ticket_compra_' . $compra['id_compra'] . '.pdf');
?>
