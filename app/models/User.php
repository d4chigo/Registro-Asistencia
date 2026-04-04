<?php
// app/models/User.php
require_once __DIR__ . '/../config/database.php';

class User {
    private $conn;
    private $table_name = "usuarios";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getByDni($dni) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE dni = :dni LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':dni', $dni);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createEmployee($dni, $nombre, $apellido) {
        $query = "INSERT INTO " . $this->table_name . " (dni, nombre, apellido, password, rol_id) 
                  VALUES (:dni, :nombre, :apellido, :password, 2)";
        $stmt = $this->conn->prepare($query);
        
        // El empleado por defecto no necesita password para marcar asistencia, 
        // pero la DB la requiere. Usamos una genérica o el mismo DNI.
        $password = password_hash($dni, PASSWORD_BCRYPT);
        
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':password', $password);
        
        return $stmt->execute();
    }
}
?>
