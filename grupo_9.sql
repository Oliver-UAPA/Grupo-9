-- grupo_9.sql
-- Base de datos del sistema de inventario Grupo 9
-- Importar en phpMyAdmin o con: mysql -u root -p < grupo_9.sql

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS `grupo_9`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `grupo_9`;

-- -------------------------------------------------------
-- Tabla: productos
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS `productos` (
  `id`       INT          NOT NULL AUTO_INCREMENT,
  `nombre`   VARCHAR(100) DEFAULT NULL,
  `tipo`     VARCHAR(50)  DEFAULT NULL,
  `cantidad` INT          DEFAULT NULL,
  `costo`    DECIMAL(10,2) DEFAULT NULL,
  `stock`    VARCHAR(10)  DEFAULT NULL,
  `usuario`  VARCHAR(50)  DEFAULT NULL,
  `fecha`    TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos de ejemplo
INSERT INTO `productos` (`nombre`, `tipo`, `cantidad`, `costo`, `stock`, `usuario`) VALUES
('Laptop HP',           'Electrónica',    5,  35000.00, 'si', 'admin'),
('Mouse Logitech',      'Accesorio',     20,    800.00, 'si', 'admin'),
('Teclado Mecánico',    'Accesorio',     10,   2500.00, 'no', 'admin'),
('Monitor Samsung',     'Electrónica',    3,  12000.00, 'si', 'admin'),
('Disco SSD 1TB',       'Almacenamiento', 7,   5000.00, 'si', 'admin'),
('Laptop Dell',         'Electrónica',    4,  42000.00, 'si', 'admin'),
('Memoria RAM 16GB',    'Hardware',      15,   3000.00, 'si', 'admin'),
('Fuente de Poder 600W','Hardware',       6,   2800.00, 'no', 'admin'),
('Router TP-Link',      'Redes',          8,   2200.00, 'si', 'admin'),
('Switch 8 Puertos',    'Redes',          5,   1800.00, 'si', 'admin');

-- -------------------------------------------------------
-- Tabla: usuarios
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id`   INT          NOT NULL AUTO_INCREMENT,
  `user` VARCHAR(50)  DEFAULT NULL,
  `pass` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Usuario por defecto: admin / admin123
-- (contraseña hasheada con password_hash('admin123', PASSWORD_BCRYPT))
INSERT INTO `usuarios` (`user`, `pass`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Nota: la contraseña del hash de arriba es "password"
-- Para usar "admin123", genera un nuevo hash con:
--   echo password_hash('admin123', PASSWORD_BCRYPT);
-- y reemplaza el valor en esta tabla.

COMMIT;
