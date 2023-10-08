<?php 
include('../../conexion/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["paciente"]) && isset($_POST["fechafin"])) {
    $idPaciente = $_POST["paciente"];
    $fechafin = $_POST["fechafin"];

    // Consulta SQL para actualizar la fechaHoraFin del último registro de llamado para el paciente seleccionado
    $sqlActualizarLlamado = "UPDATE llamado SET fechaHoraFin = '$fechafin' WHERE idPaciente = $idPaciente  AND fechaHoraFin ='0000-00-00 00:00:00' ORDER BY id DESC LIMIT 1";

    // Consulta SQL para actualizar el estado del paciente a "alta"
    $sqlActualizarPaciente = "UPDATE paciente SET estado = 'alta' WHERE id = $idPaciente";

    // Obtener el id de la sala asociada al paciente
    $sqlObtenerSala = "SELECT idSala FROM llamado WHERE idPaciente = $idPaciente AND fechaHoraFin ='0000-00-00 00:00:00' ORDER BY id DESC LIMIT 1";
    $resultSala = $conn->query($sqlObtenerSala);

    if ($resultSala->num_rows > 0) {
        $rowSala = $resultSala->fetch_assoc();
        $idSala = $rowSala['idSala'];

        // Consulta SQL para reducir la ocupación actual de la sala en 1
        $sqlReducirOcupacion = "UPDATE sala SET ocupacionActual = ocupacionActual - 1 WHERE id = $idSala";
        $conn->query($sqlReducirOcupacion);
    }

    // Ejecutar las consultas en una transacción
    $conn->begin_transaction();

    try {
        $conn->query($sqlActualizarLlamado);
        $conn->query($sqlActualizarPaciente);
        $conn->commit();

        header("Location: pacientes.php");
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