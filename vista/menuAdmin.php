<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>

    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@900;600&display=swap" rel="stylesheet">

    <style>
        /* Evitar desplazamiento horizontal y aplicar fuente(alverta) */
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden; 
            overflow-y: auto;
            background-color: #f4f4f4;
            font-family: 'Alverta', sans-serif; 
        }

        /* Cabecera */
        .cabecera {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            height: 144px;
            background-color: #1A428A; 
            color: white; 
            padding: 0 20px;
            position: relative;
        }

        /* Contenedor central (para título y los botones) */
        .centro {
            flex-grow: 1; /* esto es para ocupar el espacio central */
            text-align: center;
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        /* Logo */
        .logo {
            height: 140px; 
        }

        /* Título centrado */
        .titulo {
            font-size: 48px;
            font-weight: 900; 
            margin: 0;
            margin-bottom: 20px; /* espacio para separar clinica rayo de los botones, se sube o se baja (no tocar, ahora esta centrado) */
        }

        /* Contenedor de botones */
        .botones {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .boton {
            min-width: 170px;  /* para aumentar el ancho de panel admin, ya que al ponerlo en una misma linea se comia letras" */
            height: 40px;  
            border: none;  
            font-size: 18px;  
            font-weight: 600;
            cursor: pointer;
            text-transform: none; 
            color: white; 
            background-color: #111C4E; 
            border-radius: 0px;
            transition: background-color 0.3s, transform 0.2s;
            white-space: nowrap; /* para evitar los saltos de linea (panel de admin salia en lineas dif) */  
        }

        .boton:hover {
            background-color: #0D1637; 
            transform: translateY(-3px); 
        }
    </style>
</head>
<body>

    <!-- Cabecera -->
    <div class="cabecera">
        <!-- Logo -->
        <a href="inicioAdmin.php">
            <img src="../controlador/images/LogoBlanco.png" alt="Logo de la Clínica" class="logo">
        </a>

        <!-- Contenedor central -->
        <div class="centro">
            <!-- Título -->
            <div class="titulo">Clínica Rayo</div>

            <!-- Botones -->
            <div class="botones">
                <a href="inicioAdmin.php">
                    <button class="boton">Inicio</button>
                </a>
                <a href="../controlador/panelAdmin.php">
                    <button class="boton">Panel Administrador</button>
                </a>
                <a href="perfilAdmin.php">
                    <button class="boton">Perfil</button>
                </a>
            </div>
        </div>
    </div>

</body>
</html>
