-- Seed: Turnos futuros (17-30 Abril 2026)
-- Horarios: 8:00 a 16:00
-- Profesionales: ID 1-5
-- Consultorios: Usar consultorio_default_id de cada profesional
-- Estado: 1 (Pendiente)
-- Duración: 30 minutos

INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, observaciones, duracion_minutos) VALUES
-- Día 1: Viernes 17/04/2026
(1, 1, 1, '2026-04-17 08:00:00', 1, 'Primera consulta', 30),
(2, 2, 2, '2026-04-17 09:00:00', 1, 'Control', 30),
(3, 3, 4, '2026-04-17 10:00:00', 1, '', 30),
(4, 4, 3, '2026-04-17 11:00:00', 1, 'Seguimiento', 30),
(5, 5, 5, '2026-04-17 14:00:00', 1, '', 30),

-- Día 2: Lunes 20/04/2026
(1, 1, 1, '2026-04-20 08:30:00', 1, '', 30),
(2, 2, 2, '2026-04-20 09:30:00', 1, '', 30),
(3, 3, 4, '2026-04-20 10:30:00', 1, 'Control mensual', 30),
(1, 4, 3, '2026-04-20 15:00:00', 1, '', 30),
(2, 5, 5, '2026-04-20 16:00:00', 1, '', 30),

-- Día 3: Martes 21/04/2026
(4, 1, 1, '2026-04-21 08:00:00', 1, '', 30),
(5, 2, 2, '2026-04-21 10:00:00', 1, 'Primera vez', 30),
(1, 3, 4, '2026-04-21 11:30:00', 1, '', 30),
(3, 4, 3, '2026-04-21 14:30:00', 1, '', 30),
(2, 5, 5, '2026-04-21 15:30:00', 1, 'Control', 30),

-- Día 4: Miércoles 22/04/2026
(5, 1, 1, '2026-04-22 09:00:00', 1, '', 30),
(1, 2, 2, '2026-04-22 10:00:00', 1, '', 30),
(4, 3, 4, '2026-04-22 11:00:00', 1, 'Segunda consulta', 30),
(2, 4, 3, '2026-04-22 13:00:00', 1, '', 30),
(3, 5, 5, '2026-04-22 16:00:00', 1, '', 30);

-- Total: 20 turnos futuros distribuidos