<?php 

include('../../conexion/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["dni"]) && isset($_POST["telefono"])  && isset($_POST["social"])  && isset($_POST["historial"]) ) {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $dni = $_POST["dni"];
    $telefono = $_POST["telefono"];
    $social = $_POST["social"];
    $historial = $_POST["historial"];


// Insertar el nuevo paciente en la tabla paciente
$sql = "INSERT INTO paciente (nombre, apellido, dni, telefono, obraSocial, estado ) VALUES ('$nombre', '$apellido', '$dni', '$telefono','$social','espera')";

if ($conn->query($sql) === TRUE) {
    // Obtener el idPaciente generado automáticamente
    $idPaciente = $conn->insert_id;
    
    // Insertar el historial clínico en la tabla historia_clinica
    $sqlHistorial = "INSERT INTO historia_clinica (idPaciente, contenido)    VALUES ('$idPaciente', '$historial')";
    
    if ($conn->query($sqlHistorial) === TRUE) {
        header("Location: pacientes.php");
        exit();
    } else {
        echo "Error al insertar el historial clínico: " . $conn->error;
        echo '<a href="pacientes.php">Volver a intentar</a>';
    }
} else {
    echo "Error en el registro del paciente: " . $conn->error;
    echo '<a href="pacientes.php">Volver a intentar</a>';
}

}
?>