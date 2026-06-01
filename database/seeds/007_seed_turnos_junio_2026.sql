-- Seed: Turnos Junio 2026 (30 días)
-- Genera turnos respetando agendas configuradas
-- Prof 1 (Dr. Pérez): Lun/Mie/Vie 08:00-12:00 cada 30min
-- Prof 2 (Dra. López): Lun-Vie 14:00-18:00 cada 30min
-- Prof 3 (Dr. Gómez): Mar/Jue 09:00-13:00 cada 45min

-- Semana: Lunes 01/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Lunes 08:00-12:00)
(1, 1, 1, '2026-06-01 08:00:00', 1, 0, 'Control cardiología', 30),
(2, 1, 1, '2026-06-01 08:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-06-01 09:00:00', 1, 0, 'Primera vez', 30),
(4, 1, 1, '2026-06-01 09:30:00', 1, 0, NULL, 30),
(1, 1, 1, '2026-06-01 10:00:00', 1, 0, 'Seguimiento', 30),
(2, 1, 1, '2026-06-01 10:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-06-01 11:00:00', 1, 0, 'Control', 30),
(4, 1, 1, '2026-06-01 11:30:00', 1, 0, NULL, 30),
-- Dra. López (Lunes 14:00-18:00)
(1, 2, 2, '2026-06-01 14:00:00', 1, 0, 'Dermatología', 30),
(2, 2, 2, '2026-06-01 14:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-01 15:00:00', 1, 0, 'Control piel', 30),
(4, 2, 2, '2026-06-01 15:30:00', 1, 0, NULL, 30),
(1, 2, 2, '2026-06-01 16:00:00', 1, 0, 'Primera consulta', 30),
(2, 2, 2, '2026-06-01 16:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-01 17:00:00', 1, 0, 'Seguimiento', 30),
(4, 2, 2, '2026-06-01 17:30:00', 1, 0, NULL, 30);

-- Semana: Martes 02/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López (Martes 14:00-18:00)
(1, 2, 2, '2026-06-02 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-02 14:30:00', 1, 0, 'Control', 30),
(3, 2, 2, '2026-06-02 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-02 15:30:00', 1, 0, 'Urgencia leve', 30),
(1, 2, 2, '2026-06-02 16:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-02 16:30:00', 1, 0, 'Primera vez', 30),
(3, 2, 2, '2026-06-02 17:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-02 17:30:00', 1, 0, 'Seguimiento', 30),
-- Dr. Gómez (Martes 09:00-13:00)
(1, 3, 3, '2026-06-02 09:00:00', 1, 0, 'Pediatría - Control', 45),
(2, 3, 3, '2026-06-02 09:45:00', 1, 0, NULL, 45),
(3, 3, 3, '2026-06-02 10:30:00', 1, 0, 'Vacunación', 45),
(4, 3, 3, '2026-06-02 11:15:00', 1, 0, NULL, 45),
(1, 3, 3, '2026-06-02 12:00:00', 1, 0, 'Control crecimiento', 45);

-- Semana: Miércoles 03/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Miércoles 08:00-12:00)
(1, 1, 1, '2026-06-03 08:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-06-03 08:30:00', 1, 0, 'Control', 30),
(3, 1, 1, '2026-06-03 09:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-06-03 09:30:00', 1, 0, 'Primera consulta', 30),
(1, 1, 1, '2026-06-03 10:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-06-03 10:30:00', 1, 0, 'Seguimiento', 30),
(3, 1, 1, '2026-06-03 11:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-06-03 11:30:00', 1, 0, 'Control cardiología', 30),
-- Dra. López (Miércoles 14:00-18:00)
(1, 2, 2, '2026-06-03 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-03 14:30:00', 1, 0, 'Control piel', 30),
(3, 2, 2, '2026-06-03 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-03 15:30:00', 1, 0, 'Primera vez', 30),
(1, 2, 2, '2026-06-03 16:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-03 16:30:00', 1, 0, 'Seguimiento', 30),
(3, 2, 2, '2026-06-03 17:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-03 17:30:00', 1, 0, 'Control', 30);

