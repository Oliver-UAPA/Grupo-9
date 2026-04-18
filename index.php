<?php
// index.php
// Dashboard principal – página de inicio del sistema (requiere sesión)

// Validación de sesión: si no está logueado, redirige a login
include('auth.php');

// Conexión a la base de datos
require_once 'db.php';

// Consultas para las tarjetas de estadísticas
$total      = $pdo->query("SELECT COUNT(*) FROM productos")->fetchColumn();
$enStock    = $pdo->query("SELECT COUNT(*) FROM productos WHERE stock = 'si'")->fetchColumn();
$sinStock   = $pdo->query("SELECT COUNT(*) FROM productos WHERE stock = 'no'")->fetchColumn();
$valorTotal = $pdo->query("SELECT SUM(cantidad * costo) FROM productos")->fetchColumn() ?? 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard – Grupo 9</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }

        /* Sidebar de navegación lateral */
        .sidebar { min-height: 100vh; background-color: #1e293b; }
        .sidebar .brand { color: #ffffff; font-weight: 700; font-size: 1.1rem; }
        .sidebar .nav-link { color: #94a3b8; border-radius: 8px; }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active { background-color: #334155; color: #ffffff; }

        /* Tarjetas de estadísticas */
        .stat-card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,.06); }
    </style>
</head>
<body>

<div class="d-flex">

    <!-- ==================== SIDEBAR ==================== -->
    <nav class="sidebar d-flex flex-column p-3" style="width: 220px; min-width: 220px;">

        <div class="brand mb-4 px-2">
            <i class="bi bi-box-seam me-2"></i>Grupo 9
        </div>

        <!-- Menú de navegación -->
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a href="index.php" class="nav-link active">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="productos.php" class="nav-link">
                    <i class="bi bi-table me-2"></i>Productos
                </a>
            </li>
            <li class="nav-item">
                <a href="registro.php" class="nav-link">
                    <i class="bi bi-plus-circle me-2"></i>Nuevo Producto
                </a>
            </li>
        </ul>

        <!-- Usuario y botón de logout al fondo del sidebar -->
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

        <!-- Título de la página -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Dashboard</h4>
            <span class="text-muted small">
                Bienvenido, <strong><?= htmlspecialchars($_SESSION['usuario']) ?></strong>
            </span>
        </div>

        <!-- Tarjetas de estadísticas -->
        <div class="row g-3 mb-4">

            <!-- Total de productos -->
            <div class="col-sm-6 col-xl-3">
                <div class="card stat-card p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-box-seam fs-4 text-primary"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total Productos</div>
                            <div class="fs-4 fw-bold"><?= $total ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Productos en stock -->
            <div class="col-sm-6 col-xl-3">
                <div class="card stat-card p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-check-circle fs-4 text-success"></i>
                        </div>
                        <div>
                            <div class="text-muted small">En Stock</div>
                            <div class="fs-4 fw-bold"><?= $enStock ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Productos sin stock -->
            <div class="col-sm-6 col-xl-3">
                <div class="card stat-card p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-danger bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-x-circle fs-4 text-danger"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Sin Stock</div>
                            <div class="fs-4 fw-bold"><?= $sinStock ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Valor total del inventario -->
            <div class="col-sm-6 col-xl-3">
                <div class="card stat-card p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-currency-dollar fs-4 text-warning"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Valor Inventario</div>
                            <div class="fs-5 fw-bold">$<?= number_format($valorTotal, 2) ?></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Acceso rápido -->
        <div class="card border-0 rounded-3 shadow-sm p-4">
            <h6 class="fw-bold mb-3">Acceso Rápido</h6>
            <div class="d-flex gap-2 flex-wrap">
                <a href="productos.php" class="btn btn-outline-primary">
                    <i class="bi bi-table me-1"></i> Ver Productos
                </a>
                <a href="registro.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Agregar Producto
                </a>
            </div>
        </div>

    </main>
    <!-- ==================== FIN CONTENIDO ==================== -->

</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
