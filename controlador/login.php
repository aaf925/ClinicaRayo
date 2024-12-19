<?php
session_start();
include_once('../modelo/conexion.php');

// Configuración
$max_attempts = 3;
$block_time = 300;

$errors = array(); // Array para errores
$success = false;  // Controla si el login fue exitoso

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';
    $captcha = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';
    $ip = $_SERVER['REMOTE_ADDR'];
    $secretKey = "6Let1J8qAAAAAOIFZF2Iov1IJVPBzi8fZ7bt7IcF";

    // Validar reCAPTCHA
    $respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha&remoteip=$ip");
    $atributos = json_decode($respuesta, TRUE);

    if (!$atributos['success']) {
        $errors[] = "Error en la verificación de reCAPTCHA.";
    }

    // Validar campos vacíos
    if (empty($correo) || empty($contrasena)) {
        $errors[] = "El correo y la contraseña son obligatorios.";
    }

    if (empty($errors)) {
        $correo = $conexion->real_escape_string($correo);
        $contrasena = $conexion->real_escape_string($contrasena);

        // Verificar intentos fallidos
        $queryAttempts = "SELECT attempts, last_attempt FROM login_attempts WHERE email = '$correo'";
        $resultAttempts = $conexion->query($queryAttempts);

        if ($resultAttempts && $resultAttempts->num_rows > 0) {
            $rowAttempts = $resultAttempts->fetch_assoc();
            $time_elapsed = time() - strtotime($rowAttempts['last_attempt']);
            if ($rowAttempts['attempts'] >= $max_attempts && $time_elapsed < $block_time) {
                $remaining = $block_time - $time_elapsed;
                $errors[] = "Cuenta bloqueada. Inténtalo en " . ceil($remaining / 60) . " minutos.";
            } elseif ($time_elapsed >= $block_time) {
                $conexion->query("UPDATE login_attempts SET attempts = 0 WHERE email = '$correo'");
            }
        }

        // Verificar usuario
        if (empty($errors)) {
            $queryUsuario = "SELECT id_usuario, nombre, email, contraseña, tipo_usuario FROM usuario WHERE email = '$correo'";
            $resultUsuario = $conexion->query($queryUsuario);

            if ($resultUsuario && $resultUsuario->num_rows > 0) {
                $row = $resultUsuario->fetch_assoc();

                if ($contrasena == $row['contraseña']) {
                    $conexion->query("DELETE FROM login_attempts WHERE email = '$correo'");
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id_usuario'] = $row['id_usuario'];
                    $_SESSION['nombre'] = $row['nombre'];
                    $_SESSION['tipo_usuario'] = $row['tipo_usuario'];

                    $success = true;
                    if ($row['tipo_usuario'] == 'cliente') {
                        header("Location: ../controlador/inicioUsuarioRegistrado.php");
                        exit;
                    } elseif ($row['tipo_usuario'] == 'administrador') {
                        header("Location: ../controlador/inicioAdmin.php");
                        exit;
                    }
                } else {
                    $errors[] = "Contraseña incorrecta.";
                }
            } else {
                $errors[] = "Usuario no encontrado.";
            }

            // Registrar intentos fallidos
            if (!empty($errors)) {
                if ($resultAttempts && $resultAttempts->num_rows > 0) {
                    $conexion->query("UPDATE login_attempts SET attempts = attempts + 1, last_attempt = CURRENT_TIMESTAMP WHERE email = '$correo'");
                } else {
                    $conexion->query("INSERT INTO login_attempts (email, attempts) VALUES ('$correo', 1)");
                }
            }
        }
    }
  // Pasar errores a iniciarSesion.php
 
    // Cerrar conexión
    $conexion->close();
    $_SESSION['errors'] = $errors;
    header("Location: ../controlador/iniciarSesion.php");
    exit;
  
}
?>
