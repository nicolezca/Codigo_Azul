<?php
include('../../conexion/conexion.php');

session_start();

// Verificar si no hay una sesión activa
if (!isset($_SESSION["nombre"]) || !isset($_SESSION["clave"])) {
    header("Location: ../../login/formulario.html");
    exit();
}

$sql = 'SELECT p.id, p.nombre, p.apellido, p.dni, p.telefono, p.obraSocial, h.contenido
        FROM paciente p
        LEFT JOIN (
            SELECT idPaciente, MAX(id) AS max_id FROM historia_clinica GROUP BY idPaciente
        ) hmax ON p.id = hmax.idPaciente
        LEFT JOIN historia_clinica h ON hmax.idPaciente = h.idPaciente AND hmax.max_id = h.id
        WHERE p.estado = "atendido"';

$result = $conn->query($sql);

$pacientes = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pacientes[] = array(
            'id' => $row['id'],
            'nombre' => $row['nombre'],
            'apellido' => $row['apellido'],
            'dni' => $row['dni'],
            'telefono' => $row['telefono'],
            'obraSocial' => $row['obraSocial'],
            'historiaClinica' => $row['contenido'],
        );
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/styles.css">
    <title>Atendidos</title>
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
        <div class="filtrar">
            <div class="agregarDoc">
                <button id="mostrarFormulario">Dar de alta</button>
            </div>
            <i class='bx bx-filter-alt'></i>
            <input type="search" name="filter_dni" id="filter_dni" placeholder="Buscar por DNI">
            <button id="aplicarFiltro">Aplicar Filtro</button>
        </div>

    </nav>
    <?php if (isset($pacientes) && count($pacientes) > 0) : ?>
        <div class="container">
            <table id="Tabla">
                <thead>
                    <tr>
                        <th>Identificación</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>DNI</th>
                        <th>Teléfono</th>
                        <th>Obra Social</th>
                        <th>Historial Clínico</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pacientes as $paciente) : ?>
                        <tr>
                            <td><?php echo $paciente['id']; ?></td>
                            <td><?php echo $paciente['nombre']; ?></td>
                            <td><?php echo $paciente['apellido']; ?></td>
                            <td><?php echo $paciente['dni']; ?></td>
                            <td><?php echo $paciente['telefono']; ?></td>
                            <td><?php echo $paciente['obraSocial']; ?></td>
                            <td style="text-align: start;"><?php echo $paciente['historiaClinica']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <!-- Mostrar un mensaje si no hay datos -->
        <div class="container">
            <p>No se han cargado ningun Paciente.</p>
        </div>
    <?php endif; ?>

    <!-- para la tabla sala_paciente y sala_personal_asignado -->
    <form action="altaPacientes.php" id="formDoc" method="POST">
        <label for="paciente">Selecciona el paciente:</label>
        <select name="paciente" id="paciente">
            <?php
            // Consulta para obtener las pacientes disponibles
            $sql = "SELECT id, nombre, apellido FROM paciente WHERE estado = 'atendido'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nombre'], ' ', $row['apellido'] . "</option>";
                }
            } else {
                echo "<option value=''>No hay pacientes sin atender</option>";
            }
            ?>
        </select><br><br>

        <label for="fechafin">Fecha de Salida:</label>
        <input type="datetime-local" name="fechafin" id="fechafin" required><br><br>

        <input type="submit" value="hacer llamado">
    </form>
</body>

<form action="" method="post"></form>
<script src="atendidos.js"></script>

</html>