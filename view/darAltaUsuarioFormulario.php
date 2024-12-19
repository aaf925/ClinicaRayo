<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dar de alta un producto</title>

    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@900;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Alverta', sans-serif;
            background-color: #f4f4f4;
        }

        div {
            font-family: 'Alverta', sans-serif;
        }

        .formulario {
            position: relative;
            background-color: #1A428A;
            width: 800px;
            height: auto;
            margin: auto;
            padding-left: 0px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px grey;
        }

        .tituloFormulario {
            text-align: center;
            background-color: #111C4E;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .inputsFormulario {
            height: auto;
            margin-bottom: 100px;
            align-items: center;
        }

        .inputNombre, .inputApellidos, .inputTipoUsuario, .inputCorreo, .inputContrasena, .inputTelefono {
            width: 400px;
        }

        .inputNombre {
            float: left;
        }

        .inputApellidos {
            float: right;
        }

        .inputTipoUsuario {
            float: left;
        }

        .inputCorreo {
            float: left;
            width: 100%;
        }

        .inputContrasena {
            float: left;
        }

        .inputTelefono {
            float: right;
        }

        .botonesFormulario {
            width: 800px;
            height: auto;
            gap: 100px;
            padding-bottom: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .botonGuardar, .botonCancelar {
            background-color: #111C4E;
            color: white;
            font-size: 20px;
            padding: 10px;
            font-family: 'Alverta', sans-serif;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        label {
            color: white;
            padding-left: 50px;
            font-size: 20px;
            font-family: 'Alverta', sans-serif;
        }

        input, select {
            margin-left: 50px;
            margin-top: 20px;
            margin-bottom: 20px;
            width: 300px;
            height: 50px;
            font-size: 20px;
            font-family: 'Alverta', sans-serif;
        }

        input#correo {
            width: 700px;
        }

        .botonGuardar:hover, .botonCancelar:hover {
            background-color: #0D1637;
        }

        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999;
        }
        .modal {
            background-color: #1A428A;
            color: white;
            padding: 20px 40px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            font-size: 1.5rem;
            cursor: pointer;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 15px;
            text-align: center;
        }

    </style>
    <script>

        // Función para validar el formato del correo electrónico
        function validarCorreo(input) {
            const correo = input.value.trim();
            const regexCorreo = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/; // Expresión regular para validar correos
            const mensajeError = document.getElementById("correoError");

            if (!regexCorreo.test(correo)) {
                mensajeError.textContent = "Por favor, introduzca un correo electrónico válido.";
                mensajeError.style.display = "block";
                return false;
            } else {
                mensajeError.textContent = "";
                mensajeError.style.display = "none";
                return true;
            }
        }

        // Función para validar el formato del teléfono
        function validarTelefono(input) {
            const telefono = input.value.trim();
            const regexTelefono = /^[6-9]\d{8}$/; // Patrón para números españoles
            const mensajeError = document.getElementById("telefonoError");

            if (!regexTelefono.test(telefono)) {
                mensajeError.textContent = "Por favor, introduzca un número de teléfono válido.";
                mensajeError.style.display = "block";
                return false;
            } else {
                mensajeError.textContent = "";
                mensajeError.style.display = "none";
                return true;
            }
        }

        // Función para verificar contraseñas en tiempo real
        function verificarContrasenasTiempoReal() {
            const contrasena = document.getElementById("inputContrasena").value.trim();
            const confContrasena = document.getElementById("confirmContrasena").value.trim();
            const mensajeError = document.getElementById("contrasenaError");

            // Comprobar si las contraseñas coinciden
            if (confContrasena.length > 0 && contrasena !== confContrasena) {
                mensajeError.textContent = "Las contraseñas no coinciden.";
                mensajeError.style.display = "block";
            } else {
                mensajeError.textContent = "";
                mensajeError.style.display = "none";
            }
        }

        // Función para validar todo al enviar el formulario
        function validarFormulario(event) {
            const correoInput = document.getElementById("correo");
            const correoValido = validarCorreo(correoInput);

            const telefonoInput = document.getElementById("telefono");
            const telefonoValido = validarTelefono(telefonoInput);

            const contrasenaError = document.getElementById("contrasenaError");
            const contrasenaValida = contrasenaError.textContent === "";

            // Prevenir envío si hay errores
            if (!telefonoValido || !contrasenaValida || !correoValido) {
                event.preventDefault();
                return false;
            }

            // Encriptar contraseña antes de enviar
            const contrasenaInput = document.getElementById("inputContrasena");
            contrasenaInput.value = btoa(contrasenaInput.value.trim());
        }
    </script>