-- Semana: Jueves 04/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López (Jueves 14:00-18:00)
(1, 2, 2, '2026-06-04 14:00:00', 1, 0, 'Dermatología', 30),
(2, 2, 2, '2026-06-04 14:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-04 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-04 15:30:00', 1, 0, 'Control', 30),
(1, 2, 2, '2026-06-04 16:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-04 16:30:00', 1, 0, 'Primera consulta', 30),
(3, 2, 2, '2026-06-04 17:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-04 17:30:00', 1, 0, 'Seguimiento', 30),
-- Dr. Gómez (Jueves 09:00-13:00)
(1, 3, 3, '2026-06-04 09:00:00', 1, 0, NULL, 45),
(2, 3, 3, '2026-06-04 09:45:00', 1, 0, 'Control', 45),
(3, 3, 3, '2026-06-04 10:30:00', 1, 0, NULL, 45),
(4, 3, 3, '2026-06-04 11:15:00', 1, 0, 'Vacunación', 45),
(1, 3, 3, '2026-06-04 12:00:00', 1, 0, NULL, 45);

-- Semana: Viernes 05/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Viernes 08:00-12:00)
(1, 1, 1, '2026-06-05 08:00:00', 1, 0, 'Control', 30),
(2, 1, 1, '2026-06-05 08:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-06-05 09:00:00', 1, 0, 'Primera vez', 30),
(4, 1, 1, '2026-06-05 09:30:00', 1, 0, NULL, 30),
(1, 1, 1, '2026-06-05 10:00:00', 1, 0, 'Seguimiento', 30),
(2, 1, 1, '2026-06-05 10:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-06-05 11:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-06-05 11:30:00', 1, 0, 'Control cardiología', 30),
-- Dra. López (Viernes 14:00-18:00)
(1, 2, 2, '2026-06-05 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-05 14:30:00', 1, 0, 'Control piel', 30),
(3, 2, 2, '2026-06-05 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-05 15:30:00', 1, 0, 'Primera consulta', 30),
(1, 2, 2, '2026-06-05 16:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-05 16:30:00', 1, 0, 'Seguimiento', 30),
(3, 2, 2, '2026-06-05 17:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-05 17:30:00', 1, 0, 'Control', 30);

-- Semana: Lunes 08/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Lunes 08:00-12:00)
(1, 1, 1, '2026-06-08 08:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-06-08 08:30:00', 1, 0, 'Control cardiología', 30),
(3, 1, 1, '2026-06-08 09:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-06-08 09:30:00', 1, 0, NULL, 30),
(1, 1, 1, '2026-06-08 10:00:00', 1, 0, 'Primera consulta', 30),
(2, 1, 1, '2026-06-08 10:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-06-08 11:00:00', 1, 0, 'Seguimiento', 30),
(4, 1, 1, '2026-06-08 11:30:00', 1, 0, NULL, 30),
-- Dra. López (Lunes 14:00-18:00)
(1, 2, 2, '2026-06-08 14:00:00', 1, 0, 'Control', 30),
(2, 2, 2, '2026-06-08 14:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-08 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-08 15:30:00', 1, 0, 'Primera vez', 30),
(1, 2, 2, '2026-06-08 16:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-08 16:30:00', 1, 0, 'Seguimiento', 30),
(3, 2, 2, '2026-06-08 17:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-08 17:30:00', 1, 0, 'Control piel', 30);

-- Semana: Martes 09/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López (Martes 14:00-18:00)
(1, 2, 2, '2026-06-09 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-09 14:30:00', 1, 0, 'Control', 30),
(3, 2, 2, '2026-06-09 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-09 15:30:00', 1, 0, NULL, 30),
(1, 2, 2, '2026-06-09 16:00:00', 1, 0, 'Primera consulta', 30),
(2, 2, 2, '2026-06-09 16:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-09 17:00:00', 1, 0, 'Seguimiento', 30),
(4, 2, 2, '2026-06-09 17:30:00', 1, 0, NULL, 30),
-- Dr. Gómez (Martes 09:00-13:00)
(1, 3, 3, '2026-06-09 09:00:00', 1, 0, 'Control', 45),
(2, 3, 3, '2026-06-09 09:45:00', 1, 0, NULL, 45),
(3, 3, 3, '2026-06-09 10:30:00', 1, 0, NULL, 45),
(4, 3, 3, '2026-06-09 11:15:00', 1, 0, 'Control crecimiento', 45),
(1, 3, 3, '2026-06-09 12:00:00', 1, 0, NULL, 45);

