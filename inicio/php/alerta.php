<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sala"]) && isset($_POST["paciente"]) && isset($_POST["fechaInicio"]) && isset($_POST["fechaFin"]) && isset($_POST["prioridad"])) {
    // Obtener los datos del formulario
    $sala = $_POST['sala'];
    $paciente = $_POST['paciente'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $prioridad = $_POST['prioridad'];

    // Realizar las operaciones necesarias en la base de datos (por ejemplo, insertar los datos en una tabla)
    $sql = "INSERT INTO asignaciones_salas (sala, paciente, fecha_inicio, fecha_fin, prioridad) 
            VALUES ('$sala', '$paciente', '$fechaInicio', '$fechaFin', '$prioridad')";

    if ($conn->query($sql) === TRUE) {
        echo "Asignación de sala exitosa.";
    } else {
        echo "Error al asignar la sala: " . $conn->error;
    }
}
// Cerrar la conexión a la base de datos
$conn->close();

?>