<?php
require_once '../modelo/conexion.php';

if (isset($_GET['id_cita'])) {
    $idCita = $conn->real_escape_string($_GET['id_cita']);

    // Obtener los datos de la cita
    $sql = "SELECT * FROM cita WHERE id_cita = '$idCita'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $cita = $resultado->fetch_assoc();
    } else {
        echo "Cita no encontrada.";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Cita</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .banner {
            background-color: #1A428A;
            color: white;
            text-align: center;
            padding: 15px 0;
            font-size: 24px;
            font-weight: bold;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            font-weight: bold;
            color: #555;
        }

        input, select, button {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #1A428A;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0D1637;
        }
    </style>
</head>
<body>
    <?php require_once 'menuAdmin.php'; ?>
    <div class="container">
        <h2>Modificar los Datos de la Cita</h2>
        <form action="procesarModificacionCita.php" method="POST">
            <input type="hidden" name="id_cita" value="<?php echo $cita['id_cita']; ?>">

            <!-- Usuario -->
            <label for="id_usuario">Usuario:</label>
            <select name="id_usuario" required>
                <?php
                $usuarios = $conn->query("SELECT id_usuario, nombre FROM usuario");
                while ($usuario = $usuarios->fetch_assoc()) {
                    $selected = $usuario['id_usuario'] == $cita['id_usuario'] ? 'selected' : '';
                    echo "<option value='{$usuario['id_usuario']}' $selected>{$usuario['nombre']}</option>";
                }
                ?>
            </select>

            <!-- Servicio -->
            <label for="id_servicio">Servicio:</label>
            <select name="id_servicio" required>
                <?php
                $servicios = $conn->query("SELECT id_servicio, nombre FROM servicio");
                while ($servicio = $servicios->fetch_assoc()) {
                    $selected = $servicio['id_servicio'] == $cita['id_servicio'] ? 'selected' : '';
                    echo "<option value='{$servicio['id_servicio']}' $selected>{$servicio['nombre']}</option>";
                }
                ?>
            </select>

            <!-- Fecha -->
            <label for="fecha_cita">Fecha:</label>
            <input type="date" name="fecha_cita" value="<?php echo $cita['fecha_cita']; ?>" required>

            <!-- Hora -->
            <label for="hora_cita">Hora:</label>
            <input type="time" name="hora_cita" value="<?php echo substr($cita['hora_cita'], 0, 5); ?>" required>

            <!-- Estado -->
            <label for="estado">Estado:</label>
            <select name="estado" required>
                <option value="pendiente" <?php echo $cita['estado'] == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                <option value="confirmada" <?php echo $cita['estado'] == 'confirmada' ? 'selected' : ''; ?>>Confirmada</option>
                <option value="cancelada" <?php echo $cita['estado'] == 'cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                <option value="completada" <?php echo $cita['estado'] == 'completada' ? 'selected' : ''; ?>>Completada</option>
            </select>

            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>