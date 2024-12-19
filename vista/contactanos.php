<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>

    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@600;700;900&display=swap" rel="stylesheet">

    <style>
        body {
            display: flex;
            justify-content: space-between;
            font-family: 'Alverta', sans-serif;
            margin: 0;
            padding: 0;
        }

        .columnac {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-left: 50px;
            margin-bottom: 150px;
            margin-top: 20px;
        }

        /* Títulos principales */
        .columnac h3 {
            margin: 2;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        /* Texto secundario  */
        .columnac p,
        .columnac a {
            margin: 0.5px 0;
            color: black;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            line-height: 24px;
        }

        .columnac a:hover {
            text-decoration: underline;
        }

        .map-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-right: 200px;
            margin-top: 20px;
        }

        .map-wrapper {
            width: 600px;
            height: 400px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
        }

        .map-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
    </style>
</head>
<body>
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

    <!-- Contenedor de Mapas -->
    <div class="map-container">
        <!-- Primer mapa (Arahal) -->
        <div class="map-wrapper" onclick="window.open('https://maps.app.goo.gl/2fJ4JBh9SWquCkZP8', '_blank')">
            <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3175.3197058264973!2d-5.5419399!3d37.2638452!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd129b5d4aedbfd3%3A0x5488452ea8515656!2sC.%20Pozo%20Dulce%2C%2043%2C%2041600%20Arahal%2C%20Sevilla!5e0!3m2!1ses!2ses!4v1734571492102!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        <!-- Segundo mapa (Utrera) -->
        <div class="map-wrapper" onclick="window.open('https://maps.app.goo.gl/PcMbz3HnZMHGTDnJ8', '_blank')">
            <iframe
             src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6357.704542277708!2d-5.7777433999999985!3d37.1799816!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd127f0c9b32fc8b%3A0xbd2d52465b4e0b5e!2sC.%20de%20San%20Juan%20Bosco%2C%2023%2C%2041710%20Utrera%2C%20Sevilla!5e0!3m2!1ses!2ses!4v1734571532771!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</body>
</html>