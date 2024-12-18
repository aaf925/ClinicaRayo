<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../modelo/conexion.php");

if (isset($_GET['id'])) {
    $id_producto = intval($_GET['id']);
    $sql = "SELECT nombre, descripcion, precio, imagen_url FROM producto WHERE id_producto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
    } else {
        echo "Producto no encontrado.";
        exit();
    }
} else {
    echo "ID de producto no especificado.";
    exit();
}

$sql_relacionados = "SELECT id_producto, nombre, imagen_url FROM producto WHERE id_producto != ? LIMIT 3";
$stmt_relacionados = $conn->prepare($sql_relacionados);
$stmt_relacionados->bind_param("i", $id_producto);
$stmt_relacionados->execute();
$result_relacionados = $stmt_relacionados->get_result();
$otros_productos = $result_relacionados->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($producto['nombre']); ?></title>
    <style>
        body {
            font-family: 'Averta';
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
        .columna-central {
            flex: 2;
            margin-left: 40px;
        }
        .columna-derecha {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px;
            text-align: center;
        }
        .columna-derecha h2 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .producto-relacionado {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }
        .producto-relacionado img {
            width: 80px;
            height: auto;
        }
        .producto-relacionado p {
            font-size: 14px;
            margin: 0;
            font-weight: bold;
        }
        .nombre {
            font-size: 36px;
            font-weight: bold;
            text-align: left;
            margin-bottom: 10px;
        }
        .contenido {
            display: flex;
            align-items: flex-start;
            gap: 20px;
        }
        .imagen {
            flex: 0 0 40%;
        }
        .imagen img {
            width: 100%;
            max-width: 350px;
            height: auto;
        }
        .descripcion {
            flex: 1;
            font-size: 16px;
            color: #444;
            line-height: 1.6;
        }
        .valoracion {
            margin: 0 0 10px 0;
        }
        .estrella {
            color: #FFD700;
            font-size: 20px;
            margin-right: 3px;
        }
        .precio-boton {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-top: 10px;
        }
        .precio {
            font-size: 20px;
            color: #000;
            font-weight: bold;
            position: relative;
            left: 215px;
        }
        .boton-carrito {
            background-color: #111C4E;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.2s;
            position: relative;
            left: 700px;
        }
        .boton-carrito:hover {
            background-color: #0D1637;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <div class="columna-central">
        <div class="nombre">
            <?php echo htmlspecialchars($producto['nombre']); ?>
        </div>
        <div class="contenido">
            <div class="imagen">
                <img src="../<?php echo htmlspecialchars($producto['imagen_url']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                <div class="precio-boton">
                    <div class="precio">
                        <strong>Precio: </strong><?php echo number_format($producto['precio'], 2); ?> €
                    </div>
                    <form action="AñadirProductoCarrito.php" method="POST">
                        <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                        <input type="hidden" name="precio" value="<?php echo $producto['precio']; ?>">
                        <button type="submit" class="boton-carrito">Añadir al carrito</button>
                    </form>
                </div>
            </div>
            <div class="descripcion">
                <div class="valoracion">
                    <span class="estrella">&#9733;</span>
                    <span class="estrella">&#9733;</span>
                    <span class="estrella">&#9733;</span>
                    <span class="estrella">&#9733;</span>
                    <span class="estrella">&#9733;</span>
                </div>
                <p><?php echo nl2br(htmlspecialchars($producto['descripcion'])); ?></p>
            </div>
        </div>
    </div>
    <div class="columna-derecha">
        <h2>Otros productos</h2>
        <?php foreach ($otros_productos as $otro): ?>
            <div class="producto-relacionado">
                <a href="producto.php?id=<?php echo $otro['id_producto']; ?>">
                    <img src="../<?php echo htmlspecialchars($otro['imagen_url']); ?>" alt="<?php echo htmlspecialchars($otro['nombre']); ?>">
                </a>
                <p><?php echo htmlspecialchars($otro['nombre']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>