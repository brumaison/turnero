-- Crear operador para cada profesional existente
INSERT INTO operadores (email, password_hash, role_id)
SELECT 
    CONCAT('medico', p.id, '@hospital.com'),  -- Email temporal
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',  -- Password: password
    3  -- role_id = médico
FROM profesionales p
LEFT JOIN operadores o ON p.user_id = o.id
WHERE o.id IS NULL;

-- Vincular user_id
UPDATE profesionales p
JOIN operadores o ON CONCAT('medico', p.id, '@hospital.com') = o.email
SET p.user_id = o.id
WHERE p.user_id IS NULL;