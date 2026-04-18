<?php
// registro.php
// Formulario para crear un nuevo producto (CREATE)

// Validación de sesión: si no está logueado, redirige a login
include('auth.php');

// Conexión a la base de datos
require_once 'db.php';

$error = '';

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre   = trim($_POST['nombre']   ?? '');
    $tipo     = trim($_POST['tipo']     ?? '');
    $cantidad = trim($_POST['cantidad'] ?? '');
    $costo    = trim($_POST['costo']    ?? '');
    $stock    = trim($_POST['stock']    ?? '');

    // Validación: todos los campos son obligatorios
    if (empty($nombre) || empty($tipo) || $cantidad === '' || $costo === '' || empty($stock)) {
        $error = 'Todos los campos son obligatorios.';
    } elseif (!is_numeric($cantidad) || (int)$cantidad < 0) {
        $error = 'La cantidad debe ser un número mayor o igual a cero.';
    } elseif (!is_numeric($costo) || (float)$costo < 0) {
        $error = 'El costo debe ser un número mayor o igual a cero.';
    } else {
        // Insertar el nuevo producto en la base de datos
        $stmt = $pdo->prepare(
            "INSERT INTO productos (nombre, tipo, cantidad, costo, stock, usuario)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $nombre,
            $tipo,
            (int)$cantidad,
            (float)$costo,
            $stock,
            $_SESSION['usuario']  // guardar quién registró el producto
        ]);

        // Redirigir con mensaje de éxito
        header('Location: productos.php?msg=creado');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto – Grupo 9</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }
        .sidebar { min-height: 100vh; background-color: #1e293b; }
        .sidebar .brand { color: #ffffff; font-weight: 700; font-size: 1.1rem; }
        .sidebar .nav-link { color: #94a3b8; border-radius: 8px; }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active { background-color: #334155; color: #ffffff; }
    </style>
</head>
<body>

<div class="d-flex">

    <!-- ==================== SIDEBAR ==================== -->
    <nav class="sidebar d-flex flex-column p-3" style="width: 220px; min-width: 220px;">

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
                <i class="bi bi-person-circle me-1"></i>
                <?= htmlspecialchars($_SESSION['usuario']) ?>
            </div>
            <a href="logout.php" class="nav-link text-danger">
                <i class="bi bi-box-arrow-left me-2"></i>Cerrar sesión
            </a>
        </div>

    </nav>
    <!-- ==================== FIN SIDEBAR ==================== -->

    <!-- ==================== CONTENIDO PRINCIPAL ==================== -->
    <main class="flex-grow-1 p-4">

        <div class="mb-4">
            <h4 class="fw-bold mb-0">Nuevo Producto</h4>
            <p class="text-muted small">Completa los datos para registrar un producto</p>
        </div>

        <!-- Tarjeta con el formulario -->
        <div class="card border-0 rounded-3 shadow-sm" style="max-width: 560px;">
            <div class="card-body p-4">

                <!-- Mensaje de error si hay validación fallida -->
                <?php if ($error): ?>
                    <div class="alert alert-danger py-2">
                        <i class="bi bi-exclamation-circle me-1"></i>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <!-- Formulario de registro de producto -->
                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre del Producto</label>
                        <input type="text"
                               name="nombre"
                               class="form-control"
                               placeholder="Ej. Laptop HP"
                               value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tipo</label>
                        <input type="text"
                               name="tipo"
                               class="form-control"
                               placeholder="Ej. Electrónica"
                               value="<?= htmlspecialchars($_POST['tipo'] ?? '') ?>">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Cantidad</label>
                            <input type="number"
                                   name="cantidad"
                                   class="form-control"
                                   min="0"
                                   placeholder="Ej. 10"
                                   value="<?= htmlspecialchars($_POST['cantidad'] ?? '') ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Costo ($)</label>
                            <input type="number"
                                   name="costo"
                                   class="form-control"
                                   min="0"
                                   step="0.01"
                                   placeholder="Ej. 1500.00"
                                   value="<?= htmlspecialchars($_POST['costo'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">¿En Stock?</label>
                        <select name="stock" class="form-select">
                            <option value="">Seleccionar...</option>
                            <option value="si" <?= (($_POST['stock'] ?? '') === 'si') ? 'selected' : '' ?>>Sí</option>
                            <option value="no" <?= (($_POST['stock'] ?? '') === 'no') ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>

                    <!-- Botones de acción -->
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
    <!-- ==================== FIN CONTENIDO ==================== -->

</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
