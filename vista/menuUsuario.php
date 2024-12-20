<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>

    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@700&display=swap" rel="stylesheet">

    
    <style>

        /* Evitar que el desplazamiento horizontal ocurra yaplicar fuente */
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden; 
            overflow-y: auto;
            background-color: #f4f4f4;
            font-family: 'Alverta', sans-serif; 
        }

        /* Estilo del logo */
        .logo {
            height: 100%;
        
        }
        
        /* Cabecera, es la parte de arriba de color azul oscuro */
        .cabecera {
            display: flex;
            align-items: center;
            width: 100%;
            height: 144px;
            background-color: #1A428A; 
            padding: 0 20px; 
            color: white; 
        }

        /* Estilo de los botones (Inicio sesión, Registrarse) */
        .botones {
            display: flex;
            gap: 40px; 
            margin-top: -30px; 
            margin-left: calc(85vw - 300px); 
        }

        .boton {
            width: 119px;  
            height: 40px;  
            border: none;  
            font-size: 16px;  
            font-weight: bold;
            cursor: pointer;
            text-transform: none; 
            color: white; 
            background-color: #111C4E; 
            border-radius: 10px; 
            transition: background-color 0.3s, transform 0.2s;
        }

        .boton:hover {
            background-color: #0D1637; 
            transform: translateY(-3px); 
        }

        /* TABLA DEL MENU PRINCIPAL */
        .contenedor-tabla {
            position: absolute; 
            top: 127px; 
            right: 0; /* Ajusta el contenedor al borde derecho de la pantalla */
            transform: translate(0, -50%); /* Ajusta el elemento de manera centrada verticalmente, pero sin moverlo horizontalmente */
            width: auto;  /* O puedes usar un valor específico para el ancho si quieres que no sea 100% */
            text-align: center;
            z-index: 10; 
        }

        /* Estilo de la tabla en general */
        .tabla_menu {
            width: auto; 
            border-collapse: collapse;
            color: #fff; 
            background-color: transparent; 
        }

        /* Borde rodeando todo blanco y transparente */
        .tabla_menu tr {
            border: 1px solid white; 
            background-color: transparent;
        }

        /* Separación de celdas */
        .tabla_menu td {
            padding: 8px 15px; 
            border-right: 1px solid white; 
            font-size: 16px; 
            font-weight: bold; 
        }

        /* Estilo para los enlaces de las celdas */
        .tabla_menu td a {
            color: white; 
            text-decoration: none; 
            font-size: 16px; 
            font-weight: bold;
        }

        /* Cambiar color al pasar el ratón a blanco un poco mas claro  */
        .tabla_menu td a:hover {
            color: #ddd; 
        }

       
    </style>
</head>
<body>
    <!-- Cabecera -->
    <div class="cabecera">
        <a href="../controlador/inicioUsuarioRegistrado.php">
            <img src="../controlador/images/LogoBlanco.png" alt="Logo de la Clínica" class="logo">
        </a>

        <!-- Botones -->
        <div class="botones">
            <a href="../controlador/menuUsuario.php">
                <button class="boton">Perfil</button>
            </a>
        </div>
    </div>

    <!-- Menú principal -->
    <div class="contenedor-tabla">
        <table class="tabla_menu">
            <tbody>
                <tr>
                    <td><a href="../controlador/historialCompras.php">Historial Compras</a></td>
                    <td><a href="../controlador/historialCitas.php">Historial Citas</a></td>
                    <td><a href="menuUsuario.php">Modificar Datos</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>