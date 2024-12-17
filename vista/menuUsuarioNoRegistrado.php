<?php
require_once 'conexion.php';
$sql = "SELECT id_servicio, nombre FROM servicio";
$result = $conexion->query($sql);

// Almacenar los resultados en un array
$servicios = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $servicios[] = $row; // Guarda cada fila en el array
    }
}
//$conexion->close();

// Función para convertir nombres a URL amigables
function url_amigable($string) {
    $string = strtolower($string); // Convertir a minúsculas
    $string = preg_replace('/[^a-z0-9]+/', '-', $string); // Reemplazar espacios y caracteres especiales por guiones
    $string = trim($string, '-'); // Eliminar guiones al inicio y al final
    return $string;
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
            left: 1610px; 
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
    </style>
</head>
<body>
    <!-- Cabecera -->
     
    <div class="cabecera">
        <a href="inicioUsuarioNoRegistrado.php">
            <img src="LogoBlanco.png" alt="Logo de la Clínica" class="logo">
        </a>

        <!-- Botones -->
        <div class="botones">
            <a href="iniciarSesion.php">
                <button class="boton">Inicio Sesión</button>
            </a>
            <a href="registrarse.php">
                <button class="boton">Registrarse</button>
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
                            <?php foreach ($servicios as $servicio): ?>
                                <?php $url_nombre = url_amigable($servicio['nombre']); ?>
                                <li>
                                    <a href="servicio.php?id=<?php echo $servicio['id_servicio']; ?>&nombre=<?php echo $url_nombre; ?>">
                                        <?php echo htmlspecialchars($servicio['nombre']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
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
