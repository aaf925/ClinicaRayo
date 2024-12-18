<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../modelo/conexion.php';

// Verificar si la conexión está definida correctamente
if (!isset($conn) || $conn->connect_error) {
    die("Error de conexión: " . ($conn->connect_error ?? "Variable de conexión no definida."));
}

    // Consulta SQL para obtener servicios
    $sql = "SELECT id_servicio, nombre, imagen_url FROM servicio";
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

    // Consulta para obtener las 3 últimas reseñas de servicios
    $sql_reseñas_servicios = "
    SELECT rs.calificacion, rs.comentario, rs.fecha_reseña, 
        s.nombre, s.imagen_url 
    FROM reseña_servicio rs
    INNER JOIN servicio s ON rs.id_servicio = s.id_servicio
    ORDER BY rs.fecha_reseña DESC 
    LIMIT 3";
    $result_servicios = $conn->query($sql_reseñas_servicios);
    $reseñas_servicios = [];
    if ($result_servicios->num_rows > 0) {
    while ($row = $result_servicios->fetch_assoc()) {
        $reseñas_servicios[] = $row;
    }
    }

    // Consulta para obtener las 3 últimas reseñas de productos
    $sql_reseñas_productos = "
    SELECT rp.calificacion, rp.comentario, rp.fecha_reseña, 
        p.nombre, p.imagen_url, p.precio 
    FROM reseña_producto rp
    INNER JOIN producto p ON rp.id_producto = p.id_producto
    ORDER BY rp.fecha_reseña DESC 
    LIMIT 3";
    $result_productos = $conn->query($sql_reseñas_productos);
    $reseñas_productos = [];
    if ($result_productos->num_rows > 0) {
    while ($row = $result_productos->fetch_assoc()) {
        $reseñas_productos[] = $row;
    }
    }

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Usuario</title>

    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@700&display=swap" rel="stylesheet">
    <style>
        /* Estilos del cuerpo */
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden; 
            background-color: #f4f4f4;
            font-family: 'Alverta', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        /* Contenedor del video */
        .contenedor-video {
            position: relative;
            top: 50px;
            width: 90%;
            height: 60vh;
            max-width: 1800px;
            border: 2px solid #111C4E;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .contenedor-video video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .titulo-servicios {
            font-size: 2rem;
            color: #111C4E;
            margin: 20px 0;
          
        }

        /* Carrusel */
       /* Contenedor principal del carrusel */
       .carrusel-container {
            position: relative;
            width: 90%;
            max-width: 1800px; /* Contenedor azul alargado */
            margin: 0 auto;
            background-color: #111C4E;
            border-radius: 10px;
            overflow: hidden;
            padding: 20px 0;
            box-sizing: border-box;
        }

        /* Carrusel */
        .carrusel {
            display: flex;
            gap: 200px; /* Espacio entre tarjetas */
            overflow: hidden;
            scroll-behavior: smooth;
            padding: 0 100px; /* Espacio para botones laterales */
        }

        /* Tarjetas individuales */
        .servicio {
            
            flex: 0 0 300px; /* Ancho de cada tarjeta */
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            text-align: center;
            overflow: hidden;
            position: relative;
        }

        .servicio img {
            width: 100%;
            height: 200px; /* Altura fija para las imágenes */
            object-fit: cover;
        }

        /* Título centrado con recuadro azul */
        .servicio h3 {
            position: absolute;
            bottom: 50%; /* Centra verticalmente */
            left: 50%; /* Centra horizontalmente */
            transform: translate(-50%, 50%); /* Ajusta el centrado */
            background-color: rgba(0, 0, 50, 0.8); /* Recuadro azul */
            color: white;
            padding: 10px 10px;
            border-radius: 10px;
            font-size: 1rem;
            margin: 0;
            text-align: center;
            width: 80%; /* Tamaño del fondo */
            height: 70px;
            display: flex; /* Permite centrar el texto dentro del recuadro */
            justify-content: center; /* Centra horizontalmente el texto */
            align-items: center;
            pointer-events: none; /* Evita que interfiera con clics */
        }
        .boton-servicio {
            display: block; /* Hace que el enlace abarque toda la tarjeta */
            text-decoration: none; /* Elimina subrayado */
            position: relative; /* Permite posicionar el texto dentro */
            text-align: center; /* Centra el texto horizontalmente */
            color: white; /* Color del texto */
            background-color: rgba(0, 0, 50, 0.8); /* Color del fondo */
            border-radius: 10px; /* Bordes redondeados */
            font-weight: bold; /* Texto en negrita */
            overflow: hidden; /* Evita desbordamientos */
        }
        .boton-servicio h3 {
            position: absolute;
            bottom: 50%; /* Centra verticalmente */
            left: 50%; /* Centra horizontalmente */
            transform: translate(-50%, 50%); /* Ajusta el centrado exacto */
            background-color: rgba(0, 0, 50, 0.8); /* Color de fondo semi-transparente */
            color: white; /* Color del texto */
            padding: 10px 10px; /* Espaciado interno */
            border-radius: 10px; /* Bordes redondeados */
            font-size: 1rem; /* Tamaño de fuente */
            width: 80%; /* Ancho del recuadro */
             height: 70px; /* Altura fija del recuadro */
              text-align: center; /* Centra el texto horizontalmente */
              display: flex; /* Flexbox para centrar el contenido */
              justify-content: center; /* Centra horizontalmente dentro del recuadro */
              align-items: center; /* Centra verticalmente dentro del recuadro */
              pointer-events: auto; /* Permite que el recuadro sea interactivo */
            }
            /* Efecto hover para que parezca un botón */
            .boton-servicio:hover {
                background-color: rgba(0, 0, 50, 0.9); /* Cambia ligeramente el color */
                cursor: pointer; /* Muestra el cursor de clic */
            }.boton-servicio:hover h3 {
                background-color: rgba(0, 0, 100, 0.9); /* Efecto hover en el texto */
            }


        /* Botones de navegación */
        .boton-carrusel {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            font-size: 2rem;
            color: #111C4E;
            cursor: pointer;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            z-index: 10;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .boton-carrusel.izquierda {
            left: 10px;
        }

        .boton-carrusel.derecha {
            right: 10px;
        }
            /* Estilo para las reseñas */
            /* Contenedor principal de reseñas */
            .contenedor-reseñas {
            /* width: 100%;
            max-width: 1800px;
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin: 50px auto;
            background-color: white;
            width: 100%;*/  
            max-width: 2000px;
            width: 90%;
            display: flex;
            justify-content: space-between;
            margin-top: 150px;
            gap: 160px;
            margin-bottom: 100px;
            background-color: #f4f4f4; 
}

        /* Estilo de cada recuadro de reseñas */
        .recuadro-reseña {
            width: 568%;
            border: 1px solid #f4f4f4;
            border-radius: 8px;
            padding: 15px;
            background-color: #f4f4f4;

        }

        /* Título de las reseñas */
        .titulo-reseña {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        /* Cada reseña individual */
        .reseña-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }

        /* Imágenes de reseñas */
        .reseña-imagen {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }

        /* Contenido de las reseñas */
        .reseña-texto h3 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: bold;
            color: #111C4E;
        }

        .reseña-texto span {
            color: #FFD700; /* Estrellas doradas */
            margin-left: 10px;
            font-size: 1rem;
        }

        .reseña-texto p {
            margin: 5px 0;
            color: #666;
            font-size: 0.9rem;
        }



    </style>
