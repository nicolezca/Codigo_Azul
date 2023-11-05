<?php
include('../../conexion/conexion.php');

session_start();

// Verificar si no hay una sesión activa
if (!isset($_SESSION["nombre"]) || !isset($_SESSION["clave"])) {
    header("Location: ../../login/formulario.html");
    exit();
}

// Consultar las salas
$sql = 'SELECT * FROM sala';
$result = $conn->query($sql);

$salas = array(); // Un arreglo para almacenar los datos de las salas

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $salas[] = array(
            'id' => $row['id'],
            'nombre' => $row['nombre'],
            'piso' => $row['piso'],
            'tipo' => $row['tipo'],
            'capacidadMaxima' => $row['capacidadMaxima'],
            'ocupacionActual' => $row['ocupacionActual'],
            'disponible' => $row['disponible'],
        );
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/styles.css">
    <title>Salas</title>
    <style>
        /* Estilos personalizados aquí */
    </style>
</head>

<body>
    <header>
        <a href="../../inicio/inicio.php">
            <div class="logo">
                <i class='bx bx-plus-medical'></i>
            </div>
            <div class="titulo">
                <span>PixelPioneers</span>
                <span>Hospital</span>
            </div>
        </a>
    </header>
    <nav>
        <?php if(isset($_SESSION["tipo"]) && $_SESSION["tipo"]== "admin"){
                echo '
                <div class="agregarDoc">
                <button id="mostrarFormulario">Nueva sala</button>
                </div>

                ';
            } ?>
        <div class="filtrar">
            <i class='bx bx-filter-alt'></i>
            <input type="search" name="filter_name" id="filter_name" placeholder="Buscar por nombre">
            <select name="filter_estado" id="filter_estado">
                <option value="">Todos</option>
                <option value="ocupada">Ocupada</option>
                <option value="desocupada">Desocupada</option>
            </select>
            <button id="aplicarFiltro">Aplicar Filtro</button>
        </div>
    </nav>

    <?php if (isset($salas) && count($salas) > 0) : ?>
        <div class="container">
            <table id="Tabla">
                <thead>
                    <tr>
                        <th>Identificación</th>
                        <th>Nombre</th>
                        <th>Piso</th>
                        <th>Tipo</th>
                        <th>Capacidad Máxima</th>
                        <th>Ocupación Actual</th>
                        <th>Estado</th>
                        <th>Información</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($salas as $sala) : ?>
                        <tr>
                            <td><?php echo $sala['id']; ?></td>
                            <td><?php echo $sala['nombre']; ?></td>
                            <td><?php echo $sala['piso']; ?></td>
                            <td><?php echo $sala['tipo']; ?></td>
                            <td><?php echo $sala['capacidadMaxima']; ?></td>
                            <td><?php echo $sala['ocupacionActual']; ?></td>
                            <td>
                                <?php
                                if ($sala['ocupacionActual'] < $sala['capacidadMaxima']) {
                                    echo '<span class="ver-pacientes-btn">Habilitada</span>';
                                } else {
                                    echo '<span class="ver-pacientes-btn ocupada" disabled>Ocupada</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <form id="mostrarInfoSalaForm" method="post" action="mostarInfoSala.php">
                                    <input type="hidden" name="idSala" value="<?php echo $sala['id']; ?>">
                                    <input type="submit" value="Información de Sala">
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
            <p>No se han cargado ninguna Sala.</p>
        </div>
    <?php endif; ?>

    <form action="subirsala.php" id="formDoc" method="post">
        <label for="nombre">Nombre de la sala:</label>
        <input type="text" id="nombre" name="nombre" required autocomplete="off"><br><br>

        <label for="piso">Piso de la sala:</label>
        <input type="text" id="piso" name="piso" required autocomplete="off"><br><br>

        <label for="estado">Estado de la Sala:</label>
        <input type="text" id="estado" name="estado" required autocomplete="off"><br><br>

        <label for="tipo">Tipo de la Sala:</label>
        <select name="tipo" id="tipo">
            <option value="sala">Sala</option>
            <option value="baño">Baño</option>
        </select><br><br>

        <label for="capacidad">Capacidad de la sala</label>
        <input type="text" id="capacidad" name="capacidad" required autocomplete="off"><br><br>

        <label for="ocupacion">Ocupación Actual:</label>
        <input type="text" id="ocupacion" name="ocupacion" required autocomplete="off"><br><br>

        <input type="submit" value="Agregar sala">
    </form>
</body>
<script src="salas.js"></script>

</html>