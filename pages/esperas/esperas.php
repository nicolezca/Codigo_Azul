<?php

include('../../conexion/conexion.php');

$sql = 'SELECT id,nombre,apellido,dni,telefono,obraSocial FROM paciente WHERE estado="espera"';
$result = $conn->query($sql);

$doctores = array(); // Creamos un arreglo para almacenar los datos de los médicos

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $identificaciones[] = $row['id'];
        $nombre[] = $row['nombre'];
        $apellido[] = $row['apellido'];
        $dni[] = $row['dni'];
        $telefono[] = $row['telefono'];
        $obraSocial[] = $row['obraSocial'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../../img/fondazo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        form .content{
            display: flex;
            flex-direction: column;
        }
        form .content label {
            margin: 5px;
            display: block;
        }

        form select {
            width: 100%;
        }
    </style>
    <title>Pacienetes | esperas</title>
</head>

<body>
    <header>
        <a href="../../inicio/inicio.php">
            <div class="logo">
                <i class='bx bx-plus-medical'></i>
            </div>
            <div class="titulo">
                <span>PixelPionners</span>
                <span>Hospital</span>
            </div>
        </a>
    </header>
    <nav>
        <div class="agregarDoc">
            <button id="mostrarFormulario">Atender</button>
        </div>

    </nav>
    <?php if (isset($identificaciones) && count($identificaciones) > 0) : ?>
        <div class="container">
            <table id="Tabla">
                <thead>
                    <tr>
                        <th>Identificación</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Telefono</th>
                        <th>Obra Social</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($identificaciones as $key => $id) : ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $nombre[$key]; ?></td>
                            <td><?php echo $apellido[$key]; ?></td>
                            <td><?php echo $dni[$key]; ?></td>
                            <td><?php echo $telefono[$key]; ?></td>
                            <td><?php echo $obraSocial[$key]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    <?php else : ?>
        <!-- Mostrar un mensaje si no hay datos -->
        <div class="container">
            <p>No hay ningun Paciente en espera.</p>
        </div>
    <?php endif; ?>


    <form action="darAtendido.php" method="post" id="formularioAtender" style="background-color:white;transform: translateX(-100%); position:absolute;top:10%;transition: all .3s ease-in; width: 500px; padding: 20px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.4);">
        <label for="pacienteAsignar">Selecciona al paciente:</label>
        <select name="pacienteAsignar" id="pacienteAsignar" require>
            <?php
            // Consulta para obtener los pacientes en espera
            $sql = "SELECT id, nombre FROM paciente WHERE estado = 'espera'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                }
            } else {
                echo "<option value=''>No hay pacientes en espera</option>";
            }
            ?>
        </select>

        <label for="sala">Selecciona la Sala: </label>
        <select name="sala" id="sala" require>
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
        
        <div class="content">
            <label for="doctor">Selecciona al doctor:</label>
            <select name="doctor" id="doctor" require>
                <?php
                // Consulta para obtener los doctores disponibles
                $sql = "SELECT id, nombre, cargo FROM personal WHERE tipo = 'medico' AND id NOT IN (SELECT idPersonal FROM sala_personal_asignado)";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . ' ' . $row['cargo'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay doctores disponibles</option>";
                }
                ?>
            </select>

            <label for="doctorDia">Día para el doctor:</label>
            <select name="doctorDia" id="doctorDia" require>
                <option value="Lunes">Lunes</option>
                <option value="Martes">Martes</option>
                <option value="Miercoles">Miercoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
                <option value="Sabado">Sabado</option>
                <option value="Domingo">Domingo</option>
                <!-- Agrega más opciones de días según tu necesidad -->
            </select>

            <label for="doctorTurno">Turno para el doctor:</label>
            <select name="doctorTurno" id="doctorTurno" require>
                <option value="M">Mañana</option>
                <option value="T">Tarde</option>
                <option value="N">Noche</option>
                <!-- Agrega más opciones de turnos según tu necesidad -->
            </select>
        </div>

        <div class="content">
            <label for="enfermero1">Selecciona al primer enfermero:</label>
            <select name="enfermero1" id="enfermero1" require>
                <?php
                // Consulta para obtener los enfermeros disponibles
                $sql = "SELECT id, nombre, cargo FROM personal WHERE tipo = 'enfermero' ";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . ' '. $row['cargo']. "</option>";
                    }
                } else {
                    echo "<option value=''>No hay enfermeros disponibles</option>";
                }
                ?>
            </select>

            <label for="enfermero1Dia">Día para el primer enfermero:</label>
            <select name="enfermero1Dia" id="enfermero1Dia" require>
                <option value="Lunes">Lunes</option>
                <option value="Martes">Martes</option>
                <option value="Miercoles">Miercoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
                <option value="Sabado">Sabado</option>
                <option value="Domingo">Domingo</option>
                <!-- Agrega más opciones de días según tu necesidad -->
            </select>

            <label for="enfermero1Turno">Turno para el primer enfermero:</label>
            <select name="enfermero1Turno" id="enfermero1Turno" require>
                <option value="M">Mañana</option>
                <option value="T">Tarde</option>
                <option value="N">Noche</option>
                <!-- Agrega más opciones de turnos según tu necesidad -->
            </select>
        </div>

        <div class="content">
            <label for="enfermero2">Selecciona al segundo enfermero:</label>
            <select name="enfermero2" id="enfermero2" require>
                <?php
                // Consulta para obtener los enfermeros disponibles
                $sql = "SELECT id, nombre, cargo FROM personal WHERE tipo = 'enfermero'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['nombre'] .  ' '. $row['cargo']."</option>";
                    }
                } else {
                    echo "<option value=''>No hay enfermeros disponibles</option>";
                }
                ?>
            </select>

            <label for="enfermero2Dia">Día para el segundo enfermero:</label>
            <select name="enfermero2Dia" id="enfermero2Dia" require>
                <option value="Lunes">Lunes</option>
                <option value="Martes">Martes</option>
                <option value="Miercoles">Miercoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
                <option value="Sabado">Sabado</option>
                <option value="Domingo">Domingo</option>
                <!-- Agrega más opciones de días según tu necesidad -->
            </select>

            <label for="enfermero2Turno">Turno para el segundo enfermero:</label>
            <select name="enfermero2Turno" id="enfermero2Turno" require>
                <option value="M">Mañana</option>
                <option value="T">Tarde</option>
                <option value="N">Noche</option>
                <!-- Agrega más opciones de turnos según tu necesidad -->
            </select>
        </div>
        <label for="horaIngreso">Ingresar Hora de Atencion</label>
        <input type="datetime-local" name="horaIngreso" id="horaIngresos" require>

        <input type="submit" value="Asignar personal" style="margin-top: 20px;">
    </form>


    <script src="esperas.js"></script>
</body>

</html>