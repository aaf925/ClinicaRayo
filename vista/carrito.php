<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once("../modelo/conexion.php");
require_once("../vista/menuUsuarioRegistrado.php");

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Debes iniciar sesión para ver el carrito.'); window.location.href='../vista/iniciosesion.php';</script>";
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Procesar acciones (eliminar producto o vaciar carrito)
if (isset($_GET['action'])) {
    if ($_GET['action'] === 'delete' && isset($_GET['id_producto'])) {
        $id_producto = intval($_GET['id_producto']);
        $sql_delete = "DELETE FROM carrito WHERE id_producto = ? AND id_usuario = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("ii", $id_producto, $id_usuario);
        if ($stmt_delete->execute()) {
            echo "success";
        } else {
            echo "error";
        }
        exit();
    } elseif ($_GET['action'] === 'empty') {
        $sql_empty = "DELETE FROM carrito WHERE id_usuario = ?";
        $stmt_empty = $conn->prepare($sql_empty);
        $stmt_empty->bind_param("i", $id_usuario);
        if ($stmt_empty->execute()) {
            echo "success";
        } else {
            echo "error";
        }
        exit();
    }
}

// Consultar productos en el carrito del usuario agrupados por producto
$sql = "SELECT c.id_producto, p.nombre, p.precio, p.imagen_url, SUM(c.cantidad) AS cantidad 
        FROM carrito c
        JOIN producto p ON c.id_producto = p.id_producto
        WHERE c.id_usuario = ?
        GROUP BY c.id_producto";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$productos = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito</title>
    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@700;600;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Alverta, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }

        h2 {
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
        }

        .producto {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .producto img {
            width: 100px;
            height: auto;
            margin-right: 20px;
        }

        .detalle-producto {
            flex: 1;
        }

        .detalle-producto p {
            margin: 5px 0;
        }

        .acciones-producto {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .acciones-producto button {
            background-color: #1A224B;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            margin-top: 5px;
        }

        .acciones-producto button:hover {
            background-color: #0f1536;
        }

        .total-container {
            text-align: center;
            margin-top: 20px;
        }

        .total {
            font-size: 20px;
            font-weight: bold;
        }

        .acciones-globales {
            margin-top: 20px;
            text-align: center;
        }

        .acciones-globales button {
            background-color: #1A224B;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            margin: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .acciones-globales button:hover {
            background-color: #0f1536;
        }
    </style>
</head>
<body>
    <h2>Productos Seleccionados</h2>

    <?php if (!empty($productos)): ?>
        <?php foreach ($productos as $producto): ?>
            <div class="producto" data-id="<?php echo $producto['id_producto']; ?>" data-price="<?php echo $producto['precio']; ?>">
                <img src="../vista/<?php echo htmlspecialchars($producto['imagen_url']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                <div class="detalle-producto">
                    <p><strong><?php echo htmlspecialchars($producto['nombre']); ?></strong></p>
                    <p>Precio: <?php echo number_format($producto['precio'], 2); ?> €</p>
                    <p>Cantidad: <span class="cantidad"><?php echo $producto['cantidad']; ?></span></p>
                    <p>Total: <span class="precio-individual"><?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?> €</span></p>
                </div>
                <div class="acciones-producto">
                    <button class="eliminar-producto">Eliminar</button>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="total-container">
            <div class="total">Total: 0,00 €</div>
        </div>

        <div class="acciones-globales">
            <button onclick="window.location.href='../vista/tienda.php'">Continuar Compra</button>
            <button onclick="window.location.href='../vista/pagarCarrito.php'">Pagar carrito</button>
            <button onclick="vaciarCarrito()">Vaciar carrito</button>
        </div>
    <?php else: ?>
        <p>No hay productos en el carrito.</p>
    <?php endif; ?>

    <script>
        const productos = document.querySelectorAll('.producto');
        const totalContainer = document.querySelector('.total');

        function actualizarTotal() {
            let total = 0;
            productos.forEach(producto => {
                const precioUnitario = parseFloat(producto.dataset.price);
                const cantidad = parseInt(producto.querySelector('.cantidad').textContent);
                total += precioUnitario * cantidad;
            });
            totalContainer.textContent = `Total: ${total.toFixed(2)} €`;
        }

        productos.forEach(producto => {
            const btnEliminar = producto.querySelector('.eliminar-producto');
            btnEliminar.addEventListener('click', () => {
                const idProducto = producto.dataset.id;

                // Eliminar de la base de datos
                fetch(`../vista/carrito.php?action=delete&id_producto=${idProducto}`, { method: 'GET' })
                    .then(response => response.text())
                    .then(data => {
                        if (data.trim() === 'success') {
                            producto.remove(); // Eliminar producto de la interfaz
                            actualizarTotal(); // Actualizar el total
                        } else {
                            alert('Error al eliminar el producto.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al eliminar el producto.');
                    });
            });
        });

        function vaciarCarrito() {
            // Eliminar todo el carrito de la base de datos
            fetch('../vista/carrito.php?action=empty', { method: 'GET' })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === 'success') {
                        alert('Carrito vaciado correctamente.');
                        window.location.reload();
                    } else {
                        alert('Error al vaciar el carrito.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al vaciar el carrito.');
                });
        }

        actualizarTotal();
    </script>
<?php require_once("../vista/piePagina.php");?>

</body>
</html>

<?php $conn->close(); ?>