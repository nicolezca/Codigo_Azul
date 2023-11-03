<?php
include('../../conexion/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario y asegurarse de que no estén vacíos
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
    $piso = isset($_POST["piso"]) ? $_POST["piso"] : "";
    $estado = isset($_POST["estado"]) ? $_POST["estado"] : "";
    $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
    $capacidad = isset($_POST["capacidad"]) ? $_POST["capacidad"] : "";
    $ocupacion = isset($_POST["ocupacion"]) ? $_POST["ocupacion"] : "";

    // Validar los campos del formulario
    if (empty($nombre) || empty($piso) || empty($estado) || empty($tipo) || empty($capacidad) || empty($ocupacion)) {
        echo "Por favor, complete todos los campos.";
    } else {
        // Prevenir inyección SQL utilizando declaraciones preparadas
        $sql = "INSERT INTO sala (nombre, piso, disponible, tipo, capacidadMaxima, ocupacionActual) VALUES (?, ?, ?, ?, ?, ?)";
        
        // Preparar la declaración
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Vincular parámetros
            $stmt->bind_param("ssssii", $nombre, $piso, $estado, $tipo, $capacidad, $ocupacion);

            // Ejecutar la declaración
            if ($stmt->execute()) {
                $stmt->close();
                header("Location: salas.php");
                exit();
            } else {
                echo "Error en el registro: " . $stmt->error;
                $stmt->close();
                echo '<a href="salas.php">Volver a intentar</a>';
            }
        } else {
            echo "Error en la preparación de la consulta: " . $conn->error;
        }
    }
}
?>
