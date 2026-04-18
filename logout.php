<?php
// logout.php
// Cierra la sesión del usuario y redirige al login

session_start();

// Destruir todos los datos de la sesión
session_destroy();

// Redirigir al login
header('Location: login.php');
exit;
?>
