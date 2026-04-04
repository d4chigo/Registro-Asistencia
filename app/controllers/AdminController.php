<?php
// app/controllers/AdminController.php
session_start();
require_once __DIR__ . '/../models/User.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../../index.php?view=login");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'add_employee') {
    $dni = $_POST['dni'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';

    if (empty($dni) || empty($nombre) || empty($apellido)) {
        header("Location: ../../index.php?view=admin&error=campos_vacios");
        exit();
    }

    $userModel = new User();
    
    // Verificar si ya existe
    if ($userModel->getByDni($dni)) {
        header("Location: ../../index.php?view=admin&error=dni_duplicado");
        exit();
    }

    if ($userModel->createEmployee($dni, $nombre, $apellido)) {
        header("Location: ../../index.php?view=admin&status=success&msg=Empleado registrado con éxito");
    } else {
        header("Location: ../../index.php?view=admin&status=error&msg=Error al registrar");
    }
    exit();
}
?>
