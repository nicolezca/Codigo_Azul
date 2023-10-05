<?php 

include('../../conexion/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["dni"]) && isset($_POST["telefono"])  && isset($_POST["social"])  && isset($_POST["historial"])  && isset($_POST["estado"])) {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $dni = $_POST["dni"];
    $telefono = $_POST["telefono"];
    $social = $_POST["social"];
    $historial = $_POST["historial"];
    $estado = $_POST["estado"];


    // Validar los campos de registro
    if (empty($nombre) || empty($apellido) || empty($dni) || empty($telefono) || empty($social) || empty($historial)  || empty($estado) ) {
        echo "Por favor, complete todos los campos.";
    } else {
            // Insertar el nuevo usuario en la base de datos
            $sql = "INSERT INTO paciente (nombre, apellido, dni, telefono, obraSocial, historiaClinica, estado ) VALUES ('$nombre', '$apellido', '$dni', '$telefono','$social', '$historial', '$estado')";

            if ($conn->query($sql) === TRUE) {
                header("Location: ../pacientes.php");
                exit();
            } else {
                echo "Error en el registro: " . $conn->error;
                echo '<a href="../pacientes.php">Volver a intentar</a>';
            }
        }
}
?>