<?php
include('../../conexion/conexion.php');

$sql = 'SELECT id,nombre,apellido,dni,telefono,obraSocial,estado FROM paciente';
$result = $conn->query($sql);

$identificaciones = [];
$doctores = [];
$apellidos = [];
$dni = [];
$telefonos = [];
$sociales = [];
$estados = [];

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
    <style>
        .formularioHistorial {
            box-shadow: 0 0 15px gray;
            padding: 20px;
            position: absolute;
            top: 20%;
            background-color: white;
            transform: translateX(-100%);
            transition: all .3s ease-in;
        }

        .formularioHistorial label {
            margin: 10px 0;
            display: block;
        }

        .formularioHistorial textarea {
            width: 500px;
            height: 200px;
            background-color: rgba(0, 0, 0, .1);
            outline: none;
            border: none;
            padding: 20px;
            resize: none;
        }

        .formularioHistorial input[type="submit"] {
            display: block;
            margin-top: 20px;
        }
    </style>
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
            <button id="pacienteExistente">Nuevo Historial</button>
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
    <?php if (!empty($identificaciones)) : ?>
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
                        <th>Historial</th>
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
                                <form action="../pdf/pdf.php" method="post" id="algo">
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
            <p>No se han cargado ningún Paciente.</p>
        </div>
    <?php endif; ?>

    <form action="subirPaciente.php" id="formDoc" method="post">
        <label for="nombre">Nombre del paciente:</label>
        <input type="text" id="nombre" name="nombre" required autocomplete="off"><br><br>

        <label for="apellido">Apellidos del paciente:</label>
        <input type="text" id="apellido" name "apellido" required autocomplete="off"><br><br>

        <label for="dni">DNI del paciente:</label>
        <input type="text" id="dni" name="dni" required autocomplete="off"><br><br>

        <label for="telefono">Telefono del paciente:</label>
        <input type="text" id="telefono" name="telefono" required autocomplete="off"><br><br>

        <label for="social">Obra social del paciente:</label>
        <input type="text" id="social" name="social" required autocomplete="off"><br><br>

        <label for="historial">Historial del paciente:</label>
        <input type="text" id="historial" name="historial" required autocomplete="off"><br><br>

        <input type="submit" value="Agregar paciente">
    </form>

    <form action="insertarHistorial.php" method="post" id="HistorialNuevo" class="formularioHistorial">
        <label for="paciente">Selecciona al Paciente</label>
        <select name="paciente" id="paciente" required>
            <?php
            $sql = "SELECT id,nombre, apellido FROM paciente WHERE estado='fuera'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . '  ' . $row['apellido'] . "</option>";
                }
            }
            ?>
        </select>
        <label for="historial">Historia Clínica</label>
        <textarea name="historial" id="historial"></textarea>
        <input type="submit" value="Insertar">
    </form>

</body>
<script src="pacientes.js"></script>

</html>