-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-07-2024 a las 05:41:24
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `biblioteca`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_llenarModalAlumnos` (IN `alu_id` INT)   BEGIN
SELECT p.nombre, p.apellidos, a.grado, a.seccion
FROM alumnos as a 
INNER JOIN personas as p
ON p.id = a.idpersona
WHERE a.id = alu_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_llenarModalLibros` (IN `lb_id` INT)   BEGIN
SELECT o.Nombre, l.Autor, l.Editorial, l.AñoEdicion, l.TipoLibro, l.Estante, l.Division, o.Signatura, o.Cantidad, o.Estado FROM libros as l
INNER JOIN objetos as o ON o.id = l.idobjeto
WHERE l.id = lb_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_llenarModalPersonal` (IN `per_id` INT)   BEGIN
SELECT p.nombre, p.apellidos, pr.Cargo, pr.Especialidad, pr.Condición
FROM personales as pr
INNER JOIN personas as p
ON p.id = pr.idpersona
WHERE pr.id= per_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_llenarModaMoviliario` (IN `mv_id` INT)   BEGIN
SELECT o.Nombre,o.Signatura, o.Cantidad, o.Estado, mv.Observacion
FROM moviliarios as mv
INNER JOIN objetos as o ON o.id = mv.idobjeto
WHERE mv.id = mv_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_verDetallesPrestamoAlumno` (IN `dp_idPrestamo` INT)   BEGIN

SELECT
  dp.id,
  dp.Id_objeto,
  dp.Id_prestamo,
  o.Nombre,
  o.Signatura,
  l.Autor,
  l.Editorial,
  l.AñoEdicion,
  l.TipoLibro,
  CONCAT(l.Estante, ' ', l.Division) as Ubicacion,
  dp.cantidad,
  dp.FRetorno,
  dp.FEntrega,
  dp.OEstado,
  dp.PEstado
FROM deatllesprestamo  AS dp
INNER JOIN objetos AS o ON o.id = dp.Id_objeto
LEFT JOIN libros AS l ON l.idobjeto = o.id
WHERE dp.Id_prestamo = dp_idPrestamo;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idpersona` bigint(20) UNSIGNED NOT NULL,
  `grado` varchar(255) NOT NULL,
  `seccion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id`, `idpersona`, `grado`, `seccion`) VALUES
