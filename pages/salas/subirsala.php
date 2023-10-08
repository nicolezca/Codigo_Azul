<?php 

include('../../conexion/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"]) && isset($_POST["piso"]) && isset($_POST["estado"]) && isset($_POST["tipo"]) && isset($_POST["capacidad"])  && isset($_POST["ocupacion"]) ) {
    $nombre = $_POST["nombre"];
    $piso = $_POST["piso"];
    $estado = $_POST["estado"];
    $tipo = $_POST["tipo"];
    $capacidad = $_POST["capacidad"];
    $ocupacion = $_POST["ocupacion"];
    

    // Validar los campos de registro
    if (empty($nombre) || empty($piso) || empty($estado) || empty($tipo) || empty($capacidad) || empty($ocupacion)  ) {
        echo "Por favor, complete todos los campos.";
    } else {
            // Insertar el nuevo usuario en la base de datos
            $sql = "INSERT INTO sala (nombre, piso, disponible, tipo, capacidadMaxima, ocupacionActual ) VALUES ('$nombre', '$piso', '$estado', '$tipo','$capacidad', '$ocupacion')";

            if ($conn->query($sql) === TRUE) {
                header("Location: ../salas.php");
                exit();
            } else {
                echo "Error en el registro: " . $conn->error;
                echo '<a href="../sala.php">Volver a intentar</a>';
            }
        }
}
?>