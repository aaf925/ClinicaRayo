<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../modelo/conexion.php");

$sql = "SELECT id_producto, nombre, descripcion, precio, imagen_url FROM producto WHERE categoria = 'crema'";
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
        body {
            font-family: 'Averta';
            margin: 0;
            padding: 0;
        }

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

        .contenedor {
            width: 90%;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            gap: 50px;
            justify-content: flex-start;
        }

        .carrito-contenedor {
            position: absolute;
            top: 20px; 
            right: 30px; 
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

        .item {
            display: flex;
            align-items: flex-start;
            gap: 30px;
            width: calc(33.333% - 40px);
        }

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
            position: relative;
            left: 176px;
        }

        .boton1:hover {
            background-color: #0D1637;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <div class="carrito-contenedor">
        <a href="carrito.php">
            <img src="../controlador/images/carrito.png" alt="Carrito de Compras">
        </a>
    </div>

    <div class="cabecera">
        <h1 class="titulo">CREMAS</h1>
    </div>

    <div class="contenedor">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="item">
                    <div class="columna-imagen">
                        <?php $imagen_url = "../" . htmlspecialchars($row['imagen_url']); ?>
                        <a href="producto.php?id=<?php echo $row['id_producto']; ?>">
                        <img src="<?php echo $imagen_url; ?>" alt="Producto">
                        </a>
                        <form action="AñadirProductoCarrito.php" method="POST">
                            <input type="hidden" name="id_producto" value="<?php echo $row['id_producto']; ?>">
                            <input type="hidden" name="precio" value="<?php echo $row['precio']; ?>">
                            <button type="submit" class="boton1">Añadir a carrito</button>
                        </form>
                    </div>
                    <div class="texto">
                        <p class="nombre"><?php echo nl2br(htmlspecialchars($row['nombre'])); ?></p>
                        <p class="descripcion">
                            <?php echo mb_strimwidth(htmlspecialchars($row['descripcion']), 0, 100, "..."); ?>
                        </p>
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

<?
$conn->close(); ?>