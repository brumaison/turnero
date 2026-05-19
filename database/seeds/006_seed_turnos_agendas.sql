-- Seed: Turnos futuros basados en agendas (Mayo-Junio 2026)
-- Genera turnos respetando los horarios de cada agenda
-- Estados variados: Programado, Concurrido, No Concurrido, Cancelado

-- Semana 1: Lunes 18/05/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Lunes 08:00-12:00, cada 30 min)
(1, 1, 1, '2026-05-18 08:00:00', 1, 0, 'Control cardiología', 30),
(2, 1, 1, '2026-05-18 08:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-05-18 09:00:00', 1, 0, 'Primera vez', 30),
(4, 1, 1, '2026-05-18 09:30:00', 1, 0, NULL, 30),
(1, 1, 1, '2026-05-18 10:00:00', 1, 0, 'Seguimiento', 30),
(2, 1, 1, '2026-05-18 10:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-05-18 11:00:00', 1, 0, 'Control', 30),
(4, 1, 1, '2026-05-18 11:30:00', 1, 0, NULL, 30),

-- Dra. López (Lunes 14:00-18:00, cada 30 min)
(1, 2, 2, '2026-05-18 14:00:00', 1, 0, 'Dermatología', 30),
(2, 2, 2, '2026-05-18 14:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-05-18 15:00:00', 1, 0, 'Control piel', 30),
(4, 2, 2, '2026-05-18 15:30:00', 1, 0, NULL, 30),
(1, 2, 2, '2026-05-18 16:00:00', 1, 0, 'Primera consulta', 30),
(2, 2, 2, '2026-05-18 16:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-05-18 17:00:00', 1, 0, 'Seguimiento', 30),
(4, 2, 2, '2026-05-18 17:30:00', 1, 0, NULL, 30);

-- Semana 1: Martes 19/05/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López (Martes 14:00-18:00)
(1, 2, 2, '2026-05-19 14:00:00', 1, 0, 'Control', 30),
(2, 2, 2, '2026-05-19 14:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-05-19 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-05-19 15:30:00', 1, 0, 'Urgencia leve', 30),
(1, 2, 2, '2026-05-19 16:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-05-19 16:30:00', 1, 0, 'Primera vez', 30),
(3, 2, 2, '2026-05-19 17:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-05-19 17:30:00', 1, 0, 'Seguimiento', 30),

-- Dr. Gómez (Martes 09:00-13:00, cada 45 min)
(1, 3, 3, '2026-05-19 09:00:00', 1, 0, 'Pediatría - Control', 45),
(2, 3, 3, '2026-05-19 09:45:00', 1, 0, NULL, 45),
(3, 3, 3, '2026-05-19 10:30:00', 1, 0, 'Vacunación', 45),
(4, 3, 3, '2026-05-19 11:15:00', 1, 0, NULL, 45),
(1, 3, 3, '2026-05-19 12:00:00', 1, 0, 'Control crecimiento', 45);

-- Semana 1: Miércoles 20/05/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Miércoles 08:00-12:00)
(1, 1, 1, '2026-05-20 08:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-05-20 08:30:00', 1, 0, 'Control', 30),
(3, 1, 1, '2026-05-20 09:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-05-20 09:30:00', 1, 0, 'Primera consulta', 30),
(1, 1, 1, '2026-05-20 10:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-05-20 10:30:00', 1, 0, 'Seguimiento', 30),
(3, 1, 1, '2026-05-20 11:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-05-20 11:30:00', 1, 0, 'Control cardiología', 30),

-- Dra. López (Miércoles 14:00-18:00)
(1, 2, 2, '2026-05-20 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-05-20 14:30:00', 1, 0, 'Control piel', 30),
(3, 2, 2, '2026-05-20 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-05-20 15:30:00', 1, 0, 'Primera vez', 30),
(1, 2, 2, '2026-05-20 16:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-05-20 16:30:00', 1, 0, 'Seguimiento', 30),
(3, 2, 2, '2026-05-20 17:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-05-20 17:30:00', 1, 0, 'Control', 30);

-- Semana 1: Jueves 21/05/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López (Jueves 14:00-18:00)
(1, 2, 2, '2026-05-21 14:00:00', 1, 0, 'Dermatología', 30),
(2, 2, 2, '2026-05-21 14:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-05-21 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-05-21 15:30:00', 1, 0, 'Control', 30),
(1, 2, 2, '2026-05-21 16:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-05-21 16:30:00', 1, 0, 'Primera consulta', 30),
(3, 2, 2, '2026-05-21 17:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-05-21 17:30:00', 1, 0, 'Seguimiento', 30),

