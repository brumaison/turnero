-- Seed: Turnos Julio 2026 (31 días) - ~30% ocupación
-- Deja ~70% de slots libres para futuros turnos
-- Prof 1 (Dr. Pérez): Lun/Mie/Vie 08:00-12:00 cada 30min (8 slots/día)
-- Prof 2 (Dra. López): Lun-Vie 14:00-18:00 cada 30min (8 slots/día)
-- Prof 3 (Dr. Gómez): Mar/Jue 09:00-13:00 cada 45min (5 slots/día)

-- Semana 1: Lunes 07/07/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez: 3 de 8 slots (37%)
(1, 1, 1, '2026-07-07 08:00:00', 1, 0, 'Control cardiología', 30),
(2, 1, 1, '2026-07-07 10:00:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-07-07 11:30:00', 1, 0, 'Primera vez', 30),
-- Dra. López: 2 de 8 slots (25%)
(1, 2, 2, '2026-07-07 14:30:00', 1, 0, 'Dermatología', 30),
(2, 2, 2, '2026-07-07 16:00:00', 1, 0, NULL, 30);

-- Semana 1: Martes 08/07/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López: 2 de 8 slots
(3, 2, 2, '2026-07-08 15:00:00', 1, 0, 'Control piel', 30),
(4, 2, 2, '2026-07-08 17:00:00', 1, 0, NULL, 30),
-- Dr. Gómez: 2 de 5 slots (40%)
(1, 3, 3, '2026-07-08 09:00:00', 1, 0, 'Pediatría - Control', 45),
(2, 3, 3, '2026-07-08 11:15:00', 1, 0, NULL, 45);

-- Semana 1: Miércoles 09/07/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez: 3 de 8 slots
(1, 1, 1, '2026-07-09 09:00:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-07-09 10:30:00', 1, 0, 'Seguimiento', 30),
(4, 1, 1, '2026-07-09 11:00:00', 1, 0, NULL, 30),
-- Dra. López: 2 de 8 slots
(1, 2, 2, '2026-07-09 14:00:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-07-09 16:30:00', 1, 0, 'Primera consulta', 30);

-- Semana 1: Jueves 10/07/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López: 2 de 8 slots
(2, 2, 2, '2026-07-10 15:30:00', 1, 0, 'Control', 30),
(4, 2, 2, '2026-07-10 17:30:00', 1, 0, NULL, 30),
-- Dr. Gómez: 2 de 5 slots
(3, 3, 3, '2026-07-10 09:45:00', 1, 0, 'Vacunación', 45),
(4, 3, 3, '2026-07-10 12:00:00', 1, 0, NULL, 45);

-- Semana 1: Viernes 11/07/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez: 3 de 8 slots
(2, 1, 1, '2026-07-11 08:30:00', 1, 0, 'Control', 30),
(1, 1, 1, '2026-07-11 10:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-07-11 11:30:00', 1, 0, 'Primera consulta', 30),
-- Dra. López: 2 de 8 slots
(1, 2, 2, '2026-07-11 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-07-11 15:00:00', 1, 0, 'Seguimiento', 30);

-- Semana 2: Lunes 14/07/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez: 2 de 8 slots
(1, 1, 1, '2026-07-14 08:00:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-07-14 09:30:00', 1, 0, 'Control cardiología', 30),
-- Dra. López: 2 de 8 slots
(3, 2, 2, '2026-07-14 14:30:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-07-14 16:00:00', 1, 0, 'Primera vez', 30);

-- Semana 2: Martes 15/07/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López: 2 de 8 slots
(1, 2, 2, '2026-07-15 15:00:00', 1, 0, 'Control piel', 30),
(2, 2, 2, '2026-07-15 17:00:00', 1, 0, NULL, 30),
-- Dr. Gómez: 2 de 5 slots
(1, 3, 3, '2026-07-15 09:00:00', 1, 0, NULL, 45),
(3, 3, 3, '2026-07-15 10:30:00', 1, 0, 'Control crecimiento', 45);

-- Semana 2: Miércoles 16/07/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez: 2 de 8 slots
(2, 1, 1, '2026-07-16 08:30:00', 1, 0, 'Seguimiento', 30),
(4, 1, 1, '2026-07-16 11:00:00', 1, 0, NULL, 30),
-- Dra. López: 2 de 8 slots
(1, 2, 2, '2026-07-16 14:00:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-07-16 15:30:00', 1, 0, 'Control', 30);

-- Semana 2: Jueves 17/07/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López: 2 de 8 slots
(2, 2, 2, '2026-07-17 14:30:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-07-17 16:30:00', 1, 0, 'Primera consulta', 30),
-- Dr. Gómez: 2 de 5 slots
(2, 3, 3, '2026-07-17 09:45:00', 1, 0, NULL, 45),
(4, 3, 3, '2026-07-17 11:15:00', 1, 0, 'Vacunación', 45);

