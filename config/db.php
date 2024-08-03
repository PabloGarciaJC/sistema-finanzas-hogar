<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = '127.0.0.1';
$username = 'u498565300_fzuserpjgc';
$password = 'iTdJM0k4w6c4qS';
$dbname = 'u498565300_fhbdpjgc';

$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

echo "Conexión exitosa a la base de datos.";

$conn->close();
?>
