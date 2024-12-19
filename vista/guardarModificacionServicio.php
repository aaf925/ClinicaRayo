<?php
require_once '../modelo/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $id_servicio = $conn->real_escape_string($_POST['id_servicio']);
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $precio = $conn->real_escape_string($_POST['precio']);
        $descripcion = $conn->real_escape_string($_POST['descripcion']);
        
        // Obtener la imagen anterior
        $sql_select = "SELECT imagen_url FROM servicio WHERE id_servicio = '$id_servicio'";
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
            $sql = "UPDATE servicio 
                    SET nombre = '$nombre', 
                        precio = '$precio', 
                        descripcion = '$descripcion', 
                        imagen_url = '$ruta_guardar' 
                    WHERE id_servicio = '$id_servicio'";
        }
    } else {
        // Actualizar sin cambiar la imagen
        $id_servicio = $conn->real_escape_string($_POST['id_servicio']);
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $precio = $conn->real_escape_string($_POST['precio']);
        $descripcion = $conn->real_escape_string($_POST['descripcion']);

        $sql = "UPDATE servicio 
                SET nombre = '$nombre', 
                    precio = '$precio', 
                    descripcion = '$descripcion'
                WHERE id_servicio = '$id_servicio'";
    }

    if ($conn->query($sql)) {
        header("Location: ../vista/modificarServicioFormulario.php?id_servicio=$id_servicio&modificacion=exito");
        exit();
    } else {
        echo "Error al actualizar el servicio: " . $conn->error;
    }
}

$conn->close();
?>