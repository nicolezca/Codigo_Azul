<?php
include('../conexion/conexion.php');

session_start();

// Verificar si no hay una sesión activa
if (!isset($_SESSION["nombre"]) || !isset($_SESSION["clave"])) {
    header("Location: ../login/formulario.html");
    exit();
}

function obtenerSalasDisponibles($conn){
    $sql = "SELECT id, nombre FROM sala WHERE ocupacionActual < capacidadMaxima";
    $result = $conn->query($sql);
    return $result;
}

function obtenerPersonal($conn, $tipo){
    $sql = "SELECT id, nombre, cargo FROM personal WHERE tipo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tipo);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../img/fondazo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .perfil{
            position: absolute;
            right: 0;
            top: 0;
            padding: 10px 20px;
            background-color: white;
            border-radius: 0 0 0 20px;
            box-shadow: 0 0 15px black;
            z-index: 999999;
        }
        .perfil button{
            background: none;
            border: none;
            outline: none;
            display: flex;
            justify-content: center;
            align-items: center;
            color: blue;
            cursor: pointer;
        }
        .perfil button i{
            font-size: 24px;
        }

        .cardSesion{
            width: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            box-shadow:  0 0 15px black;
            padding: 20px;
            position: absolute;
            top:   -100%;
            left: calc(50% - 200px);
            z-index: 9999;
            background-color: white;
            transition: all .3s ease-in-out;
        }

        .cardSesion i{
            color: red;
            font-size: 30px;
            margin-bottom: 10px;
        }

        .cardSesion span{
            font-size: 24px;
        }
        .cardSesion #nombre{
            font-weight: bold;
        }
        .cardSesion button{
            margin-top: 10px;
            padding: 10px 20px;
            border-radius: 20px;
            outline: 1px solid transparent;
            border:none;
            background: blue;
            color: white;
            transition: all .3s ease-in-out;
        }
        .cardSesion button:hover{
            background-color: transparent;
            outline: 1px solid blue;
            color: blue;
        }
    </style>
    <title>Home | Hospital</title>
</head>

<body>
    <div class="perfil">
        <button  id="CerrarSesion">
        <i class='bx bxs-user-circle'></i>Cerrar Sesion
        </button>
    </div>
    <header class="header">
        <div class="top-bar">
            <div class="logo">
                <i class='bx bx-plus-medical'></i>
            </div>
            <div class="titulo">
                <span>PixelPionners</span>
                <span>Hospital</span>
            </div>
        </div>
        <div class="btn-emergencia">
            <button id="btnLlamado">Emergencia</button>
        </div>
        <nav class="navegacion">
            <a href="../pages/doctores/doctores.php">Doctores</a>
            <a href="../pages/enfermeros/enfermeros.php">Enfermeros</a>
            <a href="../pages/pacientes/pacientes.php">Pacientes</a>
        </nav>
    </header>
    <div class="banner">
        <img src="../img/fondo_incial.jpg" alt="">
    </div>
    <div class="btn-seccion">
        <div class="card">
            <a href="../pages/salas/salas.php">
                <i class='bx bx-bed'></i>
                <span>Salas</span>
            </a>
        </div>
        <div class="card">
            <a href="../pages/llamado/atencion.php">
                <i class='bx bxs-book-add'></i>
                <span>Respuesta de atencion</span>
            </a>
        </div>
        <div class="card">
            <a href="../pages/pacientes/atendidos.php">
                <i class='bx bx-street-view'></i>
                <span>Atendidos</span>
            </a>
        </div>
        <div class="card">
            <a href="../pages/esperas/esperas.php">
                <i class='bx bx-time'></i>
                <span>En Espera</span>
            </a>
        </div>
    </div>

    <!-- para la tabla llamado y llamado_personal -->
    <form id="formularioSala" action="php/alerta.php" method="POST">
        <label for="prioridad">Prioridad de Llamado:</label>
        <select name="prioridad" id="prioridad">
            <option value="normal">Normal</option>
            <option value="emergencia">Emergencia</option>
        </select>

        <!-- se presenta una sala al llamado -->
        <label for="sala">Selecciona una Sala:</label>
        <select name="sala" id="sala">
            <?php
            $result = obtenerSalasDisponibles($conn);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                }
            } else {
                echo "<option value=''>No hay salas disponibles</option>";
            }
            ?>
        </select>

        <!-- Se le asigna personal -->
        <label for="personal">Doctor a asignar:</label>
        <select name="doctor" id="doctor">
            <?php
            $result = obtenerPersonal($conn, 'medico');
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . '  ' . $row['cargo'] . "</option>";
                }
            }
            ?>
        </select>

        <!-- Se le asigna Enfermero -->
        <label for="personal">Enfermero a asignar:</label>
        <select name="enfermero" id="enfermero">
            <?php
            $result = obtenerPersonal($conn, 'enfermero');
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . '  ' . $row['cargo'] . "</option>";
                }
            }
            ?>
        </select>
        <!-- se le asigna una fecha al llamado -->
        <label for="fechaInicio">Fecha de Inicio:</label>
        <input type="datetime-local" name="fechaInicio" id="fechaInicio" required>

        <input type="submit" value="Hacer llamado">
    </form>

    <div class="cardSesion" id="cardSesion">
        <i class='bx bx-error-alt'></i>
        <span id="nombre"><?php echo $_SESSION["nombre"]?></span>
        <span>Estas seguro de salir</span>
        <button id="sesionCerrada" onclick="btncerrado()">Cerrar Sesion</button>
    </div>

    <audio src="../img/tone-evacuation.mp3" id="sonido"></audio>
    <script src="js/main.js"></script>
    <script src="js/rastreoInactividad.js"></script>
    <script>
        function btncerrado(){
            window.location.href = 'php/CerrarRediregir.php';
        }
    </script>
</body>

</html>