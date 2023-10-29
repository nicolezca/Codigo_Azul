<?php
include('../../conexion/conexion.php');
// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtiene los datos del formulario
    $idPaciente = $_POST['paciente'];
    $historiaClinica = $_POST['historial'];

    // Realiza la inserción en la tabla de historia_clínica
    $sqlInsertHistoria = "INSERT INTO historia_clinica (idPaciente, contenido) VALUES ($idPaciente, '$historiaClinica')";

    // La historia clínica se insertó con éxito
    if ($conn->query($sqlInsertHistoria) === true) {

        // Actualiza el estado del paciente a "espera"
        $sqlUpdatePaciente = "UPDATE paciente SET estado = 'espera' WHERE id = $idPaciente";

        if ($conn->query($sqlUpdatePaciente) === true) {
            header(
                "Location:pacientes.php"
            );
            exit();
        } else {
            echo "Error al actualizar el estado del paciente: " . $conn->error;
        }
    } else {
        // Ocurrió un error al insertar la historia clínica
        echo "Error al insertar la historia clínica: " . $conn->error;
    }

    // Cierra la conexión a la base de datos
    $conn->close();
}
?>
