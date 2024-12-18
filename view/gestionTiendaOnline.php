<?php
require_once 'conexion.php'; // Conexión a la base de datos
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

        .gestionTiendaOnline {
            background-color: #1A428A;
            width: 800px;
            margin: auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px grey;
            color: white;
            text-align: center;
        }

        .tituloTiendaOnline {
            background-color: #111C4E;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .productos {
            background-color: #f4f4f4;
            color: black;
            padding: 20px;
            border-radius: 8px;
            overflow-y: auto;
            max-height: 300px; /* Permite scroll vertical */
            text-align: left;
        }

        .producto-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .producto-item:last-child {
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
    <?php require_once 'menuAdmin.php'; ?>

    <br>
    <br>

    <div class="gestionTiendaOnline">
        <div class="tituloTiendaOnline">
            Tienda Online
        </div>

        <!-- Formulario para enviar los IDs seleccionados -->
        <form action="darDeBajaProducto.php" method="POST">
            <div class="productos">
                <?php
                require_once 'conexion.php';
                
                // Consulta para obtener los productos
                $sql = "SELECT id_producto, nombre, precio, imagen_url, vendido, stock FROM producto";
                $resultado = $conexion->query($sql);

                if ($resultado && $resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        $cantidad_vendida = $fila['vendido'];
                        $ganancia = $cantidad_vendida * $fila['precio'];

                        echo "<div class='producto-item'>";
                        echo "ID: {$fila['id_producto']} | Producto: {$fila['nombre']} | P/U: {$fila['precio']} € | Stock: {$fila['stock']} | Vendido: {$fila['vendido']} | Ganancia: $ganancia €";
                        echo "<input type='checkbox' name='productos[]' value='{$fila['id_producto']}'> "; // Checkbox con el ID
                        echo "<input type='hidden' name='imagenes[{$fila['id_producto']}]' value='{$fila['imagen_url']}'>"; // Ruta de la imagen
                        echo "</div>";
                    }
                } else {
                    echo "<p>No hay productos disponibles.</p>";
                }
                $conexion->close();
                ?>
            </div>

            <div class="buttons">
                <button type="button" onclick="window.location.href='darAltaProductoFormulario.php';">Dar de alta nuevo producto</button>
                <button onclick="window.location.href='modificarProductoFormulario.php';">Modificar productos</button>
                <button type="submit" name="borrar">Dar de baja producto</button>
            </div>            
        </form>
    </div>
</body>
</html>
