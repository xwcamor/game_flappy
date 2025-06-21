-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 03-06-2025 a las 09:48:50
-- Versión del servidor: 8.2.0
-- Versión de PHP: 8.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `flappybird`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `scores`
--

CREATE TABLE `scores` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `score` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `scores`
--

INSERT INTO `scores` (`id`, `user_id`, `score`, `created_at`) VALUES
(167, 3, 0, '2025-06-03 04:33:02'),
(168, 3, 0, '2025-06-03 04:33:06'),
(169, 3, 0, '2025-06-03 04:33:10'),
(170, 3, 0, '2025-06-03 04:33:12'),
(171, 3, 1, '2025-06-03 04:33:19'),
(172, 3, 0, '2025-06-03 04:33:23'),
(173, 3, 0, '2025-06-03 04:33:25'),
(174, 3, 0, '2025-06-03 04:33:27'),
(175, 3, 0, '2025-06-03 04:33:31'),
(176, 3, 0, '2025-06-03 07:30:31'),
(177, 3, 0, '2025-06-03 07:30:34'),
(178, 3, 0, '2025-06-03 07:30:37'),
(179, 3, 0, '2025-06-03 07:32:49'),
(180, 3, 1, '2025-06-03 07:32:57'),
(181, 3, 0, '2025-06-03 07:33:01'),
(182, 3, 2, '2025-06-03 07:33:10'),
(183, 3, 1, '2025-06-03 07:33:19'),
(184, 20, 0, '2025-06-03 07:50:48'),
(185, 20, 0, '2025-06-03 07:50:53'),
(186, 20, 1, '2025-06-03 07:51:01'),
(187, 20, 0, '2025-06-03 07:51:06'),
(188, 20, 0, '2025-06-03 07:51:09'),
(189, 20, 0, '2025-06-03 07:51:11'),
(190, 20, 0, '2025-06-03 07:51:15'),
(191, 20, 0, '2025-06-03 07:51:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(3, 'marco', '$2y$10$2Ga8YzjTKt4aavDqdTvnMO1ZNmTzLWVpMdQXWItsOLBgRwGyxoPo2'),
(5, 'paula', '$2y$10$mBOXpiHVmPCMSk1O5XL0LuApOAUxZo364JItAwkwBMJFCaWWe9Bta'),
(14, 'paul', '$2y$10$ILkqxETMOGSI0ftBUlngGOrvxen2qByZlTkDhe2j4D5PgRdfYxPc.'),
(18, 'mario', '$2y$10$sXo3hntFiv1L8TvLvk7hHOeRmrhcDXBV9EWS.WYGRcnHpM6gIoy1W'),
(20, 'tar', '$2y$10$g7/Na5wipEbvlGfF3dNekOl6U1f4Y2W49TCcmmxlFK19EWNQDPF.a');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_score_user` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `username_2` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `fk_score_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;