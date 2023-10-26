<?php
include('../conexion/conexion.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../img/fondazo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/styles.css">
    <title>Home | Hospital</title>
</head>

<body>
    <header class="header">
        <div class="top-bar">
            <div class="logo">
                <i class='bx bx-plus-medical'></i>
            </div>
            <div class="titulo">
                <span>PixelPionners</span>
                <span>Hospital</span>
            </div>
        </div>
        <div class="btn-emergencia">
            <button id="btnLlamado">Emergencia</button>
        </div>
        <nav class="navegacion">
            <a href="../pages/doctores/doctores.php">Doctores</a>
            <a href="../pages/enfermeros/enfermeros.php">Enfermeros</a>
            <a href="../pages/pacientes/pacientes.php">Pacientes</a>
        </nav>
    </header>
    <div class="banner">
        <img src="../img/fondo_incial.jpg" alt="">
    </div>
    <div class="btn-seccion">
        <div class="card">
            <a href="../pages/salas/salas.php">
                <i class='bx bx-bed'></i>
                <span>Salas</span>
            </a>
        </div>
        <div class="card">
            <a href="../pages/llamado/atencion.php">
                <i class='bx bxs-book-add'></i>
                <span>Respuesta de atencion</span>
            </a>
        </div>
        <div class="card">
            <a href="../pages/pacientes/atendidos.php">
                <i class='bx bx-street-view'></i>
                <span>Atendidos</span>
            </a>
        </div>
        <div class="card">
            <a href="../pages/esperas/esperas.php">
                <i class='bx bx-time'></i>
                <span>En Espera</span>
            </a>
        </div>
    </div>


    <!-- para la tabla llamado y llamado _personal-->
    <form id="formularioSala" action="php/alerta.php" method="POST">
        <label for="prioridad">Prioridad de Llamado:</label>
        <select name="prioridad" id="prioridad">
            <option value="normal">Normal</option>
            <option value="emergencia">Emergencia</option>
        </select>

        <!-- se presenta una sala al llamado -->
        <label for="sala">Selecciona una Sala:</label>
        <select name="sala" id="sala">
            <?php
            // Consulta para obtener las salas disponibles
            $sql = "SELECT id, nombre FROM sala WHERE ocupacionActual < capacidadMaxima";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                }
            } else {
                echo "<option value=''>No hay salas disponibles</option>";
            }
            ?>
        </select>

        <!-- Se le asigna personal -->
        <label for="personal">Doctor a asignar:</label>
        <select name="doctor" id="doctor">
            <?php
            // Consulta para obtener personal
            $sql = "SELECT id, nombre, cargo FROM personal WHERE tipo = 'medico'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . '  ' . $row['cargo'] . "</option>";
                }
            }
            ?>
        </select>

        <!-- Se le asigna Enfermero -->
        <label for="personal">Enfermero a asignar:</label>
        <select name="enfermero" id="enfermero">
            <?php
            // Consulta para obtener personal
            $sql = "SELECT id, nombre, tipo, cargo FROM personal WHERE tipo = 'enfermero'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . '  ' . $row['cargo'] . "</option>";
                }
            }
            ?>
        </select>
        <!-- se le asigna una fecha al llamado -->
        <label for="fechaInicio">Fecha de Inicio:</label>
        <input type="datetime-local" name="fechaInicio" id="fechaInicio" required>

        <input type="submit" value="hacer llamado">
    </form>

    <audio src="../img/tone-evacuation.mp3" id="sonido"></audio>
    <script src="js/main.js"></script>
</body>

</html>

<!-- el formulario funciona asi: se sube casi todos los datos(id,sala,paciente,fecha_inicio) a la tabla de sala_paciente mientras que el personal a asignar se sube en la tabla de sala_personal_asignado con el id del llamado -->