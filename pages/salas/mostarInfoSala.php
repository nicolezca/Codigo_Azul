<?php
// Tu conexión a la base de datos y consulta SQL
include('../../conexion/conexion.php');

session_start();

// Verificar si no hay una sesión activa
if (!isset($_SESSION["nombre"]) || !isset($_SESSION["clave"])) {
    header("Location: ../../login/formulario.html");
    exit();
}


include('infosala.php');

// Cierra la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="../css/infosala.css">
        <title>Document</title>
    </head>
    <body>
    <header>
        <a href="salas.php">
            <div class="logo">
                <i class='bx bx-plus-medical'></i>
            </div>
            <div class="titulo">
                <span>PixelPionners</span>
                <span>Hospital</span>
            </div>
        </a>
    </header>
    <main>
         <div class="container">
            <section class="sala">
                <!-- Puedes mostrar los datos de la sala aquí -->
                <h2>Datos de la Sala</h2>
                <span>Nombre: <?php echo  $salaData['nombre'];?></span>
                <span>Identificacion:  <?php echo $salaData['id'];?></span>
            </section>
            <!-- seccion del paciente y personal -->
            <section class="infoSala">
                <div class="personas">
                    <nav class="navegacion">
                        <i class='bx bx-group'></i>    
                        <h2>Pacientes</h2>
                    </nav>
                    <div class="infoPersona">
                        <?php
                        if (!empty($pacientes)) {
                            foreach ($pacientes as $paciente) {
                                echo "<span class='nombre'>" . $paciente['nombre'] . " " . $paciente['apellido'] . "</span><br>";
                                echo "<span class='estado'>" . $paciente['estado'] . "</span><br>";
                                echo "<div class='info'>";
                                echo "<span>DNI: " . $paciente['dni'] . "</span>";
                                echo "<span>Telefono: " . $paciente['telefono'] . "</span>";
                                echo "<span>Obra Social: " . $paciente['obraSocial'] . "</span>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>No hay datos de pacientes disponibles.</p>";
                        }
                        ?>
                    </div>
                </div>
                <div class="personas">
                    <nav class="navegacion">
                        <i class='bx bx-first-aid'></i>
                        <h2>Personal</h2>
                    </nav>
                    <div class="infoPersona">
                        <?php
                        if (!empty($personal)) {
                            foreach ($personal as $persona) {
                                echo "<span class='nombre'>" . $persona['nombre'] . " " . $persona['apellido'] . "</span><br>";
                                echo "<span class='estado'>" . $persona['tipo'] . "</span><br>";
                                echo "<div class='info'>";
                                echo "<span>Cargo: " . $persona['cargo'] . "</span>";
                                echo "<span>Matrícula: " . $persona['matricula'] . "</span>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>No hay datos de personal disponibles.</p>";
                        }
                        ?>
                    </div>
                </div>
            </section>

         </div>
    </main>
</body>

</html>