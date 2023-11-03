<?php
include('../../conexion/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['paciente']) && isset($_POST['historial'])) {
        $idPaciente = $_POST['paciente'];
        $historiaClinica = $_POST['historial'];

        // Escapa las variables para prevenir inyecciones SQL
        $idPaciente = mysqli_real_escape_string($conn, $idPaciente);
        $historiaClinica = mysqli_real_escape_string($conn, $historiaClinica);

        // Crea una sentencia preparada para insertar la historia clínica
        $sqlInsertHistoria = "INSERT INTO historia_clinica (idPaciente, contenido) VALUES (?, ?)";
        $stmtInsertHistoria = $conn->prepare($sqlInsertHistoria);
        $stmtInsertHistoria->bind_param("is", $idPaciente, $historiaClinica);

        if ($stmtInsertHistoria->execute()) {
            
            // Actualiza el estado del paciente a "espera"
            $sqlUpdatePaciente = "UPDATE paciente SET estado = 'espera' WHERE id = ?";
            $stmtUpdatePaciente = $conn->prepare($sqlUpdatePaciente);
            $stmtUpdatePaciente->bind_param("i", $idPaciente);

            if ($stmtUpdatePaciente->execute()) {
                header("Location: pacientes.php");
                exit();
            } else {
                echo "Error al actualizar el estado del paciente: " . $conn->error;
            }
        } else {
            echo "Error al insertar la historia clínica: " . $conn->error;
        }

        // Cierra las sentencias preparadas
        $stmtInsertHistoria->close();
        $stmtUpdatePaciente->close();
    } else {
        echo "Faltan datos en el formulario.";
    }
}

// Cierra la conexión a la base de datos
$conn->close();
?>
