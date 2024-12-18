<?

require_once 'menuUsuarioNoRegistrado.php'; 

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Productos</title>

    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@700;600;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .titulo {
            font-size: 32px;
            font-weight: 700;
            padding-left: 70px;
            margin-bottom: 20px;
        }

        .contenedor {
            width: 1337px;
            height: 149px;
            border-radius: 5px;
            padding: 20px;
            margin: 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

                /* Estilo del carrito */
                .carrito-contenedor {
            position: relative;
            top: 70px;
            left: 1350px;
           
        }

        .carrito-contenedor img {
            width: 114px;
            height: 95px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .carrito-contenedor img:hover {
            transform: scale(1.1);
        }

        .item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .item img {
            width: 154px;
            height: auto;
        }

        .texto {
            color: #000000;
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-left: 20px;
            font-weight: 700;
        }

        .texto p {
            margin: 0;
        }

        .texto .precio {
            font-weight: bold;
        }

        .boton-contenedor1 {
            display: flex;
            justify-content: flex-end; 
            margin-top: 30px;
            margin-right: 70px;
        }

        /* Estilo del botón */
        .boton1 {
            width: 162px;
            height: 34px;
            border: none;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-transform: none;
            color: white;
            background-color: #111C4E;
            border-radius: 10px;
            transition: background-color 0.3s, transform 0.2s;
        }

        .boton1:hover {
            background-color: #0D1637;
            transform: translateY(-3px);
        }
    </style>
</head>
<body>


        <!-- Icono del carrito -->
        <div class="carrito-contenedor">
            <a href="carrito.php">
                <img src="../controlador/images/carrito.png" alt="Carrito de Compras">
            </a>
        </div>

    <!-- Primer cuadro: Cremas -->
    <div class="titulo" style="margin-top: 120px;">CREMAS</div>
    <div class="contenedor">
        <div class="item">
            <img src="../controlador/images/CPIcrema.png" alt="Crema 1">
            <div class="texto">
                <p>CPI crema <br> podológica, 50 g</p>
                <p class="precio">19,95 €</p>
            </div>
        </div>
        <div class="item">
            <img src="../controlador/images/dermaFeetCrema.png" alt="Crema 2">
            <div class="texto">
                <p>Dermafeet Crema <br> Podológica Urea <br> 20% 75ml</p>
                <p class="precio">11,50 €</p>
            </div>
        </div>
        <div class="item">
            <img src="../controlador/images/UreadinPodosCrema.png" alt="Crema 3">
            <div class="texto">
                <p>Ureadin Podios Gel Oil<br> 75ml Reparador Talones<br> y Pies</p>
                <p class="precio">9,68 €</p>
            </div>
        </div>
    </div>
    <div class="boton-contenedor1">
        <a href="verMasProductosCremas.php">
            <button class="boton1">Ver más productos</button>
        </a>
    </div>

    <!-- Segundo cuadro: Otros Productos -->
    <div class="titulo" style="margin-top: 70px;">OTROS PRODUCTOS</div>
    <div class="contenedor">
        <div class="item">
            <img src="../controlador/images/DrSchollLapiz.png" alt="Producto 1">
            <div class="texto">
                <p>Dr Scholl Lápiz<br> Tratamiento Verrugas<br> Pies y Manos<br> Cremas de manos</p>
                <p class="precio">18,99 €</p>
            </div>
        </div>
        <div class="item">
            <img src="../controlador/images/CoconutMask.png" alt="Producto 2">
            <div class="texto">
                <p>7th Heaven Coconut<br> Foot Mask Mascarilla<br> Suavizante para Pies<br> Cuidado de piernas y pies</p>
                <p class="precio">3,99 €</p>
            </div>
        </div>
        <div class="item">
            <img src="../controlador/images/BetterEliteCortaUñas.png" alt="Producto 3">
            <div class="texto">
                <p>Better Elite Corta<br> Uñas de Pedicura<br> Herramientas<br> manicura y pedicura</p>
                <p class="precio">5,95 €</p>
            </div>
        </div>
    </div>
    <div class="boton-contenedor1">
        <a href="verMasProductos.php">
            <button class="boton1">Ver más productos</button>
        </a>
    </div>

<? require_once 'piePagina.php';?>
</body>
</html>