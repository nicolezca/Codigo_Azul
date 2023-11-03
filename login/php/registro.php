<?php
session_start();

function registrarUsuario($conn, $nombre, $clave, $tipo) {
    $sql = "INSERT INTO usuario (nombre, contrasena, tipo) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $clave, $tipo);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombreingreso"]) && isset($_POST["claveIngreso"]) && (isset($_POST["admin"]) || isset($_POST["generico"]))) {
    $nombre = $_POST["nombreingreso"];
    $clave = $_POST["claveIngreso"];
    $tipo = isset($_POST["admin"]) ? "admin" : "generico";

    if (empty($nombre) || empty($clave) || empty($tipo)) {
        echo "Por favor, complete todos los campos.";
    } else {
        include('../../conexion/conexion.php');

        $nombre = mysqli_real_escape_string($conn, $nombre);

        $sql = "SELECT * FROM usuario WHERE nombre = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "El nombre de usuario ya está registrado.";
        } else {
            if (registrarUsuario($conn, $nombre, $clave, $tipo)) {
                echo "Registro exitoso";
                header("Location: ../../inicio/inicio.php");
                exit();
            } else {
                echo "Error en el registro.";
                echo '<a href="login.php">Volver a intentar</a>';
            }
        }

        $conn->close();
    }
}
?>
