<?php 
include('../../conexion/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["paciente"]) && isset($_POST["fechafin"])) {
    $idPaciente = $_POST["paciente"];
    $fechafin = $_POST["fechafin"];

    // Obtener el id de la sala asociada desde la tabla sala_paciente
    $sqlObtenerSala = "SELECT idSala FROM sala_paciente WHERE idPaciente = $idPaciente AND fechaHoraEgreso = '0000-00-00 00:00:00' ORDER BY id DESC LIMIT 1";
    $resultSala = $conn->query($sqlObtenerSala);

    if ($resultSala->num_rows > 0) {
        $rowSala = $resultSala->fetch_assoc();
        $idSala = $rowSala['idSala'];

        // Insertar la fecha de egreso en la tabla sala_paciente
        $sqlActualizarSalaPaciente = "UPDATE sala_paciente SET fechaHoraEgreso = '$fechafin' WHERE idPaciente = $idPaciente AND fechaHoraEgreso = '0000-00-00 00:00:00' ORDER BY id DESC LIMIT 1";
        $conn->query($sqlActualizarSalaPaciente);

        // Reducir la ocupación actual de la sala en 1
        $sqlReducirOcupacion = "UPDATE sala SET ocupacionActual = ocupacionActual - 1 WHERE id = $idSala";
        $conn->query($sqlReducirOcupacion);
        //Eliminar el registro de sala_personal_asignado correspondiente al paciente dado de alta
        $sqlEliminarAsignacion = "DELETE FROM sala_personal_asignado WHERE idSala = $idSala";
        $conn->query($sqlEliminarAsignacion);

    }

    // Actualizar el estado del paciente a "fuera"
    $sqlActualizarPaciente = "UPDATE paciente SET estado = 'fuera' WHERE id = $idPaciente";

    // Ejecutar las consultas en una transacción
    $conn->begin_transaction();

    try {
        $conn->query($sqlActualizarPaciente);
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
