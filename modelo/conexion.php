<?php
$host = 'db5016829413.hosting-data.io'; // Sustituye con el host que aparece en tu panel, si es diferente.
$dbname = 'dbs13594088';        // Nombre de la base de datos.
$username = 'dbu3773451';      // Usuario (mismo que el nombre de la base de datos).
$password = 'dominio@clinicarayo.es';    // Contraseña asignada a tu usuario en IONOS.

try {
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>
