<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Iniciar sesión
require_once("../modelo/conexion.php"); // Asegúrate de incluir este archivo

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Debes iniciar sesión para continuar.'); window.location.href='../vista/iniciosesion.php';</script>";
    exit();
}

$id_usuario = $_SESSION['id_usuario']; // Obtener el ID del usuario desde la sesión

// Verificar si se ha enviado el formulario con los datos de pago
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $email = htmlspecialchars($_POST['email']);
    $numero_tarjeta = htmlspecialchars($_POST['numero_tarjeta']);
    $mes_vencimiento = htmlspecialchars($_POST['mes_vencimiento']);
    $cvc = htmlspecialchars($_POST['cvc']);
    $titular_tarjeta = htmlspecialchars($_POST['titular_tarjeta']);

    // Validar los datos (simplificado para este ejemplo)
    if (empty($email) || empty($numero_tarjeta) || empty($mes_vencimiento) || empty($cvc) || empty($titular_tarjeta)) {
        echo "<script>alert('Por favor, complete todos los campos.'); window.location.href='../vista/continuarPagarCarrito.php';</script>";
        exit();
    }

    // Validar formato del número de tarjeta (ejemplo básico)
    if (!preg_match('/^\d{16}$/', $numero_tarjeta)) {
        echo "<script>alert('Número de tarjeta no válido.'); window.location.href='../vista/continuarPagarCarrito.php';</script>";
        exit();
    }

    // Validar CVC (3 dígitos)
    if (!preg_match('/^\d{3}$/', $cvc)) {
        echo "<script>alert('CVC no válido.'); window.location.href='../vista/continuarPagarCarrito.php';</script>";
        exit();
    }

    // Validar mes de vencimiento (formato MM/YY)
    if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $mes_vencimiento)) {
        echo "<script>alert('Fecha de vencimiento no válida.'); window.location.href='../vista/continuarPagarCarrito.php';</script>";
        exit();
    }

    // Consultar el último pedido del usuario
    $sql_pedido = "SELECT id_pedido, total FROM pedido WHERE id_usuario = ? ORDER BY id_pedido DESC LIMIT 1";
    $stmt_pedido = $conn->prepare($sql_pedido);
    $stmt_pedido->bind_param("i", $id_usuario);
    $stmt_pedido->execute();
    $result_pedido = $stmt_pedido->get_result();
    $pedido = $result_pedido->fetch_assoc();

    if (!$pedido) {
        echo "<script>alert('No se encontró un pedido para procesar el pago.'); window.location.href='../vista/carrito.php';</script>";
        exit();
    }

    $id_pedido = $pedido['id_pedido'];
    $total_pedido = $pedido['total'];

    // Simular la validación del pago (aquí iría la integración con una pasarela real)
    $pago_exitoso = true; // Supongamos que el pago es exitoso

    if ($pago_exitoso) {
        // Actualizar el estado del pedido a 'pagado'
        $sql_actualizar_pedido = "UPDATE pedido SET estado = 'pagado' WHERE id_pedido = ?";
        $stmt_actualizar = $conn->prepare($sql_actualizar_pedido);
        $stmt_actualizar->bind_param("i", $id_pedido);
        $stmt_actualizar->execute();

        if ($stmt_actualizar->affected_rows > 0) {
            echo "<script>alert('Pago completado con éxito.'); window.location.href='../vista/confirmacionPago.php';</script>";
        } else {
            echo "<script>alert('Error al actualizar el estado del pedido.'); window.location.href='../vista/continuarPagarCarrito.php';</script>";
        }
    } else {
        echo "<script>alert('El pago no se pudo completar. Intente nuevamente.'); window.location.href='../vista/continuarPagarCarrito.php';</script>";
    }
} else {
    echo "<script>alert('Acceso no autorizado.'); window.location.href='../vista/carrito.php';</script>";
    exit();
}

if (isset($conn)) {
    $conn->close(); // Cierra la conexión si está definida
}
?>