<?php
include('config.php');

$conn = new mysqli($dbConfig['hostname'], $dbConfig['username'], $dbConfig['password'], $dbConfig['database']);

if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}
