<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir archivo de conexión
require_once("../modelo/conexion.php");

// Consulta para obtener los productos con categoría "crema"
$sql = "SELECT nombre, descripcion, precio, imagen_url FROM producto WHERE categoria = 'crema'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Cremas</title>
    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@700;600;900&display=swap" rel="stylesheet">

    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Cabecera con título */
        .cabecera {
            width: 100%;
            text-align: left;
            padding-left: 70px;
            margin-top: 20px;
            margin-bottom: 50px;
        }

        .titulo {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
        }

        /* Contenedor principal */
        .contenedor {
            width: 90%;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            gap: 50px;
            justify-content: flex-start;
        }

        /* Estilo del carrito */
        .carrito-contenedor {
            position: absolute;
            top: 20px; /* Separación desde arriba */
            right: 30px; /* Separación desde la derecha */
        }

        .carrito-contenedor img {
            width: 80px;
            height: 80px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .carrito-contenedor img:hover {
            transform: scale(1.1);
        }

        /* Estructura del producto */
        .item {
            display: flex;
            align-items: flex-start;
            gap: 30px;
            width: calc(33.333% - 40px); /* Tres elementos por fila */
        }

        /* Columna de la imagen */
        .item .columna-imagen {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .item img {
            width: 154px;
            height: auto;
            margin-bottom: 20px;
        }

        /* Columna del texto */
        .texto {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;
            flex: 1;
        }

        .texto .nombre {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 5px;
            color: #000;
        }

        .texto .descripcion {
            font-size: 14px;
            color: #444;
            margin-bottom: 10px;
        }

        .texto .precio {
            font-size: 16px;
            color: #111;
            font-weight: bold;
        }

        /* Botón */
        .boton1 {
            width: 154px;
            height: 34px;
            border: none;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            color: white;
            background-color: #111C4E;
            border-radius: 8px;
            transition: background-color 0.3s, transform 0.2s;
        }

        .boton1:hover {
            background-color: #0D1637;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>

    <!-- Contenedor del carrito -->
    <div class="carrito-contenedor">
        <a href="carrito.php">
            <img src="../controlador/images/carrito.png" alt="Carrito de Compras">
        </a>
    </div>

    <!-- Cabecera fija con el título -->
    <div class="cabecera">
        <h1 class="titulo">CREMAS</h1>
    </div>

    <!-- Contenedor de productos -->
    <div class="contenedor">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="item">
                    <!-- Columna de la imagen con el botón debajo -->
                    <div class="columna-imagen">
                        <?php 
                        // Construir la ruta de la imagen
                        $imagen_url = "../" . htmlspecialchars($row['imagen_url']);
                        ?>
                        <img src="<?php echo $imagen_url; ?>" alt="Producto">
                        <a href="AñadirACarrito.php">
                            <button class="boton1">Añadir a carrito</button>
                        </a>
                    </div>

                    <!-- Columna de texto -->
                    <div class="texto">
                        <!-- Nombre -->
                        <p class="nombre"><?php echo nl2br(htmlspecialchars($row['nombre'])); ?></p>
                        
                        <!-- Descripción truncada -->
                        <p class="descripcion">
                            <?php 
                            $descripcion = htmlspecialchars($row['descripcion']);
                            echo mb_strimwidth($descripcion, 0, 30, "...");
                            ?>
                        </p>

                        <!-- Precio -->
                        <p class="precio"><?php echo number_format($row['precio'], 2); ?> €</p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; font-size: 18px;">No hay productos disponibles en esta categoría.</p>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
$conn->close();
?>