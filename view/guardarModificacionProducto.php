<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        // Capturar datos del formulario
        $id_producto = $conexion->real_escape_string($_POST['id_producto']);
        $nombre = $conexion->real_escape_string($_POST['nombre']);
        $precio = $conexion->real_escape_string($_POST['precio']);
        $descripcion = $conexion->real_escape_string($_POST['descripcion']);
        $stock = $conexion->real_escape_string($_POST['cantidad']);
        $categoria = $conexion->real_escape_string($_POST['categoria']);
        
        // Obtener la imagen anterior de la base de datos
        $sql_select = "SELECT imagen_url FROM producto WHERE id_producto = '$id_producto'";
        $resultado = $conexion->query($sql_select);

        if ($resultado && $fila = $resultado->fetch_assoc()) {
            $imagen_anterior = __DIR__ . '/' . $fila['imagen_url'];
        } else {
            $imagen_anterior = null; // Si no hay imagen anterior
        }

        // Procesar la nueva imagen
        $imagen_nombre = basename($_FILES['imagen']['name']);
        $imagen_tmp = $_FILES['imagen']['tmp_name'];

        $directorio_destino = __DIR__ . "/img/";
        $imagen_destino = $directorio_destino . $imagen_nombre;

        // Crear la carpeta img si no existe
        if (!file_exists($directorio_destino)) {
            mkdir($directorio_destino, 0777, true);
        }

        // Subir la nueva imagen
        if (move_uploaded_file($imagen_tmp, $imagen_destino)) {
            $ruta_guardar = "img/" . $imagen_nombre;

            // Eliminar la imagen anterior si existe
            if (!empty($imagen_anterior) && file_exists($imagen_anterior)) {
                unlink($imagen_anterior);
            }

            // Actualizar los datos del producto en la base de datos
            $sql = "UPDATE producto 
                    SET nombre = '$nombre', 
                        precio = '$precio', 
                        descripcion = '$descripcion', 
                        stock = '$stock', 
                        categoria = '$categoria',
                        imagen_url = '$ruta_guardar' 
                    WHERE id_producto = '$id_producto'";

            if ($conexion->query($sql)) {
                header("Location: gestionTiendaOnline.php?modificacion=exito");
                exit();
            } else {
                echo "Error al actualizar el producto: " . $conexion->error;
                exit();
            }
        } else {
            echo "Error al subir la nueva imagen.";
            exit();
        }
    } else {
        // Si no se sube una nueva imagen, solo actualizar otros campos
        $id_producto = $conexion->real_escape_string($_POST['id_producto']);
        $nombre = $conexion->real_escape_string($_POST['nombre']);
        $precio = $conexion->real_escape_string($_POST['precio']);
        $descripcion = $conexion->real_escape_string($_POST['descripcion']);
        $stock = $conexion->real_escape_string($_POST['cantidad']);
        $categoria = $conexion->real_escape_string($_POST['categoria']);

        // Actualizar sin modificar la imagen
        $sql = "UPDATE producto 
                SET nombre = '$nombre', 
                    precio = '$precio', 
                    descripcion = '$descripcion', 
                    stock = '$stock', 
                    categoria = '$categoria'
                WHERE id_producto = '$id_producto'";

        if ($conexion->query($sql)) {
            header("Location: gestionTiendaOnline.php?modificacion=exito");
            exit();
        } else {
            echo "Error al actualizar el producto: " . $conexion->error;
            exit();
        }
    }
}

$conexion->close();
?>
