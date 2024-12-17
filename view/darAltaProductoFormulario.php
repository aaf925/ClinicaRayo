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

        .inputNombre, .inputPrecio, .inputCantidad, .inputImagen {
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

        .inputCantidad {
            float: right;
        }

        .botonArchivo {
            float: left;
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

        label#cantidad {
            padding-left: 180px;
        }

        input#cantidad {
            width: 70px;
            margin-left: 10px;
        }

        .inputCantidad {
            margin-top: 10px;
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

    </style>
</head>
<body>
    <!-- Incluye el menú superior -->
    <?php require_once 'menuAdmin.php'; ?>

    <br>
    <br>

    <div class = "formulario">
        <div class = "tituloFormulario"><h1 style = "color: white; padding: 10px; ">Formulario para dar de alta un producto</h1></div>
        <div class = "inputsFormulario">
            <form action="darAltaProducto.php" method="post" enctype="multipart/form-data">
                <div class = "inputNombre">
                    <label for="nombre">Nombre:</label>
                    <br>
                    <input type="text" id="nombre" name="nombre" required placeholder="Ingrese el nombre del producto">
                </div>
                <div class = "inputPrecio">
                    <label for="precio">Precio:</label>
                    <br>
                    <input type="double" id="precio" name="precio" min="0" required placeholder="Ingrese el precio del producto">
                </div>
                <div class = "inputDescripcion">
                    <label for="descripcion">Descripci&oacute;n:</label>
                    <br>
                    <textarea type="text" id="descripcion" name="descripcion" required placeholder="Ingrese la descripci&oacute;n del producto"></textarea>
                </div>
                <div class = "inputImagen">
                    <label>Foto:</label>
                    <br>
                    <input type="file" id="imagen" name="imagen" accept = ".jpg, .jpeg, .png" required>
                </div>
                <div class = "inputCantidad">
                    <label for="cantidad" id="cantidad">Cantidad:</label>
                    <input type="number" id="cantidad" name="cantidad" required min="1">
                </div>
                <button class="botonCancelar" type="button" onclick="window.location.href='panelAdmin.php';">Cancelar</button>
                <button class = "botonGuardar" type="submit">Guardar</button>
            </form>
            <?php
                include('darAltaProducto.php');
            ?>
        </div>
    </div>
    
</body>
</html>
