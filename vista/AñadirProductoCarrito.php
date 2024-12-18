<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../modelo/conexion.php");
session_start();

// Simulación de usuario autenticado (sustituir por sesión real)
$id_usuario = $_SESSION['id_usuario'] ?? 1;

// Validar los datos recibidos
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_producto'], $_POST['precio'])) {
    $id_producto = intval($_POST['id_producto']);
    $precio = floatval($_POST['precio']);
    $cantidad = 1; // Cantidad predeterminada al añadir al carrito
    $total = $precio * $cantidad;

    // Insertar el producto en la tabla carrito
    $query = "INSERT INTO carrito (id_usuario, id_producto, cantidad, total, fecha_actualizacion) 
              VALUES (?, ?, ?, ?, NOW())";

    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("iiid", $id_usuario, $id_producto, $cantidad, $total);

        if ($stmt->execute()) {
            header("Location: carrito.php?mensaje=Producto añadido al carrito");
            exit();
        } else {
            echo "Error al añadir el producto al carrito: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conexion->error;
    }
} else {
    echo "Datos inválidos o incompletos.";
}

$conexion->close();
?>
