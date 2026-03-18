# 🏥 ByV Turnos

Sistema interno de gestión de turnos para Círculo Médico. Uso exclusivo para operadores y administradores de consultorios.

## Características

- Gestión de turnos por día, profesional y consultorio
- Registro de pacientes y profesionales
- Operadores con roles y permisos
- Interfaz limpia con Tabler.io

## Requisitos

- PHP 8+
- MySQL / MariaDB
- Composer
- Servidor web (Apache/Nginx)

## Seguridad

- Protección CSRF en formularios
- Passwords con bcrypt
- Consultas preparadas (PDO)
- Sanitización de outputs

## Estructura

/app
  /Controllers  → Lógica de las pantallas
  /Core         → Router, View, Database
  /Views        → Plantillas Tabler.io
/config         → Configuración de la app
/public         → Document root

## Desarrollado por

ByV Desarrollo Web | byv.desarrolloweb@gmail.com

- Bruno Maisón (Backend Developer - Frontend Developer)
- Verónica Fraccalvieri (Diseñadora Multimedia - Frontend Developer )