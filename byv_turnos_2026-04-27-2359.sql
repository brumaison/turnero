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
DROP DATABASE IF EXISTS `byv_turnos`;
CREATE DATABASE IF NOT EXISTS `byv_turnos` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `byv_turnos`;

-- Volcando estructura para tabla byv_turnos.agendas
DROP TABLE IF EXISTS `agendas`;
CREATE TABLE IF NOT EXISTS `agendas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `profesional_id` int NOT NULL,
  `dia_semana` tinyint NOT NULL COMMENT '1=Lunes, 7=Domingo',
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `duracion_minutos` int DEFAULT '30',
  `activo` tinyint DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `profesional_id` (`profesional_id`),
  CONSTRAINT `agendas_ibfk_1` FOREIGN KEY (`profesional_id`) REFERENCES `profesionales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.agendas: ~0 rows (aproximadamente)
DELETE FROM `agendas`;
INSERT INTO `agendas` (`id`, `profesional_id`, `dia_semana`, `hora_inicio`, `hora_fin`, `duracion_minutos`, `activo`, `created_at`) VALUES
	(1, 1, 1, '08:00:00', '12:00:00', 30, 1, '2026-04-28 01:42:45'),
	(2, 1, 3, '08:00:00', '12:00:00', 30, 1, '2026-04-28 01:42:45'),
	(3, 1, 5, '08:00:00', '12:00:00', 30, 1, '2026-04-28 01:42:45'),
	(4, 2, 1, '14:00:00', '18:00:00', 30, 1, '2026-04-28 01:42:45'),
	(5, 2, 2, '14:00:00', '18:00:00', 30, 1, '2026-04-28 01:42:45'),
	(6, 2, 3, '14:00:00', '18:00:00', 30, 1, '2026-04-28 01:42:45'),
	(7, 2, 4, '14:00:00', '18:00:00', 30, 1, '2026-04-28 01:42:45'),
	(8, 2, 5, '14:00:00', '18:00:00', 30, 1, '2026-04-28 01:42:45'),
	(9, 3, 2, '09:00:00', '13:00:00', 45, 1, '2026-04-28 01:42:45'),
	(10, 3, 4, '09:00:00', '13:00:00', 45, 1, '2026-04-28 01:42:45');

-- Volcando estructura para tabla byv_turnos.configuracion
DROP TABLE IF EXISTS `configuracion`;
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

-- Volcando datos para la tabla byv_turnos.configuracion: ~0 rows (aproximadamente)
DELETE FROM `configuracion`;
INSERT INTO `configuracion` (`id`, `sede_base_id`, `logo_url`, `nombre_comercial`, `permite_turnos_online`) VALUES
	(1, 1, NULL, 'Círculo Médico Matanza', 0);

