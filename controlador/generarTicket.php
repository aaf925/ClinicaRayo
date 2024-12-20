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

// Función para generar el PDF
if (isset($_GET['id_compra'])) {
    $id_compra = intval($_GET['id_compra']);

    // Consultar la compra específica
    $query_compra = "
        SELECT fecha, precio_total, productos, calificacion
        FROM historial_compra
        WHERE id_compra = ? AND id_usuario = ?";
    $stmt_compra = $conn->prepare($query_compra);
    $stmt_compra->bind_param("ii", $id_compra, $id_usuario);
    $stmt_compra->execute();
    $result_compra = $stmt_compra->get_result();
    $compra = $result_compra->fetch_assoc();
    $stmt_compra->close();

    if ($compra) {
        // Crear el PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 20);

        // Logo
        $pdf->Image('../controlador/images/LogoAzul.png', 10, 10, 30);
        $pdf->SetY(20);

        // Encabezado
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(190, 10, utf8_decode('FACTURA'), 0, 1, 'C');
        $pdf->Ln(10);

        // Datos del cliente
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->Cell(0, 10, utf8_decode('DATOS DEL CLIENTE'), 1, 1, 'C', true);
        $pdf->Cell(100, 8, utf8_decode('Nombre: ' . $user['nombre'] . ' ' . $user['apellido']), 0, 1);
        $pdf->Cell(100, 8, utf8_decode('Email: ' . $user['email']), 0, 1);
        $pdf->Cell(100, 8, utf8_decode('Teléfono: ' . $user['telefono']), 0, 1);
        $pdf->Ln(10);

        // Datos de la factura
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(100, 10, utf8_decode('N° FACTURA: ' . $id_compra), 0, 1);
        $pdf->Cell(100, 8, utf8_decode('FECHA: ' . $compra['fecha']), 0, 1);
        $pdf->Ln(10);

        // Tabla
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(200, 200, 200);
        $pdf->Cell(40, 10, utf8_decode('CANTIDAD'), 1, 0, 'C', true);
        $pdf->Cell(80, 10, utf8_decode('DESCRIPCIÓN'), 1, 0, 'C', true);
        $pdf->Cell(35, 10, utf8_decode('PRECIO U'), 1, 0, 'C', true);
        $pdf->Cell(35, 10, utf8_decode('IMPORTE'), 1, 1, 'C', true);

        // Datos de la tabla
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(40, 10, $compra['productos'], 1);
        $pdf->Cell(80, 10, utf8_decode('Productos varios'), 1);
        $pdf->Cell(35, 10, utf8_decode(number_format($compra['precio_total'] / $compra['productos'], 2) . ''), 1);
        $pdf->Cell(35, 10, utf8_decode(number_format($compra['precio_total'], 2) . ''), 1, 1);

        // Subtotal y Total
     
        // Salida del PDF
        $pdf->Output('D', 'Factura_' . $id_compra . '.pdf');
        exit();
    }
}
?>