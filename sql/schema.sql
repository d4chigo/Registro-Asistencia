-- Esquema de la Base de Datos para el Control de Asistencia
CREATE DATABASE IF NOT EXISTS attendance_db;
USE attendance_db;

-- Roles (1: Admin, 2: Empleado)
CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

INSERT INTO roles (id, nombre) VALUES (1, 'administrador'), (2, 'empleado');

-- Usuarios (dni para login, usuario opcional para admin)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dni VARCHAR(20) UNIQUE NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol_id INT NOT NULL,
    FOREIGN KEY (rol_id) REFERENCES roles(id)
);

-- Registros de asistencia (entrada/salida por día)
CREATE TABLE IF NOT EXISTS asistencia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    fecha DATE NOT NULL,
    entrada DATETIME,
    salida DATETIME,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Admin por defecto (DNI: 12345678, Password: admin)
INSERT INTO usuarios (dni, nombre, apellido, usuario, password, rol_id) 
VALUES ('12345678', 'Admin', 'General', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);
