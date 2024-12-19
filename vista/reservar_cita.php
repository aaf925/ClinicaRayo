<?php 
include_once ('../modelo/conexion.php');

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $comentario = $_POST['comentarios'];
    $fecha_cita = $_POST['dia'];
    $hora_cita = $_POST['hora'];

    // Convertir fecha al formato MySQL
    $fecha_cita = date("Y-m-d", strtotime(str_replace('/', '-', $fecha_cita)));

    // Obtener el valor máximo actual de id_cita
    $resultado = $conn->query("SELECT MAX(id_cita) as maximo FROM cita");
    if ($fila = $resultado->fetch_object()) {
        $newId = $fila->maximo + 1;
    } else {
        $newId = 1;
    }

    // Insertar en la tabla 'cita'
    $cadenaSQL2 = "INSERT INTO cita (id_cita, id_usuario, id_servicio, fecha_cita, hora_cita, estado)
                   VALUES ('$newId', '0', '0', '$fecha_cita', '$hora_cita', 'pendiente')";
    
    if ($conn->query($cadenaSQL2) === TRUE) {
        //echo "<script>alert('Cita agendada correctamente');</script>";
    } else {
        echo "Error: " . $cadenaSQL . "<br>" . $conn->error;
    }

    // Insertar en la tabla 'datos_cita' (orden correcto)
    $cadenaSQL = "INSERT INTO datos_cita (nombre, email, fecha_cita, comentario, telefono, hora_cita, estado, id_cita)
                  VALUES ('$nombre', '$email', '$fecha_cita', '$comentario', '$telefono', '$hora_cita', 'pendiente', '$newId')";
     if ($conn->query($cadenaSQL) === TRUE) {
        //echo "<script>alert('Cita agendada correctamente');</script>";
    } else {
        echo "Error: " . $cadenaSQL . "<br>" . $conn->error;
    }
    $fechas = [];
    $resultado = $conn->query("SELECT dia, estado FROM admin_cita");
    while ($row = $resultado->fetch_assoc()) {
    $fechas[] = $row; // Agregar todas las fechas y estados a un array
}

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda tu Cita</title>
    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@700&display=swap" rel="stylesheet">
    <style>
        /* General */
        body {
            font-family: 'Alverta', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f4f4f4;
        }

        .container {
            
            align-items: flex-start;
            
            margin: 20px auto;
            padding: 20px;
            max-width: 2000px;
            width: 90%;
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
            gap: 160px;
            margin-bottom: 100px;
            background-color: #f4f4f4; 

        }

        /* Formulario */
        .form-container {
            width: 50%;
            display: flex;
            flex-direction: column;
        }

        .form-container h2 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: #111C4E;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #111C4E;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            color: #333;
            box-sizing: border-box;
        }

        .form-group textarea {
            resize: none;
            height: 100px;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #111C4E;
        }

        .submit-btn {
            background-color: #111C4E;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #0D1637;
        }

        /* Calendario */
        .calendar-container {
            width: 45%;
            text-align: center;
        }

        .calendar-container h4 {
            font-size: 0.9rem;
            color: black;
            margin-bottom: 10px;
            
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f4f4f4;
            padding: 10px;
            font-weight: bold;
            border: 2px solid #000000;
        }

        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            border: 2px solid #000000;
        }

        .calendar div {
            padding: 10px;
            border: 2px solid #000000;
            text-align: center;
            font-size: 1.9rem;
            font-weight: bold;
            color: #000000;
        }

        .calendar div span {
            
            display: block;
            font-size: 0.8rem;
            color: gray;
            margin-top: 5px;
        }

        .calendar .header {
            background-color: #f4f4f4;
            font-weight: bold;
            color: #111C4E;
        }

        /* Flechas */
        .arrow {
            cursor: pointer;
            font-size: 1.2rem;
            color: #000000;
            transition: color 0.3s;
        }

        .arrow:hover {
            color: #000000;
        }
        .calendar .other-month {
            color: #aaa; /* Color gris para días del otro mes */
        }
          /* Estilos del calendario */
          .calendar .completada {
            border-bottom: 5px solid red;
        }
        .calendar .disponible {
            border-bottom: 5px solid green;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Formulario -->
        <div class="form-container">
            <h2>Agenda aquí tu cita</h2>
            <form action="" method="POST">
    <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" placeholder="Ejemplo">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="correo@gmail.com">
    </div>
    <div class="form-group">
        <label for="telefono">Teléfono</label>
        <input type="tel" id="telefono" name="telefono" placeholder="XXX XX XX XX">
    </div>
    <div class="form-group">
        <label for="dia">Selecciona día</label>
        <select id="dia" name="dia">
            <option value="" disabled selected>Selecciona un día</option>
        </select>
    </div> 
    <div class="form-group">
        <label for="hora">Selecciona una hora</label>
        <select id="hora" name="hora" required>
            <option value="" disabled selected>Selecciona una hora</option>
            <option value="09:00:00">09:00 AM</option>
            <option value="10:00:00">10:00 AM</option>
            <option value="11:00:00">11:00 AM</option>
            <option value="14:00:00">02:00 PM</option>
            <option value="15:00:00">03:00 PM</option>
        </select>
    </div>
    <div class="form-group">
        <label for="comentarios">Comentarios</label>
        <textarea id="comentarios" name="comentarios" placeholder="Ejemplo"></textarea>
    </div>
    <button type="submit" class="submit-btn">Enviar</button>
</form>

        </div>

        <!-- Calendario -->
        <div class="calendar-container">
            <h4>solo se aceptarán citas con datos correctos</h4>
            <div class="calendar-header">
                <span class="arrow" id="prev">&#9664;</span>
                <span id="monthYear"></span>
                <span class="arrow" id="next">&#9654;</span>
            </div>
            <div class="calendar" id="calendar">
                <!-- Encabezados del calendario -->
                <div class="header">L</div>
                <div class="header">M</div>
                <div class="header">X</div>
                <div class="header">J</div>
                <div class="header">V</div>
                <div class="header">S</div>
                <div class="header">D</div>
            </div>
        </div>
    </div>
    <script>
        const calendar = document.getElementById("calendar");
const monthYear = document.getElementById("monthYear");
const prev = document.getElementById("prev");
const next = document.getElementById("next");
const dayDropdown = document.getElementById("dia");

const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
let currentDate = new Date();
// Fechas y estados obtenidos del servidor (PHP)
const fechas = <?php echo json_encode($fechas); ?>;

function renderCalendar(date) {
    // Eliminar días actuales
    calendar.querySelectorAll(".day").forEach(day => day.remove());
    dayDropdown.innerHTML = '<option value="" disabled selected>Selecciona un día</option>';

    const year = date.getFullYear();
    const month = date.getMonth();
    monthYear.textContent = `${months[month]} ${year}`;

    const firstDay = new Date(year, month, 1).getDay();
    const totalDays = new Date(year, month + 1, 0).getDate();

    // Ajustar el primer día (lunes = 1)
    const adjustedFirstDay = firstDay === 0 ? 6 : firstDay - 1;

    // Días del mes anterior
    const lastDayPrevMonth = new Date(year, month, 0).getDate();
    for (let i = adjustedFirstDay; i > 0; i--) {
        const dayDiv = document.createElement("div");
        dayDiv.textContent = lastDayPrevMonth - i + 1;
        dayDiv.classList.add("day", "other-month");
        calendar.appendChild(dayDiv);
    }

    // Días del mes actual
    for (let day = 1; day <= totalDays; day++) {
        const currentDay = new Date(year, month, day);
        const dayOfWeek = currentDay.getDay(); // 0: domingo, 1: lunes, ..., 6: sábado
        const formattedDate = currentDay.toISOString().split('T')[0];
        const dayDiv = document.createElement("div");
        dayDiv.textContent = day;
        dayDiv.classList.add("day");
         // Buscar la fecha en el array fechas
         const fecha = fechas.find(f => f.dia === formattedDate);
        if (fecha) {
            if (fecha.estado === "completada") {
                    dayDiv.classList.add("completada");
            } else {
                    dayDiv.classList.add("disponible");
                    }
                }

        // Agregar días de lunes (1) a viernes (5) al desplegable
        if (dayOfWeek >= 1 && dayOfWeek <= 5) {
            const option = document.createElement("option");
            const formattedDate = `${day}/${month + 1}/${year}`;
            option.value = formattedDate;
            option.textContent = formattedDate;
            dayDropdown.appendChild(option);
        }

        calendar.appendChild(dayDiv);
    }

    // Días del próximo mes
    const remainingDays = 42 - (adjustedFirstDay + totalDays);
    for (let i = 1; i <= remainingDays; i++) {
        const dayDiv = document.createElement("div");
        dayDiv.textContent = i;
        dayDiv.classList.add("day", "other-month");
        calendar.appendChild(dayDiv);
    }
}

prev.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar(currentDate);
});

next.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar(currentDate);
});

renderCalendar(currentDate);

    </script>

</body>
</html>
