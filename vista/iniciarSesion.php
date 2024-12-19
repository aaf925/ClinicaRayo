<?php
include_once('../modelo/conexion.php');
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : array();
unset($_SESSION['errors']); // Limpiar errores después de mostrarlos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>

    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="iniciarSesion.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
 

    <style>

/* Contenedor principal centrado */
.contenedorPrincipal {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh; /* Altura completa de la ventana */
    background-color: #f5f5f5; /* Color de fondo */
    padding: 20px; /* Evitar que el cuadro toque los bordes */
    box-sizing: border-box;
}

/* Cuadro central */
.contenidoCuadro {
    width: 100%;
    max-width: 600px; /* Máximo ancho en pantallas grandes */
    background-color: #1A428A;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 30px;
    color: white;
    text-align: center;
}

/* Estilo del formulario */
.formulario input[type="email"],
.formulario input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: none;
    border-radius: 5px;
}

.botom {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.botom button {
    width: 48%;
    background-color: #0F1D40;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.botom button:hover {
    background-color: #0D1734;
}

/* Centrado del reCAPTCHA */
.g-recaptcha {
    display: flex;
    justify-content: center; /* Centra el contenido horizontalmente */
    align-items: center; /* Centra el contenido verticalmente */
    margin: 20px 0; /* Ajusta el espacio alrededor del reCAPTCHA si es necesario */
}


/* Media queries para pantallas pequeñas */
@media (max-width: 768px) {
    .contenidoCuadro {
        width: 90%; /* Ocupa casi todo el ancho */
        padding: 20px;
    }

    .botom {
        flex-direction: column;
        gap: 10px; /* Espacio entre botones */
    }

    .botom button {
        width: 100%; /* Botones más anchos */
    }
}

    
    </style>
</head>
<body>
        <!-- Mostrar errores -->
        <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php foreach ($errors as $error): ?>
                            <?php echo $error . "<br>"; ?>
                        <?php endforeach; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
    <div class="contenedorPrincipal">
        <div class="contenidoCuadro">
            <form class="formulario" action="../controlador/login.php" method="POST">
                <label for="correo">Correo electrónico:</label>
                <input type="email" name="correo" id="correo" placeholder="ejemplo@ejemplo.es" required>

                <label for="contrasena">Contraseña:</label>
                <input type="password" name="contrasena" id="contrasena" placeholder="********" required>

                <div class="g-recaptcha" data-sitekey="6Let1J8qAAAAAFUqHmEc1NgrOVlvdzBYGugSkyjl"></div>
                <br>
                <a href="../controlador/registrarse.php">¿No tienes cuenta? Regístrate aquí.</a>

                <div class="botom">
                    <button type="button" onclick="location.href='../controlador/registrarse.php'">Cancelar</button>
                    <button type="submit">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