-- Semana 2: Viernes 18/07/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez: 2 de 8 slots
(1, 1, 1, '2026-07-18 09:00:00', 1, 0, 'Control', 30),
(3, 1, 1, '2026-07-18 10:30:00', 1, 0, NULL, 30),
-- Dra. López: 2 de 8 slots
(1, 2, 2, '2026-07-18 15:00:00', 1, 0, 'Dermatología', 30),
(3, 2, 2, '2026-07-18 17:00:00', 1, 0, NULL, 30);

-- Semana 3: Lunes 21/07/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez: 2 de 8 slots
(2, 1, 1, '2026-07-21 08:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-07-21 10:00:00', 1, 0, 'Primera vez', 30),
-- Dra. López: 2 de 8 slots
(2, 2, 2, '2026-07-21 14:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-07-21 16:30:00', 1, 0, 'Seguimiento', 30);

-- Semana 3: Martes 22/07/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López: 2 de 8 slots
(1, 2, 2, '2026-07-22 15:30:00', 1, 0, 'Control piel', 30),
(3, 2, 2, '2026-07-22 17:00:00', 1, 0, NULL, 30),
-- Dr. Gómez: 2 de 5 slots
(1, 3, 3, '2026-07-22 09:00:00', 1, 0, 'Pediatría', 45),
(2, 3, 3, '2026-07-22 11:15:00', 1, 0, NULL, 45);

-- Semana 3: Miércoles 23/07/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez: 2 de 8 slots
(1, 1, 1, '2026-07-23 08:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-07-23 11:00:00', 1, 0, 'Control cardiología', 30),
-- Dra. López: 2 de 8 slots
(2, 2, 2, '2026-07-23 14:30:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-07-23 16:00:00', 1, 0, 'Primera consulta', 30);

-- Semana 3: Jueves 24/07/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López: 2 de 8 slots
(1, 2, 2, '2026-07-24 14:00:00', 1, 0, 'Control', 30),
(3, 2, 2, '2026-07-24 15:30:00', 1, 0, NULL, 30),
-- Dr. Gómez: 2 de 5 slots
(3, 3, 3, '2026-07-24 09:45:00', 1, 0, NULL, 45),
(4, 3, 3, '2026-07-24 12:00:00', 1, 0, 'Control', 45);

-- Semana 3: Viernes 25/07/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez: 2 de 8 slots
(2, 1, 1, '2026-07-25 09:00:00', 1, 0, 'Seguimiento', 30),
(4, 1, 1, '2026-07-25 10:30:00', 1, 0, NULL, 30),
-- Dra. López: 2 de 8 slots
(1, 2, 2, '2026-07-25 15:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-07-25 17:30:00', 1, 0, 'Primera vez', 30);

-- Semana 4: Lunes 28/07/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez: 2 de 8 slots
(1, 1, 1, '2026-07-28 08:00:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-07-28 11:30:00', 1, 0, 'Control', 30),
-- Dra. López: 2 de 8 slots
(3, 2, 2, '2026-07-28 14:00:00', 1, 0, 'Dermatología', 30),
(4, 2, 2, '2026-07-28 16:00:00', 1, 0, NULL, 30);

-- Semana 4: Martes 29/07/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López: 2 de 8 slots
(1, 2, 2, '2026-07-29 15:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-07-29 17:00:00', 1, 0, 'Seguimiento', 30),
-- Dr. Gómez: 2 de 5 slots
(1, 3, 3, '2026-07-29 09:00:00', 1, 0, 'Vacunación', 45),
(3, 3, 3, '2026-07-29 10:30:00', 1, 0, NULL, 45);

-- Semana 4: Miércoles 30/07/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez: 2 de 8 slots
(2, 1, 1, '2026-07-30 08:30:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-07-30 10:00:00', 1, 0, 'Primera consulta', 30),
-- Dra. López: 2 de 8 slots
(1, 2, 2, '2026-07-30 14:30:00', 1, 0, 'Control piel', 30),
(3, 2, 2, '2026-07-30 16:30:00', 1, 0, NULL, 30);

-- Semana 4: Jueves 31/07/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López: 2 de 8 slots
(2, 2, 2, '2026-07-31 14:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-07-31 15:30:00', 1, 0, 'Control', 30),
-- Dr. Gómez: 2 de 5 slots
(2, 3, 3, '2026-07-31 09:45:00', 1, 0, NULL, 45),
(4, 3, 3, '2026-07-31 11:15:00', 1, 0, 'Control crecimiento', 45);
