<?php
// Iniciar sesión
session_start();

include_once('../modelo/conexion.php');
// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Evitar inyección SQL
    $correo = $conexion->real_escape_string($correo);
    $contrasena = $conexion->real_escape_string($contrasena);

    // Buscar en la tabla `usuario`
    $queryUsuario = "SELECT id_usuario, nombre, email, contraseña, tipo_usuario FROM usuario WHERE email = '$correo'";
    $resultUsuario = $conexion->query($queryUsuario);

    if ($resultUsuario && $resultUsuario->num_rows > 0) {
        $row = $resultUsuario->fetch_assoc();

        // Verificar contraseña
        if ($contrasena == $row['contraseña']) { 
            $_SESSION['id_usuario'] = $row['id_usuario'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['tipo_usuario'] = $row['tipo_usuario'];
            $tipo = $row['tipo_usuario'];
            if ($row['tipo_usuario'] == 'cliente') {
                header("Location: ../controlador/inicioUsuarioRegistrado.php");
            } else if ($row['tipo_usuario'] == 'administrador') {
                header("Location: ../controlador/inicioAdmin.php");
            }
            exit;
           
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        // Buscar en la tabla `admin`
        $queryAdmin = "SELECT id_admin, nombre, email, contraseña FROM admin WHERE email = '$correo'";
        $resultAdmin = $conexion->query($queryAdmin);

        if ($resultAdmin && $resultAdmin->num_rows > 0) {
            $row = $resultAdmin->fetch_assoc();

            // Verificar contraseña
            if ($contrasena == $row['contraseña']) {
                $_SESSION['id_admin'] = $row['id_admin'];
                $_SESSION['nombre'] = $row['nombre'];
                $_SESSION['tipo_usuario'] = 'administrador';
                header("Location: ../controlador/inicioAdmin.php");
                exit;
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "Usuario no encontrado.";
        }
    }
}

// Cerrar la conexión
$conexion->close();
?>
