<?php
include('../../conexion/conexion.php');

$sql = 'SELECT id,nombre,apellido,dni,telefono,obraSocial,estado FROM paciente';
$result = $conn->query($sql);

$doctores = array(); // Creamos un arreglo para almacenar los datos de los médicos

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $identificaciones[] = $row['id'];
        $doctores[] = $row['nombre'];
        $apellidos[] = $row['apellido'];
        $dni[] = $row['dni'];
        $telefonos[] = $row['telefono'];
        $sociales[] = $row['obraSocial'];
        $estados[] = $row['estado'];
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
    <title>Pacientes</title>
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
            <button id="mostrarFormulario">nuevo paciente</button>
        </div>
        <div class="filtrar">
            <i class='bx bx-filter-alt'></i>
            <input type="search" name="filter_dni" id="filter_dni" placeholder="Buscar por DNI">
            <select name="filter_estado" id="filter_estado">
                <option value="">Todos</option>
                <option value="alta">Alta</option>
                <option value="baja">Baja</option>
                <option value="espera">Espera</option>
            </select>
            <button id="aplicarFiltro">Aplicar Filtro</button>
        </div>

    </nav>
    <?php if (isset($identificaciones) && count($identificaciones) > 0) : ?>
        <div class="container">
            <table id="Tabla">
                <thead>
                    <tr>
                        <th>Identificación</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>DNI</th>
                        <th id="telefono">Teléfono</th>
                        <th>Obra Social</th>
                        <th>Estado</th>
                        <th>historial</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($identificaciones as $key => $id) : ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $doctores[$key]; ?></td>
                            <td><?php echo $apellidos[$key]; ?></td>
                            <td><?php echo $dni[$key]; ?></td>
                            <td><?php echo $telefonos[$key]; ?></td>
                            <td><?php echo $sociales[$key]; ?></td>
                            <td><?php echo $estados[$key]; ?></td>
                            <td>
                                <form action="php/pdf.php" method="post" id="algo">
                                    <input type="hidden" name="id_paciente" value="<?php echo $id; ?>">
                                    <input type="submit" value="Historial Clínico">
                                </form>
                            </td>
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

    <form action="subirPaciente.php" id="formDoc" method="post">
        <label for="nombre">Nombre del paciente:</label>
        <input type="text" id="nombre" name="nombre" required autocomplete="off"><br><br>

        <label for="apellido">Apellidos del paciente:</label>
        <input type="text" id="apellido" name="apellido" required autocomplete="off"><br><br>

        <label for="dni">DNI del paciente:</label>
        <input type="text" id="dni" name="dni" required autocomplete="off"><br><br>

        <label for="telefno">Telefono del paciente:</label>
        <input type="text" id="telefno" name="telefono" required autocomplete="off"><br><br>

        <label for="social">Obra social del paciente:</label>
        <input type="text" id="social" name="social" required autocomplete="off"><br><br>

        <label for="historial">HIstorial del paciente:</label>
        <input type="text" id="historial" name="historial" required autocomplete="off"><br><br>

        <label for="historial">Estado del paciente:</label>
        <select name="estado" id="estado">
            <option value="alta">alta</option>
            <option value="baja">baja</option>
            <option value="espera">espera</option>
        </select><br><br>
        <input type="submit" value="Agregar paciente">
    </form>

</body>
<script src="pacientes.js"></script>

</html>