<?php
// app/models/Attendance.php
require_once __DIR__ . '/../config/database.php';

class Attendance {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllRecords() {
        $query = "SELECT a.*, u.nombre, u.apellido, u.dni 
                  FROM asistencia a 
                  JOIN usuarios u ON a.usuario_id = u.id 
                  ORDER BY a.fecha DESC, a.entrada DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTodayRecords() {
        $query = "SELECT a.*, u.nombre, u.apellido 
                  FROM asistencia a 
                  JOIN usuarios u ON a.usuario_id = u.id 
                  WHERE a.fecha = CURDATE() 
                  ORDER BY a.entrada DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
