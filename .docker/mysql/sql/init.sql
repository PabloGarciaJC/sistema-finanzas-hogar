-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 08-02-2023 a las 06:56:53
-- Versión del servidor: 5.7.36
-- Versión de PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pablogarciajc_gestionhogar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--
-- Creación: 05-02-2023 a las 11:12:00
-- Última actualización: 07-02-2023 a las 02:10:38
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `gastos` decimal(10,2) DEFAULT NULL,
  `fechaCorte` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `rol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nombre`, `descripcion`, `gastos`, `fechaCorte`, `status`, `rol`) VALUES
(14, 'Carrefour', 'Mercado Familiar ytes', '407.00', 'Ultimo de Cada Mes', 'PENDIENTE', 1),
(15, 'Carrefour', 'Sitio Web Pablo', '10.00', '15 de cada Mes', 'PENDIENTE', 1),
(17, 'Carrefour', 'Netflix', '5.49', '21 de cada Mes', 'PENDIENTE', 1),
(18, 'Carrefour', 'HBO', '3.99', '21 de casa mes', 'PENDIENTE', 1),
(19, 'Carrefour', 'Mercado Padres Pablo', '130.00', '21 de casa mes', 'PENDIENTE', 1),
(20, 'Servicios', 'Fibra - Yoigo', '57.09', '21 de casa mes', 'PENDIENTE', 1),
(21, 'Servicios', 'Seguro de Dientes - Vero', '20.40', '21 de casa mes', 'PENDIENTE', 1),
(22, 'Servicios', 'Luz', '27.15', '21 de casa mes', 'PENDIENTE', 1),
(23, 'Servicios', 'Alguiler', '650.00', 'Finales de mes', 'PENDIENTE', 1),
(24, 'Servicios', 'Cuota de la Moto', '69.36', 'Ultimo de mes', 'PENDIENTE', 1),
(25, 'Deudas', 'BVA targeta de Vero', '59.00', 'Ultimo de mes', 'PENDIENTE', 1),
(26, 'Deudas', 'Prestamo de 4000 mil', '64.90', 'Ultimo de mes', 'PENDIENTE', 1),
(27, 'Deudas', 'Credito del Erte', '50.19', 'Ultimo de mes', 'PENDIENTE', 1),
(30, 'Deudas', 'Credito del Erte', '50.19', 'Ultimo de mes', 'PENDIENTE', 1),
(31, 'Deudas', 'Credito del Erte', '50.19', 'Ultimo de mes', 'PENDIENTE', 1),
(32, 'Deudas', 'Credito del Erte', '50.19', 'Ultimo de mes', 'PENDIENTE', 1),
(33, 'Deudas', 'Credito del Erte', '50.19', 'Ultimo de mes', 'PENDIENTE', 1),
(34, 'Deudas', 'Credito del Erte', '50.19', 'Ultimo de mes', 'PENDIENTE', 1),
(35, 'Deudas', 'Credito del Erte', '50.19', 'Ultimo de mes', 'PENDIENTE', 1),
(36, 'Deudas', 'Credito del Erte', '50.19', 'Ultimo de mes', 'PENDIENTE', 1),
(37, 'Deudas', 'Credito del Erte', '50.19', 'Ultimo de mes', 'PENDIENTE', 1),
(38, 'Deudas', 'Credito del Erte', '50.19', 'Ultimo de mes', 'PENDIENTE', 1),
(39, 'Deudas', 'Credito del Erte', '50.19', 'Ultimo de mes', 'PENDIENTE', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--
-- Creación: 05-02-2023 a las 11:11:55
-- Última actualización: 07-02-2023 a las 01:39:13
--

CREATE TABLE `historial` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `gastos` decimal(10,2) DEFAULT NULL,
  `fechaCorte` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `idRegister` int(11) DEFAULT NULL,
  `rol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`id`, `nombre`, `descripcion`, `gastos`, `fechaCorte`, `status`, `idRegister`, `rol`) VALUES
(192, 'Carrefour', 'hola es pepe', '900.00', 'ultimo de mes', 'PENDIENTE', 44, 0),
(203, 'Deudas', 'BVA targeta de Vero', '59.00', 'Ultimo de mes', 'PENDIENTE', 45, 0),
(204, 'Deudas', 'Prestamo de 4000 mil', '64.90', 'Ultimo de mes', 'PENDIENTE', 45, 0),
(205, 'Deudas', 'Credito del Erte', '50.19', 'Ultimo de mes', 'PENDIENTE', 45, 0),
(209, 'Carrefour', 'Mercado Familiar', '407.00', 'Ultimo de Cada Mes', 'PENDIENTE', 42, 0),
(210, 'Carrefour', 'Sitio Web Pablo', '10.00', '15 de cada Mes', 'PENDIENTE', 42, 0),
(211, 'Carrefour', 'Netflix', '5.49', '21 de cada Mes', 'PENDIENTE', 42, 0),
(212, 'Carrefour', 'HBO', '3.99', '21 de casa mes', 'PENDIENTE', 42, 0),
(213, 'Carrefour', 'Mercado Padres Pablo', '130.00', '21 de casa mes', 'PENDIENTE', 42, 0),
(214, 'Servicios', 'Fibra - Yoigo', '57.09', '21 de casa mes', 'PENDIENTE', 42, 0),
(215, 'Servicios', 'Seguro de Dientes - Vero', '20.40', '21 de casa mes', 'PENDIENTE', 42, 0),
(216, 'Servicios', 'Luz', '27.15', '21 de casa mes', 'PENDIENTE', 42, 0),
(217, 'Servicios', 'Alguiler', '650.00', 'Finales de mes', 'PENDIENTE', 42, 0),
(218, 'Servicios', 'Cuota de la Moto', '69.36', 'Ultimo de mes', 'PENDIENTE', 42, 0),
(219, 'Deudas', 'BVA targeta de Vero', '59.00', 'Ultimo de mes', 'PENDIENTE', 42, 0),
(220, 'Deudas', 'Prestamo de 4000 mil', '64.90', 'Ultimo de mes', 'PENDIENTE', 42, 0),
(221, 'Deudas', 'Credito del Erte', '50.19', 'Ultimo de mes', 'PENDIENTE', 42, 0),
(224, 'Carrefour', 'Mercado Familiar', '407.00', 'Ultimo de Cada Mes', 'PENDIENTE', 43, 0),
(225, 'Carrefour', 'Sitio Web Pablo', '10.00', '15 de cada Mes', 'PENDIENTE', 43, 0),
(226, 'Carrefour', 'Netflix', '5.49', '21 de cada Mes', 'PENDIENTE', 43, 0),
(227, 'Carrefour', 'HBO', '3.99', '21 de casa mes', 'PENDIENTE', 43, 0),
(228, 'Carrefour', 'Mercado Padres Pablo', '130.00', '21 de casa mes', 'PENDIENTE', 43, 0),
(229, 'Servicios', 'Fibra - Yoigo', '57.09', '21 de casa mes', 'PENDIENTE', 43, 0),
(230, 'Servicios', 'Seguro de Dientes - Vero', '20.40', '21 de casa mes', 'PENDIENTE', 43, 0),
(231, 'Servicios', 'Luz', '27.15', '21 de casa mes', 'PENDIENTE', 43, 0),
(232, 'Servicios', 'Alguiler', '650.00', 'Finales de mes', 'PENDIENTE', 43, 0),
(233, 'Servicios', 'Cuota de la Moto', '69.36', 'Ultimo de mes', 'PENDIENTE', 43, 0),
(234, 'Deudas', 'BVA targeta de Vero', '59.00', 'Ultimo de mes', 'PENDIENTE', 43, 0),
(235, 'Deudas', 'Prestamo de 4000 mil', '64.90', 'Ultimo de mes', 'PENDIENTE', 43, 0),
(236, 'Deudas', 'Credito del Erte', '50.19', 'Ultimo de mes', 'PENDIENTE', 43, 0),
(240, 'Carrefour', 'Mercado Familiar', '407.00', 'Ultimo de Cada Mes', 'PENDIENTE', 45, 0),
(241, 'Carrefour', 'Sitio Web Pablo', '10.00', '15 de cada Mes', 'PENDIENTE', 45, 0),
(242, 'Carrefour', 'Netflix', '5.49', '21 de cada Mes', 'PENDIENTE', 45, 0),
(243, 'Carrefour', 'HBO', '3.99', '21 de casa mes', 'PENDIENTE', 45, 0),
(244, 'Carrefour', 'Mercado Padres Pablo', '130.00', '21 de casa mes', 'PENDIENTE', 45, 0),
(245, 'Servicios', 'Fibra - Yoigo', '57.09', '21 de casa mes', 'PENDIENTE', 45, 0),
(246, 'Servicios', 'Seguro de Dientes - Vero', '20.40', '21 de casa mes', 'PENDIENTE', 45, 0),
(247, 'Servicios', 'Luz', '27.15', '21 de casa mes', 'PENDIENTE', 45, 0),
(248, 'Servicios', 'Alguiler', '650.00', 'Finales de mes', 'PENDIENTE', 45, 0),
(249, 'Servicios', 'Cuota de la Moto', '69.36', 'Ultimo de mes', 'PENDIENTE', 45, 0),
(250, 'Deudas', 'BVA targeta de Vero', '59.00', 'Ultimo de mes', 'PENDIENTE', 45, 0),
(251, 'Deudas', 'Prestamo de 4000 mil', '64.90', 'Ultimo de mes', 'PENDIENTE', 45, 0),
(252, 'Deudas', 'Credito del Erte', '50.19', 'Ultimo de mes', 'PENDIENTE', 45, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `register`
--
-- Creación: 01-06-2022 a las 17:30:08
-- Última actualización: 07-02-2023 a las 01:37:40
--

CREATE TABLE `register` (
  `id` int(11) NOT NULL,
  `income_veronica` decimal(10,2) DEFAULT NULL,
  `income_pablo` decimal(10,2) DEFAULT NULL,
  `income_extra` decimal(10,2) DEFAULT NULL,
  `saving_verpa` decimal(10,2) DEFAULT NULL,
  `month` varchar(50) NOT NULL,
  `year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `register`
--

INSERT INTO `register` (`id`, `income_veronica`, `income_pablo`, `income_extra`, `saving_verpa`, `month`, `year`) VALUES
(42, '300.00', '100.00', '0.00', '0.00', 'Octubre', 2022),
(43, '0.00', '247.36', '1000.00', '1000.00', 'Septiembre', 2022),
(44, '819.00', '881.00', '120.00', '0.00', 'Diciembre', 2002),
(45, '1000.00', '1000.00', '0.00', '0.00', 'febrero', 2023);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_register_d` (`idRegister`);

--
-- Indices de la tabla `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UQ_month_year` (`month`,`year`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT de la tabla `register`
--
ALTER TABLE `register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `FK_register_d` FOREIGN KEY (`idRegister`) REFERENCES `register` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
