<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de Contacto</title>
    <!-- Añadir el enlace de Google Fonts para Alverta -->
    <link href="https://fonts.googleapis.com/css2?family=Alverta&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Alverta', sans-serif; /* Aplicar la fuente Alverta */
        }

        .content-container {
            display: flex; /* Organización horizontal */
            justify-content: flex-start; /* Texto y mapas alineados al inicio */
            align-items: flex-start; /* Alinear elementos en la parte superior */
            gap: 20px; /* Espaciado entre texto y mapas */
            margin: 20px; /* Espaciado general */
        }

        .columnac, .map-container {
            width: 50%; /* Ajusta el ancho de cada columna */
        }

        .columnac h3 {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }

        .columnac p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 10px;
            color: #555;
        }

        .map-container {
            display: flex;
            flex-direction: column; /* Organización vertical para mapas */
            gap: 20px; /* Espaciado entre mapas */
        }

        .map-wrapper {
            cursor: pointer; /* Añadir cursor para interacción */
            width: 100%; /* Ajusta el ancho al contenedor */
            height: 350px; /* Ajusta la altura */
            border: 1px solid #ddd; /* Borde opcional */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra opcional */
            overflow: hidden; /* Evita que el contenido desborde */
            border-radius: 5px; /* Bordes redondeados */
        }

        iframe {
            width: 100%; /* Asegura que el iframe ocupe el contenedor */
            height: 100%;
            border: none; /* Elimina bordes del iframe */
        }
    </style>
</head>
<body>
    <div class="content-container">
        <!-- Columna de Información -->
        <div class="columnac">
            <h3>Direcciones</h3>
            <p>Calle Pozodulce 43, Arahal, Sevilla</p>
            <p>Calle San Juan Bosco, 23 Local 3, Utrera, Sevilla</p>
            <br>
            <h3>Email</h3>
            <p>cliclicarayo@gmail.com</p>
            <h3>Horario</h3>
            <p>
                Depende de intervenciones, <br>
                contactar por teléfono para<br>
                más información de horarios.
            </p>          
            <br>
            <h3>Teléfono</h3>  
            <p>Tel: 954841159 (llamadas)</p>
            <p>Tel: 644248375 (whatsapp)</p>
            <br>
            <h3>Redes Sociales</h3> 
            <p>Instagram: clinicarayo</p>
            <br>
        </div>

        <!-- Contenedor de mapas -->
        <div class="map-container">
            <!-- Primer mapa (Arahal) -->
            <div class="map-wrapper" onclick="window.open('https://maps.app.goo.gl/2fJ4JBh9SWquCkZP8', '_blank')">
                <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3175.3197058264973!2d-5.5419399!3d37.2638452!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd129b5d4aedbfd3%3A0x5488452ea8515656!2sC.%20Pozo%20Dulce%2C%2043%2C%2041600%20Arahal%2C%20Sevilla!5e0!3m2!1ses!2ses!4v1734571492102!5m2!1ses!2ses"></iframe>
            </div>

            <!-- Segundo mapa (Utrera) -->
            <div class="map-wrapper" onclick="window.open('https://maps.app.goo.gl/PcMbz3HnZMHGTDnJ8', '_blank')">
                <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6357.704542277708!2d-5.7777433999999985!3d37.1799816!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd127f0c9b32fc8b%3A0xbd2d52465b4e0b5e!2sC.%20de%20San%20Juan%20Bosco%2C%2023%2C%2041710%20Utrera%2C%20Sevilla!5e0!3m2!1ses!2ses!4v1734571532771!5m2!1ses!2ses"></iframe>
            </div>
        </div>
    </div>
</body>
</html>
