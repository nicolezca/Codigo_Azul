<?php
include('../../conexion/conexion.php');

session_start();

// Verificar si no hay una sesión activa
if (!isset($_SESSION["nombre"]) || !isset($_SESSION["clave"])) {
    header("Location: ../../login/formulario.html");
    exit();
}

function obtenerDoctores($conn) {
    $sql = 'SELECT * FROM personal WHERE tipo ="medico"';
    $result = $conn->query($sql);
    $doctores = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $doctor = array(
                'identificacion' => $row['id'],
                'nombre' => $row['nombre'],
                'apellidos' => $row['apellido'],
                'cargo' => $row['cargo'],
                'matricula' => $row['matricula']
            );
            $doctores[] = $doctor;
        }
    }

    return $doctores;
}

$doctores = obtenerDoctores($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/styles.css">
    <title>Doctores</title>
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
            <button id="mostrarFormulario">Nuevo doctor</button>
        </div>
        <div class="filtrar">
            <i class='bx bx-filter-alt'></i>
            <input type="search" name="filter_matricula" id="filter_matricula" placeholder="Buscar por matrícula">
            <button id="aplicarFiltro">Aplicar Filtro</button>
        </div>
    </nav>
    <?php if (!empty($doctores)) : ?>
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
                    <?php foreach ($doctores as $doctor) : ?>
                        <tr>
                            <td><?php echo $doctor['identificacion']; ?></td>
                            <td><?php echo $doctor['nombre']; ?></td>
                            <td><?php echo $doctor['apellidos']; ?></td>
                            <td><?php echo $doctor['cargo']; ?></td>
                            <td><?php echo $doctor['matricula']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <!-- Mostrar un mensaje si no hay datos -->
        <div class="container">
            <p>No se han cargado ningún Doctor.</p>
        </div>
    <?php endif; ?>

    <form action="subirDoctor.php" id="formDoc" method="post">
        <label for="nombre">Nombre del Doctor:</label>
        <input type="text" id="nombre" name="nombre" required autocomplete="off"><br><br>

        <label for="apellido">Apellidos del Doctor:</label>
        <input type="text" id="apellido" name="apellido" required autocomplete="off"><br><br>

        <label for="cargo">Cargo del Doctor:</label>
        <input type="text" id="cargo" name="cargo" required autocomplete="off"><br><br>

        <label for="matricula">Matrícula del Doctor:</label>
        <input type="text" id="matricula" name="matricula" required autocomplete="off"><br><br>

        <input type="submit" value="Agregar Doctor">
    </form>

</body>
<!-- crear js general para mostrar formulario -->
<script src="../js/main.js"></script>
</html>
