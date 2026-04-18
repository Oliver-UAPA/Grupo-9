<?php
// productos.php
// Lista todos los productos del sistema (READ)

// Validación de sesión: si no está logueado, redirige a login
include('auth.php');

// Conexión a la base de datos
require_once 'db.php';

// Leer mensaje flash de la URL (viene de redireccionamientos del CRUD)
$msg = $_GET['msg'] ?? '';

// Consulta para obtener todos los productos ordenados por fecha
$productos = $pdo->query("SELECT * FROM productos ORDER BY fecha DESC")
                 ->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos – Grupo 9</title>
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

        /* Badges personalizados para estado del stock */
        .badge-si { background-color: #dcfce7; color: #166534; }
        .badge-no { background-color: #fee2e2; color: #991b1b; }
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
                <a href="productos.php" class="nav-link active">
                    <i class="bi bi-table me-2"></i>Productos
                </a>
            </li>
            <li class="nav-item">
                <a href="registro.php" class="nav-link">
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

        <!-- Encabezado de la sección -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Lista de Productos</h4>
            <a href="registro.php" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Nuevo Producto
            </a>
        </div>

        <!-- Mensajes de confirmación según la acción realizada -->
        <?php if ($msg === 'creado'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i> Producto guardado correctamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($msg === 'editado'): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="bi bi-pencil me-1"></i> Producto actualizado correctamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($msg === 'eliminado'): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-trash me-1"></i> Producto eliminado.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Tabla de productos -->
        <div class="card border-0 rounded-3 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">#</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Cantidad</th>
                                <th>Costo</th>
                                <th>Stock</th>
                                <th>Registrado por</th>
                                <th>Fecha</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($productos)): ?>
                                <!-- Si no hay productos registrados -->
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        No hay productos registrados aún.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <!-- Mostrar cada producto en una fila -->
                                <?php foreach ($productos as $p): ?>
                                <tr>
                                    <td class="ps-3 text-muted small"><?= $p['id'] ?></td>
                                    <td class="fw-semibold"><?= htmlspecialchars($p['nombre']) ?></td>
                                    <td><?= htmlspecialchars($p['tipo']) ?></td>
                                    <td><?= $p['cantidad'] ?></td>
                                    <td>$<?= number_format($p['costo'], 2) ?></td>
                                    <td>
                                        <!-- Badge de stock con color según disponibilidad -->
                                        <span class="badge rounded-pill badge-<?= $p['stock'] ?>">
                                            <?= $p['stock'] === 'si' ? 'Sí' : 'No' ?>
                                        </span>
                                    </td>
                                    <td class="text-muted small"><?= htmlspecialchars($p['usuario']) ?></td>
                                    <td class="text-muted small"><?= date('d/m/Y', strtotime($p['fecha'])) ?></td>
                                    <td class="text-center">
                                        <!-- Botón editar (UPDATE) -->
                                        <a href="editar.php?id=<?= $p['id'] ?>"
                                           class="btn btn-outline-secondary btn-sm me-1"
                                           title="Editar producto">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                        <!-- Botón eliminar (DELETE) con confirmación -->
                                        <a href="eliminar.php?id=<?= $p['id'] ?>"
                                           class="btn btn-outline-danger btn-sm"
                                           title="Eliminar producto"
                                           onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?')">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>
    <!-- ==================== FIN CONTENIDO ==================== -->

</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
