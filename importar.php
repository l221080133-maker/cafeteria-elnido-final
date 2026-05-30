<?php
// 1. Configurar credenciales automáticas de Railway
$hostname = $_ENV['MYSQLHOST'];
$username = $_ENV['MYSQLUSER'];
$password = $_ENV['MYSQLPASSWORD'];
$database = $_ENV['MYSQLDATABASE'];
$port     = $_ENV['MYSQLPORT'];

$conexion = mysqli_connect($hostname, $username, $password, $database, $port);

if (!$conexion) {
    die("Error al conectar a MySQL: " . mysqli_connect_error());
}

// 2. Aquí adentro pegas TODO el texto de tu archivo anderxito_db.sql
$sql = <<<'EOD'

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2026 a las 23:10:04
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `anderxito_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `mensaje` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `productos` text DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `cantidad` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario`, `productos`, `total`, `fecha`, `cantidad`) VALUES
(68, 'l221080133@iztapalapa.tecnm.mx', 'Latte Nido', 40.00, '2026-05-27 18:53:03', 1),
(69, 'l221080133@iztapalapa.tecnm.mx', 'Latte Nido', 40.00, '2026-05-27 18:56:01', 1),
(70, 'l221080133@iztapalapa.tecnm.mx', 'Latte Nido', 80.00, '2026-05-27 19:00:29', 2),
(71, 'l221080133@iztapalapa.tecnm.mx', 'henrry', 170.00, '2026-05-27 19:13:00', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `imagen`) VALUES
(1, 'Espresso Macabélico', 35.00, 'galeria-1.jpg'),
(2, 'Capuchino del Nido', 45.00, 'galeria-2.jpg'),
(3, 'Latte Nido', 40.00, 'galeria-3.jpg'),
(4, 'Americano Intenso', 30.00, 'galeria-4.jpg'),
(5, 'Ander', 85.00, 'galeria-6.jpg'),
(6, 'zende', 50.00, 'galeria-5.jpg'),
(7, 'henrry', 85.00, 'galeria-8.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resenas`
--

CREATE TABLE `resenas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resenas`
--

INSERT INTO `resenas` (`id`, `nombre`, `mensaje`, `fecha`) VALUES
(1, '10/10', 'muy buena la cafeteria\r\n', '2026-05-27 18:10:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `rol` varchar(50) DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `rol`) VALUES
(1, 'Ander', 'alemanbryan772@gmail.com', '123456', 'admin'),
(5, 'dani', 'l221080133@iztapalapa.tecnm.mx', '123', 'cliente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `resenas`
--
ALTER TABLE `resenas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `resenas`
--
ALTER TABLE `resenas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


EOD;

// 3. Ejecutar la importación masiva en el servidor
if (mysqli_multi_query($conexion, $sql)) {
    echo "<h1 style='color:green; text-align:center; margin-top:50px;'>¡Base de datos importada con éxito total en Railway! ☕🦅🚀</h1>";
    echo "<p style='text-align:center;'>Ya puedes volver a tu página principal y probar el inicio de sesión.</p>";
} else {
    echo "Error al importar las tablas: " . mysqli_error($conexion);
}
?>