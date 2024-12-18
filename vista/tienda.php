<?
require_once '../modelo/conexion.php';
require_once 'menuUsuarioNoRegistrado.php'; 

try {
    // Consultas para obtener productos por categorías
    $sqlCremas = "SELECT id_producto, nombre, descripcion, precio, imagen_url FROM producto WHERE categoria = 'CREMAS' LIMIT 3";
    $sqlOtros = "SELECT id_producto, nombre, descripcion, precio, imagen_url FROM producto WHERE categoria = 'OTROS' LIMIT 3";

    // Ejecutar consultas
    $resultCremas = $conn->query($sqlCremas);
    $resultOtros = $conn->query($sqlOtros);

    // Almacenar resultados en arrays
    $cremas = $resultCremas->fetch_all(MYSQLI_ASSOC);
    $otrosProductos = $resultOtros->fetch_all(MYSQLI_ASSOC);

} catch (Exception $e) {
    die("Error al cargar los productos: " . $e->getMessage());
}

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
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .titulo {
            font-size: 32px;
            font-weight: 700;
            padding-left: 70px;
            margin-bottom: 20px;
        }

        .contenedor {
            width: 1337px;
            height: 149px;
            border-radius: 5px;
            padding: 20px;
            margin: 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

                /* Estilo del carrito */
                .carrito-contenedor {
            position: relative;
            top: 70px;
            left: 1350px;
           
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
            align-items: center;
            gap: 10px;
        }

        .item img {
            width: 154px;
            height: auto;
        }

        .texto {
            color: #000000;
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-left: 20px;
            font-weight: 700;
        }

        .texto p {
            margin: 0;
        }

        .texto .precio {
            font-weight: bold;
        }

        .boton-contenedor1 {
            display: flex;
            justify-content: flex-end; 
            margin-top: 30px;
            margin-right: 70px;
        }

        /* Estilo del botón */
        .boton1 {
            width: 162px;
            height: 34px;
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

        .boton1:hover {
            background-color: #0D1637;
            transform: translateY(-3px);
        }

        .producto-enlace {
            text-decoration: none; /* Quita el subrayado */
            color: inherit; /* Mantiene el color del texto */
        }

        .producto-enlace:hover {
            text-decoration: none; /* Asegura que tampoco tenga subrayado al pasar el cursor */
        }

    </style>
</head>
<body>


        <!-- Icono del carrito -->
        <div class="carrito-contenedor">
            <a href="carrito.php">
                <img src="../controlador/images/carrito.png" alt="Carrito de Compras">
            </a>
        </div>

<!-- Primer cuadro: Cremas -->
<div class="titulo" style="margin-top: 120px;">CREMAS</div>
<div class="contenedor">
    <?php if (!empty($cremas)): ?>
        <?php foreach ($cremas as $crema): ?>
            <a href="producto.php?id=<?php echo htmlspecialchars($crema['id_producto']); ?>" class="producto-enlace">
                <div class="item">
                    <img src="<?php echo htmlspecialchars($crema['imagen_url']); ?>" alt="<?php echo htmlspecialchars($crema['nombre']); ?>">
                    <div class="texto">
                        <p><?php echo htmlspecialchars($crema['nombre']); ?><br><?php echo nl2br(htmlspecialchars($crema['descripcion'])); ?></p>
                        <p class="precio"><?php echo htmlspecialchars(number_format($crema['precio'], 2, ',', '.')) . " €"; ?></p>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay productos disponibles en esta categoría.</p>
    <?php endif; ?>
</div>
<div class="boton-contenedor1">
    <a href="tiendaVerMasCremas.php">
        <button class="boton1">Ver más productos</button>
    </a>
</div>

<!-- Segundo cuadro: Otros Productos -->
<div class="titulo" style="margin-top: 70px;">OTROS PRODUCTOS</div>
<div class="contenedor">
    <?php if (!empty($otrosProductos)): ?>
        <?php foreach ($otrosProductos as $producto): ?>
            <a href="producto.php?id=<?php echo htmlspecialchars($producto['id_producto']); ?>" class="producto-enlace">
                <div class="item">
                    <img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                    <div class="texto">
                        <p><?php echo htmlspecialchars($producto['nombre']); ?><br><?php echo nl2br(htmlspecialchars($producto['descripcion'])); ?></p>
                        <p class="precio"><?php echo htmlspecialchars(number_format($producto['precio'], 2, ',', '.')) . " €"; ?></p>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay productos disponibles en esta categoría.</p>
    <?php endif; ?>
</div>
<div class="boton-contenedor1">
    <a href="tiendaVerMasProductos.php">
        <button class="boton1">Ver más productos</button>
    </a>
</div>



<? require_once 'piePagina.php';?>
</body>
</html>