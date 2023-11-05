<?php
session_start();

function validarInicioSesion($conn, $nombre, $clave) {
    $sql = "SELECT nombre, tipo FROM usuario WHERE nombre = ? AND contrasena = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre, $clave);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION["nombre"] = $nombre;
        $_SESSION["clave"] = $clave;

        if ($_SESSION["nombre"] == $nombre) {
            $row = $result->fetch_assoc();
            $_SESSION["tipo"] = $row["tipo"];
        }

        header("Location: ../../inicio/inicio.php");
        exit();
    } else {
        echo "Credenciales inválidas";
        echo '<a href="../formulario.html">Volver a intentar</a>';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"]) && isset($_POST["clave"])) {
    $nombre = $_POST["nombre"];
    $clave = $_POST["clave"];

    if (empty($nombre) || empty($clave)) {
        echo "Por favor, complete todos los campos.";
    } else {
        include('../../conexion/conexion.php');

        $nombre = mysqli_real_escape_string($conn, $nombre);
        $clave = mysqli_real_escape_string($conn, $clave);

        validarInicioSesion($conn, $nombre, $clave);

        $conn->close();
    }
}
?>