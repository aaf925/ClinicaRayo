<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../modelo/conexion.php';

// Verificar si la conexión está definida correctamente
if (!isset($conn) || $conn->connect_error) {
    die("Error de conexión: " . ($conn->connect_error ?? "Variable de conexión no definida."));
}

    // Consulta SQL para obtener servicios
    $sql = "SELECT id_servicio, nombre, imagen_url FROM servicio WHERE id_servicio>0";
    $result = $conn->query($sql);

    // Verificar si la consulta fue exitosa
    if (!$result) {
        throw new Exception("Error en la consulta SQL: " . $conn->error);
    }

    // Arreglo para almacenar los servicios
    $servicios = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $servicios[] = $row;
        }
    }

// Liberar memoria y cerrar la conexión si no se usa más adelante
$result->free_result();

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

        /* Evitar que el desplazamiento horizontal ocurra y aplicar fuente */
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

        /* Ajuste para pantallas pequeñas (menos de 768px) */
@media (max-width: 768px) {
    .botones {
        margin-left: 20px; /* Alinea los botones más a la izquierda */
        gap: 20px; /* Reduce el espacio entre los botones */
    }

    .boton {
        width: 100px; /* Ajusta el tamaño de los botones en pantallas pequeñas */
        height: 35px;
        font-size: 14px; /* Reduce el tamaño del texto */
    }

    /* Estilo del logo */
    .logo {
        max-width: 50%; /* Ajusta el tamaño del logo según el ancho de la pantalla */
        height: auto; /* Mantiene la proporción del logo */
    }
}

    </style>
</head>
<body>
    <!-- Cabecera -->
    <div class="cabecera">
        <a href="../controlador/inicioUsuarioNoRegistrado.php">
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
                    <td><a href="../controlador/sobreNosotros.php">Sobre nosotros</a></td>
                    <td class="desplegable">
                        <a href="#">Servicios <span class="flecha">&#9662;</span></a>
                        <ul class="menu-desplegable">
                            <?php foreach ($servicios as $servicio): ?>
                                <?php $url_nombre = url_amigable($servicio['nombre']); ?>
                                <li>
                                    <a href="../vista/servicio.php?id=<?php echo $servicio['id_servicio']; ?>&nombre=<?php echo $url_nombre; ?>">
                                        <?php echo htmlspecialchars($servicio['nombre']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                    <td><a href="../vista/tienda.php">Tienda</a></td>
                    <td><a href="../vista/reservarCita.php">Reservar cita</a></td>
                    <td><a href="../vista/blog.php">Blog</a></td>
                    <td><a href="../controlador/contactanos.php">Contáctanos</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>