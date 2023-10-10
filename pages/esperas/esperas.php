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
                        <th>ID Sala</th>
                        <th>ID Paciente</th>
                        <th>Fecha ingreso</th>
                        <th>Fecha Egreso</th>
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
            <p>No se han cargado ningun Paciente.</p>
        </div>
    <?php endif; ?>

    <script src="atencion.js"></script>
</body>

</html>