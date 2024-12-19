<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Inicia la sesión

require_once("../modelo/conexion.php");


// Simular el ID del usuario si no hay sesión iniciada
if (!isset($_SESSION['id_usuario'])) {
    // Variable provisional para pruebas
    $_SESSION['id_usuario'] = 999; // Cambia este valor para probar con diferentes usuarios
}

$id_usuario = intval($_SESSION['id_usuario']); // Recuperar el ID del usuario desde la sesión o variable provisional

// Procesar la solicitud de añadir al carrito (AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'añadir_carrito') {
    $id_producto = intval($_POST['id_producto']);
    $precio = floatval($_POST['precio']);
    $cantidad = 1; // Por defecto, la cantidad es 1
    $total = $cantidad * $precio;
    $id_carrito = 1; // Puedes actualizar este valor si manejas varios carritos

    // Preparar la consulta de inserción
    $sql_insert = "INSERT INTO carrito (id_entrada, id_carrito, id_usuario, id_producto, cantidad, total) VALUES (NULL, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);

    if ($stmt) {
        $stmt->bind_param("iiiid", $id_carrito, $id_usuario, $id_producto, $cantidad, $total);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Producto añadido al carrito.']);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo añadir al carrito. Detalles: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al preparar la consulta: ' . $conn->error]);
    }
    exit();
}

// Obtener detalles del producto
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

// Obtener productos relacionados
$sql_relacionados = "SELECT id_producto, nombre, imagen_url FROM producto WHERE id_producto != ? LIMIT 3";
$stmt_relacionados = $conn->prepare($sql_relacionados);
$stmt_relacionados->bind_param("i", $id_producto);
$stmt_relacionados->execute();
$result_relacionados = $stmt_relacionados->get_result();

$otros_productos = [];
while ($row = $result_relacionados->fetch_assoc()) {
    $otros_productos[] = $row;
}

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
            padding: 0;
        }
        .carrito-contenedor {
            position: absolute;
            top: 150px; /* Ajuste para estar a la altura del título */
            right: 20px;
        }
        
        .carrito-contenedor img {
            width: 80px;
            height: 80px;
            cursor: pointer;
        }
        .contenido {
            display: flex;
            justify-content: space-between;
            padding: 20px 40px;
        }
        .producto-detalle {
            display: flex;
            gap: 40px;
        }
        .imagen-producto img {
            width: 300px;
            height: auto;
        }
        .info-producto {
            flex: 1;
        }
        .precio-boton {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-top: 20px;
        }
        .precio {
            font-size: 20px;
            font-weight: bold;
            color: #111C4E;
        }
        .boton-carrito {
            background-color: #111C4E;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 14px;
        }
        .boton-carrito:hover {
            background-color: #0D1637;
        }
        .otros-productos img {
            width: 60px;
            height: auto;
            margin-bottom: 10px;
            
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
     <!-- Banner según el estado de la sesión -->
     <?php include 'menuUsuarioNoRegistrado.php'; ?>
    <!-- Icono del carrito -->
    <div class="carrito-contenedor">
        <a href="../vista/carrito.php">
            <img src="../controlador/images/carrito.png" alt="Carrito">
        </a>
    </div>

    <!-- Contenido principal -->
    <div class="contenido">
        <div class="producto-detalle">
            <!-- Imagen del producto -->
            <div class="imagen-producto">
                <img src="../vista/<?php echo htmlspecialchars($producto['imagen_url']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
            </div>

            <!-- Información del producto -->
            <div class="info-producto">
                <h1><?php echo htmlspecialchars($producto['nombre']); ?></h1>
                <div class="descripcion"><?php echo nl2br(htmlspecialchars($producto['descripcion'])); ?></div>
                <div class="precio-boton">
                    <div class="precio"><?php echo number_format($producto['precio'], 2); ?> €</div>
                    <form onsubmit="añadirAlCarrito(event)">
                        <input type="hidden" name="accion" value="añadir_carrito">
                        <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                        <input type="hidden" name="precio" value="<?php echo $producto['precio']; ?>">
                        <button type="submit" class="boton-carrito">Añadir al carrito</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Otros productos -->
        <div class="columna-derecha">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <h2>Otros productos de esta sección</h2>
            <?php foreach ($otros_productos as $otro): ?>
                <div class="otros-productos" >
                    <a href="../vista/producto.php?id=<?php echo $otro['id_producto']; ?>">
                        <img src="../vista/<?php echo htmlspecialchars($otro['imagen_url']); ?>" alt="<?php echo htmlspecialchars($otro['nombre']); ?>">
                    </a>
                    <p><?php echo htmlspecialchars($otro['nombre']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <br>
<br>
    <!-- Pie de página -->
    <?php include '../vista/piePagina.php'; 
    $conn->close();?>
</body>
</html>