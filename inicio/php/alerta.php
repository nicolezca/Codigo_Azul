<?php
include('../../conexion/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sala"]) && isset($_POST["fechaInicio"]) && isset($_POST["doctor"]) && isset($_POST["enfermero"]) && isset($_POST["prioridad"])) {
    // Obtener los datos del formulario
    $sala = $_POST['sala'];
    $doctor = $_POST['doctor'];
    $fechaInicio = $_POST['fechaInicio'];
    $enfermero = $_POST['enfermero'];
    $prioridad = $_POST['prioridad'];

    // Primero, se inserta en la tabla llamado
    $sql = "INSERT INTO llamado (idSala, fechaHoraInicio, prioridadLlamada) VALUES ('$sala', '$fechaInicio',  '$prioridad')";

    if ($conn->query($sql) === TRUE) {
        $idLlamado = $conn->insert_id;

        // Consulta para obtener el nombre de la sala
        $sqlSalaNombre = "SELECT nombre FROM sala WHERE id = $sala";
        $resultSalaNombre = $conn->query($sqlSalaNombre);

        if ($resultSalaNombre->num_rows > 0) {
            $rowSalaNombre = $resultSalaNombre->fetch_assoc();
            $nombreSala = $rowSalaNombre['nombre'];

            // Consulta para obtener el teléfono del doctor
            $sqlTelefonoDoctor = "SELECT telefono FROM personal WHERE id = $doctor";
            $resultTelefonoDoctor = $conn->query($sqlTelefonoDoctor);

            if ($resultTelefonoDoctor->num_rows > 0) {
                $rowTelefonoDoctor = $resultTelefonoDoctor->fetch_assoc();
                $telefonoDoctor = $rowTelefonoDoctor['telefono'];

                // Consulta para obtener el teléfono del enfermero
                $sqlTelefonoEnfermero = "SELECT telefono FROM personal WHERE id = $enfermero";
                $resultTelefonoEnfermero = $conn->query($sqlTelefonoEnfermero);

                if ($resultTelefonoEnfermero->num_rows > 0) {
                    $rowTelefonoEnfermero = $resultTelefonoEnfermero->fetch_assoc();
                    $telefonoEnfermero = $rowTelefonoEnfermero['telefono'];

                    session_start();
                    $_SESSION['nombre'] = $nombreSala;
                    $_SESSION['telefono_doctor'] = $telefonoDoctor;
                    $_SESSION['telefono_enfermero'] = $telefonoEnfermero;

                    // Redirige a la página de inicio
                    header("Location: ../inicio.php");
                    exit();
                } else {
                    echo "No se encontró ningún enfermero con el ID proporcionado.";
                }
            } else {
                echo "No se encontró ningún doctor con el ID proporcionado.";
            }
        } else {
            echo "No se encontró ninguna sala con el ID proporcionado.";
        }
    } else {
        echo "Error al insertar el llamado: " . $conn->error;
    }
}

$conn->close();
