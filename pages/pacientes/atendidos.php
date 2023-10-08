<?php 
include('../../conexion/conexion.php');

$sql = 'SELECT id,nombre,apellido,dni,telefono,obraSocial,historiaClinica FROM paciente WHERE estado ="baja"';
$result = $conn->query($sql);

$doctores = array(); // Creamos un arreglo para almacenar los datos de los pacientes

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $identificaciones[] = $row['id'];
        $nombre[] = $row['nombre'];
        $apellidos[] = $row['apellido'];
        $dni[] = $row['dni'];
        $telefonos[] = $row['telefono'];
        $sociales[] = $row['obraSocial'];
        $historiales[] = $row['historiaClinica'];
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
            <i class='bx bx-filter-alt'></i>
            <input type="search" name="filter_dni" id="filter_dni" placeholder="Buscar por DNI">
            <button id="aplicarFiltro">Aplicar Filtro</button>
        </div>

    </nav>
    <?php if (isset($identificaciones) && count($identificaciones) > 0) : ?>
        <div class="container">
            <table id="Tabla">
                <thead>
                    <tr>
                        <th>identificacion</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>DNI</th>
                        <th id="telefono">Telefono</th>
                        <th>Obra Sosial</th>
                        <th >historial Clinico</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($identificaciones as $key => $id) : ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $nombre[$key]; ?></td>
                            <td><?php echo $apellidos[$key]; ?></td>
                            <td><?php echo $dni[$key]; ?></td>
                            <td><?php echo $telefonos[$key]; ?></td>
                            <td><?php echo $sociales[$key]; ?></td>
                            <td style="text-align: start;"><?php echo $historiales[$key]; ?></td>
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
</body>
<script src="atendidos.js"></script>
</html>


<!-- cambiar nombre del archivo y reviar documentacion para la implementacion de una nueva seccion y la distribucion de partes  -->