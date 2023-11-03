<?php
include('../../conexion/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["dni"]) && isset($_POST["telefono"]) && isset($_POST["social"]) && isset($_POST["historial"])) {
    $nombre = mysqli_real_escape_string($conn, $_POST["nombre"]);
    $apellido = mysqli_real_escape_string($conn, $_POST["apellido"]);
    $dni = mysqli_real_escape_string($conn, $_POST["dni"]);
    $telefono = mysqli_real_escape_string($conn, $_POST["telefono"]);
    $social = mysqli_real_escape_string($conn, $_POST["social"]);
    $historial = mysqli_real_escape_string($conn, $_POST["historial"]);

    if (insertarPaciente($conn, $nombre, $apellido, $dni, $telefono, $social, $historial)) {
        header("Location: pacientes.php");
        exit();
    } else {
        echo "Error en el registro del paciente o el historial clínico.";
        echo '<a href="pacientes.php">Volver a intentar</a>';
    }
}

function insertarPaciente($conn, $nombre, $apellido, $dni, $telefono, $social, $historial) {
    // Crear una sentencia preparada para insertar el paciente en la tabla paciente
    $sql = "INSERT INTO paciente (nombre, apellido, dni, telefono, obraSocial, estado) VALUES (?, ?, ?, ?, ?, 'espera')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $apellido, $dni, $telefono, $social);

    if ($stmt->execute()) {
        $idPaciente = $stmt->insert_id;
        $stmt->close();

        // Crear una sentencia preparada para insertar el historial clínico en la tabla historia_clinica
        $sqlHistorial = "INSERT INTO historia_clinica (idPaciente, contenido) VALUES (?, ?)";
        $stmtHistorial = $conn->prepare($sqlHistorial);
        $stmtHistorial->bind_param("is", $idPaciente, $historial);

        if ($stmtHistorial->execute()) {
            $stmtHistorial->close();
            return true;
        }
    }

    return false;
}
?>