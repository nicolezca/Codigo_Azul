<?php
include('../../conexion/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["paciente"]) && isset($_POST["fechafin"])) {
    $idPaciente = $_POST["paciente"];
    $fechafin = $_POST["fechafin"];

    // Consulta SQL para actualizar la fechaHoraFin del último registro de llamado para el paciente seleccionado
    $sqlActualizarLlamado = "UPDATE llamado SET fechaHoraFin = '$fechafin' WHERE idPaciente = $idPaciente  AND fechaHoraFin ='0000-00-00 00:00:00' ORDER BY id DESC LIMIT 1";

    // Consulta SQL para actualizar el estado del paciente a "alta"
    $sqlActualizarPaciente = "UPDATE paciente SET estado = 'alta' WHERE id = $idPaciente";

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
