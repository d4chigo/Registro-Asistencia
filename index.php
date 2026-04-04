<?php
// index.php - Enrutador principal
session_start();

$view = isset($_GET['view']) ? $_GET['view'] : 'attendance';

switch ($view) {
    case 'attendance':
        include 'views/attendance/register.php';
        break;
    
    case 'login':
        // Por ahora redirige a una vista básica de login admin
        include 'views/auth/login.php';
        break;

    case 'admin':
        if (!isset($_SESSION['admin'])) {
            header('Location: index.php?view=login');
            exit();
        }
        include 'views/admin/dashboard.php';
        break;

    default:
        include 'views/attendance/register.php';
        break;
}
?>
