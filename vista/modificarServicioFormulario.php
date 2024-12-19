<?php
require_once '../modelo/conexion.php';

// Verificar si el ID del servicio fue enviado
if (isset($_GET['id_servicio'])) {
    $id_servicio = $conn->real_escape_string($_GET['id_servicio']);

    // Consulta para obtener los datos del servicio
    $sql = "SELECT * FROM servicio WHERE id_servicio = '$id_servicio'";
    $resultado = $conn->query($sql);

    if ($resultado && $fila = $resultado->fetch_assoc()) {
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Modificar Producto</title>
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

                .inputNombre, .inputPrecio {
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
                    width: 100%;
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
            <?php require_once '../vista/menuAdmin.php'; ?>
            
            <br>
            <br>

            <div class="formulario">
                <div class = "tituloFormulario"><h1 style = "color: white; padding: 10px; ">Formulario para Modificar un servicio</h1></div>
                <div class="inputsFormulario">
                    <form action="../vista/guardarModificacionServicio.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_servicio" value="<?php echo $id_servicio; ?>">

                        <div class = "inputNombre">
                            <label for="nombre">Nombre:</label>
                            <br>
                            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($fila['nombre']); ?>" placeholder="Ingrese el nombre del servicio" required>
                        </div>

                        <div class = "inputPrecio">
                            <label for="precio">Precio:</label>
                            <br>
                            <input type="double" id="precio" name="precio" min="0" value="<?php echo htmlspecialchars($fila['precio']); ?>" placeholder="Ingrese el precio del servicio" required>
                        </div>

                        <div class = "inputDescripcion">
                            <label for="descripcion">Descripci&oacute;n:</label>
                            <br>
                            <textarea type="text" id="descripcion" name="descripcion" required placeholder="Ingrese la descripci&oacute;n del servicio"><?php echo htmlspecialchars($fila['descripcion']); ?></textarea>
                        </div>

                        <div class = "inputImagen">
                            <label for="imagen">Foto:</label>
                            <br>
                            <input type="file" id="imagen" name="imagen" accept=".jpg, .jpeg, .png">
                            <?php if (!empty($fila['imagen_url'])): ?>
                                <div class = "imagenActual" style="display: flex; justify-content: center; align-items: center; padding: 50px;">
                                    <img style="max-width: 100%; height: auto;" src="<?php echo htmlspecialchars($fila['imagen_url']); ?>" alt="Imagen actual">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="botonesFormulario">
                            <button class="botonCancelar" type="button" onclick="window.location.href='../vista/gestionServicios.php';">Cancelar</button>
                            <button class = "botonGuardar" type="submit">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
            <?php if (isset($_GET['modificacion']) && $_GET['modificacion'] === 'exito'): ?>
            <div class="modal-overlay" onclick="window.location.href='../vista/gestionServicios.php';">
            <div class="modal">
                Servicio modificado correctamente<br>
                (Haga clic en cualquier parte para continuar)
            </div>
        </div>
    <?php endif; ?>
        </body>
        </html>
        <?php
    } else {
        echo "Error: Servicio no encontrado.";
    }
} else {
    echo "Error: ID de servicio no recibido.";
}
$conn->close();
?>