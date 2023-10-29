<?php 


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["idSala"])) {
    $idSala = $_POST["idSala"];

    // Inicializa variables para almacenar datos
    $pacientes = array();
    $personal = array();

    // Consulta para obtener los datos de la sala
    $salaQuery = "SELECT * FROM sala WHERE id = $idSala";
    $salaResult = $conn->query($salaQuery);

    if ($salaResult === false) {
        die("Error al ejecutar la consulta de la sala: " . $conn->error);
    }

    $salaData = $salaResult->fetch_assoc();

    // Consulta para obtener los pacientes en la sala
    $pacienteQuery = "SELECT paciente.* FROM sala_paciente
                     INNER JOIN paciente ON sala_paciente.idPaciente = paciente.id
                     WHERE sala_paciente.idSala = $idSala";
    $pacienteResult = $conn->query($pacienteQuery);

    if ($pacienteResult === false) {
        die("Error al ejecutar la consulta de pacientes: " . $conn->error);
    }

    while ($row = $pacienteResult->fetch_assoc()) {
        $pacientes[] = $row;
    }

    // Consulta para obtener el personal asignado a la sala
    $personalQuery = "SELECT DISTINCT personal.* FROM sala_personal_asignado
                     INNER JOIN personal ON sala_personal_asignado.idPersonal = personal.id
                     WHERE sala_personal_asignado.idSala = $idSala";
    $personalResult = $conn->query($personalQuery);

    if ($personalResult === false) {
        die("Error al ejecutar la consulta de personal: " . $conn->error);
    }

    while ($row = $personalResult->fetch_assoc()) {
        $personal[] = $row;
    }




}

?>