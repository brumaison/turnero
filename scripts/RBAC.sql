-- Roles (reemplaza el ENUM)
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(50) NOT NULL UNIQUE,  -- 'admin', 'recepcion', etc.
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Permisos disponibles
CREATE TABLE permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(100) NOT NULL UNIQUE,  -- 'turnos.create', 'pacientes.edit', etc.
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Relación roles ↔ permisos
CREATE TABLE role_permissions (
    role_id INT NOT NULL,
    permission_id INT NOT NULL,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
);

-- 1. Eliminar el ENUM
ALTER TABLE operadores DROP COLUMN rol;

-- 2. Agregar FK a roles
ALTER TABLE operadores 
  ADD COLUMN role_id INT AFTER password_hash,
  ADD FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE SET NULL;
  
-- Roles base
INSERT INTO roles (slug, nombre, descripcion) VALUES
('admin', 'Administrador', 'Acceso total al sistema'),
('recepcion', 'Recepcionista', 'Gestión básica de turnos y pacientes');

-- Permisos base
INSERT INTO permissions (slug, nombre) VALUES
('turnos.view', 'Ver turnos'),
('turnos.create', 'Crear turnos'),
('turnos.edit', 'Editar turnos'),
('turnos.delete', 'Eliminar turnos'),
('pacientes.view', 'Ver pacientes'),
('pacientes.create', 'Crear pacientes'),
('pacientes.edit', 'Editar pacientes'),
('operadores.manage', 'Gestionar operadores');  -- Solo admin

-- Asignar permisos a roles
INSERT INTO role_permissions (role_id, permission_id) VALUES
-- Recepcionista: turnos y pacientes (CRUD básico)
(2, 1), (2, 2), (2, 3), (2, 5), (2, 6), (2, 7),
-- Admin: todo + gestión de operadores
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6), (1, 7), (1, 8);

-- Actualizar el admin existente
UPDATE operadores SET role_id = 1 WHERE email = 'admin@demo.com';