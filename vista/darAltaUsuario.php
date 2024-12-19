<?php
require_once '../modelo/conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
   
    // Recoger los datos del formulario
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellidos = $conn->real_escape_string($_POST['apellidos']);
    $tipoUsuario = $conn->real_escape_string($_POST['tipoUsuario']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $correo = $conn->real_escape_string($_POST['correo']);
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Encripta la contraseña

    // Comprobar si el correo ya existe en la base de datos
    $sql_check = "SELECT id_usuario FROM usuario WHERE email = '$correo'";
    $resultado = $conn->query($sql_check);

    if ($resultado && $resultado->num_rows > 0) {
        // Si el correo ya existe, redirigir al formulario con un mensaje de error
        header("Location: darAltaUsuarioFormulario.php?error=correo_existente");
        exit();
    }

    // Obtener el ID máximo actual de la tabla usuarios
    $sql_max_id = "SELECT MAX(id_usuario) AS max_id FROM usuario";
    $resultado_id = $conn->query($sql_max_id);

    if ($resultado_id && $fila = $resultado_id->fetch_assoc()) {
        $id_nuevo = ($fila['max_id'] !== NULL) ? $fila['max_id'] + 1 : 1; // Incrementa el ID máximo o empieza en 1
    } else {
        $id_nuevo = 1; // Si no hay usuarios, el ID será 1
    }

    // Insertar el nuevo usuario con el ID generado
    $sql_insert = "INSERT INTO usuario (id_usuario, nombre, apellido, tipo_usuario, telefono, email, password) 
                   VALUES ('$id_nuevo', '$nombre', '$apellidos', '$tipoUsuario', '$telefono', '$correo', '$contrasena')";

    if ($conn->query($sql_insert) === TRUE) {
        header("Location: darAltaUsuarioFormulario.php?success=true");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>