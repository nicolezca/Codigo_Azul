<?php
include('../../conexion/conexion.php');

if (
    $_SERVER["REQUEST_METHOD"] == "POST"
    && isset($_POST["pacienteAsignar"])
    && isset($_POST["sala"])
    && isset($_POST["horaIngreso"])
    && isset($_POST["doctorDia"]) && isset($_POST["doctorTurno"])
    && isset($_POST["enfermero1Dia"]) && isset($_POST["enfermero1Turno"])
    && isset($_POST["enfermero2Dia"]) && isset($_POST["enfermero2Turno"])
) {
    // Obtener los datos del formulario
    $pacienteId = $_POST['pacienteAsignar'];
    $sala = $_POST['sala'];
    $fechaIngreso = $_POST['horaIngreso'];

    $doctorId = $_POST['doctor'];
    $doctorDia = $_POST['doctorDia'];
    $doctorTurno = $_POST['doctorTurno'];

    $enfermero1Id = $_POST['enfermero1'];
    $enfermero1Dia = $_POST['enfermero1Dia'];
    $enfermero1Turno = $_POST['enfermero1Turno'];

    $enfermero2Id = $_POST['enfermero2'];
    $enfermero2Dia = $_POST['enfermero2Dia'];
    $enfermero2Turno = $_POST['enfermero2Turno'];

    $salaPaciente = "INSERT INTO sala_paciente (idSala, idPaciente, fechaHoraIngreso, fechaHoraEgreso) VALUES ($sala, $pacienteId, '$fechaIngreso', ' ')";

    if ($conn->query($salaPaciente) === TRUE) {
        // Insertar los registros en la tabla sala_personal_asignado
        $sql = "INSERT INTO sala_personal_asignado (idPersonal, idSala, dias, turno) VALUES
                            ($doctorId, $sala, '$doctorDia', '$doctorTurno'),
                            ($enfermero1Id, $sala, '$enfermero1Dia', '$enfermero1Turno'),
                            ($enfermero2Id, $sala, '$enfermero2Dia', '$enfermero2Turno')";

        if ($conn->multi_query($sql) === TRUE) {
            // Actualizar la ocupación de la sala en la tabla sala
            $updateSalaSql = "UPDATE sala SET ocupacionActual = ocupacionActual + 1 WHERE id = $sala";
            if ($conn->query($updateSalaSql) === TRUE) {
                // Cambiar el estado del paciente a "atendido" en la tabla paciente
                $updatePacienteSql = "UPDATE paciente SET estado = 'atendido' WHERE id = $pacienteId";
                if ($conn->query($updatePacienteSql) === TRUE) {
                    header("Location: ../salas/salas.php");
                } else {
                    echo "Error al actualizar el estado del paciente: " . $conn->error;
                }
            } else {
                echo "Error al actualizar la ocupación de la sala: " . $conn->error;
            }
        } else {
            echo "Error en la asignación: " . $conn->error;
        }
    } else {
        echo "Error al Insertar Paciente a la sala" . $conn->error;
    }
}

$conn->close();
?>