-- Dr. Gómez (Jueves 09:00-13:00)
(1, 3, 3, '2026-05-21 09:00:00', 1, 0, NULL, 45),
(2, 3, 3, '2026-05-21 09:45:00', 1, 0, 'Control', 45),
(3, 3, 3, '2026-05-21 10:30:00', 1, 0, NULL, 45),
(4, 3, 3, '2026-05-21 11:15:00', 1, 0, 'Vacunación', 45),
(1, 3, 3, '2026-05-21 12:00:00', 1, 0, NULL, 45);

-- Semana 1: Viernes 22/05/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Viernes 08:00-12:00)
(1, 1, 1, '2026-05-22 08:00:00', 1, 0, 'Control', 30),
(2, 1, 1, '2026-05-22 08:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-05-22 09:00:00', 1, 0, 'Primera vez', 30),
(4, 1, 1, '2026-05-22 09:30:00', 1, 0, NULL, 30),
(1, 1, 1, '2026-05-22 10:00:00', 1, 0, 'Seguimiento', 30),
(2, 1, 1, '2026-05-22 10:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-05-22 11:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-05-22 11:30:00', 1, 0, 'Control cardiología', 30),

-- Dra. López (Viernes 14:00-18:00)
(1, 2, 2, '2026-05-22 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-05-22 14:30:00', 1, 0, 'Control piel', 30),
(3, 2, 2, '2026-05-22 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-05-22 15:30:00', 1, 0, 'Primera consulta', 30),
(1, 2, 2, '2026-05-22 16:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-05-22 16:30:00', 1, 0, 'Seguimiento', 30),
(3, 2, 2, '2026-05-22 17:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-05-22 17:30:00', 1, 0, 'Control', 30);

-- Semana 2: Lunes 25/05/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Lunes 08:00-12:00)
(1, 1, 1, '2026-05-25 08:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-05-25 08:30:00', 1, 0, 'Control', 30),
(3, 1, 1, '2026-05-25 09:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-05-25 09:30:00', 1, 0, NULL, 30),
(1, 1, 1, '2026-05-25 10:00:00', 1, 0, 'Primera consulta', 30),
(2, 1, 1, '2026-05-25 10:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-05-25 11:00:00', 1, 0, 'Seguimiento', 30),
(4, 1, 1, '2026-05-25 11:30:00', 1, 0, NULL, 30),

-- Dra. López (Lunes 14:00-18:00)
(1, 2, 2, '2026-05-25 14:00:00', 1, 0, 'Control', 30),
(2, 2, 2, '2026-05-25 14:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-05-25 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-05-25 15:30:00', 1, 0, 'Primera vez', 30),
(1, 2, 2, '2026-05-25 16:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-05-25 16:30:00', 1, 0, 'Seguimiento', 30),
(3, 2, 2, '2026-05-25 17:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-05-25 17:30:00', 1, 0, 'Control piel', 30);

-- Semana 2: Martes 26/05/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López (Martes 14:00-18:00)
(1, 2, 2, '2026-05-26 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-05-26 14:30:00', 1, 0, 'Control', 30),
(3, 2, 2, '2026-05-26 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-05-26 15:30:00', 1, 0, NULL, 30),
(1, 2, 2, '2026-05-26 16:00:00', 1, 0, 'Primera consulta', 30),
(2, 2, 2, '2026-05-26 16:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-05-26 17:00:00', 1, 0, 'Seguimiento', 30),
(4, 2, 2, '2026-05-26 17:30:00', 1, 0, NULL, 30),

-- Dr. Gómez (Martes 09:00-13:00)
(1, 3, 3, '2026-05-26 09:00:00', 1, 0, 'Control', 45),
(2, 3, 3, '2026-05-26 09:45:00', 1, 0, NULL, 45),
(3, 3, 3, '2026-05-26 10:30:00', 1, 0, NULL, 45),
(4, 3, 3, '2026-05-26 11:15:00', 1, 0, 'Control crecimiento', 45),
(1, 3, 3, '2026-05-26 12:00:00', 1, 0, NULL, 45);

-- Semana 2: Miércoles 27/05/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Miércoles 08:00-12:00)
(1, 1, 1, '2026-05-27 08:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-05-27 08:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-05-27 09:00:00', 1, 0, 'Control cardiología', 30),
(4, 1, 1, '2026-05-27 09:30:00', 1, 0, NULL, 30),
(1, 1, 1, '2026-05-27 10:00:00', 1, 0, 'Primera vez', 30),
(2, 1, 1, '2026-05-27 10:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-05-27 11:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-05-27 11:30:00', 1, 0, 'Seguimiento', 30),

