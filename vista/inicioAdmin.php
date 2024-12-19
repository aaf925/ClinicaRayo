<?php
// Iniciar sesión
session_start();

// Verificar si el usuario ha iniciado sesión y si es administrador
if (!isset($_SESSION['loggedin']) || $_SESSION['tipo_usuario'] !== 'administrador') {
    
    // Si no es administrador o no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: iniciarSesion.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@900;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Alverta', sans-serif;
            background-color: #f4f4f4;
        }

        .contenido {
            text-align: center;
            padding: 20px;
        }

        .titulo-bloque {
            font-weight: bold;
            margin: 20px 0 10px;
            font-size: 32px;
        }

        .cantidad {
            display: inline-block;
            background-color: #274C96;
            color: white;
            width: 218px; 
            height: 102px; 
            line-height: 102px; 
            border-radius: 0px;
            margin: 10px 0;
            font-size: 32px;
            font-weight: 600;
            text-align: center;
        }

        .comentarios {
            text-align: center;
            margin: 20px auto;
            width: 100%;
            font-size: 32px;
        }

        .comentarios h3 {
            margin-bottom: 10px;
            font-weight: 600;
            text-align: left;
            margin-left: 30px;
        }

        .comentario, .peticion {
            background-color: #1A428A;
            color: white;
            width: 717px; 
            height: 141px; 
            line-height: 141px; 
            margin: 10px auto;
            border-radius: 0px;
            font-size: 32px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
<?php require_once 'menuAdmin.php'; ?>

    <br>
    <br>


    <!-- Contenido adicional -->
    <div class="contenido">
        <!-- Usuarios conectados -->
        <div>
            <div class="titulo-bloque">Usuarios conectados<br>
             en este momento</div>
            <div class="cantidad">Cantidad</div>
        </div>

        <!-- Ventas realizadas -->
        <div>
            <div class="titulo-bloque">Ventas realizadas hoy</div>
            <div class="cantidad">Cantidad</div>
        </div>

        <!-- Nuevos comentarios -->
        <div class="comentarios">
            <h3>Nuevos comentarios:</h3>
            <br>
            <div class="comentario">Comentario nuevo 1</div>
            <br>
            <div class="peticion">Petición nueva 1</div>
        </div>
    </div>
</body>
</html>
