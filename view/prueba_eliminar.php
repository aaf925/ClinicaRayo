<?php
// Código para probar la eliminación del archivo
$ruta_imagen = __DIR__ . '/img/Babaria.png';

if (file_exists($ruta_imagen)) {
    if (unlink($ruta_imagen)) {
        echo "Archivo eliminado correctamente.";
    } else {
        echo "Error: No se pudo eliminar el archivo. Verifica permisos.";
    }
} else {
    echo "Error: El archivo no existe en " . $ruta_imagen;
}
echo "Ruta completa: " . __DIR__ . '/img/ejemplo.png';
?>
