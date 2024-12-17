<?php
    include('conexion.php');
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $imagen = $_POST['imagen'];
        $cantidad = $_POST['cantidad'];
    }
?>