-- Semana: Miércoles 10/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Miércoles 08:00-12:00)
(1, 1, 1, '2026-06-10 08:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-06-10 08:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-06-10 09:00:00', 1, 0, 'Control cardiología', 30),
(4, 1, 1, '2026-06-10 09:30:00', 1, 0, NULL, 30),
(1, 1, 1, '2026-06-10 10:00:00', 1, 0, 'Primera vez', 30),
(2, 1, 1, '2026-06-10 10:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-06-10 11:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-06-10 11:30:00', 1, 0, 'Seguimiento', 30),
-- Dra. López (Miércoles 14:00-18:00)
(1, 2, 2, '2026-06-10 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-10 14:30:00', 1, 0, 'Control piel', 30),
(3, 2, 2, '2026-06-10 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-10 15:30:00', 1, 0, NULL, 30),
(1, 2, 2, '2026-06-10 16:00:00', 1, 0, 'Primera consulta', 30),
(2, 2, 2, '2026-06-10 16:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-10 17:00:00', 1, 0, 'Seguimiento', 30),
(4, 2, 2, '2026-06-10 17:30:00', 1, 0, NULL, 30);

-- Semana: Jueves 11/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López (Jueves 14:00-18:00)
(1, 2, 2, '2026-06-11 14:00:00', 1, 0, 'Control', 30),
(2, 2, 2, '2026-06-11 14:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-11 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-11 15:30:00', 1, 0, 'Primera vez', 30),
(1, 2, 2, '2026-06-11 16:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-11 16:30:00', 1, 0, 'Seguimiento', 30),
(3, 2, 2, '2026-06-11 17:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-11 17:30:00', 1, 0, 'Control piel', 30),
-- Dr. Gómez (Jueves 09:00-13:00)
(1, 3, 3, '2026-06-11 09:00:00', 1, 0, NULL, 45),
(2, 3, 3, '2026-06-11 09:45:00', 1, 0, 'Vacunación', 45),
(3, 3, 3, '2026-06-11 10:30:00', 1, 0, NULL, 45),
(4, 3, 3, '2026-06-11 11:15:00', 1, 0, NULL, 45),
(1, 3, 3, '2026-06-11 12:00:00', 1, 0, 'Control', 45);

-- Semana: Viernes 12/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Viernes 08:00-12:00)
(1, 1, 1, '2026-06-12 08:00:00', 1, 0, 'Control', 30),
(2, 1, 1, '2026-06-12 08:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-06-12 09:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-06-12 09:30:00', 1, 0, 'Primera consulta', 30),
(1, 1, 1, '2026-06-12 10:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-06-12 10:30:00', 1, 0, 'Seguimiento', 30),
(3, 1, 1, '2026-06-12 11:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-06-12 11:30:00', 1, 0, NULL, 30),
-- Dra. López (Viernes 14:00-18:00)
(1, 2, 2, '2026-06-12 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-12 14:30:00', 1, 0, 'Control', 30),
(3, 2, 2, '2026-06-12 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-12 15:30:00', 1, 0, NULL, 30),
(1, 2, 2, '2026-06-12 16:00:00', 1, 0, 'Primera vez', 30),
(2, 2, 2, '2026-06-12 16:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-12 17:00:00', 1, 0, 'Seguimiento', 30),
(4, 2, 2, '2026-06-12 17:30:00', 1, 0, NULL, 30);

-- Semana: Lunes 15/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Lunes 08:00-12:00)
(1, 1, 1, '2026-06-15 08:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-06-15 08:30:00', 1, 0, 'Control', 30),
(3, 1, 1, '2026-06-15 09:00:00', 1, 0, 'Primera vez', 30),
(4, 1, 1, '2026-06-15 09:30:00', 1, 0, NULL, 30),
(1, 1, 1, '2026-06-15 10:00:00', 1, 0, 'Seguimiento', 30),
(2, 1, 1, '2026-06-15 10:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-06-15 11:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-06-15 11:30:00', 1, 0, 'Control cardiología', 30),
-- Dra. López (Lunes 14:00-18:00)
(1, 2, 2, '2026-06-15 14:00:00', 1, 0, 'Dermatología', 30),
(2, 2, 2, '2026-06-15 14:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-15 15:00:00', 1, 0, 'Control piel', 30),
(4, 2, 2, '2026-06-15 15:30:00', 1, 0, NULL, 30),
(1, 2, 2, '2026-06-15 16:00:00', 1, 0, 'Primera consulta', 30),
(2, 2, 2, '2026-06-15 16:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-15 17:00:00', 1, 0, 'Seguimiento', 30),
(4, 2, 2, '2026-06-15 17:30:00', 1, 0, NULL, 30);

