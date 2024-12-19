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
            margin-left: 970px; 
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
            left: 1605px; 
            transform: translate(-50%, -50%); 
            width: 100%; 
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

        /* DESPLEGABLE EN SERVICIOS */
        .menu-desplegable {
            list-style: none; 
            margin: 0;
            padding: 0;
            display: none; 
            position: absolute; 
            background-color: #1A428A; 
            border: 1px solid #fff; 
            top: 100%; 
            left: 150px;
            min-width: 250px; 
            z-index: 1000; 
        }

        /* Línea en el desplegable */
        .menu-desplegable li {
            padding: 10px; 
            border-bottom: 1px solid white; 
            text-align: left; 
        }

        /* Quitar la línea en el último elemento */
        .menu-desplegable li:last-child {
            border-bottom: none;
        }

        /* Estilo del menú desplegable */
        .menu-desplegable li a {
            color: white; 
            text-decoration: none; 
            display: block; 
            font-size: 16px;
        }

        /* Cambiar el color al pasar el ratón */
        .menu-desplegable li a:hover {
            background-color: #133b7f; 
        }

        /* Mostrar el menú al pasar el ratón */
        .desplegable:hover .menu-desplegable {
            display: block; 
        }

        /* Media query para pantallas pequeñas */
@media (max-width: 768px) {
    .contenedor-tabla {
        display: flex; /* Cambia a flexbox */
        flex-wrap: wrap; /* Los elementos se envuelven en una nueva fila */
        justify-content: space-around; /* Espacio distribuido entre los elementos */
        position: relative; /* Cambio para que se ajuste mejor en pantallas pequeñas */
        left: 50%; /* Centra el contenedor */
        transform: translateX(-50%); /* Centra correctamente el contenedor */
    }

    /* Ajustar los elementos de la tabla para que se distribuyan bien */
    .contenedor-tabla > * {
        flex: 0 0 45%; /* Cada elemento ocupa el 45% del ancho en pantallas pequeñas */
        margin: 10px 0; /* Espacio entre filas */
    }
}
    </style>
</head>
<body>
    <!-- Cabecera -->
    <div class="cabecera">
        <a href="inicioUsuarioNoRegistrado.php">
            <img src="../controlador/images/LogoBlanco.png" alt="Logo de la Clínica" class="logo">
        </a>

        <!-- Botones -->
        <div class="botones">
            <a href="iniciarSesion.php">
                <button class="boton">Perfil</button>
            </a>
        </div>
    </div>

    <!-- Menú principal -->
    <div class="contenedor-tabla">
        <table class="tabla_menu">
            <tbody>
                <tr>
                    <td><a href="sobreNosotros.php">Sobre nosotros</a></td>
                    <td class="desplegable">
                        <a href="#">Servicios <span class="flecha">&#9662;</span></a>
                        <ul class="menu-desplegable">
                            <li><a href="podologiaGeneral.php">Podología General</a></li>
                            <li><a href="podologiaAvanzada.php">Podología Avanzada</a></li>
                            <li><a href="podologiaInfantil.php">Podología Infantil</a></li>
                            <li><a href="eco-intervencionismo.php">Eco-intervencionismo</a></li>
                            <li><a href="tratamientosFisicos.php">Tratamientos Físicos</a></li>
                            <li><a href="cirugiaAbierta.php">Cirugía Abierta</a></li>
                            <li><a href="cirugiaCerrada.php">Cirugía Cerrada</a></li>
                        </ul>
                    </td>
                    <td><a href="tienda.php">Tienda</a></td>
                    <td><a href="reservarCita.php">Reservar cita</a></td>
                    <td><a href="blog.php">Blog</a></td>
                    <td><a href="contactanos.php">Contáctanos</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
