<?php
session_start();
// Verificar si el usuario ha iniciado sesión y si es administrador
if (!isset($_SESSION['loggedin']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    
    // Si no es administrador o no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: iniciarSesion.php");
    exit();
}

require_once '../vista/menuUsuario.php';
require_once '../vista/historialCompras.php';
require_once '../vista/piePagina.html'; 
?>