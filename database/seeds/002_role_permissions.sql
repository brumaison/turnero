-- 🔹 Seed: Permisos rol Médico (nuevo)
-- Ejecutar en TODOS los servidores

-- Médico: Solo ver turnos y pacientes (lectura)
INSERT IGNORE INTO role_permissions (role_id, permission_id) VALUES
    (3, 1),  -- turnos.view
    (3, 5);  -- pacientes.view