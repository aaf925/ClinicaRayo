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

        .gestionTiendaOnline {
            position: relative;
            background-color: #1A428A;
            width: 800px;
            height: auto;
            margin: auto;
            padding-left: 0px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px grey;
        }

        .tituloTiendaOnline {
            text-align: center;
            background-color: #111C4E;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
    </style>
</head>
<body>
    <!-- Incluye el menú superior -->
    <?php require_once 'menuAdmin.php'; ?>

    <br>
    <br>

    <div class = "gestionTiendaOnline">
        <div class = "tituloTiendaOnline"><h1 style = "color: white; padding: 10px; ">Tienda Online</h1></div>
        <div class = "productos"></div>
        <button class="darDeAltaNuevoProducto" type="button" onclick="window.location.href='darAltaProductoFormulario.php';">Dar de alta nuevo producto</button>
        <button class="modificarProducto" type="button" onclick="window.location.href='modificarProductoFormulario.php';">Modificar productos</button>
        <button class="darDeBajaProducto" type="button" onclick="window.location.href='darDeBajaProductoFormulario.php';">Dar de baja producto</button>
    </div>
    
</body>
</html>
