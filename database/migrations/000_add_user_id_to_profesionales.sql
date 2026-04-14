-- 🔹 Migración: Vincular profesionales con usuarios
-- Ejecutar en TODOS los servidores

-- 1. Agregar columna user_id en profesionales
ALTER TABLE profesionales 
ADD COLUMN user_id INT NULL AFTER id;

-- 2. Agregar índice y FK (opcional, mejorar performance)
ALTER TABLE profesionales 
ADD INDEX idx_profesionales_user_id (user_id);

-- 3. NOTA: Los user_id se completan manualmente o vía script PHP
-- UPDATE profesionales p
-- JOIN operadores o ON p.dni = o.dni  -- o el campo que vincule
-- SET p.user_id = o.id
-- WHERE p.user_id IS NULL;