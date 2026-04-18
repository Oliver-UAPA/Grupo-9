<?php
// eliminar.php
// Elimina un producto de la base de datos (DELETE)

// Validación de sesión: si no está logueado, redirige a login
include('auth.php');

// Conexión a la base de datos
require_once 'db.php';

// Obtener el ID del producto desde la URL
$id = (int)($_GET['id'] ?? 0);

// Solo eliminar si el ID es válido
if ($id > 0) {
    // Consulta para eliminar el producto por ID
    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->execute([$id]);
}

// Redirigir a la lista con mensaje de confirmación
header('Location: productos.php?msg=eliminado');
exit;
?>
