-- --------------------------------------------------------
-- SEED: Datos básicos para testing
-- --------------------------------------------------------

-- 1. Estados de turno (4 estados)
INSERT INTO estados_turno (id, nombre) VALUES
(1, 'Programado'),
(2, 'Concurrido'),
(3, 'No Concurrido'),
(4, 'Cancelado');

-- 2. Especialidades
INSERT INTO especialidades (id, nombre) VALUES
(1, 'Cardiología'),
(2, 'Clínica'),
(3, 'Pediatría'),
(4, 'Dermatología');

-- 3. Consultorios
INSERT INTO consultorios (id, nombre) VALUES
(1, 'Consultorio 1 - Planta Baja'),
(2, 'Consultorio 2 - Planta Baja'),
(3, 'Consultorio 3 - 1er Piso');

-- 4. Profesionales
INSERT INTO profesionales (id, nombre, consultorio_default_id, duracion_default) VALUES
(1, 'Dr. Pérez, Juan', 1, 30),
(2, 'Dra. López, María', 2, 30),
(3, 'Dr. Gómez, Carlos', 3, 45);

-- 5. Vincular profesionales con especialidades
INSERT INTO profesional_especialidad (profesional_id, especialidad_id) VALUES
(1, 1), (1, 2),
(2, 2), (2, 4),
(3, 3);

-- 6. Agendas (Lunes a Viernes)
INSERT INTO agendas (profesional_id, dia_semana, hora_inicio, hora_fin, duracion_minutos) VALUES
-- Dr. Pérez: Lunes, Miércoles, Viernes 8-12hs
(1, 1, '08:00:00', '12:00:00', 30),
(1, 3, '08:00:00', '12:00:00', 30),
(1, 5, '08:00:00', '12:00:00', 30),
-- Dra. López: Lunes a Viernes 14-18hs
(2, 1, '14:00:00', '18:00:00', 30),
(2, 2, '14:00:00', '18:00:00', 30),
(2, 3, '14:00:00', '18:00:00', 30),
(2, 4, '14:00:00', '18:00:00', 30),
(2, 5, '14:00:00', '18:00:00', 30),
-- Dr. Gómez: Martes y Jueves 9-13hs
(3, 2, '09:00:00', '13:00:00', 45),
(3, 4, '09:00:00', '13:00:00', 45);

-- 7. Pacientes (para los turnos)
INSERT INTO pacientes (dni, apellido, nombre, email, telefono) VALUES
(20123456, 'González', 'Ana', 'ana@email.com', '11-1234-5678'),
(25234567, 'Rodríguez', 'Luis', 'luis@email.com', '11-2345-6789'),
(30345678, 'Martínez', 'Sofía', 'sofia@email.com', '11-3456-7890'),
(35456789, 'Fernández', 'Pedro', 'pedro@email.com', '11-4567-8901');

-- 8. Turnos de ejemplo (ajustar fechas según necesites)
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, duracion_minutos, sobreturno, observaciones) VALUES
-- Turnos Programados (futuros)
(1, 1, 1, '2026-04-27 08:00:00', 1, 30, 0, 'Primera consulta'),
(2, 1, 1, '2026-04-27 08:30:00', 1, 30, 0, NULL),
(3, 2, 2, '2026-04-27 14:00:00', 1, 30, 0, 'Control'),
(4, 3, 3, '2026-04-28 09:00:00', 1, 45, 0, NULL),
-- Turnos Concurridos (pasados)
(1, 2, 2, '2026-04-20 14:00:00', 2, 30, 0, 'Se realizó sin problemas'),
(2, 1, 1, '2026-04-21 08:00:00', 2, 30, 0, NULL),
-- Turnos No Concurridos
(3, 1, 1, '2026-04-22 09:00:00', 3, 30, 0, 'No asistió, no avisó'),
-- Turnos Cancelados
(4, 2, 2, '2026-04-23 15:00:00', 4, 30, 0, 'Canceló con 24hs de anticipación'),
-- Sobreturnos
(1, 1, 1, '2026-04-27 12:30:00', 1, 30, 1, 'Fuera de agenda - Urgencia');

-- 9 estados turnos

ALTER TABLE estados_turno ADD COLUMN color VARCHAR(7) DEFAULT '#17a2b8';

UPDATE estados_turno SET color = '#17a2b8' WHERE id = 1; -- Programado
UPDATE estados_turno SET color = '#28a745' WHERE id = 2; -- Concurrido
UPDATE estados_turno SET color = '#6c757d' WHERE id = 3; -- No Concurrido
UPDATE estados_turno SET color = '#dc3545' WHERE id = 4; -- Cancelado