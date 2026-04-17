<?php
// config/auth.php
// Incluir este archivo al inicio de cada página protegida
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
?>
