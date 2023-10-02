<?php
    include('../conexion/conexion.php');

?>

<!DOCTYPE html>
<html lang="en">

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
        <div class="btn-emergencia" >
            <button id="btnLlamado">Emergencia</button>
        </div>
        <nav class="navegacion">
            <a href="../pages/doctores.php">Doctores</a>
            <a href="../pages/enfermeros.php">Enfermeros</a>
            <a href="../pages/pacientes.php">Pacientes</a>
        </nav>
    </header>
    <div class="banner">
        <img src="../img/fondo_incial.jpg" alt="">
    </div>
    <div class="btn-seccion">
        <div class="card">
            <a href="../pages/salas.php">
                 <i class='bx bx-bed'></i>
                <span>Salas</span>
            </a>
        </div>
        <div class="card">
            <a href="">
                <i class='bx bxs-book-add'></i>
                <span>Respuesta de atencion</span>
            </a>
        </div>
        <div class="card">
            <a href="">
                <i class='bx bx-street-view'></i>
                <span>Atendidos</span>
            </a>
        </div>
        <div class="card">
            <a href="">
                <i class='bx bx-time'></i>
                <span>En Espera</span>
            </a>
        </div>
    </div>



    <form id="formularioSala" action="php/alerta.php" method="POST">
        <label for="sala">Selecciona una Sala:</label>
        <select name="sala" id="sala">
            <?php
            // Consulta para obtener las salas disponibles
            $sql = "SELECT id, nombre FROM sala WHERE disponible = '1'";
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
        <label for="paciente">Selecciona una Sala:</label>
        <select name="paciente" id="paciente">
            <?php
            // Consulta para obtener las salas disponibles
            $sql = "SELECT id, nombre FROM paciente WHERE estado = 'espera'";
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
        <label for="fechaInicio">Fecha de Inicio:</label>
        <input type="date" name="fechaInicio" id="fechaInicio" required>

        <label for="fechaFin">Fecha de Fin:</label>
        <input type="date" name="fechaFin" id="fechaFin" required>

        <label for="prioridad">Prioridad de Llamado:</label>
        <select name="prioridad" id="prioridad">
            <option value="Alta">Normal</option>
            <option value="Baja">Emergencia</option>
        </select>

        <label for="personal">Personal a asignar:</label>
        <select name="personal" id="personal">
            <?php
            // Consulta para obtener las salas disponibles
            $sql = "SELECT id, nombre FROM personal";
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


        <input type="submit" value="hacer llamado">
    </form>


    
</body>
<script src="js/main.js"></script>
</html>