-- Semana: Martes 16/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López (Martes 14:00-18:00)
(1, 2, 2, '2026-06-16 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-16 14:30:00', 1, 0, 'Control', 30),
(3, 2, 2, '2026-06-16 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-16 15:30:00', 1, 0, 'Urgencia leve', 30),
(1, 2, 2, '2026-06-16 16:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-16 16:30:00', 1, 0, 'Primera vez', 30),
(3, 2, 2, '2026-06-16 17:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-16 17:30:00', 1, 0, 'Seguimiento', 30),
-- Dr. Gómez (Martes 09:00-13:00)
(1, 3, 3, '2026-06-16 09:00:00', 1, 0, 'Pediatría - Control', 45),
(2, 3, 3, '2026-06-16 09:45:00', 1, 0, NULL, 45),
(3, 3, 3, '2026-06-16 10:30:00', 1, 0, 'Vacunación', 45),
(4, 3, 3, '2026-06-16 11:15:00', 1, 0, NULL, 45),
(1, 3, 3, '2026-06-16 12:00:00', 1, 0, 'Control crecimiento', 45);

-- Semana: Miércoles 17/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Miércoles 08:00-12:00)
(1, 1, 1, '2026-06-17 08:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-06-17 08:30:00', 1, 0, 'Control cardiología', 30),
(3, 1, 1, '2026-06-17 09:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-06-17 09:30:00', 1, 0, 'Primera consulta', 30),
(1, 1, 1, '2026-06-17 10:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-06-17 10:30:00', 1, 0, 'Seguimiento', 30),
(3, 1, 1, '2026-06-17 11:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-06-17 11:30:00', 1, 0, 'Control', 30),
-- Dra. López (Miércoles 14:00-18:00)
(1, 2, 2, '2026-06-17 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-17 14:30:00', 1, 0, 'Control piel', 30),
(3, 2, 2, '2026-06-17 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-17 15:30:00', 1, 0, NULL, 30),
(1, 2, 2, '2026-06-17 16:00:00', 1, 0, 'Primera consulta', 30),
(2, 2, 2, '2026-06-17 16:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-17 17:00:00', 1, 0, 'Seguimiento', 30),
(4, 2, 2, '2026-06-17 17:30:00', 1, 0, NULL, 30);

-- Semana: Jueves 18/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López (Jueves 14:00-18:00)
(1, 2, 2, '2026-06-18 14:00:00', 1, 0, 'Control', 30),
(2, 2, 2, '2026-06-18 14:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-18 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-18 15:30:00', 1, 0, 'Primera vez', 30),
(1, 2, 2, '2026-06-18 16:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-18 16:30:00', 1, 0, 'Seguimiento', 30),
(3, 2, 2, '2026-06-18 17:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-18 17:30:00', 1, 0, 'Control piel', 30),
-- Dr. Gómez (Jueves 09:00-13:00)
(1, 3, 3, '2026-06-18 09:00:00', 1, 0, NULL, 45),
(2, 3, 3, '2026-06-18 09:45:00', 1, 0, 'Control', 45),
(3, 3, 3, '2026-06-18 10:30:00', 1, 0, NULL, 45),
(4, 3, 3, '2026-06-18 11:15:00', 1, 0, 'Vacunación', 45),
(1, 3, 3, '2026-06-18 12:00:00', 1, 0, NULL, 45);

-- Semana: Viernes 19/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Viernes 08:00-12:00)
(1, 1, 1, '2026-06-19 08:00:00', 1, 0, 'Control', 30),
(2, 1, 1, '2026-06-19 08:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-06-19 09:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-06-19 09:30:00', 1, 0, 'Primera vez', 30),
(1, 1, 1, '2026-06-19 10:00:00', 1, 0, 'Seguimiento', 30),
(2, 1, 1, '2026-06-19 10:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-06-19 11:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-06-19 11:30:00', 1, 0, 'Control cardiología', 30),
-- Dra. López (Viernes 14:00-18:00)
(1, 2, 2, '2026-06-19 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-19 14:30:00', 1, 0, 'Control', 30),
(3, 2, 2, '2026-06-19 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-19 15:30:00', 1, 0, NULL, 30),
(1, 2, 2, '2026-06-19 16:00:00', 1, 0, 'Primera vez', 30),
(2, 2, 2, '2026-06-19 16:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-19 17:00:00', 1, 0, 'Seguimiento', 30),
(4, 2, 2, '2026-06-19 17:30:00', 1, 0, NULL, 30);

