<?php
require_once '../modelo/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $id_producto = $conn->real_escape_string($_POST['id_producto']);
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $precio = $conn->real_escape_string($_POST['precio']);
        $descripcion = $conn->real_escape_string($_POST['descripcion']);
        $stock = $conn->real_escape_string($_POST['cantidad']);
        $categoria = $conn->real_escape_string($_POST['categoria']);
        
        // Obtener la imagen anterior
        $sql_select = "SELECT imagen_url FROM producto WHERE id_producto = '$id_producto'";
        $resultado = $conn->query($sql_select);
        $imagen_anterior = ($resultado && $fila = $resultado->fetch_assoc()) ? __DIR__ . '/' . $fila['imagen_url'] : null;

        // Subir nueva imagen
        $imagen_nombre = basename($_FILES['imagen']['name']);
        $imagen_tmp = $_FILES['imagen']['tmp_name'];
        $directorio_destino = __DIR__ . "/img/";
        $imagen_destino = $directorio_destino . $imagen_nombre;

        if (move_uploaded_file($imagen_tmp, $imagen_destino)) {
            $ruta_guardar = "img/" . $imagen_nombre;

            // Eliminar imagen anterior
            if (!empty($imagen_anterior) && file_exists($imagen_anterior)) {
                unlink($imagen_anterior);
            }

            // Actualizar producto
            $sql = "UPDATE producto 
                    SET nombre = '$nombre', 
                        precio = '$precio', 
                        descripcion = '$descripcion', 
                        stock = '$stock', 
                        categoria = '$categoria',
                        imagen_url = '$ruta_guardar' 
                    WHERE id_producto = '$id_producto'";
        }
    } else {
        // Actualizar sin cambiar la imagen
        $id_producto = $conn->real_escape_string($_POST['id_producto']);
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $precio = $conn->real_escape_string($_POST['precio']);
        $descripcion = $conn->real_escape_string($_POST['descripcion']);
        $stock = $conn->real_escape_string($_POST['cantidad']);
        $categoria = $conn->real_escape_string($_POST['categoria']);

        $sql = "UPDATE producto 
                SET nombre = '$nombre', 
                    precio = '$precio', 
                    descripcion = '$descripcion', 
                    stock = '$stock', 
                    categoria = '$categoria'
                WHERE id_producto = '$id_producto'";
    }

    if ($conn->query($sql)) {
        header("Location: ../vista/modificarProductoFormulario.php?id_producto=$id_producto&modificacion=exito");
        exit();
    } else {
        echo "Error al actualizar el producto: " . $conn->error;
    }
}

$conn->close();
?>