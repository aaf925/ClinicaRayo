<?php
// Incluir el archivo de conexión
require_once 'conexion.php';

// Obtener el ID máximo de la tabla productos
$sql_max_id = "SELECT MAX(id_producto) AS max_id FROM producto";
$resultado = $conexion->query($sql_max_id);

if ($resultado && $fila = $resultado->fetch_assoc()) {
    $id_nuevo = ($fila['max_id'] !== NULL) ? $fila['max_id'] + 1 : 1;
} else {
    $id_nuevo = 1;
}

// Verificar si se enviaron los datos mediante POST y que existe el archivo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        // Recoger datos del formulario
        $nombre = $conexion->real_escape_string($_POST['nombre']);
        $precio = $conexion->real_escape_string($_POST['precio']);
        $descripcion = $conexion->real_escape_string($_POST['descripcion']);
        $cantidad = $conexion->real_escape_string($_POST['cantidad']);
        $categoria = $conexion->real_escape_string($_POST['categoria']);

        // Manejo de la imagen
        $imagen_nombre = basename($_FILES['imagen']['name']);
        $imagen_tmp = $_FILES['imagen']['tmp_name'];

        // Definir la ruta destino para guardar las imágenes
        $directorio_destino = __DIR__ . "/img/";
        $imagen_destino = $directorio_destino . $imagen_nombre;

        // Crear la carpeta "img" si no existe
        if (!file_exists($directorio_destino)) {
            mkdir($directorio_destino, 0777, true);
        }

        // Mover la imagen subida a la carpeta destino
        if (move_uploaded_file($imagen_tmp, $imagen_destino)) {
            // Ruta relativa que se guardará en la base de datos
            $ruta_guardar = "view/img/" . $imagen_nombre;

            // Insertar datos en la base de datos
            $sql = "INSERT INTO producto (id_producto, nombre, precio, descripcion, stock, categoria, imagen_url) 
                    VALUES ('$id_nuevo', '$nombre', '$precio', '$descripcion', '$cantidad', '$categoria', '$ruta_guardar')";

            if ($conexion->query($sql) === TRUE) {
                header("Location: darAltaProductoFormulario.php?success=true");
                exit;
            }
        }
    }
    header("Location: darAltaProductoFormulario.php?success=false");
    exit;
}

// Cerrar la conexión
$conexion->close();
?>
