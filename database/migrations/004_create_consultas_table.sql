-- Create consultas table
CREATE TABLE consultas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    turno_id INT NOT NULL UNIQUE,
    paciente_id INT NOT NULL,
    profesional_id INT NOT NULL,
    diagnostico TEXT NULL,
    notas TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (turno_id) REFERENCES turnos(id) ON DELETE CASCADE,
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
    FOREIGN KEY (profesional_id) REFERENCES profesionales(id),
    
    INDEX idx_paciente_id (paciente_id),
    INDEX idx_profesional_id (profesional_id),
    INDEX idx_turno_id (turno_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT 'Consultas médicas realizadas por profesionales';