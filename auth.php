<?php
// auth.php
// Validación de sesión: protege las páginas del sistema
// Incluir este archivo al inicio de cada página protegida

session_start();

// Si no hay sesión activa, redirigir al login
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
?>
