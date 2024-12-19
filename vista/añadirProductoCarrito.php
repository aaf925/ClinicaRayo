<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../modelo/conexion.php");
session_start();

// Simulación de usuario autenticado (reemplazar con sesión real)
$id_usuario = $_SESSION['id_usuario'] ?? 1;

// Verificar si se reciben los datos por POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_producto'], $_POST['precio'])) {
    $id_producto = intval($_POST['id_producto']);
    $precio = floatval($_POST['precio']);
    $cantidad = 1; // Cantidad predeterminada
    $total = $precio * $cantidad;

    // Insertar en la base de datos
    $query = "INSERT INTO carrito (id_usuario, id_producto, cantidad, total, fecha_actualizacion) 
              VALUES (?, ?, ?, ?, NOW())";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("iiid", $id_usuario, $id_producto, $cantidad, $total);
        if ($stmt->execute()) {
            header("Location: ../vista/carrito.php?mensaje=Producto añadido al carrito");
            exit();
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }
} else {
    echo "Datos no recibidos correctamente.";
}

// Cerrar la conexión
$conn->close();
?>