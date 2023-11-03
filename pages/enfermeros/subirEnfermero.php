<?php
include('../../conexion/conexion.php');

function validarCampos($nombre, $apellido, $cargo, $matricula) {
    return empty($nombre) || empty($apellido) || empty($cargo) || empty($matricula);
}

function verificarMatriculaExistente($conn, $matricula) {
    $sql = "SELECT * FROM personal WHERE matricula = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matricula);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

function insertarEnfermero($conn, $nombre, $apellido, $cargo, $matricula) {
    $sql = "INSERT INTO personal (nombre, apellido, cargo, matricula, tipo) VALUES (?, ?, ?, ?, 'enfermero')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $apellido, $cargo, $matricula);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["cargo"]) && isset($_POST["matricula"])) {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $cargo = $_POST["cargo"];
    $matricula = $_POST["matricula"];

    if (validarCampos($nombre, $apellido, $cargo, $matricula)) {
        echo "Por favor, complete todos los campos.";
    } else {
        if (verificarMatriculaExistente($conn, $matricula)) {
            echo "La matricula ya está registrada.";
        } else {
            if (insertarEnfermero($conn, $nombre, $apellido, $cargo, $matricula)) {
                echo "Registro exitoso";
                header("Location: enfermeros.php");
                exit();
            } else {
                echo "Error en el registro: " . $conn->error;
                echo '<a href="enfermeros.php">Volver a intentar</a>';
            }
        }
    }
}
?>
