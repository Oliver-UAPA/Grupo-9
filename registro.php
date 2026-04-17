<?php
// registro.php – Crear nuevo producto (CREATE)
require_once 'config/auth.php';
require_once 'config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = trim($_POST['nombre'] ?? '');
    $tipo     = trim($_POST['tipo'] ?? '');
    $cantidad = trim($_POST['cantidad'] ?? '');
    $costo    = trim($_POST['costo'] ?? '');
    $stock    = trim($_POST['stock'] ?? '');

    // Validación básica
    if (empty($nombre) || empty($tipo) || $cantidad === '' || $costo === '' || empty($stock)) {
        $error = 'Todos los campos son obligatorios.';
    } elseif (!is_numeric($cantidad) || (int)$cantidad < 0) {
        $error = 'La cantidad debe ser un número positivo.';
    } elseif (!is_numeric($costo) || (float)$costo < 0) {
        $error = 'El costo debe ser un número positivo.';
    } else {
        $stmt = $pdo->prepare(
            "INSERT INTO productos (nombre, tipo, cantidad, costo, stock, usuario) VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([$nombre, $tipo, (int)$cantidad, (float)$costo, $stock, $_SESSION['usuario']]);
        header('Location: productos.php?msg=creado');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto – Grupo 9</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; }
        .sidebar { min-height: 100vh; background: #1e293b; }
        .sidebar .nav-link { color: #94a3b8; border-radius: 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: #334155; color: #fff; }
        .sidebar .brand { color: #fff; font-weight: 700; font-size: 1.1rem; }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <nav class="sidebar d-flex flex-column p-3" style="width: 220px; min-width:220px;">
        <div class="brand mb-4 px-2">
            <i class="bi bi-box-seam me-2"></i>Grupo 9
        </div>
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a href="index.php" class="nav-link">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="productos.php" class="nav-link">
                    <i class="bi bi-table me-2"></i>Productos
                </a>
            </li>
            <li class="nav-item">
                <a href="registro.php" class="nav-link active">
                    <i class="bi bi-plus-circle me-2"></i>Nuevo Producto
                </a>
            </li>
        </ul>
        <div class="mt-auto">
            <hr class="border-secondary">
            <div class="text-secondary small px-2 mb-2">
                <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($_SESSION['usuario']) ?>
            </div>
            <a href="logout.php" class="nav-link text-danger">
                <i class="bi bi-box-arrow-left me-2"></i>Cerrar sesión
            </a>
        </div>
    </nav>

    <!-- Contenido -->
    <main class="flex-grow-1 p-4">
        <div class="mb-4">
            <h4 class="fw-bold mb-0">Nuevo Producto</h4>
            <p class="text-muted small">Completa los datos del producto</p>
        </div>

        <div class="card border-0 rounded-3 shadow-sm" style="max-width: 560px;">
            <div class="card-body p-4">

                <?php if ($error): ?>
                    <div class="alert alert-danger py-2">
                        <i class="bi bi-exclamation-circle me-1"></i> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" novalidate>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre del Producto</label>
                        <input type="text" name="nombre" class="form-control"
                               placeholder="Ej. Laptop HP"
                               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tipo</label>
                        <input type="text" name="tipo" class="form-control"
                               placeholder="Ej. Electrónica"
                               value="<?= htmlspecialchars($_POST['tipo'] ?? '') ?>">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Cantidad</label>
                            <input type="number" name="cantidad" class="form-control" min="0"
                                   placeholder="Ej. 10"
                                   value="<?= htmlspecialchars($_POST['cantidad'] ?? '') ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Costo ($)</label>
                            <input type="number" name="costo" class="form-control" min="0" step="0.01"
                                   placeholder="Ej. 1500.00"
                                   value="<?= htmlspecialchars($_POST['costo'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">En Stock</label>
                        <select name="stock" class="form-select">
                            <option value="">Seleccionar...</option>
                            <option value="si" <?= (($_POST['stock'] ?? '') === 'si') ? 'selected' : '' ?>>Sí</option>
                            <option value="no" <?= (($_POST['stock'] ?? '') === 'no') ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Guardar Producto
                        </button>
                        <a href="productos.php" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>

            </div>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
