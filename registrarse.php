<?php
require_once 'menuUsuarioNoRegistrado.php'
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>

    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@700&display=swap" rel="stylesheet">

    <style>

     /* Estilo para el cuadro central */
     .contenidoCuadro {
            width: 472px;
            height: 536px;
            background-color: #1A428A; 
            border-radius: 5px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            left: 500px;
            top: 100px;
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
            justify-content: space-around;
            width: 100%;
            position: relative;
            top: 50px;
        }

        .botom button {
            background-color: #0F1D40;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 13px 23px;
            cursor: pointer;
            font-size: 16px;
            font-family: 'Alverta', sans-serif; 
            font-weight: bold; 
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
            <form class="formulario">


                <label for="nombre">&nbsp;&nbsp;&nbsp;Nombre:</label>
                <input type="nombre" id="nombre" placeholder="*******" required>

                <label for="apellidos">&nbsp;&nbsp;&nbsp;Apellidos:</label>
                <input type="apellidos" id="apellidos" placeholder="*******" required>

                <label for="correo">&nbsp;&nbsp;&nbsp;Correo electrónico:</label>
                <input type="email" id="correo" placeholder="ejemplo@ejemplo.es" required>

                <label for="contrasena">&nbsp;&nbsp;&nbsp;Contraseña:</label>
                <input type="password" id="contrasena" placeholder="********" required>

                <label for="telefono">&nbsp;&nbsp;&nbsp;Nº Telefono:</label>
                <input type="telefono" id="telefono" placeholder="*******" required>

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
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php
require_once 'piePagina.php';