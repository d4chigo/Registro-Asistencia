<?php
// app/controllers/AttendanceController.php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/database.php';

if (isset($_GET['action']) && $_GET['action'] == 'register') {
    $dni = $_POST['dni'] ?? '';
    
    if (empty($dni)) {
        header("Location: ../../index.php?status=error&msg=DNI requerido");
        exit();
    }

    $userModel = new User();
    $user = $userModel->getByDni($dni);

    if (!$user) {
        header("Location: ../../index.php?status=error&msg=Empleado no encontrado");
        exit();
    }

    $db = new Database();
    $conn = $db->getConnection();
    $fecha_actual = date('Y-m-d');
    $hora_actual = date('Y-m-d H:i:s');

    // Verificar si ya marcó entrada hoy
    $query = "SELECT * FROM asistencia WHERE usuario_id = :id AND fecha = :fecha";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $user['id']);
    $stmt->bindParam(':fecha', $fecha_actual);
    $stmt->execute();
    $asistencia = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$asistencia) {
        // Registrar entrada
        $query = "INSERT INTO asistencia (usuario_id, fecha, entrada) VALUES (:id, :fecha, :entrada)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $user['id']);
        $stmt->bindParam(':fecha', $fecha_actual);
        $stmt->bindParam(':entrada', $hora_actual);
        $stmt->execute();
        $msg = "Entrada registrada: " . $user['nombre'] . " " . $user['apellido'];
    } else if (is_null($asistencia['salida'])) {
        // Registrar salida
        $query = "UPDATE asistencia SET salida = :salida WHERE id = :asistencia_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':salida', $hora_actual);
        $stmt->bindParam(':asistencia_id', $asistencia['id']);
        $stmt->execute();
        $msg = "Salida registrada: " . $user['nombre'] . " " . $user['apellido'];
    } else {
        $msg = "Ya has registrado entrada y salida por hoy.";
        header("Location: ../../index.php?status=warning&msg=" . urlencode($msg));
        exit();
    }

    header("Location: ../../index.php?status=success&msg=" . urlencode($msg));
    exit();
}
?>
