<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['tipo_usuario'] !== 'administrador') {
    
    // Si no es administrador o no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: iniciarSesion.php");
    exit();
}
require_once '../vista/menuAdmin.php';
require_once '../vista/inicioAdmin.php';
?>
