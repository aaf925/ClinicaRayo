<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Alverta:wght@700;600;900&display=swap" rel="stylesheet">

    <style>

        /* Estilo para el cuadro central */
     .contenidoCuadro1 {
            width: 637px;
            height: 740px;
            background-color: #1A428A; 
            border-radius: 5px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            left: 800px;
            top: 100px;
            border-radius: 0px;
        }

        .contenidoCuadro1 .titulo1{

            margin: 2;
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            left: 0px;
            top: 70px;
            color: white;
        }

        .contenidoCuadro1 .botones1{
            width: 267px;  
            height: 100px;  
            border: none;  
            font-size: 32px;  
            font-weight: bold;
            cursor: pointer;
            text-transform: none; 
            color: black; 
            background-color:white;
            border-radius: 5px; 
            transition: background-color 0.3s, transform 0.2s;
            position:relative;
            top: 100px;
            left: -150px;
        }

        .contenidoCuadro1 .botones2{
            width: 267px;  
            height: 100px;  
            border: none;  
            font-size: 32px;  
            font-weight: bold;
            cursor: pointer;
            text-transform: none; 
            color: black; 
            background-color:white;
            border-radius: 5px; 
            transition: background-color 0.3s, transform 0.2s;
            position:relative;
            top: 0px;
            left: 150px;
        }

        .contenidoCuadro1 .botones3{
            width: 540px;  
            height: 100px;  
            border: none;  
            font-size: 32px;  
            font-weight: bold;
            cursor: pointer;
            text-transform: none; 
            color: black; 
            background-color:white;
            border-radius: 5px; 
            transition: background-color 0.3s, transform 0.2s;
            position:relative;
            top: 50px;
        
        }

        .contenidoCuadro1 .botones4{
            width: 267px;  
            height: 100px;  
            border: none;  
            font-size: 32px;  
            font-weight: bold;
            cursor: pointer;
            text-transform: none; 
            color: black; 
            background-color:white;
            border-radius: 5px; 
            transition: background-color 0.3s, transform 0.2s;
            position:relative;
            top: 100px;
            left: -150px;
        }

        .contenidoCuadro1 .botones5{
            width: 267px;  
            height: 100px;  
            border: none;  
            font-size: 32px;  
            font-weight: bold;
            cursor: pointer;
            text-transform: none; 
            color: black; 
            background-color:white;
            border-radius: 5px; 
            transition: background-color 0.3s, transform 0.2s;
            position:relative;
            top: 0px;
            left: 150px;
        }


        .contenidoCuadro1 .botones6{
            width: 267px;  
            height: 100px;  
            border: none;  
            font-size: 32px;  
            font-weight: bold;
            cursor: pointer;
            text-transform: none; 
            color: black; 
            background-color:white;
            border-radius: 5px; 
            transition: background-color 0.3s, transform 0.2s;
            position:relative;
            top: 50px;
            left: -150px;
        }

        .contenidoCuadro1 .botones7{
            width: 267px;  
            height: 100px;  
            border: none;  
            font-size: 32px;  
            font-weight: bold;
            cursor: pointer;
            text-transform: none; 
            color: black; 
            background-color:white;
            border-radius: 5px; 
            transition: background-color 0.3s, transform 0.2s;
            position:relative;
            top: -50px;
            left: 150px;
        }


/*Para el cuadro de la izq ahora */

.contenidoCuadro2 {
            width: 637px;
            height: 740px;
            background-color: #1A428A; 
            border-radius: 5px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            left: 50px;
            top: -680px;
            border-radius: 0px;
        }

        .contenidoCuadro2 .titulo2{

            margin: 2;
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            top: -80px;
            left: 0px;
            color:white;
        }

        .contenidoCuadro2 .botones8{
            width: 572px;  
            height: 100px;  
            border: none;  
            font-size: 32px;  
            font-weight: bold;
            cursor: pointer;
            text-transform: none; 
            color: black; 
            background-color:white;
            border-radius: 0px; 
            transition: background-color 0.3s, transform 0.2s;
            position:relative;
            top: -50px;
        
        }

        .contenidoCuadro2 .botones9{
            width: 572px;  
            height: 100px;  
            border: none;  
            font-size: 32px;  
            font-weight: bold;
            cursor: pointer;
            text-transform: none; 
            color: black; 
            background-color:white;
            border-radius: 0px; 
            transition: background-color 0.3s, transform 0.2s;
            position:relative;
            top: 0px;
        
        }

        .contenidoCuadro2 .botones10{
            width: 572px;  
            height: 100px;  
            border: none;  
            font-size: 32px;  
            font-weight: bold;
            cursor: pointer;
            text-transform: none; 
            color: black; 
            background-color:white;
            border-radius: 0px; 
            transition: background-color 0.3s, transform 0.2s;
            position:relative;
            top: 50px;
        
        }


        .contenidoCuadro2 .botones11{
            width: 572px;  
            height: 100px;  
            border: none;  
            font-size: 32px;  
            font-weight: bold;
            cursor: pointer;
            text-transform: none; 
            color: black; 
            background-color:white;
            border-radius: 0px; 
            transition: background-color 0.3s, transform 0.2s;
            position:relative;
            top: 100px;
        
        }




        </style>
</head>
<body>

    <?php include('menuAdmin.php'); ?>

<div class="contenidoCuadro1">
 <div class="titulo1">ACCESOS DIRECTOS</div>
 <a href="">
                    <button class="botones1">Gestión de<br>
                        Servicios</button>
                    </a>

 <a href="gestionTiendaOnline.php">
                    <button class="botones2">Gestión de<br>
                        tienda online</button>
                    </a>

 <a href="">
                    <button class="botones3">Gestión de contenidos <br>
                        de la empresa</button>
                    </a>

 <a href="">
                    <button class="botones4">Gestión de<br>
                        citas</button>
                    </a>


 <a href="gestionUsuarios.php">
                    <button class="botones5">Gestión de<br>
                        usuario</button>
                    </a>



                    <a href="">
                    <button class="botones6">Gestión de<br>
                        Categoría Blog</button>
                    </a>


 <a href="">
                    <button class="botones7">Gestión de<br>
                        Artículos Blog</button>
                    </a>
</div>

<div class="contenidoCuadro2">
    <div class="titulo2">GESTIÓN DE ACCESOS</div>

                    <button class="botones8">Resumen de accesos a la web</button>
       

                    <button class="botones9">Resumen de compras de la web</button>
                 

                    <button class="botones10">Resumen de citas reservadas</button>
       

                    <button class="botones11">Resumen de nuevas reseñas</button>



</div>

</body>
</html>