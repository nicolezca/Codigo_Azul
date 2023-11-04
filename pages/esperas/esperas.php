<?php
include('../../conexion/conexion.php');

session_start();

// Verificar si no hay una sesión activa
if (!isset($_SESSION["nombre"]) || !isset($_SESSION["clave"])) {
    header("Location: ../../login/formulario.html");
    exit();
}

function generarOpciones($opciones, $valorSeleccionado = '') {
    $htmlOpciones = '';

    foreach ($opciones as $valor => $texto) {
        $seleccionado = ($valor == $valorSeleccionado) ? 'selected' : '';
        $htmlOpciones .= "<option value='$valor' $seleccionado>$texto</option>";
    }

    return $htmlOpciones;
}

// Define arrays para los días y turnos
$dias = array(
    'Lunes' => 'Lunes',
    'Martes' => 'Martes',
    'Miercoles' => 'Miércoles',
    'Jueves' => 'Jueves',
    'Viernes' => 'Viernes',
    'Sabado' => 'Sábado',
    'Domingo' => 'Domingo'
);

$turnos = array(
    'M' => 'Mañana',
    'T' => 'Tarde',
    'N' => 'Noche'
);


function obtenerPacientesEnEspera($conn)
{
    $sql = 'SELECT id, nombre, apellido, dni, telefono, obraSocial FROM paciente WHERE estado = "espera"';
    $result = $conn->query($sql);

    $pacientes = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $pacientes[] = $row;
        }
    }
    return $pacientes;
}

function obtenerOpcionesSelect($result, $valueField, $textField, $defaultValue = '')
{
    $options = '';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $value = $row[$valueField];
            $text = $row[$textField];
            $selected = ($value == $defaultValue) ? 'selected' : '';
            $options .= "<option value='$value' $selected>$text</option>";
        }
    } else {
        $options = "<option value=''>No hay opciones disponibles</option>";
    }
    return $options;
}

$pacientes = obtenerPacientesEnEspera($conn);
$identificaciones = array_column($pacientes, 'id');
$nombre = array_column($pacientes, 'nombre');
$apellido = array_column($pacientes, 'apellido');
$dni = array_column($pacientes, 'dni');
$telefono = array_column($pacientes, 'telefono');
$obraSocial = array_column($pacientes, 'obraSocial');
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
        form .content {
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
    <title>Pacientes en Espera</title>
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
    <?php if (!empty($identificaciones)) : ?>
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
        <!-- Mostrar un mensaje si no hay pacientes en espera -->
        <div class="container">
            <p>No hay ningún paciente en espera.</p>
        </div>
    <?php endif; ?>

    <form action="darAtendido.php" method="post" id="formularioAtender" style="background-color:white;transform: translateX(-100%); position:absolute;top:10%;transition: all .3s ease-in; width: 500px; padding: 20px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.4);">
        <label for="pacienteAsignar">Selecciona al paciente:</label>
        <select name="pacienteAsignar" id="pacienteAsignar" required>
            <?php
            $sql = "SELECT id, nombre FROM paciente WHERE estado = 'espera'";
            $result = $conn->query($sql);
            echo obtenerOpcionesSelect($result, 'id', 'nombre');
            ?>
        </select>

        <label for="sala">Selecciona la Sala: </label>
        <select name="sala" id="sala" required>
            <?php
            $sql = "SELECT id, nombre FROM sala WHERE ocupacionActual < capacidadMaxima";
            $result = $conn->query($sql);
            echo obtenerOpcionesSelect($result, 'id', 'nombre');
            ?>
        </select>

        <div class="content">
            <label for="doctor">Selecciona al doctor:</label>
            <select name="doctor" id="doctor" required>
                <?php
                $sql = "SELECT id, nombre, cargo FROM personal WHERE tipo = 'medico' AND id NOT IN (SELECT idPersonal FROM sala_personal_asignado)";
                $result = $conn->query($sql);
                echo obtenerOpcionesSelect($result, 'id', 'nombre', '');
                ?>
            </select>

            <label for="doctorDia">Día para el doctor:</label>
            <select name="doctorDia" id="doctorDia" required>
                <?php echo generarOpciones($dias); ?>
            </select>

            <label for="doctorTurno">Turno para el doctor:</label>
            <select name="doctorTurno" id="doctorTurno" required>
                <?php echo generarOpciones($turnos); ?>
            </select>
        </div>

        <div class="content">
            <label for="enfermero1">Selecciona al primer enfermero:</label>
            <select name="enfermero1" id="enfermero1" required>
                <?php
                $sql = "SELECT id, nombre, cargo FROM personal WHERE tipo = 'enfermero' ";
                $result = $conn->query($sql);
                echo obtenerOpcionesSelect($result, 'id', 'nombre', '');
                ?>
            </select>

            <label for "enfermero1Dia">Día para el primer enfermero:</label>
            <select name="enfermero1Dia" id="enfermero1Dia" required>
                <?php echo generarOpciones($dias); ?>
            </select>

            <label for="enfermero1Turno">Turno para el primer enfermero:</label>
            <select name="enfermero1Turno" id="enfermero1Turno" required>
                <?php echo generarOpciones($turnos); ?>
            </select>
        </div>

        <div class="content">
            <label for="enfermero2">Selecciona al segundo enfermero:</label>
            <select name="enfermero2" id="enfermero2" required>
                <?php
                $sql = "SELECT id, nombre, cargo FROM personal WHERE tipo = 'enfermero'";
                $result = $conn->query($sql);
                echo obtenerOpcionesSelect($result, 'id', 'nombre', '');
                ?>
            </select>

            <label for="enfermero2Dia">Día para el segundo enfermero:</label>
            <select name="enfermero2Dia" id="enfermero2Dia" required>
            <?php echo generarOpciones($dias); ?>
            </select>

            <label for="enfermero2Turno">Turno para el segundo enfermero:</label>
            <select name="enfermero2Turno" id="enfermero2Turno" required>
            <?php echo generarOpciones($turnos); ?>
            </select>
        </div><br>

        <label for="horaIngreso">Ingresar Hora de Atencion: </label>
        <input type="datetime-local" name="horaIngreso" id="horaIngresos" required>

        <input type="submit" value="Asignar personal" style="margin-top: 20px;">
    </form>

</body>
<script src="esperas.js"></script>

</html>