-- Volcando estructura para tabla byv_turnos.consultas
DROP TABLE IF EXISTS `consultas`;
CREATE TABLE IF NOT EXISTS `consultas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `turno_id` int NOT NULL,
  `paciente_id` int NOT NULL,
  `profesional_id` int NOT NULL,
  `diagnostico` text COLLATE utf8mb4_unicode_ci,
  `notas` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `turno_id` (`turno_id`),
  KEY `idx_paciente_id` (`paciente_id`),
  KEY `idx_profesional_id` (`profesional_id`),
  KEY `idx_turno_id` (`turno_id`),
  CONSTRAINT `consultas_ibfk_1` FOREIGN KEY (`turno_id`) REFERENCES `turnos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `consultas_ibfk_2` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`),
  CONSTRAINT `consultas_ibfk_3` FOREIGN KEY (`profesional_id`) REFERENCES `profesionales` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Consultas médicas realizadas por profesionales';

-- Volcando datos para la tabla byv_turnos.consultas: ~4 rows (aproximadamente)
DELETE FROM `consultas`;
INSERT INTO `consultas` (`id`, `turno_id`, `paciente_id`, `profesional_id`, `diagnostico`, `notas`, `created_at`, `updated_at`) VALUES
	(1, 11, 1, 1, 'una mala niñera!', 'una mala niñera!', '2026-04-17 03:28:30', '2026-04-17 03:28:30'),
	(2, 1, 1, 1, 'no sabemos', 'viene medio roto', '2026-03-24 03:44:05', '2026-03-24 03:44:05'),
	(3, 17, 2, 2, '', '', '2026-04-21 01:29:11', '2026-04-21 01:29:11'),
	(4, 27, 1, 2, 'dignostico tal', 'nota tal y cual', '2026-04-22 14:28:26', '2026-04-22 14:28:26'),
	(5, 32, 11, 3, 'a´lfo', 'algkghn', '2026-04-23 02:33:11', '2026-04-23 02:33:11');

-- Volcando estructura para tabla byv_turnos.consultorios
DROP TABLE IF EXISTS `consultorios`;
CREATE TABLE IF NOT EXISTS `consultorios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sede_id` int DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `consultorios_ibfk_1` (`sede_id`),
  CONSTRAINT `consultorios_ibfk_1` FOREIGN KEY (`sede_id`) REFERENCES `sedes` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.consultorios: ~0 rows (aproximadamente)
DELETE FROM `consultorios`;
INSERT INTO `consultorios` (`id`, `sede_id`, `nombre`, `direccion`, `telefono`) VALUES
	(1, NULL, 'Consultorio 1 - Planta Baja', NULL, NULL),
	(2, NULL, 'Consultorio 2 - Planta Baja', NULL, NULL),
	(3, NULL, 'Consultorio 3 - 1er Piso', NULL, NULL);

-- Volcando estructura para tabla byv_turnos.especialidades
DROP TABLE IF EXISTS `especialidades`;
CREATE TABLE IF NOT EXISTS `especialidades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.especialidades: ~0 rows (aproximadamente)
DELETE FROM `especialidades`;
INSERT INTO `especialidades` (`id`, `nombre`) VALUES
	(1, 'Cardiología'),
	(2, 'Clínica'),
	(3, 'Pediatría'),
	(4, 'Dermatología');

-- Volcando estructura para tabla byv_turnos.estados_turno
DROP TABLE IF EXISTS `estados_turno`;
CREATE TABLE IF NOT EXISTS `estados_turno` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT '#17a2b8',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.estados_turno: ~4 rows (aproximadamente)
DELETE FROM `estados_turno`;
INSERT INTO `estados_turno` (`id`, `nombre`, `color`) VALUES
	(1, 'Programado', '#17a2b8'),
	(2, 'Concurrido', '#28a745'),
	(3, 'No Concurrido', '#6c757d'),
	(4, 'Cancelado', '#dc3545');

