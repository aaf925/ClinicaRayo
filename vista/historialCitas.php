<?php
// Archivo de conexión a la base de datos
include_once('../modelo/conexion.php');

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../controlador/inicioUsuarioNoRegistrado.php");
    exit();
}

// Obtener el ID del usuario autenticado
$id_usuario = $_SESSION['id_usuario'];

// Consultar los datos del historial de citas del usuario autenticado
$sql_historial_citas = "
    SELECT id_cita, lugar, fecha, hora, asistencia, atendido_por, calificacion
    FROM historial_cita
    WHERE id_usuario = ?
    ORDER BY fecha DESC";

$stmt_historial = $conn->prepare($sql_historial_citas);
$stmt_historial->bind_param("i", $id_usuario);
$stmt_historial->execute();
$result_citas = $stmt_historial->get_result();
$historial_citas = [];

if ($result_citas->num_rows > 0) {
    while ($row = $result_citas->fetch_assoc()) {
        $historial_citas[] = $row;
    }
}

// Cerrar conexiones
$stmt_historial->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Citas</title>
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
            max-width: 1400px;
            margin: 20px auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .card {
            background-color: white;
            border: 1px solid #0D1734;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .card h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: #111C4E;
        }

        .card p {
            font-size: 1rem;
            margin: 5px 0;
            color: #333;
        }

        .card .stars {
            color: #FFD700;
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .card .btn {
            margin-top: 10px;
            background-color: #0D1734;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .card .btn:hover {
            background-color: #111C4E;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php foreach ($historial_citas as $cita): ?>
            <div class="card">
                <h3>Cita <?php echo htmlspecialchars($cita['id_cita']); ?></h3>
                <div class="stars">
                    <?php echo str_repeat('★', $cita['calificacion']); ?>
                    <?php echo str_repeat('☆', 5 - $cita['calificacion']); ?>
                </div>
                <p><strong>Lugar:</strong> <?php echo htmlspecialchars($cita['lugar']); ?></p>
                <p><strong>Fecha:</strong> <?php echo htmlspecialchars($cita['fecha']); ?></p>
                <p><strong>Hora:</strong> <?php echo htmlspecialchars($cita['hora']); ?></p>
                <p><strong>Asistencia:</strong> <?php echo $cita['asistencia'] ? 'Sí' : 'No'; ?></p>
                <p><strong>Atendido por:</strong> <?php echo htmlspecialchars($cita['atendido_por']); ?></p>
                <button class="btn">Añadir a valoración</button>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
