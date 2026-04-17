<?php
// api/eliminar.php – Eliminar un producto (DELETE)
require_once '../config/auth.php';
require_once '../config/db.php';

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: ../productos.php?msg=eliminado');
exit;
?>
