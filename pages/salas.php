<?php
include('../conexion/conexion.php');

$sql = 'SELECT * FROM sala';
$result = $conn->query($sql);

$doctores = array(); // Creamos un arreglo para almacenar los datos de los médicos

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $identificaciones[] = $row['id'];
        $salas[] = $row['nombre'];
        $pisos[] = $row['piso'];
        $estado[] = $row['disponible'];
        $tipo[] = $row['tipo'];
        $capacidadM[] = $row['capacidadMaxima'];
        $ocupacion[] = $row['ocupacionActual'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/styles.css">
    <title>Pacientes</title>
</head>

<body>
    <header>
        <a href="../inicio/inicio.php">
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
            <button id="mostrarFormulario">nueva sala</button>
        </div>
        <div class="filtrar">
            <i class='bx bx-filter-alt'></i>
            <input type="search" name="filter_dni" id="filter_dni" placeholder="Buscar por nombre">
            <select name="filter_estado" id="filter_estado">
                <option value="">Todos</option>
                <option value="ocupada">ocupada</option>
                <option value="desocupada">desocupada</option>
            </select>
            <button id="aplicarFiltro">Aplicar Filtro</button>
        </div>

    </nav>
    <?php if (isset($identificaciones) && count($identificaciones) > 0) : ?>
        <div class="container">
            <table id="Tabla">
                <thead>
                    <tr>
                        <th>identificacion</th>
                        <th>sala</th>
                        <th>piso</th>
                        <th>estado</th>
                        <th>tipo</th>
                        <th id="telefono">capacidad Maxima</th>
                        <th>ocupacion actual</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($identificaciones as $key => $id) : ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $salas[$key]; ?></td>
                            <td><?php echo $pisos[$key]; ?></td>
                            <td><?php echo $estado[$key]; ?></td>
                            <td><?php echo $tipo[$key]; ?></td>
                            <td><?php echo $capacidadM[$key]; ?></td>
                            <td><?php echo $ocupacion[$key]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <!-- Mostrar un mensaje si no hay datos -->
        <div class="container">
            <p>No se han cargado ninguna Sala.</p>
        </div>
    <?php endif; ?>

    <form action="php/subirsala.php" id="formDoc" method="post">
        <label for="nombre">Nombre de la sala:</label>
        <input type="text" id="nombre" name="nombre" required autocomplete="off"><br><br>

        <label for="piso">Piso de la sala:</label>
        <input type="text" id="piso" name="piso" required autocomplete="off"><br><br>

        <label for="estado">Estado de la Sala:</label>
        <input type="text" id="estado" name="estado" required autocomplete="off"><br><br>

        <label for="estado">tipo de la Sala:</label>
        <select name="tipo" id="tipo">
            <option value="sala">sala</option>
            <option value="vaño">baño</option>
        </select><br><br>

        <label for="capacidad">capacidad de la sala</label>
        <input type="text" id="capacidad" name="capacidad" required autocomplete="off"><br><br>

        <label for="ocupacion">ocupacion Actual:</label>
        <input type="text" id="ocupacion" name="ocupacion" required autocomplete="off"><br><br>

        <input type="submit" value="Agregar sala">
    </form>

</body>
<script src="js/main.js"></script>

</html>