<?php
// Mostrar todos los errores de PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir el archivo de conexión
include './modelo/conexion.php';

// Probar la conexión
try {
    if (isset($conn)) {
        echo "Conexión exitosa a la base de datos.";
    } else {
        echo "Error: La conexión no está configurada.";
    }
} catch (Exception $e) {
    echo "Error al conectar: " . $e->getMessage();
}
?>
