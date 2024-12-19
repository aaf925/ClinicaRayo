<?php
include_once('../modelo/conexion.php');
include_once 'menuUsuarioNoRegistrado.php';

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellidos'];
    $email = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $password = $_POST['contrasena']; 
    $tipo_usuario = 'cliente'; // Valor por defecto, puede ser cambiado

    // Consultar el valor máximo del 'id' en la tabla 'usuario'
    $sql_max_id = "SELECT MAX(id_usuario) AS max_id FROM usuario";
    $result = $conn->query($sql_max_id);

    if ($result->num_rows > 0) {
        // Obtener el valor máximo de id
        $row = $result->fetch_assoc();
        $nuevo_id = $row['max_id'] + 1; // Añadir 1 al valor máximo
    } else {
        // Si no hay registros en la tabla, se asigna el valor 1
        $nuevo_id = 1;
    }

    // Insertar los datos en la tabla 'usuario'
    $sql = "INSERT INTO usuario (id_usuario, nombre, apellido, email, telefono, tipo_usuario, fecha_registro, password)
            VALUES ('$nuevo_id', '$nombre', '$apellido', '$email', '$telefono', '$tipo_usuario', NOW(), '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Usuario registrado exitosamente');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>

    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@700&display=swap" rel="stylesheet">

    <style>

    /* Contenedor principal centrado */
    .cuadroCentral {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh; /* Altura completa de la ventana */
        background-color: #f5f5f5; /* Color de fondo */
        padding: 20px; /* Evitar que el cuadro toque los bordes */
        box-sizing: border-box;
    }

     /* Estilo para el cuadro central */
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

        /* Estilo para el formulario */
        .formulario {
            width: 100%;
            text-align: center;
            color: #ffffff; 
            font-family: 'Alverta', sans-serif
        }

        .formulario label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            font-weight: bold; 
            text-align: left; 
        }

        .formulario input[type="nombre"],
        .formulario input[type="apellidos"],
        .formulario input[type="email"],
        .formulario input[type="password"] ,
        .formulario input[type="telefono"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
            font-family: 'Alverta', sans-serif;
        }

        .formulario a {
            color: #ffffff;
            text-decoration: none;
            font-size: 13px;
            font-family: 'Alverta', sans-serif;
            font-weight: bold;
        }

        .formulario a:hover {
            text-decoration: underline;
        }

         /* Botones */
         
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

    </style>
</head>
<body>
    <!-- CuadroCentral -->
    <div class="cuadroCentral">
        <div class="contenidoCuadro">
            <form class="formulario" form action="" method="POST">


                <label for="nombre">&nbsp;&nbsp;&nbsp;Nombre:</label>
                <input type="nombre" name="nombre" id="nombre" placeholder="Nombre de usuario" required>

                <label for="apellidos">&nbsp;&nbsp;&nbsp;Apellidos:</label>
                <input type="apellidos" name="apellidos" id="apellidos" placeholder="Apellidos" required>

                <label for="correo">&nbsp;&nbsp;&nbsp;Correo electrónico:</label>
                <input type="email" name="correo" id="correo" placeholder="ejemplo@ejemplo.es" required>

                <label for="contrasena">&nbsp;&nbsp;&nbsp;Contraseña:</label>
                <input type="password" name="contrasena" id="contrasena" placeholder="********" required>

                <label for="telefono">&nbsp;&nbsp;&nbsp;Nº Telefono:</label>
                <input type="telefono" name="telefono" id="telefono" placeholder="Nº Telefono" required>

                <div class="botom">
                <button type="button">Cancelar</button>
                <button type="submit">Confirmar</button>
                
            </div>

                </div>
            </form>
        </div>
    </div>
</body>
</html>