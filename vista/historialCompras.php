<?php
include_once('../modelo/conexion.php'); // Archivo de conexión a la base de datos

// Consultar datos del historial de compras
$sql_historial_compras = "
    SELECT id_compra, fecha, precio_total, productos, calificacion, ticket_url
    FROM historial_compra
    ORDER BY fecha DESC";
$result_compras = $conexion->query($sql_historial_compras);
$historial_compras = [];
if ($result_compras->num_rows > 0) {
    while ($row = $result_compras->fetch_assoc()) {
        $historial_compras[] = $row;
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Compras</title>
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
        <?php foreach ($historial_compras as $compra): ?>
            <div class="card">
                <h3>Compra <?php echo htmlspecialchars($compra['id_compra']); ?></h3>
                <div class="stars">
                    <?php echo str_repeat('★', $compra['calificacion']); ?>
                    <?php echo str_repeat('☆', 5 - $compra['calificacion']); ?>
                </div>
                <p><strong>Fecha:</strong> <?php echo htmlspecialchars($compra['fecha']); ?></p>
                <p><strong>Precio Total:</strong> <?php echo number_format($compra['precio_total'], 2); ?> €</p>
                <p><strong>Productos:</strong> <?php echo htmlspecialchars($compra['productos']); ?></p>
                <a href="<?php echo htmlspecialchars($compra['ticket_url']); ?>" target="_blank">
                    <button class="btn">Ver Ticket</button>
                </a>
                <button class="btn">Añadir a valoración</button>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
