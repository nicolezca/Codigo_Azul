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

    // Insertar el paciente en la sala de forma segura con una consulta preparada
    $salaPacienteQuery = $conn->prepare("INSERT INTO sala_paciente (idSala, idPaciente, fechaHoraIngreso, fechaHoraEgreso) VALUES (?, ?, ?, ' ')");
    $salaPacienteQuery->bind_param("iss", $sala, $pacienteId, $fechaIngreso);
    if ($salaPacienteQuery->execute()) {
        // Crear un array de asignaciones de personal
        $personalAsignado = array(
            array($doctorId, $doctorDia, $doctorTurno),
            array($enfermero1Id, $enfermero1Dia, $enfermero1Turno),
            array($enfermero2Id, $enfermero2Dia, $enfermero2Turno)
        );

        // Insertar las asignaciones de personal de forma segura con una consulta preparada
        $salaPersonalQuery = $conn->prepare("INSERT INTO sala_personal_asignado (idPersonal, idSala, dias, turno) VALUES (?, ?, ?, ?)");
        $salaPersonalQuery->bind_param("isss", $personalId, $sala, $dias, $turno);

        foreach ($personalAsignado as list($personalId, $dias, $turno)) {
            if (!$salaPersonalQuery->execute()) {
                echo "Error en la asignación de personal: " . $conn->error;
                exit;
            }
        }

        // Actualizar la ocupación de la sala en la tabla sala
        $updateSalaSql = "UPDATE sala SET ocupacionActual = ocupacionActual + 1 WHERE id = ?";
        $updateSalaQuery = $conn->prepare($updateSalaSql);
        $updateSalaQuery->bind_param("i", $sala);

        if ($updateSalaQuery->execute()) {
            // Cambiar el estado del paciente a "atendido" en la tabla paciente
            $updatePacienteSql = "UPDATE paciente SET estado = 'atendido' WHERE id = ?";
            $updatePacienteQuery = $conn->prepare($updatePacienteSql);
            $updatePacienteQuery->bind_param("i", $pacienteId);

            if ($updatePacienteQuery->execute()) {
                header("Location: ../salas/salas.php");
            } else {
                echo "Error al actualizar el estado del paciente: " . $conn->error;
            }
        } else {
            echo "Error al actualizar la ocupación de la sala: " . $conn->error;
        }
    } else {
        echo "Error al Insertar Paciente a la sala" . $conn->error;
    }
}

$conn->close();
?>
