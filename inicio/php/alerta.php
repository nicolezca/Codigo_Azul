<?php
include('../../conexion/conexion.php');

function obtenerNombreSala($conn, $salaId) {
    $sql = "SELECT nombre FROM sala WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $salaId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['nombre'];
    }
    return null;
}

function obtenerTelefonoPersonal($conn, $personalId) {
    $sql = "SELECT telefono FROM personal WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $personalId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['telefono'];
    }
    return null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sala"]) && isset($_POST["fechaInicio"]) && isset($_POST["doctor"]) && isset($_POST["enfermero"]) && isset($_POST["prioridad"])) {
    $salaId = $_POST['sala'];
    $doctorId = $_POST['doctor'];
    $fechaInicio = $_POST['fechaInicio'];
    $enfermeroId = $_POST['enfermero'];
    $prioridad = $_POST['prioridad'];

    $sql = "INSERT INTO llamado (idSala, fechaHoraInicio, prioridadLlamada) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $salaId, $fechaInicio, $prioridad);

    if ($stmt->execute()) {
        $idLlamado = $stmt->insert_id;

        $nombreSala = obtenerNombreSala($conn, $salaId);

        if ($nombreSala !== null) {
            $telefonoDoctor = obtenerTelefonoPersonal($conn, $doctorId);
            $telefonoEnfermero = obtenerTelefonoPersonal($conn, $enfermeroId);

            if ($telefonoDoctor !== null && $telefonoEnfermero !== null) {
                session_start();
                $_SESSION['nombre'] = $nombreSala;
                $_SESSION['telefono_doctor'] = $telefonoDoctor;
                $_SESSION['telefono_enfermero'] = $telefonoEnfermero;

                header("Location: ../inicio.php");
                exit();
            } else {
                echo "No se encontró el teléfono de doctor o enfermero con el ID proporcionado.";
            }
        } else {
            echo "No se encontró la sala con el ID proporcionado.";
        }
    } else {
        echo "Error al insertar el llamado: " . $conn->error;
    }
}

$conn->close();
