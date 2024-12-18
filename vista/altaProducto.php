<?php
// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conectar a la base de datos
    require_once '../modelo/conexion.php';

    // Recoger los datos del formulario
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];

    // Ruta para almacenar las imágenes
    $target_dir = "./vista/uploads/"; // Ruta donde se guardarán las imágenes
    $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verificar si el archivo es una imagen
    $check = getimagesize($_FILES["imagen"]["tmp_name"]);
    if ($check === false) {
        echo "El archivo no es una imagen.";
        exit();
    }

    // Mover el archivo al directorio de destino
    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
        echo "La imagen ha sido subida correctamente.";

        // Insertar los datos en la base de datos, incluyendo la ruta de la imagen
        $query = "INSERT INTO productos (nombre, precio, descripcion, cantidad, imagen) 
                  VALUES ('$nombre', '$precio', '$descripcion', '$cantidad', '$target_file')";
        
        if (mysqli_query($conexion, $query)) {
            echo "Producto registrado exitosamente.";
            // Redirigir para limpiar el formulario
            header('Location: altaProducto.php');
            exit();
        } else {
            echo "Error al guardar el producto: " . mysqli_error($conexion);
        }
    } else {
        echo "Lo siento, hubo un error al subir la imagen.";
    }
}
?>
