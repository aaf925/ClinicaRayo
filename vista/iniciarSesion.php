<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>

    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="iniciarSesion.css">

    <style>

         /* Estilo para el cuadro central */
         .contenidoCuadro {
        width: 522px;
        height: 435px;
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

    .formulario input[type="email"],
    .formulario input[type="password"] {
        width: 90%;
        padding: 10px;
        margin-bottom: 50px;
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
        top: 10px;
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
    <form class="formulario" form action="../controlador/login.php" method="POST">
    <label for="correo">&nbsp;&nbsp;&nbsp;Correo electrónico:</label>
    <input type="email" name="correo" id="correo" name="correo" placeholder="ejemplo@ejemplo.es" required>

    <label for="contrasena">&nbsp;&nbsp;&nbsp;Contraseña:</label>
    <input type="password" name="contrasena" id="contrasena" name="contrasena" placeholder="********" required>
       <!-- reCAPTCHA -->
       <div class="g-recaptcha" data-sitekey="6LderJ8qAAAAALEkE_SHDhxy3Xz0l1sGdjwlDrgD"></div>
    <br>

    <a href="#">¿No tienes cuenta? Regístrate aquí.</a>

    <div class="botom">
        <button type="button" onclick="'../controlador/registrarse.php'">Cancelar</button>
        
        <button type="submit">Confirmar</button>
    </div>
</form>
<!-- Incluye la librería de reCAPTCHA -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
<br>
