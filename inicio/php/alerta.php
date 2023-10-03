<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sala"]) && isset($_POST["paciente"]) && isset($_POST["fechaInicio"]) && isset($_POST["fechaFin"]) && isset($_POST["prioridad"])) {
    // Obtener los datos del formulario
    $sala = $_POST['sala'];//el id de la sala
    $paciente = $_POST['paciente'];//el id del paciente
    $fechaInicio = $_POST['fechaInicio'];
    $prioridad = $_POST['prioridad'];//tipo de prioridad (normal o emergencia)


    $sql = "INSERT INTO llamado (sala, paciente, fechaHoraIngreso, fechaHoraEgreso, prioridad) 
            VALUES ('$sala', '$paciente', '$fechaInicio', '$fechaFin', '$prioridad')";

    $sql2 = "INSERT INTO sala_personal_asignado (idSala, idPaciente) VALUES";
    if ($conn->query($sql,$sql2) === TRUE) {
        header(
            "location:../../pages/atendidos.php"
        );
    } else {
        echo "Error al asignar la sala: " . $conn->error;
    }
}
// Cerrar la conexión a la base de datos
$conn->close();

?>