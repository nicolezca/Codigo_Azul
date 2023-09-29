-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-09-2023 a las 12:03:02
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `olimpiadas`
CREATE DATABASE olimpiadas;
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `llamado`
--

CREATE TABLE `llamado` (
  `id` int(11) NOT NULL,
  `estado` enum('atendido','no_atendido','finalizado') NOT NULL,
  `fechaHoraInicio` datetime NOT NULL,
  `fechaHoraFin` datetime DEFAULT NULL,
  `idPaciente` int(11) DEFAULT NULL,
  `idSala` int(11) DEFAULT NULL,
  `prioridadLlamada` enum('normal','emergencia') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `llamado_personal`
--

CREATE TABLE `llamado_personal` (
  `id` int(11) NOT NULL,
  `idLlamado` int(11) NOT NULL,
  `idPersonal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `obraSocial` varchar(255) DEFAULT NULL,
  `historiaClinica` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`id`, `nombre`, `apellido`, `dni`, `telefono`, `obraSocial`, `historiaClinica`) VALUES
(1, 'Agustin', 'Lezcano', '46690052', '2241562603', 'IOMA', 'entro por una farinjitis aguda'),
(2, 'Juan', 'Pérez', '12345678', '555-1234', 'PAMI', 'El paciente se sometió a una cirugía de apendicectomía la semana pasada'),
(3, 'María', 'González', '98765432', '555-5678', 'no tiene', 'El paciente sufre de migrañas frecuentes'),
(4, 'Ana', 'Rodriguez', '12345678', '1162114065', 'Swiss Medical', 'La paciente informa de dolor en la espalda baja después de levantar objetos pesados'),
(5, 'María', 'Garcia', '34567890', '2241555-9012', 'O.S.P.S.A', 'La paciente se presenta con dolor abdominal agudo'),
(6, 'María', 'Garcia', '34567890', '2241555-9012', 'O.S.P.S.A', 'La paciente se presenta con dolor abdominal agudo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `cargo` varchar(255) DEFAULT NULL,
  `matricula` varchar(20) DEFAULT NULL,
  `tipo` enum('medico','enfermero') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`id`, `nombre`, `apellido`, `cargo`, `matricula`, `tipo`) VALUES
(1, 'María', 'González', 'Médica General', '12345', 'medico'),
(2, 'Juan', 'Pérez', 'Cardiólogo', '67890', 'medico'),
(3, 'Laura', 'Rodríguez', 'Pediatra', '23456', 'medico'),
(4, 'Carlos', 'López', 'Ginecólogo', '78901', 'medico'),
(5, 'Ana', 'Martínez', 'Cirujano', '34567', 'medico'),
(6, 'Javier', 'Sánchez', 'Dermatólogo', '89012', 'medico'),
(7, 'Susana', 'Ramírez', 'Oftalmólogo', '45678', 'medico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sala`
--

CREATE TABLE `sala` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `piso` int(11) NOT NULL,
  `disponible` tinyint(1) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `capacidadMaxima` int(11) NOT NULL,
  `ocupacionActual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sala_paciente`
--

CREATE TABLE `sala_paciente` (
  `id` int(11) NOT NULL,
  `idSala` int(11) NOT NULL,
  `idPaciente` int(11) NOT NULL,
  `fechaHoraIngreso` datetime NOT NULL,
  `fechaHoraEgreso` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sala_personal_asignado`
--

CREATE TABLE `sala_personal_asignado` (
  `id` int(11) NOT NULL,
  `idPersonal` int(11) NOT NULL,
  `idSala` int(11) NOT NULL,
  `dias` varchar(10) NOT NULL,
  `turno` enum('M','T','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `tipo` enum('admin','generico') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `contrasena`, `tipo`) VALUES
(1, 'agustin', '08062005aL', 'admin'),
(2, 'agostina', 'marquez', 'admin'),
(3, 'joaquin', 'joa97531', 'generico');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `llamado`
--
ALTER TABLE `llamado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idPaciente` (`idPaciente`),
  ADD KEY `idSala` (`idSala`);

--
-- Indices de la tabla `llamado_personal`
--
ALTER TABLE `llamado_personal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idLlamado` (`idLlamado`),
  ADD KEY `idPersonal` (`idPersonal`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sala`
--
ALTER TABLE `sala`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sala_paciente`
--
ALTER TABLE `sala_paciente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idSala` (`idSala`),
  ADD KEY `idPaciente` (`idPaciente`);

--
-- Indices de la tabla `sala_personal_asignado`
--
ALTER TABLE `sala_personal_asignado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idPersonal` (`idPersonal`),
  ADD KEY `idSala` (`idSala`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `llamado`
--
ALTER TABLE `llamado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `llamado_personal`
--
ALTER TABLE `llamado_personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `sala`
--
ALTER TABLE `sala`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sala_paciente`
--
ALTER TABLE `sala_paciente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sala_personal_asignado`
--
ALTER TABLE `sala_personal_asignado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `llamado`
--
ALTER TABLE `llamado`
  ADD CONSTRAINT `llamado_ibfk_1` FOREIGN KEY (`idPaciente`) REFERENCES `paciente` (`id`),
  ADD CONSTRAINT `llamado_ibfk_2` FOREIGN KEY (`idSala`) REFERENCES `sala` (`id`);

--
-- Filtros para la tabla `llamado_personal`
--
ALTER TABLE `llamado_personal`
  ADD CONSTRAINT `llamado_personal_ibfk_1` FOREIGN KEY (`idLlamado`) REFERENCES `llamado` (`id`),
  ADD CONSTRAINT `llamado_personal_ibfk_2` FOREIGN KEY (`idPersonal`) REFERENCES `personal` (`id`);

--
-- Filtros para la tabla `sala_paciente`
--
ALTER TABLE `sala_paciente`
  ADD CONSTRAINT `sala_paciente_ibfk_1` FOREIGN KEY (`idSala`) REFERENCES `sala` (`id`),
  ADD CONSTRAINT `sala_paciente_ibfk_2` FOREIGN KEY (`idPaciente`) REFERENCES `paciente` (`id`);

--
-- Filtros para la tabla `sala_personal_asignado`
--
ALTER TABLE `sala_personal_asignado`
  ADD CONSTRAINT `sala_personal_asignado_ibfk_1` FOREIGN KEY (`idPersonal`) REFERENCES `personal` (`id`),
  ADD CONSTRAINT `sala_personal_asignado_ibfk_2` FOREIGN KEY (`idSala`) REFERENCES `sala` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
