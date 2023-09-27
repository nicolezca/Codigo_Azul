<?php
    include('../../conexion/conexion.php');

// Procesar inicio de sesión
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"]) && isset($_POST["clave"])) {
    $nombre = $_POST["nombre"];
    $clave = $_POST["clave"];
    
    // Validar los campos de inicio de sesión
    if (empty($nombre) || empty($clave)) {
        echo "Por favor, complete todos los campos.";
    } else {
        // Realizar la validación de las credenciales en la base de datos
        $sql = "SELECT * FROM usuario WHERE nombre = '$nombre' AND contrasena = '$clave'";
        $result = $conn->query($sql);
        
        if ($result->num_rows == 1) {
            session_start();
            $_SESSION["nombre"] = $nombre;
            $_SESSION["clave"] = $clave;
            header("Location: ../../inicio/inicio.php");
            exit();
        } else {
            echo "Credenciales inválidas";
            echo '<a href="../formulario.html">volver a intentar</a>';
        }
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>