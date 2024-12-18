<?php
require_once 'menuUsuarioNoRegistrado.php';
include_once ('../modelo/conexion.php');

// Validar si se recibe el ID del servicio en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_servicio = intval($_GET['id']);

    // Consulta SQL para obtener los datos del servicio según el ID
    $sql = "SELECT nombre, descripcion, imagen_url FROM servicio WHERE id_servicio = ?";
    $stmt = $conn->prepare($sql); // Cambiado $conexion por $conn
    $stmt->bind_param("i", $id_servicio);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verificar si existe el servicio
    if ($resultado->num_rows > 0) {
        $servicio = $resultado->fetch_assoc();
        $nombre = $servicio['nombre'];
        $descripcion = $servicio['descripcion'];
        $imagen_url = $servicio['imagen_url'];
    } else {
        die("El servicio no existe.");
    }

    $stmt->close();
} else {
    die("ID de servicio no proporcionado o inválido.");
}

$conn->close(); // Cambiado $conexion por $conn
?>



<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eco-Intervencionismo</title>
  <style>
    /* Estilos aquí (mantén los tuyos existentes) */
    body {
      margin: 0;
      padding: 0;
      font-family: 'Arial', sans-serif;
      background-color: #f4f4f4;
      color: #333;
      overflow-x: hidden; 
      overflow-y: auto;
    }

    /* Contenedor Principal */
    .container {
      max-width: 1200px;
      
    }

    /* Encabezado Superior */
    .header {
      display: flex;
      align-items: flex-start; /* Alinea los elementos verticalmente al inicio */
      margin-bottom: 30px;
      gap: 100px; /* Espacio entre texto e imagen */
    }

    .header-content {
      margin: 80px; /* Ajuste para alinear con el logo */
    }

    .header h1 {
      font-size: 2.2rem;
      color: black;
      margin: 0; /* Elimina márgenes adicionales */
    }

    .header p {
      font-size: 1rem;
      line-height: 1.6;
      color: black;
      margin: 15px 0 0; 
   
      max-width: 600px;
    }

    .image-container {
  position: relative;
  top: 80px; /* Coordenada Y */
  left: 150px; /* Coordenada X */
  width: 800px; /* Tamaño de la imagen */
  height: 300px;
}

.image-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

    /* Sección FAQ */
    .faq {
  display: flex;
  flex-direction: column;
  align-items: flex-end; /* Centra horizontalmente */
  justify-content: center; /* Centra verticalmente si fuera necesario */
  margin-right: 80px;
  text-align: center;
  margin-top: 20px; 
 
}

.faq h2 {
  margin-bottom: 20px;
  color: black;
  font-size: 1.8rem;
}

.faq-item {
  width: 80%; /* Ajusta el ancho máximo de las preguntas */
  max-width: 651px; /* Define el tamaño exacto basado en tu captura */
  margin-bottom: 15px; /* Espacio entre elementos */
  border-radius: 5px;
  overflow: hidden;
  text-align: left; /* Mantiene el texto alineado a la izquierda */
}


    .faq-item button {
      width: 100%;
      background-color: #f9f9f9;
      color: black;
      border:#002b5e;
      padding: 15px;
      font-size: 1rem;
      text-align: left;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: bold;
    }

    .faq-item button:hover {
      border:#002b5e;
      background-color: #f9f9f9;
    }

    .faq-item p {
      padding: 15px;
      background-color: #f9f9f9;
      display: none;
      color: black;
    }

    .faq-item button::after {
      content: '+';
      font-size: 1.2rem;
    }

    .faq-item button.active::after {
      content: '-';
    }
    

    /* Responsividad */
    @media (max-width: 768px) {
      .header {
        flex-direction: column;
      }
      .header-content {
        margin-left: 20px;
      }
      .image-container {
        width: 100%;
        margin-top: 20px;
      }
    }
  </style>
</head>
<body>
  <!-- Contenedor Principal -->
  <div class="container">
    <!-- Encabezado -->
    <div class="header">
      <div class="header-content">
        <h1><?php echo htmlspecialchars($nombre); ?></h1>
        <p>
          <?php echo nl2br(htmlspecialchars($descripcion)); ?>
        </p>
      </div>
      <div class="image-container">
        <img src="<?php echo htmlspecialchars($imagen_url); ?>" alt="Eco-intervencionismo en acción">
      </div>
    </div>

    <!-- Sección FAQ -->
    <div class="faq">
      <h2>Más Información sobre  <?php echo htmlspecialchars($nombre); ?></h2>
      <div class="faq-item">
        <button onclick="toggleAnswer(this)">
          ¿Cuáles son los beneficios de <?php echo htmlspecialchars($nombre); ?>?
        </button>
        <p>
          Esta técnica proporciona imágenes en tiempo real, lo que permite tomar decisiones precisas durante 
          el tratamiento y reduce la necesidad de intervenciones más invasivas.
        </p>
      </div>
    </div>
  </div>

  <script>
    // Función para abrir y cerrar respuestas en la sección FAQ
    function toggleAnswer(button) {
      const answer = button.nextElementSibling;
      const isActive = button.classList.contains('active');

      document.querySelectorAll('.faq-item button').forEach(btn => {
        btn.classList.remove('active');
        btn.nextElementSibling.style.display = 'none';
      });

      if (!isActive) {
        button.classList.add('active');
        answer.style.display = 'block';
      }
    }
  </script>
</body>
</html>
<?php
require_once 'piePagina.php';
?>
