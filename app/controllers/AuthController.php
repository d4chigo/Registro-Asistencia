<?php
// app/controllers/AuthController.php
session_start();
require_once __DIR__ . '/../config/database.php';

if (isset($_GET['action']) && $_GET['action'] == 'login') {
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    $db = new Database();
    $conn = $db->getConnection();

    $query = "SELECT * FROM usuarios WHERE usuario = :usuario AND rol_id = 1 LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin'] = $admin['id'];
        $_SESSION['admin_nombre'] = $admin['nombre'];
        header("Location: ../../index.php?view=admin");
    } else {
        header("Location: ../../index.php?view=login&error=1");
    }
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: ../../index.php?view=login");
    exit();
}
?>
