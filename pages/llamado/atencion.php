<?php
include('../../conexion/conexion.php');

$sql = 'SELECT * FROM llamado';
$result = $conn->query($sql);

$doctores = array(); // Creamos un arreglo para almacenar los datos de los médicos

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $identificaciones[] = $row['id'];
        $salas[] = $row['idSala'];
        $fechaInicios[] = $row['fechaHoraInicio'];
        $fechaFin[] = $row['fechaHoraFin'];
        $tipoLlamado[] = $row['prioridadLlamada'];
    }
}
?>

<!-- HTML -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../../img/fondazo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/styles.css">
    <title>atencion</title>
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
            <i class='bx bx-filter-alt'></i>
            <select name="filter_estado" id="filter_estado">
                <option value="">Todos</option>
                <option value="emergencia">emergencia</option>
                <option value="normal">normal</option>
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
                        <th>ID Sala</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Finalizacion</th>
                        <th>Tipo de llamado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($identificaciones as $key => $id) : ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $salas[$key]; ?></td>
                            <td><?php echo $fechaInicios[$key]; ?></td>
                            <?php if ($fechaFin[$key] == "0000-00-00 00:00:00") : ?>
                                <td>No se finalizó</td>
                            <?php else : ?>
                                <td><?php echo $fechaFin[$key]; ?></td>
                            <?php endif; ?>
                            <td><?php echo $tipoLlamado[$key]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    <?php else : ?>
        <!-- Mostrar un mensaje si no hay datos -->
        <div class="container">
            <p>No se han cargado ningun llamado.</p>
        </div>
    <?php endif; ?>

<script src="atencion.js"></script>
</body>
</html>