-- Semana: Lunes 22/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Lunes 08:00-12:00)
(1, 1, 1, '2026-06-22 08:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-06-22 08:30:00', 1, 0, 'Control', 30),
(3, 1, 1, '2026-06-22 09:00:00', 1, 0, 'Primera vez', 30),
(4, 1, 1, '2026-06-22 09:30:00', 1, 0, NULL, 30),
(1, 1, 1, '2026-06-22 10:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-06-22 10:30:00', 1, 0, 'Seguimiento', 30),
(3, 1, 1, '2026-06-22 11:00:00', 1, 0, 'Control cardiología', 30),
(4, 1, 1, '2026-06-22 11:30:00', 1, 0, NULL, 30),
-- Dra. López (Lunes 14:00-18:00)
(1, 2, 2, '2026-06-22 14:00:00', 1, 0, 'Control piel', 30),
(2, 2, 2, '2026-06-22 14:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-22 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-22 15:30:00', 1, 0, 'Primera vez', 30),
(1, 2, 2, '2026-06-22 16:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-22 16:30:00', 1, 0, 'Seguimiento', 30),
(3, 2, 2, '2026-06-22 17:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-22 17:30:00', 1, 0, 'Control', 30);

-- Semana: Martes 23/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López (Martes 14:00-18:00)
(1, 2, 2, '2026-06-23 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-23 14:30:00', 1, 0, 'Control', 30),
(3, 2, 2, '2026-06-23 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-23 15:30:00', 1, 0, NULL, 30),
(1, 2, 2, '2026-06-23 16:00:00', 1, 0, 'Primera consulta', 30),
(2, 2, 2, '2026-06-23 16:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-23 17:00:00', 1, 0, 'Seguimiento', 30),
(4, 2, 2, '2026-06-23 17:30:00', 1, 0, NULL, 30),
-- Dr. Gómez (Martes 09:00-13:00)
(1, 3, 3, '2026-06-23 09:00:00', 1, 0, NULL, 45),
(2, 3, 3, '2026-06-23 09:45:00', 1, 0, 'Control', 45),
(3, 3, 3, '2026-06-23 10:30:00', 1, 0, NULL, 45),
(4, 3, 3, '2026-06-23 11:15:00', 1, 0, 'Vacunación', 45),
(1, 3, 3, '2026-06-23 12:00:00', 1, 0, NULL, 45);

-- Semana: Miércoles 24/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Miércoles 08:00-12:00)
(1, 1, 1, '2026-06-24 08:00:00', 1, 0, 'Control', 30),
(2, 1, 1, '2026-06-24 08:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-06-24 09:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-06-24 09:30:00', 1, 0, 'Primera vez', 30),
(1, 1, 1, '2026-06-24 10:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-06-24 10:30:00', 1, 0, 'Seguimiento', 30),
(3, 1, 1, '2026-06-24 11:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-06-24 11:30:00', 1, 0, NULL, 30),
-- Dra. López (Miércoles 14:00-18:00)
(1, 2, 2, '2026-06-24 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-24 14:30:00', 1, 0, 'Control piel', 30),
(3, 2, 2, '2026-06-24 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-24 15:30:00', 1, 0, NULL, 30),
(1, 2, 2, '2026-06-24 16:00:00', 1, 0, 'Primera consulta', 30),
(2, 2, 2, '2026-06-24 16:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-24 17:00:00', 1, 0, 'Seguimiento', 30),
(4, 2, 2, '2026-06-24 17:30:00', 1, 0, NULL, 30);

-- Semana: Jueves 25/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dra. López (Jueves 14:00-18:00)
(1, 2, 2, '2026-06-25 14:00:00', 1, 0, 'Control', 30),
(2, 2, 2, '2026-06-25 14:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-25 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-25 15:30:00', 1, 0, 'Primera vez', 30),
(1, 2, 2, '2026-06-25 16:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-25 16:30:00', 1, 0, 'Seguimiento', 30),
(3, 2, 2, '2026-06-25 17:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-25 17:30:00', 1, 0, 'Control piel', 30),
-- Dr. Gómez (Jueves 09:00-13:00)
(1, 3, 3, '2026-06-25 09:00:00', 1, 0, NULL, 45),
(2, 3, 3, '2026-06-25 09:45:00', 1, 0, 'Control crecimiento', 45),
(3, 3, 3, '2026-06-25 10:30:00', 1, 0, NULL, 45),
(4, 3, 3, '2026-06-25 11:15:00', 1, 0, NULL, 45),
(1, 3, 3, '2026-06-25 12:00:00', 1, 0, 'Control', 45);