</head>
<body>

    <!-- Contenedor del video -->
    <div class="contenedor-video">
        <video autoplay loop muted>
            <source src="../controlador/images/ClinicaRayo.mp4" type="video/mp4">
            Tu navegador no soporta el formato de video.
        </video>
    </div>

    <!-- Título -->
   
    <div class="titulo-servicios" style="margin-top: 120px;">Lista de Servicios</div>

    <!-- Carrusel de Servicios -->
     <!-- Contenedor del carrusel -->
<div class="carrusel-container" style="margin-top: 50px;">
    <!-- Botones de navegación -->
    <button class="boton-carrusel izquierda" onclick="desplazarCarrusel(-1)">&#9664;</button>
    <div class="carrusel" id="carrusel">
        <?php if (!empty($servicios)): ?>
            <?php foreach ($servicios as $servicio): ?>
                <div class="servicio">
                    <a href="servicio.php?id=<?php echo $servicio['id_servicio']; ?>&nombre=<?php echo urlencode($servicio['nombre']); ?>" class="boton-servicio">
                        <img src="<?php echo htmlspecialchars($servicio['imagen_url']); ?>" alt="<?php echo htmlspecialchars($servicio['nombre']); ?>">
                        <h3><?php echo htmlspecialchars($servicio['nombre']); ?></h3>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay servicios disponibles.</p>
        <?php endif; ?>
    </div>
    <button class="boton-carrusel derecha" onclick="desplazarCarrusel(1)">&#9654;</button>
</div>

    
 
      <!-- Contenedor para las reseñas -->
      <div class="contenedor-reseñas">
        <!-- Reseñas de Servicios -->
        <div class="recuadro-reseña">
            <h2 class="titulo-reseña">Reseñas Recientes de Servicios</h2>
            <?php foreach ($reseñas_servicios as $reseña): ?>
                <div class="reseña-item">
                    <img src="<?php echo htmlspecialchars($reseña['imagen_url']); ?>" alt="<?php echo htmlspecialchars($reseña['nombre']); ?>" class="reseña-imagen">
                    <div class="reseña-texto">
                        <h3><?php echo htmlspecialchars($reseña['nombre']); ?>
                            <span><?php echo str_repeat('★', $reseña['calificacion']); ?></span>
                        </h3>
                        <p><?php echo htmlspecialchars($reseña['comentario']); ?></p>
                        <p><small><?php echo htmlspecialchars($reseña['fecha_reseña']); ?></small></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Reseñas de Productos -->
        <div class="recuadro-reseña">
            <h2 class="titulo-reseña">Reseñas Recientes de Productos</h2>
            <?php foreach ($reseñas_productos as $reseña): ?>
                <div class="reseña-item">
                    <img src="<?php echo htmlspecialchars($reseña['imagen_url']); ?>" alt="<?php echo htmlspecialchars($reseña['nombre']); ?>" class="reseña-imagen">
                    <div class="reseña-texto">
                        <h3><?php echo htmlspecialchars($reseña['nombre']); ?>
                            <span><?php echo str_repeat('★', $reseña['calificacion']); ?></span>
                        </h3>
                        <p><?php echo number_format($reseña['precio'], 2); ?> €</p>
                        <p><?php echo htmlspecialchars($reseña['comentario']); ?></p>
                        <p><small><?php echo htmlspecialchars($reseña['fecha_reseña']); ?></small></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>



    <script>
       
        const carrusel = document.getElementById('carrusel');
        const desplazamiento = 510; // Ancho de la tarjeta + espacio entre ellas

        function desplazarCarrusel(direccion) {
            carrusel.scrollLeft += direccion * desplazamiento;
        }
    </script>
</body>
</html>
