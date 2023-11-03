<?php
include('../../conexion/conexion.php');

function obtenerEnfermeros($conn) {
    $sql = 'SELECT * FROM personal WHERE tipo ="enfermero"';
    $result = $conn->query($sql);
    $enfermeros = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $enfermero = array(
                'identificacion' => $row['id'],
                'nombre' => $row['nombre'],
                'apellidos' => $row['apellido'],
                'cargo' => $row['cargo'],
                'matricula' => $row['matricula']
            );
            $enfermeros[] = $enfermero;
        }
    }

    return $enfermeros;
}

$enfermeros = obtenerEnfermeros($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/styles.css">
    <title>Enfermeros</title>
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
            <button id="mostrarFormulario">Nuevo enfermero</button>
        </div>
        <div class="filtrar">
            <i class='bx bx-filter-alt'></i>
            <input type="search" name="filter_matricula" id="filter_matricula" placeholder="Buscar por matrícula">
            <button id="aplicarFiltro">Aplicar Filtro</button>
        </div>
    </nav>
    <?php if (!empty($enfermeros)) : ?>
        <div class="container">
            <table id="Tabla">
                <thead>
                    <tr>
                        <th>Identificación</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Cargo</th>
                        <th>Matrícula</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enfermeros as $enfermero) : ?>
                        <tr>
                            <td><?php echo $enfermero['identificacion']; ?></td>
                            <td><?php echo $enfermero['nombre']; ?></td>
                            <td><?php echo $enfermero['apellidos']; ?></td>
                            <td><?php echo $enfermero['cargo']; ?></td>
                            <td><?php echo $enfermero['matricula']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <!-- Mostrar un mensaje si no hay datos -->
        <div class="container">
            <p>No se han cargado ningún enfermero.</p>
        </div>
    <?php endif; ?>

    <form action="subirEnfermero.php" id="formDoc" method="post">
        <label for="nombre">Nombre del Enfermero:</label>
        <input type="text" id="nombre" name="nombre" required autocomplete="off"><br><br>

        <label for="apellido">Apellidos del Enfermero:</label>
        <input type="text" id="apellido" name "apellido" required autocomplete="off"><br><br>

        <label for="cargo">Cargo del Enfermero:</label>
        <input type="text" id="cargo" name="cargo" required autocomplete="off"><br><br>

        <label for="matricula">Matrícula del Enfermero:</label>
        <input type="text" id="matricula" name="matricula" required autocomplete="off"><br><br>

        <input type="submit" value="Agregar enfermero">
    </form>

</body>
<script src="../js/main.js"></script>
</html>
