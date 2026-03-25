USE `byv_turnos`;

-- ============================================
-- DATOS DE DEMO (para mostrar al cliente)
-- ============================================

-- 1. Especialidades
INSERT INTO `especialidades` (`id`, `nombre`) VALUES
(1, 'Clínica Médica'),
(2, 'Pediatría'),
(3, 'Cardiología'),
(4, 'Dermatología');

-- 2. Profesionales (con consultorio default)
INSERT INTO `profesionales` (`id`, `nombre`, `especialidad_id`, `consultorio_default_id`) VALUES
(1, 'Dr. Juan Pérez', 1, 1),
(2, 'Dra. María Gómez', 2, 1),
(3, 'Dr. Carlos López', 3, 1),
(4, 'Dra. Ana Martínez', 4, 1);

-- 3. Pacientes
INSERT INTO `pacientes` (`dni`, `nombre`, `apellido`, `telefono`, `email`) VALUES
('30123456', 'Ana', 'Rodríguez', '11-1234-5678', 'ana@email.com'),
('31234567', 'Luis', 'Fernández', '11-2345-6789', 'luis@email.com'),
('32345678', 'Carla', 'Martínez', '11-3456-7890', 'carla@email.com'),
('33456789', 'Pedro', 'González', '11-4567-8901', 'pedro@email.com'),
('34567890', 'Laura', 'Sánchez', '11-5678-9012', 'laura@email.com');

-- 4. Turnos de ejemplo (hoy y mañana)
INSERT INTO `turnos` (`paciente_id`, `profesional_id`, `consultorio_id`, `fecha_hora`, `estado_id`, `observaciones`) VALUES
(1, 1, 1, DATE_ADD(NOW(), INTERVAL 1 HOUR), 2, 'Control anual'),
(2, 2, 1, DATE_ADD(NOW(), INTERVAL 2 HOUR), 1, 'Primera consulta'),
(3, 3, 1, DATE_ADD(NOW(), INTERVAL 3 HOUR), 1, NULL),
(4, 1, 1, DATE_ADD(NOW(), INTERVAL 24 HOUR), 1, 'Seguimiento'),
(5, 4, 1, DATE_ADD(NOW(), INTERVAL 25 HOUR), 2, 'Control dermatológico');