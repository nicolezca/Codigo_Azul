<?php
include('../conexion/conexion.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../img/fondazo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/styles.css">
    <title>Home | Hospital</title>
</head>

<body>
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
        <nav class="navegacion">
            <a href="../pages/doctores.php">Doctores</a>
            <a href="../pages/enfermeros.php">Enfermeros</a>
            <a href="../pages/pacientes.php">Pacientes</a>
        </nav>
    </header>
    <div class="banner">
        <img src="../img/fondo_incial.jpg" alt="">
    </div>
    <div class="btn-seccion">
        <div class="card">
            <a href="../pages/salas.php">
                 <i class='bx bx-bed'></i>
                <span>Salas</span>
            </a>
        </div>
        <div class="card">
            <a href="">
                <i class='bx bxs-book-add'></i>
                <span>Respuesta de atencion</span>
            </a>
        </div>
        <div class="card">
            <a href="">
                <i class='bx bx-street-view'></i>
                <span>Atendidos</span>
            </a>
        </div>
        <div class="card">
            <a href="">
                <i class='bx bx-time'></i>
                <span>En Espera</span>
            </a>
        </div>
    </div>
</body>

</html>