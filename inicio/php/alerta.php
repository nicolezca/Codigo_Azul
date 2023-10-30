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
    $sql = "INSERT INTO llamado (idSala, fechaHoraInicio, fechaHoraFin, prioridadLlamada) VALUES ('$sala', '$fechaInicio', ' ', '$prioridad')";

    if ($conn->query($sql) === TRUE) {
        // Obten el idLlamado generado automáticamente
        $idLlamado = $conn->insert_id;

        // Insertar el doctor asignado al llamado
        $sqlDoctor = "INSERT INTO llamado_personal (idLlamado, idPersonal) VALUES ('$idLlamado', '$doctor')";
        if ($conn->query($sqlDoctor) !== TRUE) {
            echo "Error al asignar el doctor a la llamada: " . $conn->error;
        }

        // Insertar el enfermero asignado al llamado
        $sqlEnfermero = "INSERT INTO llamado_personal (idLlamado, idPersonal) VALUES ('$idLlamado', '$enfermero')";
        if ($conn->query($sqlEnfermero) !== TRUE) {
            echo "Error al asignar el enfermero a la llamada: " . $conn->error;
        } else {
            // Consulta para obtener el nombre de la sala
            $sqlSalaNombre = "SELECT nombre FROM sala WHERE id = 1";
            $resultSalaNombre = $conn->query($sqlSalaNombre);

            if ($resultSalaNombre->num_rows > 0) {
                $rowSalaNombre = $resultSalaNombre->fetch_assoc();
                $nombreSala = $rowSalaNombre['nombre'];

                // Inicia la sesión
                session_start();

                // Guardar el nombre de la sala en una variable de sesión
                $_SESSION['nombre'] = $nombreSala;

                // Redirige a la página de inicio
                header("Location: alertarpersonal.php");
                exit();
            } else {
                echo "No se encontró ninguna sala con el ID proporcionado.";
            }
        }
    } else {
        echo "Error al insertar el llamado: " . $conn->error;
    }
}

$conn->close();
