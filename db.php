<?php
$servername = "localhost";
$username = "id22312035_frostmourne";
$password = "PUESNOSExD1.";
$dbname = "id22312035_db_analisis";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
