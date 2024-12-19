<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once("../modelo/conexion.php");

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Debes iniciar sesión para ver el carrito.'); window.location.href='../vista/iniciosesion.php';</script>";
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Consultar productos en el carrito del usuario
$sql = "SELECT c.id_producto, p.nombre, p.precio, p.imagen_url, c.cantidad 
        FROM carrito c
        JOIN producto p ON c.id_producto = p.id_producto
        WHERE c.id_usuario = ?";
$stmt = $conexion->prepare($sql);
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
            margin-left: 40px;
            background-color: #f9f9f9;
        }

        h2 {
            font-style: 700;
            margin-bottom: 50px;
            margin-left: 50px;
            margin-top: 50px;
        }

        .producto {
            display: flex;
            align-items: flex-start;
            margin-top: 20px;
            padding-bottom: 90px;
        }

        .producto img {
            width: 177px;
            height: 182px;
            margin-left: 50px;
            border: 1px solid #ddd;
        }

        .detalle-producto {
            flex: 1;
        }

        .detalle-producto p {
            margin: 5px 0;
            margin-left: 50px;
        }

        .precio-cantidad {
            margin-top: 10px;
            margin-left: 0px;
        }

        .precio-cantidad span {
            display: block;
            font-weight: 700;
            margin-left: 50px;
        }

        .precio-conteo {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 10px;
            width: 250px;
            margin-left: 50px;
        }

        .contador {
            display: flex;
            align-items: center;
            margin-left: 200px;
        }

        .contador button {
            background-color: #1A224B;
            color: white;
            border: none;
            border-radius: 5px;
            width: 30px;
            height: 30px;
            font-size: 16px;
            cursor: pointer;
        }

        .contador .count {
            text-align: center;
            width: 40px;
            height: 30px;
            border: 1px solid #ddd;
            line-height: 30px;
        }

        .precio {
            font-weight: bold;
        }

        .total-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            margin-left: 40px;
            margin-bottom: 150px;
        }

        .total {
            background-color: white;
            border: 1px solid #1A224B;
            padding: 10px 15px;
            font-weight: bold;
        }

        .acciones {
            display: flex;
            gap: 10px;
        }

        .acciones button {
            background-color: #1A224B;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 100px;
        }

        .acciones button:hover {
            background-color: #0f1536;
        }
    </style>
</head>
<body>
    <h2>Productos Seleccionados</h2>

    <?php if (!empty($productos)): ?>
        <?php foreach ($productos as $producto): ?>
            <div class="producto" data-price="<?php echo $producto['precio']; ?>">
                <img src="../<?php echo htmlspecialchars($producto['imagen_url']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                <div class="detalle-producto">
                    <p><strong><?php echo htmlspecialchars($producto['nombre']); ?></strong></p>
                    <div class="precio-cantidad">
                        <span>Precio: <?php echo number_format($producto['precio'], 2); ?> €</span>
                        <span>Cantidad: <?php echo $producto['cantidad']; ?></span>
                    </div>
                    <div class="precio-conteo">
                        <span class="precio-individual"><?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?> €</span>
                        <div class="contador">
                            <button class="decrement">-</button>
                            <div class="count"><?php echo $producto['cantidad']; ?></div>
                            <button class="increment">+</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="total-container">
            <div class="total">0,00 €</div>
            <div class="acciones">
                <button onclick="window.location.href='tienda.php'">Continuar Compra</button>
                <button onclick="window.location.href='pagarCarrito.php'">Pagar carrito</button>
                <button onclick="vaciarCarrito()">Vaciar carrito</button>
            </div>
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
                const cantidad = parseInt(producto.querySelector('.count').textContent);
                total += precioUnitario * cantidad;
            });
            totalContainer.textContent = `${total.toFixed(2)} €`;
        }

        productos.forEach(producto => {
            const btnIncrement = producto.querySelector('.increment');
            const btnDecrement = producto.querySelector('.decrement');
            const countDisplay = producto.querySelector('.count');
            const precioDisplay = producto.querySelector('.precio-individual');
            const precioUnitario = parseFloat(producto.dataset.price);

            let cantidad = parseInt(countDisplay.textContent);

            btnIncrement.addEventListener('click', () => {
                cantidad++;
                countDisplay.textContent = cantidad;
                precioDisplay.textContent = `${(precioUnitario * cantidad).toFixed(2)} €`;
                actualizarTotal();
            });

            btnDecrement.addEventListener('click', () => {
                if (cantidad > 1) {
                    cantidad--;
                    countDisplay.textContent = cantidad;
                    precioDisplay.textContent = `${(precioUnitario * cantidad).toFixed(2)} €`;
                    actualizarTotal();
                }
            });
        });

        function vaciarCarrito() {
            alert("Carrito vaciado correctamente.");
            window.location.reload();
        }

        actualizarTotal();
    </script>
</body>
</html>

<?php $conexion->close(); ?>
