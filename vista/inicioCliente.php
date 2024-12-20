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

// Consultar los dos últimos registros de historial de citas
$sql_citas = "
    SELECT id_cita, lugar, fecha, hora, asistencia, atendido_por, calificacion 
    FROM historial_cita 
    WHERE id_usuario = ? 
    ORDER BY fecha DESC, hora DESC 
    LIMIT 2";
$stmt_citas = $conn->prepare($sql_citas);
$stmt_citas->bind_param("i", $id_usuario);
$stmt_citas->execute();
$result_citas = $stmt_citas->get_result();
$citas = $result_citas->fetch_all(MYSQLI_ASSOC);
$stmt_citas->close();

// Consultar los dos últimos registros de historial de compras
$sql_compras = "
    SELECT id_compra, fecha, precio_total, productos, calificacion 
    FROM historial_compra 
    WHERE id_usuario = ? 
    ORDER BY fecha DESC 
    LIMIT 2";
$stmt_compras = $conn->prepare($sql_compras);
$stmt_compras->bind_param("i", $id_usuario);
$stmt_compras->execute();
$result_compras = $stmt_compras->get_result();
$compras = $result_compras->fetch_all(MYSQLI_ASSOC);
$stmt_compras->close();

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
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 15px;
    height: 300px; /* Altura fija */
    display: flex; /* Asegura el alineamiento del contenido */
    flex-direction: column;
    justify-content: space-between; /* Distribuye el contenido de manera uniforme */
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
            <?php foreach ($citas as $cita): ?>
                <div class="card">
                    <h3>Servicio Contratado</h3>
                    <p><strong>Fecha:</strong> <?php echo htmlspecialchars($cita['fecha']); ?></p>
                    <p><strong>Hora:</strong> <?php echo htmlspecialchars($cita['hora']); ?></p>
                    <p><strong>Lugar:</strong> <?php echo htmlspecialchars($cita['lugar']); ?></p>
                    <p><strong>Atendido por:</strong> <?php echo htmlspecialchars($cita['atendido_por']); ?></p>
                    <p><strong>Asistencia:</strong> <?php echo $cita['asistencia'] ? 'Sí' : 'No'; ?></p>
                    
                <a href="../controlador/generarPDFServicio.php?id_cita=<?php echo htmlspecialchars($cita['id_cita']); ?>" target="_blank">
                    <button class="btn">Ver información completa</button>
                </a>

                </div>
            <?php endforeach; ?>
            <a href="../controlador/historialCitas.php">
                <button class="btn full-width-btn">Ver historial de citas completo</button>
            </a>

            

        </div>

        <!-- Historial de Compras -->
        <div class="section">
            <div class="section-title">Historial de Compras</div>
            <?php foreach ($compras as $compra): ?>
                <div class="card">
                    <h3>Pedido Nº<?php echo htmlspecialchars($compra['id_compra']); ?></h3>
                    <p><strong>Fecha:</strong> <?php echo htmlspecialchars($compra['fecha']); ?></p>
                    <p><strong>Total pagado:</strong> <?php echo number_format($compra['precio_total'], 2); ?> €</p>
                    <p><strong>Productos:</strong> <?php echo htmlspecialchars($compra['productos']); ?></p>
                    <a href="../controlador/generarTicket.php?id_compra=<?php echo htmlspecialchars($compra['id_compra']); ?>" target="_blank">
                    <button class="btn">Ver información completa</button>
                </a>
                </div>
            <?php endforeach; ?>
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