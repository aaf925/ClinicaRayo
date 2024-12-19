<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>

    <link href="https://fonts.googleapis.com/css2?family=Averta:wght@700&display=swap" rel="stylesheet">
    <style>

        /* Configuración */
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            font-family: 'Averta', sans-serif;
            display: flex;
    flex-direction: column;
    min-height: 100vh;
        }

        .logop {
            position: relative;
            top: 70px;
            left: -30px;
        }

        .pie-de-pagina {
            width: 100%;
            background-color: #1A428A; 
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px 0; 
            margin-top: auto;
        }

        .pie-de-pagina .contenidop {
            width: 90%;
            max-width: 1440px;
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px; 
        }

        .columna {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        /* Títulos principales */
        .columna h3 {
            margin: 0;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        /* Texto secundario  */
        .columna p,
        .columna a {
            margin: 0.5px 0;
            color: white;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
            line-height: 24px;
        }

        .columna a:hover {
            text-decoration: underline;
        }

        .pie-de-pagina .enlaces {
            display: flex;
            justify-content: space-around; 
            width: 100%;
            border-top: 1px solid #ffffff55;
            padding-top: 10px;
            margin-top: 20px;
        }

        .enlaces a {
            margin: 0 50px; 
            color: white;
            font-weight: 700;
            text-decoration: none;
            font-size: 16px;
        }

        .enlaces a:hover {
            text-decoration: underline;
        }

        .social {
            margin-top: 10px;
            display: flex;
            flex-direction: column; 
        }

        .social a {
            display: flex;
            align-items: center;
            margin-bottom: 10px; 
            color: white;
            font-size: 16px;
            text-decoration: none;
            font-weight: 700;
        }

        .social a img {
            width: 24px;
            height: 24px;
            margin-right: 8px;
        }

        /* Media Queries para pantallas pequeñas */
@media (max-width: 768px) {
    /* Hacer la imagen más pequeña */
    .logop {
        height: 120px; /* Ajusta el tamaño según lo necesites */
        left: 0;
        top: 0;
    }

    .pie-de-pagina .contenidop {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    /* Ajuste de márgenes y distribución en el pie de página */
    .pie-de-pagina .columna {
        align-items: center;
    }

    .enlaces {
        flex-direction: column;
        align-items: center;
    }

    .enlaces a {
        margin: 10px 0;
    }

    .social a {
        margin-bottom: 5px;
    }
}
    </style>
</head>
<body>
    <!-- Pie de página -->
    <div class="pie-de-pagina">
        <!-- Contenido principal del pie de página -->
        <div class="contenidop">
            <div class="columna">
                <img src="../controlador/images/LogoBlanco.png" alt="Logo de la Clínica" class="logop" style="height: 200px;">
            </div>
            <div class="columna">
                <br>
                <h3>Clínicas</h3>
                <p>Clínica podológica Utrera</p>
                <p>Clínica podológica Arahal</p>
                <br>
                <h3>Servicios</h3>
                <p>Podología general</p>
                <p>Podología avanzada</p>
                <p>Podología infantil</p>
                <p>Tratamientos físicos</p>
                <p>Análisis biomecánicos</p>
                <p>Eco-intervencionismo</p>
            </div>
            <div class="columna">
                <br>
                <h3>Productos</h3>
                <p>Tienda</p>
                <p>Cremas</p>
                <p>Otros productos</p>
                <p>Carrito</p>
                <br>
                <h3>Sobre nosotros</h3>
                <p>Nuestra plantilla</p>
                <p>Historia</p>
                <p>Noticias recientes</p>
                <p>Artículos</p>
            </div>
            <div class="columna">
                <br>
                <h3>Contacto</h3>
                <p>Teléfono: 954841159</p>
                <p>Correo: clinicarayo@gmail.com</p>
                <br>
                <br>
                <br>
                <div class="social">
                    <a href="https://www.instagram.com/clinicarayo" target="_blank">
                        <img src="../controlador/images/Insta.png" alt="Instagram"> clinicarayo
                    </a>
                    <a href="https://www.facebook.com/clinicarayo" target="_blank">
                        <img src="../controlador/images/Face.png" alt="Facebook"> Clinica Rayo
                    </a>
                    <a href="https://wa.me/644248375" target="_blank">
                        <img src="../controlador/images/wasap.png" alt="WhatsApp"> 644248375
                    </a>
                </div> 
            </div>
        </div>
        <!-- Enlaces secundarios -->
        <div class="enlaces">
            <a href="#">Aviso Legal</a>
            <a href="#">Términos de Uso</a>
            <a href="#">Política de Privacidad</a>
            <a href="#">Cookies</a>
        </div>
    </div>
</body>
</html>
