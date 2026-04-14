-- 🔹 Seed: Rol Médico (nuevo)
-- Ejecutar en TODOS los servidores

INSERT IGNORE INTO roles (id, slug, nombre, descripcion, created_at) 
VALUES 
    (3, 'medico', 'Médico', 'Solo ve sus propios turnos y agenda', NOW());