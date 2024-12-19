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

        .gestionUsuarios {
            background-color: #1A428A;
            width: 800px;
            margin: auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px grey;
            color: white;
            text-align: center;
        }

        .tituloUsuarios {
            background-color: #111C4E;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .usuarios {
            background-color: #f4f4f4;
            color: black;
            padding: 20px;
            border-radius: 8px;
            overflow-y: auto;
            max-height: 300px; /* Permite scroll vertical */
            text-align: left;
        }

        .usuario-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        .usuario-item:last-child {
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

    <div class="gestionUsuarios">
        <div class="tituloUsuarios">
            Gestión de Usuarios
        </div>

        <!-- Formulario para enviar los IDs seleccionados -->
        <form action="../vista/darDeBajaUsuario.php" method="POST">
            <div class="usuarios">
                <?php
                require_once '../modelo/conexion.php';
                
                // Consulta para obtener los usuarios
                $sql = "SELECT id_usuario, nombre, email, telefono, tipo_usuario FROM usuario";
                $resultado = $conn->query($sql);

                if ($resultado && $resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<div class='usuario-item'>";
                        echo "ID: {$fila['id_usuario']} | Nombre: {$fila['nombre']} | Email: {$fila['email']} | Telefono: {$fila['telefono']} | Tipo: {$fila['tipo_usuario']}";
                        echo "<input type='checkbox' name='usuarios[]' value='{$fila['id_usuario']}'> "; // Checkbox con el ID
                        echo "</div>";
                    }
                } else {
                    echo "<p>No hay usuarios disponibles.</p>";
                }
                $conn->close();
                ?>
            </div>
            <div class="buttons">
                <button type="button" onclick="window.location.href='../vista/darAltaUsuarioFormulario.php';">Dar de alta nuevo usuario</button>
                <button type="submit" name="borrar">Dar de baja usuario</button>
            </div>            
        </form>
    </div>
</body>
</html>