<?php
// Incluye el archivo de conexión a la base de datos
include('../../conexion/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["paciente"]) && isset($_POST["fechaInicio"])) {
    $idPaciente = $_POST["paciente"];
    $fechaInicio = $_POST["fechaInicio"];

    // Consulta SQL para actualizar la fechaHoraFin del último registro de llamado para el paciente seleccionado
    $sqlActualizarLlamado = "UPDATE llamado SET fechaHoraFin = '$fechaInicio' WHERE idPaciente = $idPaciente AND fechaHoraFin IS NULL ORDER BY id DESC LIMIT 1";

    // Consulta SQL para actualizar el estado del paciente a "alta"
    $sqlActualizarPaciente = "UPDATE paciente SET estado = 'alta' WHERE id = $idPaciente";

    // Ejecutar las consultas en una transacción
    $conn->begin_transaction();

    try {
        // Actualizar la fechaHoraFin del último registro de llamado
        $conn->query($sqlActualizarLlamado);

        // Actualizar el estado del paciente
        $conn->query($sqlActualizarPaciente);

        // Confirmar la transacción
        $conn->commit();

        // Redirigir a la página de pacientes después de realizar el alta
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