-- Dra. López (Miércoles 14:00-18:00)
(1, 2, 2, '2026-05-27 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-05-27 14:30:00', 1, 0, 'Control piel', 30),
(3, 2, 2, '2026-05-27 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-05-27 15:30:00', 1, 0, NULL, 30),
(1, 2, 2, '2026-05-27 16:00:00', 1, 0, 'Primera consulta', 30),
(2, 2, 2, '2026-05-27 16:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-05-27 17:00:00', 1, 0, 'Seguimiento', 30),
(4, 2, 2, '2026-05-27 17:30:00', 1, 0, NULL, 30);

-- Semana 2: Jueves 28/05/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López (Jueves 14:00-18:00)
(1, 2, 2, '2026-05-28 14:00:00', 1, 0, 'Control', 30),
(2, 2, 2, '2026-05-28 14:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-05-28 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-05-28 15:30:00', 1, 0, 'Primera vez', 30),
(1, 2, 2, '2026-05-28 16:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-05-28 16:30:00', 1, 0, 'Seguimiento', 30),
(3, 2, 2, '2026-05-28 17:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-05-28 17:30:00', 1, 0, 'Control piel', 30),

-- Dr. Gómez (Jueves 09:00-13:00)
(1, 3, 3, '2026-05-28 09:00:00', 1, 0, NULL, 45),
(2, 3, 3, '2026-05-28 09:45:00', 1, 0, 'Vacunación', 45),
(3, 3, 3, '2026-05-28 10:30:00', 1, 0, NULL, 45),
(4, 3, 3, '2026-05-28 11:15:00', 1, 0, NULL, 45),
(1, 3, 3, '2026-05-28 12:00:00', 1, 0, 'Control', 45);

-- Semana 2: Viernes 29/05/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Viernes 08:00-12:00)
(1, 1, 1, '2026-05-29 08:00:00', 1, 0, 'Control', 30),
(2, 1, 1, '2026-05-29 08:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-05-29 09:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-05-29 09:30:00', 1, 0, 'Primera consulta', 30),
(1, 1, 1, '2026-05-29 10:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-05-29 10:30:00', 1, 0, 'Seguimiento', 30),
(3, 1, 1, '2026-05-29 11:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-05-29 11:30:00', 1, 0, NULL, 30),

-- Dra. López (Viernes 14:00-18:00)
(1, 2, 2, '2026-05-29 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-05-29 14:30:00', 1, 0, 'Control', 30),
(3, 2, 2, '2026-05-29 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-05-29 15:30:00', 1, 0, NULL, 30),
(1, 2, 2, '2026-05-29 16:00:00', 1, 0, 'Primera vez', 30),
(2, 2, 2, '2026-05-29 16:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-05-29 17:00:00', 1, 0, 'Seguimiento', 30),
(4, 2, 2, '2026-05-29 17:30:00', 1, 0, NULL, 30);

-- Semana 3: Lunes 01/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Lunes 08:00-12:00)
(1, 1, 1, '2026-06-01 08:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-06-01 08:30:00', 1, 0, 'Control cardiología', 30),
(3, 1, 1, '2026-06-01 09:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-06-01 09:30:00', 1, 0, NULL, 30),
(1, 1, 1, '2026-06-01 10:00:00', 1, 0, 'Primera consulta', 30),
(2, 1, 1, '2026-06-01 10:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-06-01 11:00:00', 1, 0, 'Seguimiento', 30),
(4, 1, 1, '2026-06-01 11:30:00', 1, 0, NULL, 30),

-- Dra. López (Lunes 14:00-18:00)
(1, 2, 2, '2026-06-01 14:00:00', 1, 0, 'Control piel', 30),
(2, 2, 2, '2026-06-01 14:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-01 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-01 15:30:00', 1, 0, 'Primera vez', 30),
(1, 2, 2, '2026-06-01 16:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-01 16:30:00', 1, 0, 'Seguimiento', 30),
(3, 2, 2, '2026-06-01 17:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-01 17:30:00', 1, 0, 'Control', 30);

-- Semana 3: Martes 02/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López (Martes 14:00-18:00)
(1, 2, 2, '2026-06-02 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-02 14:30:00', 1, 0, 'Control', 30),
(3, 2, 2, '2026-06-02 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-02 15:30:00', 1, 0, NULL, 30),
(1, 2, 2, '2026-06-02 16:00:00', 1, 0, 'Primera consulta', 30),
(2, 2, 2, '2026-06-02 16:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-02 17:00:00', 1, 0, 'Seguimiento', 30),
(4, 2, 2, '2026-06-02 17:30:00', 1, 0, NULL, 30),

