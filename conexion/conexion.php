<?php
$hostname = 'localhost';
$database = 'olimpiadas';
$username = 'root'; 
$password = '';

// Crear una conexión
$conn = new mysqli($hostname, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}
?>