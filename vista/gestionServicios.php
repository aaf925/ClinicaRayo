<?php
require_once '../modelo/conexion.php'; // Conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Tienda Online</title>

    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@900;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Alverta', sans-serif;
            background-color: #f4f4f4;
        }

        .gestionServicios {
            background-color: #1A428A;
            width: 800px;
            margin: auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px grey;
            color: white;
            text-align: center;
        }

        .tituloServicios {
            background-color: #111C4E;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .servicios {
            background-color: #f4f4f4;
            color: black;
            padding: 20px;
            border-radius: 8px;
            overflow-y: auto;
            max-height: 300px; /* Permite scroll vertical */
            text-align: left;
        }

        .servicio-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .servicio-item:last-child {
            border-bottom: none;
        }

        .checkbox {
            width: 20px;
            height: 20px;
        }

        .buttons {
            margin-top: 20px;
            display: flex;
            justify-content: space-around;
        }

        button {
            background-color: #111C4E;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background-color: #0D1637;
        }
    </style>
</head>
<body>
    <!-- Incluye el menú superior -->
    <?php require_once '../vista/menuAdmin.php'; ?>

    <br>
    <br>

    <div class="gestionServicios">
        <div class="tituloServicios">
            Lista de Servicios
        </div>

        <!-- Formulario para enviar los IDs seleccionados -->
        <form action="../vista/darDeBajaServicio.php" method="POST">
            <div class="servicios">
                <?php
                require_once '../modelo/conexion.php';

                // Consulta para obtener los servicios y contar citas relacionadas
                $sql = "SELECT s.id_servicio, s.nombre, s.precio, s.imagen_url, COUNT(c.id_cita) AS citas_count 
                        FROM servicio s
                        LEFT JOIN cita c ON s.id_servicio = c.id_servicio
                        GROUP BY s.id_servicio";
                $resultado = $conn->query($sql);

                if ($resultado && $resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        $cantidad_citas = $fila['citas_count'];
                        $ganancia = $cantidad_citas * $fila['precio'];

                        echo "<div class='servicio-item'>";
                        echo "ID: {$fila['id_servicio']} | {$fila['nombre']} | Precio: {$fila['precio']} € | Citas: {$cantidad_citas} | Ganancia: {$ganancia} €";
                        echo "<input type='checkbox' name='servicios[]' value='{$fila['id_servicio']}'> "; // Checkbox con el ID
                        echo "<input type='hidden' name='imagenes[{$fila['id_servicio']}]' value='{$fila['imagen_url']}'>"; // Ruta de la imagen
                        echo "</div>";
                    }
                } else {
                    echo "<p>No hay servicios disponibles.</p>";
                }
                $conn->close();
                ?>
            </div>
            <script>
                function modificarServicio() {
                    // Obtener todos los checkboxes seleccionados
                    const checkboxes = document.querySelectorAll("input[name='servicios[]']:checked");

                    // Si no hay exactamente un servicio seleccionado, mostrar una alerta
                    if (checkboxes.length !== 1) {
                        alert("Debe seleccionar exactamente un servicio para modificar.");
                        return;
                    }

                    // Obtener el ID del servicio seleccionado
                    const idServicio = checkboxes[0].value;

                    // Redirigir a modificarServicioFormulario.php con el ID como parámetro GET
                    window.location.href = `../vista/modificarServicioFormulario.php?id_servicio=${idServicio}`;
                }
            </script>
            <div class="buttons">
                <button type="button" onclick="window.location.href='../vista/darAltaServicioFormulario.php';">Dar de alta nuevo servicio</button>
                <button type="button" onclick="modificarServicio()">Modificar servicio</button>
                <button type="submit" name="borrar">Dar de baja servicio</button>
            </div>            
        </form>
    </div>
</body>
</html>