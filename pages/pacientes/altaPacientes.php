<?php 
include('../../conexion/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["paciente"]) && isset($_POST["fechafin"])) {
    // Validación de datos
    $idPaciente = intval($_POST["paciente"]);
    $fechafin = $_conn->real_escape_string($_POST["fechafin"]);

    if ($idPaciente <= 0) {
        die("ID de paciente inválido.");
    }

    if (empty($fechafin)) {
        die("La fecha de salida no puede estar vacía.");
    }

    // Iniciar transacción
    $conn->begin_transaction();

    try {
        // Obtener el id de la sala asociada desde la tabla sala_paciente
        $sqlObtenerSala = "SELECT idSala FROM sala_paciente WHERE idPaciente = ? AND fechaHoraEgreso = '0000-00-00 00:00:00' ORDER BY id DESC LIMIT 1";
        $stmtObtenerSala = $conn->prepare($sqlObtenerSala);
        $stmtObtenerSala->bind_param("i", $idPaciente);
        $stmtObtenerSala->execute();
        $resultSala = $stmtObtenerSala->get_result();

        if ($resultSala->num_rows > 0) {
            $rowSala = $resultSala->fetch_assoc();
            $idSala = $rowSala['idSala'];

            // Insertar la fecha de egreso en la tabla sala_paciente
            $sqlActualizarSalaPaciente = "UPDATE sala_paciente SET fechaHoraEgreso = ? WHERE idPaciente = ? AND fechaHoraEgreso = '0000-00-00 00:00:00' ORDER BY id DESC LIMIT 1";
            $stmtActualizarSalaPaciente = $conn->prepare($sqlActualizarSalaPaciente);
            $stmtActualizarSalaPaciente->bind_param("si", $fechafin, $idPaciente);
            $stmtActualizarSalaPaciente->execute();

            // Reducir la ocupación actual de la sala en 1
            $sqlReducirOcupacion = "UPDATE sala SET ocupacionActual = ocupacionActual - 1 WHERE id = ?";
            $stmtReducirOcupacion = $conn->prepare($sqlReducirOcupacion);
            $stmtReducirOcupacion->bind_param("i", $idSala);
            $stmtReducirOcupacion->execute();

            // Eliminar el registro de sala_personal_asignado correspondiente al paciente dado de alta
            $sqlEliminarAsignacion = "DELETE FROM sala_personal_asignado WHERE idSala = ?";
            $stmtEliminarAsignacion = $conn->prepare($sqlEliminarAsignacion);
            $stmtEliminarAsignacion->bind_param("i", $idSala);
            $stmtEliminarAsignacion->execute();
        }

        // Actualizar el estado del paciente a "fuera"
        $sqlActualizarPaciente = "UPDATE paciente SET estado = 'fuera' WHERE id = ?";
        $stmtActualizarPaciente = $conn->prepare($sqlActualizarPaciente);
        $stmtActualizarPaciente->bind_param("i", $idPaciente);
        $stmtActualizarPaciente->execute();

        // Confirmar la transacción
        $conn->commit();

        header("Location: ../salas/salas.php");
        exit();
    } catch (Exception $e) {
        // En caso de error, revertir la transacción
        $conn->rollback();
        echo "Error en el proceso: " . $e->getMessage();
        echo '<a href="pacientes.php">Volver a intentar</a>';
    }
} else {
    echo "Por favor, complete todos los campos del formulario.";
}
?>
