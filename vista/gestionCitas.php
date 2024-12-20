<?php
require_once '../modelo/conexion.php'; // Conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Citas</title>

    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@900;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Alverta', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .header {
            background-color: #111C4E;
            padding: 20px;
            color: white;
            text-align: center;
            font-size: 1.5rem;
        }

        .calendar, .gestionar-citas {
            max-width: 900px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .calendar h2, .gestionar-citas h2 {
            text-align: center;
            color: #111C4E;
        }

        .calendar-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .calendar-table th, .calendar-table td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        .calendar-table th {
            background-color: #111C4E;
            color: white;
        }

        .calendar-table td {
            height: 100px;
        }

        .calendar-controls {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .calendar-controls button {
            background-color: #111C4E;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .calendar-controls button:hover {
            background-color: #0D1637;
        }

        .gestionar-citas form {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            align-items: center;
        }

        .gestionar-citas button {
            background-color: #111C4E;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        .gestionar-citas button:hover {
            background-color: #0D1637;
        }

        select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
    <script>
        function actualizarHorasDisponibles() {
            const fecha = document.getElementById('fecha_cita').value;
            const selectHoras = document.getElementById('hora_cita');

            // Limpiar el contenido del desplegable mientras se carga la respuesta
            selectHoras.innerHTML = '<option value="" disabled selected>Cargando...</option>';

            if (!fecha) {
                selectHoras.innerHTML = '<option value="" disabled selected>Selecciona una hora</option>';
                return;
            }

            // Crear una solicitud AJAX para obtener las horas ocupadas
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '../vista/obtenerHorasOcupadas.php?fecha=' + encodeURIComponent(fecha), true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const horasOcupadas = JSON.parse(xhr.responseText); // Recibe horas ocupadas en formato HH:mm
                    const horasTotales = Array.from({ length: 13 }, (_, i) => {
                        const hora = i + 8; // Rango de 8 a 20
                        return hora.toString().padStart(2, '0') + ':00'; // Asegurar formato HH:mm
                    });

                    // Reiniciar el contenido del desplegable
                    selectHoras.innerHTML = '<option value="" disabled selected>Selecciona una hora</option>';
                    horasTotales.forEach(hora => {
                        if (!horasOcupadas.includes(hora)) {
                            selectHoras.innerHTML += `<option value="${hora}">${hora}</option>`;
                        }
                    });

                    if (selectHoras.innerHTML === '<option value="" disabled selected>Selecciona una hora</option>') {
                        selectHoras.innerHTML += '<option value="" disabled>No hay horas disponibles</option>';
                    }
                } else {
                    console.error('Error al obtener las horas ocupadas: ' + xhr.status);
                    selectHoras.innerHTML = '<option value="" disabled>Error al cargar</option>';
                }
            };
            xhr.onerror = function () {
                console.error('Error en la conexión con obtenerHorasOcupadas.php');
                selectHoras.innerHTML = '<option value="" disabled>Error al cargar</option>';
            };
            xhr.send();
        }

        function modificarCita(idCita) {
            // Redirigir a la página de modificación con el ID de la cita como parámetro
            window.location.href = `../vista/modificarCitaFormulario.php?id_cita=${idCita}`;
        }
    </script>