-- Volcando estructura para tabla byv_turnos.operadores
DROP TABLE IF EXISTS `operadores`;
CREATE TABLE IF NOT EXISTS `operadores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `operadores_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.operadores: ~1 rows (aproximadamente)
DELETE FROM `operadores`;
INSERT INTO `operadores` (`id`, `email`, `password_hash`, `role_id`) VALUES
	(1, 'admin@demo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);

-- Volcando estructura para tabla byv_turnos.operador_consultorios
DROP TABLE IF EXISTS `operador_consultorios`;
CREATE TABLE IF NOT EXISTS `operador_consultorios` (
  `operador_id` int NOT NULL,
  `consultorio_id` int NOT NULL,
  PRIMARY KEY (`operador_id`,`consultorio_id`),
  KEY `consultorio_id` (`consultorio_id`),
  CONSTRAINT `operador_consultorios_ibfk_1` FOREIGN KEY (`operador_id`) REFERENCES `operadores` (`id`) ON DELETE CASCADE,
  CONSTRAINT `operador_consultorios_ibfk_2` FOREIGN KEY (`consultorio_id`) REFERENCES `consultorios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.operador_consultorios: ~0 rows (aproximadamente)
DELETE FROM `operador_consultorios`;

-- Volcando estructura para tabla byv_turnos.pacientes
DROP TABLE IF EXISTS `pacientes`;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.pacientes: ~0 rows (aproximadamente)
DELETE FROM `pacientes`;
INSERT INTO `pacientes` (`id`, `dni`, `nombre`, `apellido`, `email`, `telefono`, `fecha_alta`) VALUES
	(1, '20123456', 'Ana', 'González', 'ana@email.com', '11-1234-5678', '2026-04-28 01:46:10'),
	(2, '25234567', 'Luis', 'Rodríguez', 'luis@email.com', '11-2345-6789', '2026-04-28 01:46:10'),
	(3, '30345678', 'Sofía', 'Martínez', 'sofia@email.com', '11-3456-7890', '2026-04-28 01:46:10'),
	(4, '35456789', 'Pedro', 'Fernández', 'pedro@email.com', '11-4567-8901', '2026-04-28 01:46:10');

-- Volcando estructura para tabla byv_turnos.permissions
DROP TABLE IF EXISTS `permissions`;
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
DELETE FROM `permissions`;
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
DROP TABLE IF EXISTS `profesionales`;
CREATE TABLE IF NOT EXISTS `profesionales` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `consultorio_default_id` int DEFAULT NULL,
  `duracion_default` int DEFAULT '30',
  PRIMARY KEY (`id`),
  KEY `profesionales_ibfk_3` (`consultorio_default_id`),
  KEY `idx_profesionales_user_id` (`user_id`),
  CONSTRAINT `profesionales_ibfk_3` FOREIGN KEY (`consultorio_default_id`) REFERENCES `consultorios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.profesionales: ~0 rows (aproximadamente)
DELETE FROM `profesionales`;
INSERT INTO `profesionales` (`id`, `user_id`, `nombre`, `consultorio_default_id`, `duracion_default`) VALUES
	(1, NULL, 'Dr. Pérez, Juan', 1, 30),
	(2, NULL, 'Dra. López, María', 2, 30),
	(3, NULL, 'Dr. Gómez, Carlos', 3, 45);

-- Volcando estructura para tabla byv_turnos.profesional_especialidad
DROP TABLE IF EXISTS `profesional_especialidad`;
CREATE TABLE IF NOT EXISTS `profesional_especialidad` (
  `profesional_id` int NOT NULL,
  `especialidad_id` int NOT NULL,
  PRIMARY KEY (`profesional_id`,`especialidad_id`),
  KEY `especialidad_id` (`especialidad_id`),
  CONSTRAINT `profesional_especialidad_ibfk_1` FOREIGN KEY (`profesional_id`) REFERENCES `profesionales` (`id`) ON DELETE CASCADE,
  CONSTRAINT `profesional_especialidad_ibfk_2` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidades` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.profesional_especialidad: ~0 rows (aproximadamente)
DELETE FROM `profesional_especialidad`;
INSERT INTO `profesional_especialidad` (`profesional_id`, `especialidad_id`) VALUES
	(1, 1),
	(1, 2),
	(2, 2),
	(3, 3),
	(2, 4);

-- Volcando estructura para tabla byv_turnos.roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.roles: ~2 rows (aproximadamente)
DELETE FROM `roles`;
INSERT INTO `roles` (`id`, `slug`, `nombre`, `descripcion`, `created_at`) VALUES
	(1, 'admin', 'Administrador', 'Acceso total al sistema', '2026-03-18 23:36:02'),
	(2, 'recepcion', 'Recepcionista', 'Gestión básica de turnos y pacientes', '2026-03-18 23:36:02'),
	(3, 'medico', 'Médico', 'Solo ve sus propios turnos y agenda', '2026-04-14 00:42:22');

-- Volcando estructura para tabla byv_turnos.role_permissions
DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE IF NOT EXISTS `role_permissions` (
  `role_id` int NOT NULL,
  `permission_id` int NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `permission_id` (`permission_id`),
  CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.role_permissions: ~14 rows (aproximadamente)
DELETE FROM `role_permissions`;
INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(1, 2),
	(2, 2),
	(1, 3),
	(2, 3),
	(1, 4),
	(1, 5),
	(2, 5),
	(3, 5),
	(1, 6),
	(2, 6),
	(1, 7),
	(2, 7),
	(1, 8);

-- Volcando estructura para tabla byv_turnos.sedes
DROP TABLE IF EXISTS `sedes`;
CREATE TABLE IF NOT EXISTS `sedes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.sedes: ~0 rows (aproximadamente)
DELETE FROM `sedes`;
INSERT INTO `sedes` (`id`, `nombre`, `direccion`, `telefono`) VALUES
	(1, 'Sede Central', 'Av. Siempre Viva 123', NULL);

-- Volcando estructura para tabla byv_turnos.turnos
DROP TABLE IF EXISTS `turnos`;
CREATE TABLE IF NOT EXISTS `turnos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `paciente_id` int NOT NULL,
  `profesional_id` int NOT NULL,
  `consultorio_id` int DEFAULT NULL,
  `fecha_hora` datetime NOT NULL,
  `estado_id` int DEFAULT '1',
  `sobreturno` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `duracion_minutos` int DEFAULT '30',
  PRIMARY KEY (`id`),
  KEY `paciente_id` (`paciente_id`),
  KEY `profesional_id` (`profesional_id`),
  KEY `estado_id` (`estado_id`),
  KEY `turnos_ibfk_4` (`consultorio_id`),
  KEY `idx_turnos_sobreturno` (`sobreturno`),
  CONSTRAINT `turnos_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `turnos_ibfk_2` FOREIGN KEY (`profesional_id`) REFERENCES `profesionales` (`id`) ON DELETE CASCADE,
  CONSTRAINT `turnos_ibfk_3` FOREIGN KEY (`estado_id`) REFERENCES `estados_turno` (`id`),
  CONSTRAINT `turnos_ibfk_4` FOREIGN KEY (`consultorio_id`) REFERENCES `consultorios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla byv_turnos.turnos: ~0 rows (aproximadamente)
DELETE FROM `turnos`;
INSERT INTO `turnos` (`id`, `paciente_id`, `profesional_id`, `consultorio_id`, `fecha_hora`, `estado_id`, `sobreturno`, `fecha_creacion`, `observaciones`, `duracion_minutos`) VALUES
	(1, 1, 1, 1, '2026-04-27 08:00:00', 1, 0, '2026-04-28 01:46:18', 'Primera consulta', 30),
	(2, 2, 1, 1, '2026-04-27 08:30:00', 1, 0, '2026-04-28 01:46:18', NULL, 30),
	(3, 3, 2, 2, '2026-04-27 14:00:00', 1, 0, '2026-04-28 01:46:18', 'Control', 30),
	(4, 4, 3, 3, '2026-04-28 09:00:00', 1, 0, '2026-04-28 01:46:18', NULL, 45),
	(5, 1, 2, 2, '2026-04-20 14:00:00', 2, 0, '2026-04-28 01:46:18', 'Se realizó sin problemas', 30),
	(6, 2, 1, 1, '2026-04-21 08:00:00', 2, 0, '2026-04-28 01:46:18', NULL, 30),
	(7, 3, 1, 1, '2026-04-22 09:00:00', 3, 0, '2026-04-28 01:46:18', 'No asistió, no avisó', 30),
	(8, 4, 2, 2, '2026-04-23 15:00:00', 4, 0, '2026-04-28 01:46:18', 'Canceló con 24hs de anticipación', 30),
	(9, 1, 1, 1, '2026-04-27 12:30:00', 1, 1, '2026-04-28 01:46:18', 'Fuera de agenda - Urgencia', 30);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
