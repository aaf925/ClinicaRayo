<?php
require_once '../modelo/conexion.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productos'])) {
    $productos = $_POST['productos']; // IDs seleccionados

    foreach ($productos as $id) {
        // Obtener la ruta de la imagen desde la base de datos
        $id = $conn->real_escape_string($id);
        $sql_select = "SELECT imagen_url FROM producto WHERE id_producto = '$id'";
        $resultado = $conn->query($sql_select);

        if ($resultado && $fila = $resultado->fetch_assoc()) {
            $ruta_imagen = $fila['imagen_url'];
            
            // Eliminar la imagen del servidor si existe
            if (!empty($ruta_imagen) && file_exists($ruta_imagen)) {
                unlink($ruta_imagen); // Elimina la imagen
            }
        }

        // Eliminar el producto de la base de datos
        $sql_delete = "DELETE FROM producto WHERE id_producto = '$id'";
        $conn->query($sql_delete);
    }

    $conn->close();

    // Redirigir de vuelta a la página principal con mensaje de éxito
    header("Location: gestionTiendaOnline.php?borrado=exito");
    exit();
} else {
    // Redirigir con mensaje de error si no se envían productos
    header("Location: gestionTiendaOnline.php?borrado=fallo");
    exit();
}
?>