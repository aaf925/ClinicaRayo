<?php
require_once 'conexion.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usuarios'])) {
    $usuarios = $_POST['usuarios']; // IDs de los usuarios seleccionados

    if (!empty($usuarios)) {
        // Prepara la consulta para eliminar usuarios
        $ids = implode(',', array_map('intval', $usuarios)); // Sanitiza y convierte a lista separada por comas
        $sql = "DELETE FROM usuario WHERE id_usuario IN ($ids)";

        if ($conexion->query($sql) === TRUE) {
            // Redirigir con mensaje de éxito
            header("Location: gestionUsuarios.php?success=true");
        } else {
            // Redirigir con mensaje de error
            header("Location: gestionUsuarios.php?error=db_error");
        }
    } else {
        // Redirigir si no se seleccionaron usuarios
        header("Location: gestionUsuarios.php?error=no_selection");
    }
} else {
    // Redirigir si se accede al archivo directamente sin POST
    header("Location: gestionUsuarios.php");
}

$conexion->close();
?>
