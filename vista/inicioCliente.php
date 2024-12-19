<?php

include_once('../modelo/conexion.php');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../controlador/inicioUsuarioNoRegistrado.php");
    exit();
}

// Obtener el id del usuario
$id_usuario = $_SESSION['id_usuario'];

// Consultar los datos del usuario
$query = "SELECT nombre, apellido, email, telefono, tipo_usuario FROM usuario WHERE id_usuario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Cerrar la conexión
$stmt->close();
$conn->close();

// Si no se encuentran datos, redirigir
if (!$user) {
    header("Location: ../controlador/inicioUsuarioNoRegistrado.php");
    exit();
}
?>

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
            margin: 40px auto;
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            background-color: #f4f4f4;
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
            margin-left: 10px;
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
            padding: 40px;
            margin-left: 100px;
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
            width: 60%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .logout-btn {
            
            background-color:  #0D1734;
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
            <a href="../controlador/historialCitas.php">
            <button class="btn full-width-btn">Ver historial de citas completo</button>
                </a>
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
            <a href="../controlador/historialCompras.php">
            <button class="btn full-width-btn">Ver historial de compras completo</button>
            </a>
            
        </div>
        
        <!-- Información de Usuario -->
        <div class="user-info">
    <div class="info-group">
        <label for="nombre">Nombre de Usuario:</label>
        <input type="nombre" id="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" readonly>
    </div>
    <div class="info-group">
        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
    </div>
    <div class="info-group">
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" value="<?php echo htmlspecialchars($user['apellido']); ?>" readonly>
    </div>
    <div class="info-group">
        <label for="phone">Número de Teléfono:</label>
        <input type="text" id="phone" value="<?php echo htmlspecialchars($user['telefono']); ?>" readonly>
    </div>
    <a href="../controlador/inicioUsuarioNoRegistrado.php">
        <button class="btn logout-btn">Cerrar Sesión</button>
    </a>
</div>

    </div>
    </div>
</body>
</html>
