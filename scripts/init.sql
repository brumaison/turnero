-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para byv_turnos
CREATE DATABASE IF NOT EXISTS `byv_turnos` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `byv_turnos`;

-- Volcando estructura para tabla byv_turnos.configuracion
CREATE TABLE IF NOT EXISTS `configuracion` (
  `id` int NOT NULL DEFAULT '1',
  `sede_base_id` int DEFAULT NULL,
  `logo_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_comercial` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permite_turnos_online` tinyint DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `sede_base_id` (`sede_base_id`),
  CONSTRAINT `configuracion_ibfk_1` FOREIGN KEY (`sede_base_id`) REFERENCES `sedes` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.configuracion: ~1 rows (aproximadamente)
INSERT INTO `configuracion` (`id`, `sede_base_id`, `logo_url`, `nombre_comercial`, `permite_turnos_online`) VALUES
	(1, 1, NULL, 'Círculo Médico Matanza', 0);

-- Volcando estructura para tabla byv_turnos.consultorios
CREATE TABLE IF NOT EXISTS `consultorios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sede_id` int DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `consultorios_ibfk_1` (`sede_id`),
  CONSTRAINT `consultorios_ibfk_1` FOREIGN KEY (`sede_id`) REFERENCES `sedes` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.consultorios: ~1 rows (aproximadamente)
INSERT INTO `consultorios` (`id`, `sede_id`, `nombre`, `direccion`, `telefono`) VALUES
	(1, 1, 'Consultorio Central', 'Av. Siempre Viva 123', NULL);

-- Volcando estructura para tabla byv_turnos.especialidades
CREATE TABLE IF NOT EXISTS `especialidades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.especialidades: ~0 rows (aproximadamente)

-- Volcando estructura para tabla byv_turnos.estados_turno
CREATE TABLE IF NOT EXISTS `estados_turno` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.estados_turno: ~5 rows (aproximadamente)
INSERT INTO `estados_turno` (`id`, `nombre`) VALUES
	(1, 'Pendiente'),
	(2, 'Confirmado'),
	(3, 'Cancelado'),
	(4, 'Ausente'),
	(5, 'Realizado');

-- Volcando estructura para tabla byv_turnos.operadores
CREATE TABLE IF NOT EXISTS `operadores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `operadores_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.operadores: ~1 rows (aproximadamente)
INSERT INTO `operadores` (`id`, `email`, `password_hash`, `role_id`) VALUES
	(1, 'admin@demo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);

-- Volcando estructura para tabla byv_turnos.operador_consultorios
CREATE TABLE IF NOT EXISTS `operador_consultorios` (
  `operador_id` int NOT NULL,
  `consultorio_id` int NOT NULL,
  PRIMARY KEY (`operador_id`,`consultorio_id`),
  KEY `consultorio_id` (`consultorio_id`),
  CONSTRAINT `operador_consultorios_ibfk_1` FOREIGN KEY (`operador_id`) REFERENCES `operadores` (`id`) ON DELETE CASCADE,
  CONSTRAINT `operador_consultorios_ibfk_2` FOREIGN KEY (`consultorio_id`) REFERENCES `consultorios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.operador_consultorios: ~0 rows (aproximadamente)
INSERT INTO `operador_consultorios` (`operador_id`, `consultorio_id`) VALUES
	(1, 1);

-- Volcando estructura para tabla byv_turnos.pacientes
CREATE TABLE IF NOT EXISTS `pacientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dni` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dni` (`dni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.pacientes: ~0 rows (aproximadamente)

-- Volcando estructura para tabla byv_turnos.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.permissions: ~8 rows (aproximadamente)
INSERT INTO `permissions` (`id`, `slug`, `nombre`, `descripcion`, `created_at`) VALUES
	(1, 'turnos.view', 'Ver turnos', NULL, '2026-03-18 23:36:02'),
	(2, 'turnos.create', 'Crear turnos', NULL, '2026-03-18 23:36:02'),
	(3, 'turnos.edit', 'Editar turnos', NULL, '2026-03-18 23:36:02'),
	(4, 'turnos.delete', 'Eliminar turnos', NULL, '2026-03-18 23:36:02'),
	(5, 'pacientes.view', 'Ver pacientes', NULL, '2026-03-18 23:36:02'),
	(6, 'pacientes.create', 'Crear pacientes', NULL, '2026-03-18 23:36:02'),
	(7, 'pacientes.edit', 'Editar pacientes', NULL, '2026-03-18 23:36:02'),
	(8, 'operadores.manage', 'Gestionar operadores', NULL, '2026-03-18 23:36:02');

-- Volcando estructura para tabla byv_turnos.profesionales
CREATE TABLE IF NOT EXISTS `profesionales` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `especialidad_id` int DEFAULT NULL,
  `consultorio_default_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `especialidad_id` (`especialidad_id`),
  KEY `profesionales_ibfk_3` (`consultorio_default_id`),
  CONSTRAINT `profesionales_ibfk_1` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidades` (`id`) ON DELETE SET NULL,
  CONSTRAINT `profesionales_ibfk_3` FOREIGN KEY (`consultorio_default_id`) REFERENCES `consultorios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.profesionales: ~0 rows (aproximadamente)

-- Volcando estructura para tabla byv_turnos.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.roles: ~2 rows (aproximadamente)
INSERT INTO `roles` (`id`, `slug`, `nombre`, `descripcion`, `created_at`) VALUES
	(1, 'admin', 'Administrador', 'Acceso total al sistema', '2026-03-18 23:36:02'),
	(2, 'recepcion', 'Recepcionista', 'Gestión básica de turnos y pacientes', '2026-03-18 23:36:02');

-- Volcando estructura para tabla byv_turnos.role_permissions
CREATE TABLE IF NOT EXISTS `role_permissions` (
  `role_id` int NOT NULL,
  `permission_id` int NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `permission_id` (`permission_id`),
  CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.role_permissions: ~14 rows (aproximadamente)
INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
	(1, 1),
	(2, 1),
	(1, 2),
	(2, 2),
	(1, 3),
	(2, 3),
	(1, 4),
	(1, 5),
	(2, 5),
	(1, 6),
	(2, 6),
	(1, 7),
	(2, 7),
	(1, 8);

-- Volcando estructura para tabla byv_turnos.sedes
CREATE TABLE IF NOT EXISTS `sedes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.sedes: ~1 rows (aproximadamente)
INSERT INTO `sedes` (`id`, `nombre`, `direccion`, `telefono`) VALUES
	(1, 'Sede Central', 'Av. Siempre Viva 123', NULL);

-- Volcando estructura para tabla byv_turnos.turnos
CREATE TABLE IF NOT EXISTS `turnos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `paciente_id` int NOT NULL,
  `profesional_id` int NOT NULL,
  `consultorio_id` int DEFAULT NULL,
  `fecha_hora` datetime NOT NULL,
  `estado_id` int DEFAULT '1',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `paciente_id` (`paciente_id`),
  KEY `profesional_id` (`profesional_id`),
  KEY `estado_id` (`estado_id`),
  KEY `turnos_ibfk_4` (`consultorio_id`),
  CONSTRAINT `turnos_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `turnos_ibfk_2` FOREIGN KEY (`profesional_id`) REFERENCES `profesionales` (`id`) ON DELETE CASCADE,
  CONSTRAINT `turnos_ibfk_3` FOREIGN KEY (`estado_id`) REFERENCES `estados_turno` (`id`),
  CONSTRAINT `turnos_ibfk_4` FOREIGN KEY (`consultorio_id`) REFERENCES `consultorios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.turnos: ~0 rows (aproximadamente)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
