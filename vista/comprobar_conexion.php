<?php
$host = 'db5016829413.hosting-data.io'; // Host de tu base de datos
$dbname = 'dbs13594088';                // Nombre de la base de datos
$username = 'dbu3773451';              // Usuario
$password = 'dominio@clinicarayo.es';  // Contraseña

// Intentar conexión
try {
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    echo "Conexión exitosa a la base de datos '$dbname'.";
} catch (Exception $e) {
    die("Error en la conexión: " . $e->getMessage());
}

// Cerrar conexión
$conn->close();
?>
