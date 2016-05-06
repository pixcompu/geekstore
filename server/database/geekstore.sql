-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-04-2016 a las 10:29:15
-- Versión del servidor: 5.6.25
-- Versión de PHP: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `geekstore`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `image` varchar(150) NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `image`, `price`, `quantity`) VALUES
(1, 'Capa de invisibilidad', 'Capa de invisivilidad usada en la pelicula de Harry Potter', 'resources/images/catalog/capa_harry.jpg', 99, 10),
(9, 'La mascara de Loki', 'La leyenda dice que esta máscara da poderes', 'resources/images/catalog/mascara.jpg', 123, 12),
(11, 'Guy Fawkes Mask', 'Esta máscara fue usada en V de Vendetta', 'resources/images/catalog/v_de_venganza.jpeg', 200, 12),
(12, 'Escudo de la Justicia', 'Este escudo pertenece al capitan américa, aunque estuvo en manos del hombre araña 10 segundos de tráiler.', 'resources/images/catalog/captain_shield.jpg', 1000, 2),
(13, 'Baticapa', 'Capa del murcielago de la noche', 'resources/images/catalog/baticapa.jpg', 150, 12),
(14, 'Pokebola', 'Pokebola de pokemón, lista para atraparlos a todos.', 'resources/images/catalog/pokebola.jpg', 100, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sale`
--

CREATE TABLE IF NOT EXISTS `sale` (
  `id` int(11) NOT NULL,
  `fsi_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sale_item`
--

CREATE TABLE IF NOT EXISTS `sale_item` (
  `id` int(11) NOT NULL,
  `fu_username` varchar(50) NOT NULL,
  `fp_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sale_ticket`
--

CREATE TABLE IF NOT EXISTS `sale_ticket` (
  `fu_username` varchar(50) NOT NULL,
  `fs_id` int(11) NOT NULL,
  `total` float NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(50) NOT NULL,
  `email` varchar(70) NOT NULL,
  `password` varchar(50) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'client',
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`username`, `email`, `password`, `type`, `phone`) VALUES
('geekstore', 'geekstore@admin.com', '97d81fce2029a75d79fe60781dc4124e', 'admin', '9994490032'),
('pixcompu', 'pixcompu@outlook.com', 'e088bfbcf61dfd9f2fd42526c5a5bae4', 'user', '9994490032');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
