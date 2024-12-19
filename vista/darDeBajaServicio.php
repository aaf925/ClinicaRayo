<?php
require_once '../modelo/conexion.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['servicios'])) {
    $servicios = $_POST['servicios']; // IDs seleccionados

    foreach ($servicios as $id) {
        // Obtener la ruta de la imagen desde la base de datos
        $id = $conn->real_escape_string($id);
        $sql_select = "SELECT imagen_url FROM servicio WHERE id_servicio = '$id'";
        $resultado = $conn->query($sql_select);

        if ($resultado && $fila = $resultado->fetch_assoc()) {
            $ruta_imagen = $fila['imagen_url'];
            
            // Eliminar la imagen del servidor si existe
            if (!empty($ruta_imagen) && file_exists($ruta_imagen)) {
                unlink($ruta_imagen); // Elimina la imagen
            }
        }

        // Eliminar el servicio de la base de datos
        $sql_delete = "DELETE FROM servicio WHERE id_servicio = '$id'";
        $conn->query($sql_delete);
    }

    $conn->close();

    // Redirigir de vuelta a la página principal con mensaje de éxito
    header("Location: ../vista/gestionServicios.php?borrado=exito");
    exit();
} else {
    // Redirigir con mensaje de error si no se envían productos
    header("Location: ../vista/gestionServicios.php?borrado=fallo");
    exit();
}
?>