</head>
<body>
    <!-- Incluye el menú superior -->
    <?php require_once 'menuAdmin.php'; ?>

    <br>
    <br>

    <div class="calendar">
        <h2>Citas Mensuales</h2>
            <div class="calendar-controls">
                <?php
                // Configurar locale para mostrar los meses en español
                setlocale(LC_TIME, 'es_ES.UTF-8'); // Para Linux/Mac
                setlocale(LC_TIME, 'Spanish_Spain.1252'); // Para Windows

                // Obtener mes y año actuales (o recibidos por parámetros GET para navegación)
                $mes = isset($_GET['mes']) ? $_GET['mes'] : date('m');
                $anio = isset($_GET['anio']) ? $_GET['anio'] : date('Y');

                // Ajustar para navegación de meses
                $mesAnterior = $mes - 1;
                $anioAnterior = $anio;
                if ($mesAnterior < 1) {
                    $mesAnterior = 12;
                    $anioAnterior--;
                }

                $mesSiguiente = $mes + 1;
                $anioSiguiente = $anio;
                if ($mesSiguiente > 12) {
                    $mesSiguiente = 1;
                    $anioSiguiente++;
                }

                // Obtener nombre del mes en español
                $nombreMes = strftime('%B', mktime(0, 0, 0, $mes, 1, $anio)); // Mes en español
                $nombreMes = ucfirst($nombreMes); // Capitalizar la primera letra
                ?>
                <button onclick="window.location.href='?mes=<?php echo $mesAnterior; ?>&anio=<?php echo $anioAnterior; ?>'">&lt; Mes Anterior</button>
                <span><?php echo "$nombreMes $anio"; ?></span>
                <button onclick="window.location.href='?mes=<?php echo $mesSiguiente; ?>&anio=<?php echo $anioSiguiente; ?>'">Mes Siguiente &gt;</button>
            </div>
            <table class="calendar-table">
                <thead>
                    <tr>
                        <th>L</th>
                        <th>M</th>
                        <th>X</th>
                        <th>J</th>
                        <th>V</th>
                        <th>S</th>
                        <th>D</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once '../modelo/conexion.php';

                    // Número de días en el mes actual
                    $diasEnMes = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
                    $primerDiaSemana = date('N', strtotime("$anio-$mes-01")); // Día de la semana del 1er día (1 = Lunes, 7 = Domingo)

                    $diaActual = 1;

                    // Generar filas del calendario
                    for ($semana = 0; $semana < 6; $semana++) {
                        echo "<tr>";

                        for ($diaSemana = 1; $diaSemana <= 7; $diaSemana++) {
                            if ($semana === 0 && $diaSemana < $primerDiaSemana || $diaActual > $diasEnMes) {
                                echo "<td></td>"; // Celda vacía
                            } else {
                                // Consultar número de citas para este día
                                $fecha = "$anio-$mes-" . str_pad($diaActual, 2, '0', STR_PAD_LEFT);
                                $consultaCitas = "SELECT COUNT(*) AS total_citas FROM cita WHERE fecha_cita = '$fecha'";
                                $resultadoCitas = $conn->query($consultaCitas);
                                $totalCitas = $resultadoCitas ? $resultadoCitas->fetch_assoc()['total_citas'] : 0;

                                // Mostrar día y número de citas
                                echo "<td>$diaActual<br>$totalCitas citas</td>";
                                $diaActual++;
                            }
                        }

                        echo "</tr>";

                        if ($diaActual > $diasEnMes) {
                            break; // Salir si ya se mostraron todos los días del mes
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="gestionar-citas">
            <h2>Añadir Cita</h2>
            <form action="../vista/procesarCitas.php" method="POST">
                <!-- Seleccionar Usuario -->
                <div>
                    <label for="id_usuario">Seleccionar Usuario:</label>
                    <select name="id_usuario" id="id_usuario" required>
                        <option value="" disabled selected>Selecciona un usuario</option>
                        <?php
                        require_once '../modelo/conexion.php';
                        $consultaUsuarios = "SELECT id_usuario, nombre FROM usuario";
                        $resultadoUsuarios = $conn->query($consultaUsuarios);

                        if ($resultadoUsuarios->num_rows > 0) {
                            while ($fila = $resultadoUsuarios->fetch_assoc()) {
                                echo "<option value='{$fila['id_usuario']}'>{$fila['nombre']}</option>";
                            }
                        } else {
                            echo "<option value='' disabled>No hay usuarios disponibles</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Seleccionar Servicio -->
                <div>
                    <label for="id_servicio">Seleccionar Servicio:</label>
                    <select name="id_servicio" id="id_servicio" required>
                        <option value="" disabled selected>Selecciona un servicio</option>
                        <?php
                        $consultaServicios = "SELECT id_servicio, nombre FROM servicio";
                        $resultadoServicios = $conn->query($consultaServicios);

                        while ($fila = $resultadoServicios->fetch_assoc()) {
                            echo "<option value='{$fila['id_servicio']}'>{$fila['nombre']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Seleccionar Fecha -->
                <div>
                    <label for="fecha_cita">Fecha de la Cita:</label>
                    <input type="date" name="fecha_cita" id="fecha_cita" required onchange="actualizarHorasDisponibles()">
                </div>

                <!-- Seleccionar Hora -->
                <div>
                    <label for="hora_cita">Hora de la Cita:</label>
                    <select name="hora_cita" id="hora_cita" required>
                        <option value="" disabled selected>Selecciona una hora</option>
                        <!-- Las opciones se actualizarán dinámicamente -->
                    </select>
                </div>

                <!-- Seleccionar Estado -->
                <div>
                    <label for="estado">Estado:</label>
                    <select name="estado" id="estado" required>
                        <option value="pendiente">Pendiente</option>
                        <option value="confirmada">Confirmada</option>
                        <option value="cancelada">Cancelada</option>
                        <option value="completada">Completada</option>
                    </select>
                </div>

                <!-- Botón de Enviar -->
                <div>
                    <button type="submit" name="accion" value="añadir">Añadir Cita</button>
                </div>
            </form>
        </div>

        <div class="gestionar-citas">
        <h2>Modificar Citas</h2>
        <table border="1" style="width: 100%; text-align: center;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Servicio</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once '../modelo/conexion.php';
                $sql = "SELECT c.id_cita, u.nombre AS usuario, s.nombre AS servicio, c.fecha_cita, c.hora_cita, c.estado 
                        FROM cita c
                        JOIN usuario u ON c.id_usuario = u.id_usuario
                        JOIN servicio s ON c.id_servicio = s.id_servicio";
                $resultado = $conn->query($sql);

                if ($resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$fila['id_cita']}</td>";
                        echo "<td>{$fila['usuario']}</td>";
                        echo "<td>{$fila['servicio']}</td>";
                        echo "<td>{$fila['fecha_cita']}</td>";
                        echo "<td>{$fila['hora_cita']}</td>";
                        echo "<td>{$fila['estado']}</td>";
                        echo "<td>
                                <button onclick=\"modificarCita({$fila['id_cita']})\">Modificar</button>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No hay citas disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="gestionar-citas">
        <h2>Eliminar Citas</h2>
        <table border="1" style="width: 100%; text-align: center;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Servicio</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once '../modelo/conexion.php';
                $sql = "SELECT c.id_cita, u.nombre AS usuario, s.nombre AS servicio, c.fecha_cita, c.hora_cita, c.estado 
                        FROM cita c
                        JOIN usuario u ON c.id_usuario = u.id_usuario
                        JOIN servicio s ON c.id_servicio = s.id_servicio";
                $resultado = $conn->query($sql);

                if ($resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$fila['id_cita']}</td>";
                        echo "<td>{$fila['usuario']}</td>";
                        echo "<td>{$fila['servicio']}</td>";
                        echo "<td>{$fila['fecha_cita']}</td>";
                        echo "<td>{$fila['hora_cita']}</td>";
                        echo "<td>{$fila['estado']}</td>";
                        echo "<td>
                                <form action='procesarEliminarCita.php' method='POST' style='display:inline;'>
                                    <input type='hidden' name='id_cita' value='{$fila['id_cita']}'>
                                    <button type='submit' style='background-color: #D32F2F; color: white; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;'>Eliminar</button>
                                </form>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No hay citas disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>