-- Semana: Viernes 26/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Viernes 08:00-12:00)
(1, 1, 1, '2026-06-26 08:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-06-26 08:30:00', 1, 0, 'Control cardiología', 30),
(3, 1, 1, '2026-06-26 09:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-06-26 09:30:00', 1, 0, NULL, 30),
(1, 1, 1, '2026-06-26 10:00:00', 1, 0, 'Primera consulta', 30),
(2, 1, 1, '2026-06-26 10:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-06-26 11:00:00', 1, 0, 'Seguimiento', 30),
(4, 1, 1, '2026-06-26 11:30:00', 1, 0, NULL, 30),
-- Dra. López (Viernes 14:00-18:00)
(1, 2, 2, '2026-06-26 14:00:00', 1, 0, NULL, 30),
(2, 2, 2, '2026-06-26 14:30:00', 1, 0, 'Control', 30),
(3, 2, 2, '2026-06-26 15:00:00', 1, 0, NULL, 30),
(4, 2, 2, '2026-06-26 15:30:00', 1, 0, NULL, 30),
(1, 2, 2, '2026-06-26 16:00:00', 1, 0, 'Primera vez', 30),
(2, 2, 2, '2026-06-26 16:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-26 17:00:00', 1, 0, 'Seguimiento', 30),
(4, 2, 2, '2026-06-26 17:30:00', 1, 0, NULL, 30);

-- Semana: Lunes 29/06/2026
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
-- Dr. Pérez (Lunes 08:00-12:00)
(1, 1, 1, '2026-06-29 08:00:00', 1, 0, NULL, 30),
(2, 1, 1, '2026-06-29 08:30:00', 1, 0, 'Control', 30),
(3, 1, 1, '2026-06-29 09:00:00', 1, 0, 'Primera vez', 30),
(4, 1, 1, '2026-06-29 09:30:00', 1, 0, NULL, 30),
(1, 1, 1, '2026-06-29 10:00:00', 1, 0, 'Seguimiento', 30),
(2, 1, 1, '2026-06-29 10:30:00', 1, 0, NULL, 30),
(3, 1, 1, '2026-06-29 11:00:00', 1, 0, NULL, 30),
(4, 1, 1, '2026-06-29 11:30:00', 1, 0, 'Control cardiología', 30),
-- Dra. López (Lunes 14:00-18:00)
(1, 2, 2, '2026-06-29 14:00:00', 1, 0, 'Dermatología', 30),
(2, 2, 2, '2026-06-29 14:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-29 15:00:00', 1, 0, 'Control piel', 30),
(4, 2, 2, '2026-06-29 15:30:00', 1, 0, NULL, 30),
(1, 2, 2, '2026-06-29 16:00:00', 1, 0, 'Primera consulta', 30),
(2, 2, 2, '2026-06-29 16:30:00', 1, 0, NULL, 30),
(3, 2, 2, '2026-06-29 17:00:00', 1, 0, 'Seguimiento', 30),
(4, 2, 2, '2026-06-29 17:30:00', 1, 0, NULL, 30);

-- Sobreturnos fuera de agenda
INSERT INTO turnos (paciente_id, profesional_id, consultorio_id, fecha_hora, estado_id, sobreturno, observaciones, duracion_minutos) VALUES
(1, 1, 1, '2026-06-01 12:30:00', 1, 1, 'Sobreturno - Urgencia cardiología', 30),
(2, 2, 2, '2026-06-02 18:30:00', 1, 1, 'Sobreturno - Fuera de horario', 30),
(3, 3, 3, '2026-06-04 13:30:00', 1, 1, 'Sobreturno - Pediatría urgencia', 45),
(1, 2, 2, '2026-06-15 18:30:00', 1, 1, 'Sobreturno - Dermatology urgencia', 30),
(2, 3, 3, '2026-06-16 13:15:00', 1, 1, 'Sobreturno - Pediatría', 45),
(4, 1, 1, '2026-06-22 12:15:00', 1, 1, 'Sobreturno - Urgencia', 30);
