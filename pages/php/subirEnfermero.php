<?php 

include('../../conexion/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["cargo"]) && isset($_POST["matricula"])) {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $cargo = $_POST["cargo"];
    $matricula = $_POST["matricula"];


    // Validar los campos de registro
    if (empty($nombre) || empty($apellido) || empty($cargo) || empty($matricula) ) {
        echo "Por favor, complete todos los campos.";
    } else {
        // Verificar si el nombre ya está registrado en la base de datos
        $sql = "SELECT * FROM personal WHERE matricula = '$matricula'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "El nombre de usuario ya está registrado.";
        } else {
            // Insertar el nuevo usuario en la base de datos
            $sql = "INSERT INTO personal (nombre, apellido, cargo, matricula, tipo) VALUES ('$nombre', '$apellido', '$cargo', '$matricula','enfermero')";

            if ($conn->query($sql) === TRUE) {
                echo "Registro exitoso";
                header("Location: ../enfermeros.php");
                exit();
            } else {
                echo "Error en el registro: " . $conn->error;
                echo '<a href="../enfermeros.php">Volver a intentar</a>';
            }
        }
    }
}
?>