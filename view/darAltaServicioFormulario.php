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

        .inputNombre, .inputPrecio, .inputImagen {
            width: 400px;
        }

        .inputNombre {
            float: left;
        }

        .inputPrecio {
            float: right;
        }

        .inputDescripcion {
            float: left;
        }

        .inputImagen {
            float: left;
        }

        .botonArchivo {
            float: left;
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

        input {
            margin-left: 50px;
            margin-top: 20px;
            margin-bottom: 20px;
            width: 300px;
            height: 50px;
            font-size: 20px;
            font-family: 'Alverta', sans-serif;
        }

        textarea {
            margin-left: 50px;
            margin-top: 20px;
            margin-bottom: 20px;
            width: 700px;
            height: 300px;
            font-size: 20px;
            resize: none;
            font-family: 'Alverta', sans-serif;
        }

        input#imagen {
            width: 600px;
            cursor: pointer;
        }

        input#imagen::file-selector-button {
            background-color: #111C4E;
            color: white;
            font-size: 20px;
            padding: 10px;
            font-family: 'Alverta', sans-serif;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }

        input#imagen::file-selector-button:hover {
            background-color: #0D1637;
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

    </style>
</head>
<body>
    <!-- Incluye el menú superior -->
    <?php require_once 'menuAdmin.php'; ?>

    <br>
    <br>

    <div class = "formulario">
        <div class = "tituloFormulario"><h1 style = "color: white; padding: 10px; ">Formulario para dar de alta un servicio</h1></div>
        <div class = "inputsFormulario">
            <form action="darAltaServicio.php" method="post" enctype="multipart/form-data">
                <div class = "inputNombre">
                    <label for="nombre">Nombre:</label>
                    <br>
                    <input type="text" id="nombre" name="nombre" required placeholder="Ingrese el nombre del servicio">
                </div>
                <div class = "inputPrecio">
                    <label for="precio">Precio:</label>
                    <br>
                    <input type="double" id="precio" name="precio" min="0" required placeholder="Ingrese el precio del servicio">
                </div>
                <div class = "inputDescripcion">
                    <label for="descripcion">Descripci&oacute;n:</label>
                    <br>
                    <textarea type="text" id="descripcion" name="descripcion" required placeholder="Ingrese la descripci&oacute;n del servicio"></textarea>
                </div>
                <div class = "inputImagen">
                    <label>Foto:</label>
                    <br>
                    <input type="file" id="imagen" name="imagen" accept = ".jpg, .jpeg, .png" required>
                </div>
                <div class="botonesFormulario">
                    <button class="botonCancelar" type="button" onclick="window.location.href='gestionServicios.php';">Cancelar</button>
                    <button class = "botonGuardar" type="submit">Guardar</button>
                </div>
            </form>
            <?php
                include('darAltaServicio.php');
            ?>
        </div>
    </div>
    <!-- Modal -->
    <?php if (isset($_GET['success']) && $_GET['success'] === 'true'): ?>
    <div class="modal-overlay" onclick="window.location.href='gestionServicios.php';">
        <div class="modal">
            Servicio añadido correctamente<br>
            (Haga clic en cualquier parte para continuar)
        </div>
    </div>
    <?php endif; ?>
</body>
</html>
