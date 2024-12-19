<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../modelo/conexion.php");
session_start(); // Iniciar sesión


$banner = '../vista/menuUsuarioNoRegistrado.php';


// Obtener los tres primeros productos de la categoría 'crema'
$sql_cremas = "SELECT id_producto, nombre, descripcion, precio, imagen_url FROM producto WHERE categoria = 'cremas' LIMIT 3";
$result_cremas = $conn->query($sql_cremas);

// Obtener los tres primeros productos de la categoría 'producto'
$sql_productos = "SELECT id_producto, nombre, descripcion, precio, imagen_url FROM producto WHERE categoria = 'producto' LIMIT 3";
$result_productos = $conn->query($sql_productos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Productos</title>

    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@700;600;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Averta';
            margin: 0;
            padding: 0;
        }

        .titulo {
            font-size: 32px;
            font-weight: 700;
            padding-left: 70px;
            margin-bottom: 20px;
            display: inline-block;
        }

        .contenedor {
            width: 90%;
            margin: 20px auto;
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: flex-start;
        }

        .carrito-contenedor {
            position: absolute;
            top: 150px; /* Ajuste para estar a la altura del título */
            right: 20px;
        }

        .carrito-contenedor img {
            width: 114px;
            height: 95px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .carrito-contenedor img:hover {
            transform: scale(1.1);
        }

        .item {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: calc(33.333% - 30px);
        }

        .item img {
            width: 154px;
            height: auto;
            cursor: pointer;
        }

        .texto {
            color: #000000;
            text-align: center;
            font-weight: 700;
        }

        .texto p {
            margin: 5px 0;
        }

        .texto .precio {
            font-weight: bold;
        }

        .boton-contenedor1 {
            text-align: center;
            margin-top: 30px;
        }

        .boton1 {
            width: 200px;
            height: 40px;
            border: none;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            color: white;
            background-color: #111C4E;
            border-radius: 10px;
            transition: background-color 0.3s, transform 0.2s;
            position:relative;
            left: 600px;
        }

        .boton1:hover {
            background-color: #0D1637;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <!-- Banner según el estado de la sesión -->
    <?php include $banner; ?>

    <!-- Icono del carrito -->
    <div class="carrito-contenedor">
        <a href="../vista/carrito.php">
            <img src="../controlador/images/carrito.png" alt="Carrito de Compras">
        </a>
    </div>

    <!-- Sección de Cremas -->
    <div class="titulo" style="margin-top: 50px;">CREMAS</div>
    <div class="contenedor">
        <?php if ($result_cremas && $result_cremas->num_rows > 0): ?>
            <?php while ($crema = $result_cremas->fetch_assoc()): ?>
                <div class="item">
                    <a href="producto.php?id=<?php echo $crema['id_producto']; ?>">
                        <img src="../vista/<?php echo htmlspecialchars($crema['imagen_url']); ?>" alt="<?php echo htmlspecialchars($crema['nombre']); ?>">
                    </a>
                    <div class="texto">
                        <p><?php echo htmlspecialchars($crema['nombre']); ?></p>
                        <p class="precio"><?php echo number_format($crema['precio'], 2); ?> €</p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; font-size: 18px;">No hay productos disponibles en esta categoría.</p>
        <?php endif; ?>
    </div>
    <div class="boton-contenedor1">
        <a href="../vista/tiendaVerMasCremas.php">
            <button class="boton1">Ver más cremas</button>
        </a>
    </div>

    <!-- Sección de Otros Productos -->
    <div class="titulo" style="margin-top: 50px;">OTROS PRODUCTOS</div>
    <div class="contenedor">
        <?php if ($result_productos && $result_productos->num_rows > 0): ?>
            <?php while ($producto = $result_productos->fetch_assoc()): ?>
                <div class="item">
                    <a href="producto.php?id=<?php echo $producto['id_producto']; ?>">
                        <img src="../vista/<?php echo htmlspecialchars($producto['imagen_url']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                    </a>
                    <div class="texto">
                        <p><?php echo htmlspecialchars($producto['nombre']); ?></p>
                        <p class="precio"><?php echo number_format($producto['precio'], 2); ?> €</p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; font-size: 18px;">No hay productos disponibles en esta categoría.</p>
        <?php endif; ?>
    </div>
    <div class="boton-contenedor1">
        <a href="../vista/tiendaVerMasProductos.php">
            <button class="boton1">Ver más productos</button>
        </a>
    </div>
<br>
<br>
    <!-- Pie de página -->
    <?php include '../vista/piePagina.php'; ?>

</body>
</html>

<?php
$conn->close();
?>