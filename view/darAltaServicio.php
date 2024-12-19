<?php
require_once 'conexion.php';

// Obtener el ID máximo de la tabla servicios
$sql_max_id = "SELECT MAX(id_servicio) AS max_id FROM servicio";
$resultado = $conexion->query($sql_max_id);

if ($resultado && $fila = $resultado->fetch_assoc()) {
    $id_nuevo = ($fila['max_id'] !== NULL) ? $fila['max_id'] + 1 : 1;
} else {
    $id_nuevo = 1;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $nombre = $conexion->real_escape_string($_POST['nombre']);
        $precio = $conexion->real_escape_string($_POST['precio']);
        $descripcion = $conexion->real_escape_string($_POST['descripcion']);

        $imagen_nombre = basename($_FILES['imagen']['name']);
        $imagen_tmp = $_FILES['imagen']['tmp_name'];

        $directorio_destino = __DIR__ . "/img/";
        $imagen_destino = $directorio_destino . $imagen_nombre;

        if (!file_exists($directorio_destino)) {
            mkdir($directorio_destino, 0777, true);
        }

        if (move_uploaded_file($imagen_tmp, $imagen_destino)) {
            $ruta_guardar = "img/" . $imagen_nombre;

            // Verificar ruta antes del INSERT
            echo "Ruta de imagen a guardar: $ruta_guardar";

            $sql = "INSERT INTO servicio (id_servicio, nombre, precio, descripcion, imagen_url) 
                    VALUES ('$id_nuevo', '$nombre', '$precio', '$descripcion', '$ruta_guardar')";

            if ($conexion->query($sql) === TRUE) {
                echo "Servicio añadido con éxito.";
                header("Location: darAltaServicioFormulario.php?success=true");
                exit;
            } else {
                echo "Error al insertar en la base de datos: " . $conexion->error;
                exit;
            }
        } else {
            echo "Error al mover la imagen. Verifica permisos y rutas.";
            exit;
        }
    } else {
        echo "Error al subir la imagen. Código de error: " . $_FILES['imagen']['error'];
        exit;
    }
}

$conexion->close();
?>
