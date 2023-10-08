<?php
include('../../conexion/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sala"]) && isset($_POST["paciente"]) && isset($_POST["fechaInicio"]) && isset($_POST["personal"]) && isset($_POST["prioridad"])) {
    // Obtener los datos del formulario
    $sala = $_POST['sala']; // el id de la sala
    $paciente = $_POST['paciente']; // el id del paciente
    $personal = $_POST['personal'];
    $fechaInicio = $_POST['fechaInicio'];
    $prioridad = $_POST['prioridad']; // tipo de prioridad (normal o emergencia)

    // Verificar la capacidad de la sala
    $sqlCapacidad = "SELECT capacidadMaxima, ocupacionActual FROM sala WHERE id = $sala";
    $resultCapacidad = $conn->query($sqlCapacidad);

    if ($resultCapacidad->num_rows > 0) {
        $salaInfo = $resultCapacidad->fetch_assoc();
        $capacidadMaxima = $salaInfo['capacidadMaxima'];
        $ocupacionActual = $salaInfo['ocupacionActual'];

        if ($ocupacionActual < $capacidadMaxima) {
            // La sala tiene capacidad disponible, puedes asignar al paciente

            // Primero, se inserta en la tabla llamado
            $sql = "INSERT INTO llamado (idSala, idPaciente, fechaHoraInicio, fechaHoraFin, prioridadLlamada) 
                    VALUES ('$sala', '$paciente', '$fechaInicio', ' ', '$prioridad')";

            if ($conn->query($sql) === TRUE) {
                // Obten el idLlamado generado automáticamente
                $idLlamado = $conn->insert_id;

                // Actualiza la ocupación actual de la sala
                $ocupacionActual++;

                // Actualiza la sala en la base de datos
                $sqlActualizarSala = "UPDATE sala SET ocupacionActual = $ocupacionActual WHERE id = $sala";
                $conn->query($sqlActualizarSala);

                // Ahora, inserta en la tabla sala_personal utilizando el idLlamado
                $sql2 = "INSERT INTO llamado_personal (idLlamado, idPersonal) VALUES ('$idLlamado', '$personal')";

                if ($conn->query($sql2) === TRUE) {
                    // Actualizar el estado del paciente a "baja"
                    $sql3 = "UPDATE paciente SET estado = 'baja' WHERE id = '$paciente'";

                    if ($conn->query($sql3) === TRUE) {
                        header("location:../../pages/pacientes/atendidos.php");
                    } else {
                        echo "Error al actualizar el estado del paciente: " . $conn->error;
                    }
                } else {
                    echo "Error al asignar la sala: " . $conn->error;
                }
            } else {
                echo "Error al insertar el llamado: " . $conn->error;
            }
        } else {
            echo "La sala está llena, no se puede asignar al paciente.";
        }
    } else {
        echo "Error al obtener la información de la sala: " . $conn->error;
    }
}

$conn->close();

?>