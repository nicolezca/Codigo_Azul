<?php 

include('../../conexion/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sala"]) && isset($_POST["paciente"]) && isset($_POST["fechaInicio"]) && isset($_POST["personal"]) && isset($_POST["prioridad"])) {
    // Obtener los datos del formulario
    $sala = $_POST['sala'];//el id de la sala
    $paciente = $_POST['paciente'];//el id del paciente
    $personal = $_POST['personal'];
    $fechaInicio = $_POST['fechaInicio'];
    $prioridad = $_POST['prioridad'];//tipo de prioridad (normal o emergencia)

    // Primero, se inserta en la tabla llamado
    $sql = "INSERT INTO llamado (idSala, idPaciente, fechaHoraInicio, fechaHoraFin, prioridadLlamada) 
            VALUES ('$sala', '$paciente', '$fechaInicio', ' ', '$prioridad')";
    
    if ($conn->query($sql) === TRUE) {
        // Obten el idLlamado generado automáticamente
        $idLlamado = $conn->insert_id;

        // Ahora, inserta en la tabla sala_personal utilizando el idLlamado
        $sql2 = "INSERT INTO llamado_personal (idLlamado, idPersonal) VALUES ('$idLlamado', '$personal')";
        
        if ($conn->query($sql2) === TRUE) {
            header("location:../../pages/atendidos.php");
        } else {
            echo "Error al asignar la sala: " . $conn->error;
        }
    } else {
        echo "Error al insertar el llamado: " . $conn->error;
    }
}

// Cerrar la conexión a la base de datos
$conn->close();


?>