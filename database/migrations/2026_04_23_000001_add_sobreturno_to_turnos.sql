-- --------------------------------------------------------
-- Migración: Agregar columna sobreturno a turnos
-- Fecha: 2026-04-23
-- --------------------------------------------------------

-- Up: Agregar columna e índice
ALTER TABLE turnos 
ADD COLUMN sobreturno TINYINT(1) NOT NULL DEFAULT 0 
AFTER estado_id;

CREATE INDEX idx_turnos_sobreturno ON turnos(sobreturno);

-- Down: Revertir (comentar para ejecutar, descomentar para rollback)
-- DROP INDEX idx_turnos_sobreturno ON turnos;
-- ALTER TABLE turnos DROP COLUMN sobreturno;