(48, 51, 'SEGUNDO', 'A'),
(49, 53, 'SEGUNDO', 'ÚNICA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deatllesprestamo`
--

CREATE TABLE `deatllesprestamo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Id_prestamo` bigint(20) UNSIGNED NOT NULL,
  `Id_objeto` bigint(20) UNSIGNED NOT NULL,
  `cantidad` int(10) NOT NULL,
  `FRetorno` date NOT NULL,
  `FEntrega` datetime DEFAULT NULL,
  `OEstado` varchar(50) NOT NULL,
  `PEstado` varchar(50) NOT NULL DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `deatllesprestamo`
--

INSERT INTO `deatllesprestamo` (`id`, `Id_prestamo`, `Id_objeto`, `cantidad`, `FRetorno`, `FEntrega`, `OEstado`, `PEstado`) VALUES
(57, 51, 34, 5, '2023-11-10', NULL, 'M', 'Vencido'),
(58, 51, 33, 3, '2023-11-10', '2023-11-23 05:23:28', 'R', 'Entregado'),
(59, 52, 33, 2, '2023-11-17', '2023-11-11 20:34:29', 'B', 'Entregado'),
(60, 52, 27, 2, '2023-11-16', '2023-11-11 20:34:35', 'R', 'Entregado'),
(61, 53, 37, 5, '2023-11-20', '2023-11-14 15:05:20', 'B', 'Entregado'),
(62, 54, 40, 3, '2023-11-30', NULL, 'B', 'Vencido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `divisiones`
--

CREATE TABLE `divisiones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `CodDivision` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `divisiones`
--

INSERT INTO `divisiones` (`id`, `CodDivision`) VALUES
(1, 'DIV-00A'),
(2, 'DIV-00B'),
(3, 'DIV-00C'),
(4, 'DIV-00D'),
(5, 'DIV-00E');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estantes`
--

CREATE TABLE `estantes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `CodEstante` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `estantes`
--

INSERT INTO `estantes` (`id`, `CodEstante`) VALUES
(1, 'ES-001'),
(2, 'ES-002'),
(3, 'ES-003'),
(4, 'ES-004'),
(5, 'ES-005'),
(6, 'ES-006'),
(7, 'ES-007'),
(8, 'ES-008'),
(9, 'ES-009'),
(10, 'ES-010'),
(11, 'ES-011'),
(12, 'ES-012'),
(13, 'ES-013'),
(14, 'ES-014'),
(15, 'ES-015'),
(16, 'ES-016'),
(17, 'ES-017'),
(18, 'ES-018'),
(19, 'ES-019'),
(20, 'ES-020');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idobjeto` bigint(20) UNSIGNED NOT NULL,
  `Autor` varchar(255) NOT NULL,
  `Editorial` varchar(255) NOT NULL,
  `AñoEdicion` varchar(255) NOT NULL,
  `TipoLibro` varchar(255) NOT NULL,
  `Estante` varchar(255) NOT NULL,
  `Division` varchar(255) NOT NULL,
  `FRegistro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `idobjeto`, `Autor`, `Editorial`, `AñoEdicion`, `TipoLibro`, `Estante`, `Division`, `FRegistro`) VALUES
(11, 33, 'MINEDU', 'MINEDU', '2018', 'Donación', 'ES-002', 'DIV-00C', '2023-11-02 22:30:41'),
(12, 34, 'ESTADO', 'MINEDU', '2020', 'Canje', 'ES-001', 'DIV-00A', '2023-11-02 22:31:14'),
(13, 35, 'ESTADO', 'SANTILLANA', '2014', 'Ministerio', 'ES-005', 'DIV-00B', '2023-11-08 18:37:43'),
(14, 36, 'ESTADO', 'SANTILLANA', '2018', 'Compra', 'ES-010', 'DIV-00D', '2023-11-11 15:12:53'),
(15, 37, 'COQUITO', 'MINEDU', '2010', 'Ministerio', 'ES-015', 'DIV-00E', '2023-11-11 15:16:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moviliarios`
--

CREATE TABLE `moviliarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idobjeto` bigint(20) UNSIGNED NOT NULL,
  `Observacion` varchar(255) DEFAULT 'Sin observaciones'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `moviliarios`
--

INSERT INTO `moviliarios` (`id`, `idobjeto`, `Observacion`) VALUES
(18, 26, 'SIN OBSERVACION'),
(19, 27, 'ESTAN UN POCO ROTOS PERO CONSERVADOS'),
(22, 39, 'SIN OBSERVACIÓN'),
(23, 40, 'SIN OBSERVACIÓN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetos`
--

CREATE TABLE `objetos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Signatura` varchar(255) NOT NULL,
  `Cantidad` varchar(255) NOT NULL,
  `Estado` varchar(255) NOT NULL DEFAULT 'Bueno'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `objetos`
--

INSERT INTO `objetos` (`id`, `Nombre`, `Signatura`, `Cantidad`, `Estado`) VALUES
(26, 'GLOBO TERRAQUEO', 'SIG-028837', '10', 'B'),
(27, 'MAPA MUNDI', 'SIG-027636', '7', 'R'),
(33, 'CIENCIA Y AMBIENTE', 'SIG-094374', '52', 'R'),
(34, 'HISTORIA Y GEOGRAFIA', 'SIG-0086573', '50', 'M'),
(35, 'COMUNICACIÓN', 'SIG-0002', '50', 'B'),
(36, 'MATEMATICA', 'SIG-002938', '20', 'B'),
(37, 'CIENCIAS SOCIALES', 'SIG-028736', '30', 'B'),
(39, 'REGLAS DE MEDIDAS', 'SIG-8762883', '3', 'B'),
(40, 'PELOTAS DE FUTBOL', 'SIG-083634', '6', 'B');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personales`
--

CREATE TABLE `personales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idpersona` bigint(20) UNSIGNED NOT NULL,
  `Cargo` varchar(255) NOT NULL,
  `Especialidad` varchar(255) NOT NULL,
  `Condición` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personales`
--

INSERT INTO `personales` (`id`, `idpersona`, `Cargo`, `Especialidad`, `Condición`) VALUES
(4, 52, 'DOCENTE', 'ING SOFTWARE', 'CONTRATADO'),
(5, 54, 'DIRECTORA', 'CIENCIAS SOCIALES', 'ESTABLE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `nombre`, `apellidos`) VALUES
(51, 'FRANCO', 'PEREDA'),
(52, 'DALTON', 'YNDALECIO'),
(53, 'CARLOS', 'GARCIA MARIÑOS'),
(54, 'ELENA', 'DIAS GABRIEL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idpersona` bigint(20) UNSIGNED NOT NULL,
  `FSalida` datetime NOT NULL DEFAULT current_timestamp(),
  `cantidadObjetos` varchar(50) NOT NULL,
  `EstadoP` varchar(255) NOT NULL DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`id`, `idpersona`, `FSalida`, `cantidadObjetos`, `EstadoP`) VALUES
(51, 51, '2023-11-06 19:32:01', '2', 'Vencido'),
(52, 52, '2023-11-06 19:33:49', '2', 'Entregado'),
(53, 53, '2023-11-11 15:30:26', '1', 'Entregado'),
(54, 54, '2023-11-11 15:34:09', '1', 'Vencido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Dalton Yndalecio Rodriguez', 'yndaleciorodriguezd@gmail.com', NULL, '$2y$10$yIFPTNmrlBeYKaHLak.6.e5RdqGceOEMyI9JPXCRlMT50km2o8tKy', NULL, '2023-11-09 04:52:30', '2023-11-09 04:52:30'),
(2, 'Fermin Medrano', 'cesarvallejo@gmail.com', NULL, '$2y$10$zyuW/qDLjkToNlefj/28G.2RdD7hZ277xkUSoDvtbmMUOdAuMDiVG', NULL, '2023-11-09 06:49:37', '2023-11-09 06:49:37');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumnos_idpersona_foreign` (`idpersona`);

--
-- Indices de la tabla `deatllesprestamo`
--
ALTER TABLE `deatllesprestamo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Id_prestamo` (`Id_prestamo`),
  ADD KEY `Id_objeto` (`Id_objeto`);

--
-- Indices de la tabla `divisiones`
--
ALTER TABLE `divisiones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estantes`
--
ALTER TABLE `estantes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `libros_idobjeto_foreign` (`idobjeto`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `moviliarios`
--
ALTER TABLE `moviliarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `moviliarios_idobjeto_foreign` (`idobjeto`);

--
-- Indices de la tabla `objetos`
--
ALTER TABLE `objetos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `personales`
--
ALTER TABLE `personales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `personales_idpersona_foreign` (`idpersona`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prestamos_idpersona_foreign` (`idpersona`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `deatllesprestamo`
--
ALTER TABLE `deatllesprestamo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `divisiones`
--
ALTER TABLE `divisiones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `estantes`
--
ALTER TABLE `estantes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `moviliarios`
--
ALTER TABLE `moviliarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `objetos`
--
ALTER TABLE `objetos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `personales`
--
ALTER TABLE `personales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `alumnos_idpersona_foreign` FOREIGN KEY (`idpersona`) REFERENCES `personas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `deatllesprestamo`
--
ALTER TABLE `deatllesprestamo`
  ADD CONSTRAINT `deatllesprestamo_ibfk_1` FOREIGN KEY (`Id_prestamo`) REFERENCES `prestamos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `deatllesprestamo_ibfk_2` FOREIGN KEY (`Id_objeto`) REFERENCES `objetos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `libros_idobjeto_foreign` FOREIGN KEY (`idobjeto`) REFERENCES `objetos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `moviliarios`
--
ALTER TABLE `moviliarios`
  ADD CONSTRAINT `moviliarios_idobjeto_foreign` FOREIGN KEY (`idobjeto`) REFERENCES `objetos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `personales`
--
ALTER TABLE `personales`
  ADD CONSTRAINT `personales_idpersona_foreign` FOREIGN KEY (`idpersona`) REFERENCES `personas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `prestamos_idpersona_foreign` FOREIGN KEY (`idpersona`) REFERENCES `personas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
