<?php
// tiendaVerMasCremas.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();


require_once("../modelo/conexion.php");

// Determinar qué banner incluir
if (isset($_SESSION['id_usuario'])) {
    $banner = 'menuUsuarioRegistrado.html';
} else {
    $banner = 'menuUsuarioNoRegistrado.html';
}

// Simular el ID del usuario si no hay sesión iniciada
if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['id_usuario'] = 999; // ID de usuario provisional para pruebas
}

$id_usuario = intval($_SESSION['id_usuario']);

// Procesar la solicitud de añadir al carrito (AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'añadir_carrito') {
    $id_producto = intval($_POST['id_producto']);
    $precio = floatval($_POST['precio']);
    $cantidad = 1; // Por defecto, la cantidad es 1
    $total = $cantidad * $precio;
    $id_carrito = 1; // ID del carrito (puedes cambiarlo según tus necesidades)

    // Insertar en la base de datos
    $sql_insert = "INSERT INTO carrito (id_entrada, id_carrito, id_usuario, id_producto, cantidad, total) VALUES (NULL, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_insert);

    if ($stmt) {
        $stmt->bind_param("iiiid", $id_carrito, $id_usuario, $id_producto, $cantidad, $total);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Producto añadido al carrito.']);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo añadir al carrito.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al preparar la consulta.']);
    }
    $conexion->close();
    exit();
}

// Obtener productos de la categoría 'crema'
$sql = "SELECT id_producto, nombre, descripcion, precio, imagen_url FROM producto WHERE categoria = 'crema'";
$result = $conexion->query($sql);
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
            cursor: pointer;
            transition: transform 0.2s;
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
    <script>
        async function añadirAlCarrito(event) {
            event.preventDefault(); // Evitar el comportamiento predeterminado del formulario

            const formData = new FormData(event.target);
            const response = await fetch('', { // Enviar la solicitud al mismo archivo
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            if (result.success) {
                alert('Producto añadido al carrito correctamente.');
            } else {
                alert('Error al añadir el producto al carrito: ' + result.error);
            }
        }
    </script>
</head>
<body>
    <!-- Icono del carrito -->
    <div class="carrito-contenedor">
        <a href="carrito.php">
            <img src="../controlador/images/carrito.png" alt="Carrito de Compras">
        </a>
    </div>

    <!-- Cabecera -->
    <div class="cabecera">
        <h1 class="titulo">CREMAS</h1>
    </div>

    <!-- Contenedor de productos -->
    <div class="contenedor">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="item">
                    <div class="columna-imagen">
                        <?php $imagen_url = "../" . htmlspecialchars($row['imagen_url']); ?>
                        <a href="producto.php?id=<?php echo $row['id_producto']; ?>">
                            <img src="<?php echo $imagen_url; ?>" alt="Producto">
                        </a>
                        <form onsubmit="añadirAlCarrito(event)">
                            <input type="hidden" name="accion" value="añadir_carrito">
                            <input type="hidden" name="id_producto" value="<?php echo $row['id_producto']; ?>">
                            <input type="hidden" name="precio" value="<?php echo $row['precio']; ?>">
                            <button type="submit" class="boton1">Añadir a carrito</button>
                        </form>
                    </div>
                    <div class="texto">
                        <p class="nombre"><?php echo nl2br(htmlspecialchars($row['nombre'])); ?></p>
                        <p class="descripcion"><?php echo mb_strimwidth(htmlspecialchars($row['descripcion']), 0, 100, "..."); ?></p>
                        <p class="precio"><?php echo number_format($row['precio'], 2); ?> €</p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; font-size: 18px;">No hay productos disponibles en esta categoría.</p>
        <?php endif; ?>
    </div>

    <br>
    <br>

    <?php include 'piePagina.html'; ?>
</body>
</html>

<?php $conexion->close(); ?>
