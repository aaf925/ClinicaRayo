<?php
session_start();
require_once("../modelo/conexion.php");

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Debes iniciar sesión para completar tu compra.'); window.location.href='../vista/iniciosesion.php';</script>";
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener productos del carrito y calcular el total
$sql = "SELECT c.id_producto, p.nombre, p.precio, c.cantidad, p.imagen_url
        FROM carrito c
        JOIN producto p ON c.id_producto = p.id_producto
        WHERE c.id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

$productos = [];
$total = 0;
while ($row = $result->fetch_assoc()) {
    $productos[] = $row;
    $total += $row['precio'] * $row['cantidad'];
}

// Procesar el formulario al enviarlo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellidos = htmlspecialchars($_POST['apellidos']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $direccion = htmlspecialchars($_POST['direccion']);
    $mas_informacion = htmlspecialchars($_POST['mas_informacion']);
    $codigo_postal = htmlspecialchars($_POST['codigo_postal']);
    $provincia = htmlspecialchars($_POST['provincia']);
    $ciudad = htmlspecialchars($_POST['ciudad']);

    try {
        // Iniciar una transacción
        $conn->begin_transaction();

        // Insertar los datos del pedido en la tabla `pedido`
        $sql_pedido = "INSERT INTO pedido (id_usuario, fecha_pedido, nombre, apellidos, telefono, direccion, mas_informacion, codigo_postal, provincia, ciudad, total) 
                       VALUES (?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_pedido = $conn->prepare($sql_pedido);
        $stmt_pedido->bind_param("issssssssd", $id_usuario, $nombre, $apellidos, $telefono, $direccion, $mas_informacion, $codigo_postal, $provincia, $ciudad, $total);

        if (!$stmt_pedido->execute()) {
            throw new Exception("Error al guardar el pedido: " . $stmt_pedido->error);
        }

        // Vaciar el carrito del usuario
        $sql_vaciar_carrito = "DELETE FROM carrito WHERE id_usuario = ?";
        $stmt_vaciar_carrito = $conn->prepare($sql_vaciar_carrito);
        $stmt_vaciar_carrito->bind_param("i", $id_usuario);

        if (!$stmt_vaciar_carrito->execute()) {
            throw new Exception("Error al vaciar el carrito: " . $stmt_vaciar_carrito->error);
        }

        // Confirmar la transacción
        $conn->commit();

        echo "<script>alert('Pedido guardado. Continuando con el pago.'); window.location.href='../vista/continuarPagarCarrito.php';</script>";
        exit();
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Continuar Comprando</title>
    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@700;600;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Alverta', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .contenedor {
            display: flex;
            width: 100%;
        }
        .formulario {
            flex: 1;
            padding: 30px;
            background-color: #f9f9f9;
        }
        .formulario h2 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .formulario input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .botones {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .boton {
            background-color: #111C4E;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .boton:hover {
            background-color: #0D1637;
        }
        .resumen {
            flex: 1;
            padding: 30px;
            background-color: #fff;
            border-left: 1px solid #ddd;
        }
        .resumen h2 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .producto {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .producto img {
            width: 60px;
            height: auto;
            margin-right: 15px;
        }
        .producto .info {
            flex: 1;
        }
        .producto .info p {
            margin: 5px 0;
            font-size: 14px;
        }
        .producto .precio {
            font-weight: bold;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }
    </style>
    <script>
        function redirigirCarrito() {
            window.location.href = 'carrito.php';
        }
    </script>
</head>
<body>
    <div class="contenedor">
        <!-- Columna Izquierda: Formulario -->
        <div class="formulario">
            <h2>Datos de envío</h2>
            <form action="" method="POST">
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="text" name="apellidos" placeholder="Apellidos" required>
                <input type="text" name="telefono" placeholder="Número de teléfono" required>
                <input type="text" name="direccion" placeholder="Dirección (calle y número)" required>
                <input type="text" name="mas_informacion" placeholder="Información adicional (opcional)">
                <input type="text" name="codigo_postal" placeholder="Código postal" required>
                <input type="text" name="provincia" placeholder="Provincia" required>
                <input type="text" name="ciudad" placeholder="Ciudad" required>
                <div class="botones">
                    <button type="button" class="boton" onclick="redirigirCarrito()">Cancelar</button>
                    <button type="submit" class="boton">Continuar</button>
                </div>
            </form>
        </div>
        
        <!-- Columna Derecha: Resumen del Pedido -->
        <div class="resumen">
            <h2>Resumen del pedido</h2>
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="producto">
                        <img src="../<?php echo htmlspecialchars($producto['imagen_url']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        <div class="info">
                            <p><strong><?php echo htmlspecialchars($producto['nombre']); ?></strong></p>
                            <p>Cantidad: <?php echo $producto['cantidad']; ?></p>
                        </div>
                        <div class="precio">
                            <?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?> €
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="total">Total: <?php echo number_format($total, 2); ?> €</div>
            <?php else: ?>
                <p>No hay productos en el carrito.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>