-- Dr. Gómez (Martes 09:00-13:00)
(1, 3, 3, '2026-06-02 09:00:00', 1, 0, NULL, 45),
(2, 3, 3, '2026-06-02 09:45:00', 1, 0, 'Control', 45),
(3, 3, 3, '2026-06-02 10:30:00', 1, 0, NULL, 45),
(4, 3, 3, '2026-06-02 11:15:00', 1, 0, 'Vacunación', 45),
(1, 3, 3, '2026-06-02 12:00:00', 1, 0, NULL, 45);

-- Semana 3: Miércoles 03/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Miércoles 08:00-12:00)
(1, 1, 1, '2026-06-03 08:00:00', 1, 0, 'Control', 30),
(2, 1, 1, '2026-06-03 08:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-06-03 09:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-06-03 09:30:00', 1, 0, 'Primera vez', 30),
(1, 1, 1, '2026-06-03 10:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-06-03 10:30:00', 1, 0, 'Seguimiento', 30),
(3, 1, 1, '2026-06-03 11:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-06-03 11:30:00', 1, 0, NULL, 30),

-- Dra. López (Miércoles 14:00-18:00)
(1, 2, 2, '2026-06-03 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-03 14:30:00', 1, 0, 'Control piel', 30),
(3, 2, 2, '2026-06-03 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-03 15:30:00', 1, 0, NULL, 30),
(1, 2, 2, '2026-06-03 16:00:00', 1, 0, 'Primera consulta', 30),
(2, 2, 2, '2026-06-03 16:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-03 17:00:00', 1, 0, 'Seguimiento', 30),
(4, 2, 2, '2026-06-03 17:30:00', 1, 0, NULL, 30);

-- Semana 3: Jueves 04/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López (Jueves 14:00-18:00)
(1, 2, 2, '2026-06-04 14:00:00', 1, 0, 'Control', 30),
(2, 2, 2, '2026-06-04 14:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-04 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-04 15:30:00', 1, 0, 'Primera vez', 30),
(1, 2, 2, '2026-06-04 16:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-04 16:30:00', 1, 0, 'Seguimiento', 30),
(3, 2, 2, '2026-06-04 17:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-04 17:30:00', 1, 0, 'Control piel', 30),

-- Dr. Gómez (Jueves 09:00-13:00)
(1, 3, 3, '2026-06-04 09:00:00', 1, 0, NULL, 45),
(2, 3, 3, '2026-06-04 09:45:00', 1, 0, 'Control crecimiento', 45),
(3, 3, 3, '2026-06-04 10:30:00', 1, 0, NULL, 45),
(4, 3, 3, '2026-06-04 11:15:00', 1, 0, NULL, 45),
(1, 3, 3, '2026-06-04 12:00:00', 1, 0, 'Control', 45);

-- Semana 3: Viernes 05/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Viernes 08:00-12:00)
(1, 1, 1, '2026-06-05 08:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-06-05 08:30:00', 1, 0, 'Control cardiología', 30),
(3, 1, 1, '2026-06-05 09:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-06-05 09:30:00', 1, 0, NULL, 30),
(1, 1, 1, '2026-06-05 10:00:00', 1, 0, 'Primera consulta', 30),
(2, 1, 1, '2026-06-05 10:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-06-05 11:00:00', 1, 0, 'Seguimiento', 30),
(4, 1, 1, '2026-06-05 11:30:00', 1, 0, NULL, 30),

-- Dra. López (Viernes 14:00-18:00)
(1, 2, 2, '2026-06-05 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-05 14:30:00', 1, 0, 'Control', 30),
(3, 2, 2, '2026-06-05 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-05 15:30:00', 1, 0, NULL, 30),
(1, 2, 2, '2026-06-05 16:00:00', 1, 0, 'Primera vez', 30),
(2, 2, 2, '2026-06-05 16:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-05 17:00:00', 1, 0, 'Seguimiento', 30),
(4, 2, 2, '2026-06-05 17:30:00', 1, 0, NULL, 30);

-- Sobreturnos de urgencia (fuera de agenda)
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
(1, 1, 1, '2026-05-18 12:30:00', 1, 1, 'Sobreturno - Urgencia cardiología', 30),
(2, 2, 2, '2026-05-19 18:30:00', 1, 1, 'Sobreturno - Fuera de horario', 30),
(3, 3, 3, '2026-05-21 13:30:00', 1, 1, 'Sobreturno - Pediatría urgencia', 45),
(4, 1, 1, '2026-05-22 12:15:00', 1, 1, 'Sobreturno - Urgencia', 30),
(1, 2, 2, '2026-06-01 18:30:00', 1, 1, 'Sobreturno - Dermatology urgencia', 30),
(2, 3, 3, '2026-06-02 13:15:00', 1, 1, 'Sobreturno - Pediatría', 45);
