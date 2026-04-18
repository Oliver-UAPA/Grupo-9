-- ============================================================
-- grupo_9.sql
-- Base de datos del Sistema de Inventario – Grupo 9
-- ============================================================
-- Importar en phpMyAdmin:
--   1. Crear BD llamada "grupo_9"
--   2. Ir a Importar → subir este archivo → Ejecutar
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS `grupo_9`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `grupo_9`;

-- ============================================================
-- Tabla: productos
-- Almacena los productos del inventario
-- ============================================================
CREATE TABLE IF NOT EXISTS `productos` (
  `id`       INT            NOT NULL AUTO_INCREMENT,
  `nombre`   VARCHAR(100)   DEFAULT NULL,
  `tipo`     VARCHAR(50)    DEFAULT NULL,
  `cantidad` INT            DEFAULT NULL,
  `costo`    DECIMAL(10,2)  DEFAULT NULL,
  `stock`    VARCHAR(10)    DEFAULT NULL,
  `usuario`  VARCHAR(50)    DEFAULT NULL,
  `fecha`    TIMESTAMP      NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos de ejemplo para la tabla productos
INSERT INTO `productos` (`nombre`, `tipo`, `cantidad`, `costo`, `stock`, `usuario`) VALUES
('Laptop HP',            'Electrónica',     5,  35000.00, 'si', 'Lmarte'),
('Mouse Logitech',       'Accesorio',      20,    800.00, 'si', 'Lmarte'),
('Teclado Mecánico',     'Accesorio',      10,   2500.00, 'no', 'Lmarte'),
('Monitor Samsung',      'Electrónica',     3,  12000.00, 'si', 'Lmarte'),
('Disco SSD 1TB',        'Almacenamiento',  7,   5000.00, 'si', 'Lmarte'),
('Laptop Dell',          'Electrónica',     4,  42000.00, 'si', 'Lmarte'),
('Memoria RAM 16GB',     'Hardware',       15,   3000.00, 'si', 'Lmarte'),
('Fuente de Poder 600W', 'Hardware',        6,   2800.00, 'no', 'Lmarte'),
('Router TP-Link',       'Redes',           8,   2200.00, 'si', 'Lmarte'),
('Switch 8 Puertos',     'Redes',           5,   1800.00, 'si', 'Lmarte'),
('Tablet Samsung',       'Electrónica',     9,  15000.00, 'si', 'Lmarte'),
('Audífonos Bluetooth',  'Accesorio',      25,   1200.00, 'si', 'Lmarte'),
('Cámara Web HD',        'Accesorio',      12,    900.00, 'no', 'Lmarte'),
('Impresora HP',         'Oficina',         3,   9500.00, 'si', 'Lmarte'),
('UPS 1000VA',           'Energía',         4,   7000.00, 'si', 'Lmarte');

-- ============================================================
-- Tabla: usuarios
-- Almacena los usuarios del sistema con contraseña hasheada
-- ============================================================
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id`   INT          NOT NULL AUTO_INCREMENT,
  `user` VARCHAR(50)  DEFAULT NULL,
  `pass` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Usuario de prueba: Lmarte (contraseña original del proyecto)
INSERT INTO `usuarios` (`user`, `pass`) VALUES
('Lmarte', '$2y$10$xA.zFuqTreqAUjnd1aKiIORptRka9W22LCAMC7uPxSbrkbQaUZy/K'),
('admin',  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Nota sobre contraseñas:
--   Lmarte → contraseña original (la del equipo)
--   admin  → contraseña: "password"
--
-- Para generar tu propio hash:
--   echo password_hash('tu_contraseña', PASSWORD_BCRYPT);

COMMIT;
