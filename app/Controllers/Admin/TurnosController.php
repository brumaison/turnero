<?php
namespace App\Controllers\Admin;

use App\Core\View;
use App\Core\Database;

class TurnosController {
    
    public function index() {
        $db = Database::getInstance();
        
        // Obtener turnos de hoy
        $stmt = $db->prepare("
            SELECT t.*, p.nombre, p.apellido, p.dni, pr.nombre as profesional
            FROM turnos t
            JOIN pacientes p ON t.paciente_id = p.id
            JOIN profesionales pr ON t.profesional_id = pr.id
            WHERE DATE(t.fecha_hora) = CURDATE()
            ORDER BY t.fecha_hora ASC
        ");
        $stmt->execute();
        $turnos = $stmt->fetchAll();
        
        View::render('admin/turnos/index', [
            'turnos' => $turnos,
            'pageTitle' => 'Gestión de Turnos',
            'activePage' => 'turnos'
        ]);
    }

    public function buscarPaciente() {
        header('Content-Type: application/json');
        // Después implementamos
        echo json_encode([]);
    }

    public function crearYReservar() {
        header('Content-Type: application/json');
        // Después implementamos
        echo json_encode(['success' => true]);
    }
}