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
</head>
<body>
    <div class="contenedor">
        <h2>Completar Pago</h2>
        
        <!-- Opciones de pago -->
        <div>
            <img src="applepay.png" alt="Apple Pay">
            <img src="paypal.png" alt="PayPal">
        </div>

        <p>O pagar con tarjeta bancaria:</p>
        
        <!-- Formulario de pago -->
        <form action="procesarPago.php" method="POST" class="formulario">
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="text" name="numero_tarjeta" placeholder="1234 1234 1234 1234" maxlength="19" required>
            <div style="display: flex; gap: 10px;">
                <input type="text" name="mes_vencimiento" placeholder="MM/YY" maxlength="5" style="flex: 1;" required>
                <input type="text" name="cvc" placeholder="CVC" maxlength="3" style="flex: 1;" required>
            </div>
            <input type="text" name="titular_tarjeta" placeholder="Nombre del titular de la tarjeta" required>

            <!-- Botones -->
            <div class="botones">
                <button type="submit" class="boton">Pagar 6,50 €</button>
                <button type="button" class="boton boton-cancelar" onclick="window.location.href='carrito.php'">Cancelar</button>
            </div>
        </form>
    </div>
</body>
</html>
