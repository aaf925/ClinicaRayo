<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Iniciar sesión
require_once("../modelo/conexion.php"); // Asegúrate de incluir este archivo

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Debes iniciar sesión para continuar.'); window.location.href='iniciosesion.php';</script>";
    exit();
}

$id_usuario = $_SESSION['id_usuario']; // Obtener el ID del usuario desde la sesión

// Consultar el último pedido registrado para el usuario actual
$sql_pedido = "SELECT total 
               FROM pedido 
               WHERE id_usuario = ? 
               ORDER BY id_pedido DESC 
               LIMIT 1";
$stmt_pedido = $conexion->prepare($sql_pedido);
$stmt_pedido->bind_param("i", $id_usuario);
$stmt_pedido->execute();
$result_pedido = $stmt_pedido->get_result();
$row_pedido = $result_pedido->fetch_assoc();

if (!$row_pedido || !$row_pedido['total']) {
    echo "<script>alert('No hay pedido en proceso.'); window.location.href='carrito.php';</script>";
    exit();
}

$total_pedido = number_format($row_pedido['total'], 2); // Formatear el total del pedido
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar Pedido</title>
    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@700;600;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Alverta', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f9f9f9;
        }
        .contenedor {
            background-color: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        .contenedor h2 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .contenedor img {
            width: 120px;
            margin: 10px 5px;
            cursor: pointer;
        }
        .formulario {
            margin-top: 20px;
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
            flex-direction: column;
            gap: 10px;
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
        .boton-cancelar {
            background-color: #ddd;
            color: #333;
        }
        .boton-cancelar:hover {
            background-color: #bbb;
        }
    </style>
    <script>
        function validarFormulario() {
            const tarjeta = document.querySelector('[name="numero_tarjeta"]').value;
            const vencimiento = document.querySelector('[name="mes_vencimiento"]').value;

            // Validar si la fecha de vencimiento es válida
            const [mes, año] = vencimiento.split('/');
            const ahora = new Date();
            const mesActual = ahora.getMonth() + 1;
            const añoActual = ahora.getFullYear() % 100;

            if (parseInt(año) < añoActual || (parseInt(año) === añoActual && parseInt(mes) < mesActual)) {
                alert('La tarjeta ha expirado.');
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="contenedor">
        <h2>Completar Pago</h2>
        
        <!-- Opciones de pago -->
        <div>
            
        </div>

        <p> Pagar con tarjeta bancaria:</p>
        
        <!-- Formulario de pago -->
        <form action="procesarPago.php" method="POST" class="formulario" onsubmit="return validarFormulario()">
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="text" name="numero_tarjeta" placeholder="1234 1234 1234 1234" maxlength="19" pattern="\d{4}\s\d{4}\s\d{4}\s\d{4}" title="Debe ser un número de tarjeta válido (16 dígitos separados por espacios)" required>
            <div style="display: flex; gap: 10px;">
                <input type="text" name="mes_vencimiento" placeholder="MM/YY" maxlength="5" pattern="\d{2}/\d{2}" title="Debe estar en el formato MM/YY" required>
                <input type="text" name="cvc" placeholder="CVC" maxlength="3" pattern="\d{3}" title="Debe ser un CVC válido (3 dígitos)" required>
            </div>
            <input type="text" name="titular_tarjeta" placeholder="Nombre del titular de la tarjeta" pattern="[A-Za-z\s]+" title="Solo letras y espacios permitidos" required>

            <!-- Botones -->
            <div class="botones">
                <button type="submit" class="boton">Pagar <?php echo $total_pedido; ?> €</button>
                <button type="button" class="boton boton-cancelar" onclick="window.location.href='carrito.php'">Cancelar</button>
            </div>
        </form>
    </div>
    <br>
<br>
    <!-- Pie de página -->
    <?php include 'piePagina.html'; ?>
</body>
</html>

<?php
if (isset($conexion)) {
    $conexion->close(); // Cierra la conexión si está definida
}
?>
