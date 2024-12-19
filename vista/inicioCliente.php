<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial del Usuario</title>
    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Alverta', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f4f4f4;
            color: #111C4E;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            background-color:rgb(138, 26, 26);
        }

        .section-title {
            font-size: 1.5rem;
            margin-bottom: 15px;
            font-weight: bold;
            width: 100%;
        }

        .section {
            width: 48%;
        }

        .card {
            background-color: #1A428A;
            color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .btn {
            background-color: #0F1D40;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 0.9rem;
            text-align: center;
        }

        .btn:hover {
            background-color: #0D1734;
        }

        .full-width-btn {
            width: 100%;
            margin-top: 15px;
        }

        .user-info {
            width: 100%;
            background-color: #f4f4f4;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .info-group {
            width: calc(50% - 20px);
        }

        .info-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .info-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .logout-btn {
            margin-top: 20px;
            background-color: #D32F2F;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Historial de Citas -->
        <div class="section">
            <div class="section-title">Historial de Citas</div>
            <div class="card">
                <h3>SERVICIO CONTRATADO</h3>
                <p>Información principal de la cita: Fecha de la cita, persona que le atiende, lugar de la cita</p>
                <button class="btn">Ver información completa</button>
            </div>
            <div class="card">
                <h3>SERVICIO CONTRATADO</h3>
                <p>Información principal de la cita: Fecha de la cita, persona que le atiende, lugar de la cita</p>
                <button class="btn">Ver información completa</button>
            </div>
            <button class="btn full-width-btn">Ver historial de citas completo</button>
        </div>

        <!-- Historial de Compras -->
        <div class="section">
            <div class="section-title">Historial de Compras</div>
            <div class="card">
                <h3>Pedido nºX - Fecha de Pedido</h3>
                <p>Información principal del pedido: Número de productos comprados, total pagado, dirección de envío</p>
                <button class="btn">Ver información completa</button>
            </div>
            <div class="card">
                <h3>Pedido nºX - Fecha de Pedido</h3>
                <p>Información principal del pedido: Número de productos comprados, total pagado, dirección de envío</p>
                <button class="btn">Ver información completa</button>
            </div>
            <button class="btn full-width-btn">Ver historial de compras completo</button>
        </div>

        <!-- Información de Usuario -->
        <div class="section-title" style="width: 100%;">Información de Usuario:</div>
        <div class="user-info">
            <div class="info-group">
                <label for="username">Nombre de Usuario:</label>
                <input type="text" id="username" value="usuarioEjemplo01" readonly>
            </div>
            <div class="info-group">
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" value="ejemplo@ejemplo.es" readonly>
            </div>
            <div class="info-group">
                <label for="name">Nombre y Apellidos:</label>
                <input type="text" id="name" value="Usuario Apellido1 Apellido2" readonly>
            </div>
            <div class="info-group">
                <label for="phone">Número de Teléfono:</label>
                <input type="text" id="phone" value="123456789" readonly>
            </div>
            <button class="btn logout-btn">Cerrar Sesión</button>
        </div>
    </div>
</body>
</html>