</head>
<body>
    <!-- Incluye el menú superior -->
    <?php require_once 'menuAdmin.php'; ?>

    <br>
    <br>

    <div class = "formulario">
        <div class = "tituloFormulario"><h1 style = "color: white; padding: 10px; ">Formulario para dar de alta un usuario</h1></div>
        <div class = "inputsFormulario">
            <form action="darAltaUsuario.php" method="post" enctype="multipart/form-data" onsubmit="validarFormulario(event);">
                <div class = "inputNombre">
                    <label for="nombre">Nombre:</label>
                    <br>
                    <input type="text" id="nombre" name="nombre" required placeholder="Nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios en blanco">
                </div>
                <div class = "inputApellidos">
                    <label for="apellidos">Apellidos:</label>
                    <br>
                    <input type="text" id="apellidos" name="apellidos" required placeholder="Apellidos" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios en blanco">
                </div>
                <div class = "inputTipoUsuario">
                    <label for="tipoUsuario">Tipo de usuario:</label>
                    <br>
                    <select id="tipoUsuario" name="tipoUsuario" required>
                        <option value="" disabled selected>Seleccione el tipo de usuario</option>
                        <option value="cliente">Cliente</option>
                        <option value="administrador">Administrador</option>
                    </select>
                </div>
                <div class="inputTelefono">
                    <label for="telefono">Telefono:</label>
                    <br>
                    <input type="tel" id="telefono" name="telefono" required placeholder="Ingrese el telefono" pattern="[6-9]\d{8}" oninput="validarTelefono(this)">
                    <div id="telefonoError" class="error"></div>
                </div>
                <div class = "inputCorreo">
                    <label for="correo">Correo electrónico:</label>
                    <br>
                    <input type="text" id="correo" name="correo" required placeholder="Ingrese el correo" oninput="validarCorreo(this)">
                    <div id="correoError" class="error"></div>
                </div>
                <div class = "inputContrasena">
                    <label for="inputContrasena" id="contrasena">Contraseña:</label>
                    <br>
                    <input type="password" id="inputContrasena" name="inputContrasena" required placeholder="******************" oninput="verificarContrasenasTiempoReal()">
                </div>
                <div class = "inputContrasena">
                    <label for="confirmContrasena" id="confContrasena">Confirmar contraseña:</label>
                    <br>
                    <input type="password" id="confirmContrasena" name="confirmContrasena" required placeholder="******************" oninput="verificarContrasenasTiempoReal()">
                    <div id="contrasenaError" class="error"></div>
                </div>
                <div class="botonesFormulario">
                    <button class="botonCancelar" type="button" onclick="window.location.href='gestionUsuarios.php';">Cancelar</button>
                    <button class = "botonGuardar" type="submit">Guardar</button>
                </div>
            </form>
            <?php
                include('darAltaUsuario.php');
            ?>
        </div>
    </div>
    <!-- Modal -->
    <?php if (isset($_GET['success']) && $_GET['success'] === 'true'): ?>
    <div class="modal-overlay" onclick="window.location.href='gestionUsuarios.php';">
        <div class="modal">
            Usuario añadido correctamente<br>
            (Haga clic en cualquier parte para continuar)
        </div>
    </div>
    <?php endif; ?>

    <!-- Modal de Error -->
    <?php if (isset($_GET['error']) && $_GET['error'] === 'correo_existente'): ?>
    <div class="modal-overlay" onclick="this.style.display='none';">
        <div class="modal">
            Ya existe una cuenta con este correo electrónico.<br>
            (Haga clic para cerrar)
        </div>
    </div>
    <?php endif; ?>
</body>
</html>
