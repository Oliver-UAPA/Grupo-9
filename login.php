<?php
// login.php
session_start();

// Si ya está logueado, redirigir al dashboard
if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['user'] ?? '');
    $password = trim($_POST['pass'] ?? '');

    if (empty($username) || empty($password)) {
        $error = 'Por favor completa todos los campos.';
    } else {
        require_once 'config/db.php';

        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE user = ?");
        $stmt->execute([$username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row['pass'])) {
            // Login exitoso
            $_SESSION['usuario'] = $row['user'];
            $_SESSION['usuario_id'] = $row['id'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'Usuario o contraseña incorrectos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión – Grupo 9</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,.08); }
        .brand-title { font-weight: 700; color: #0d6efd; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="card p-4" style="width: 380px;">
        <div class="text-center mb-4">
            <i class="bi bi-box-seam fs-1 text-primary"></i>
            <h4 class="brand-title mt-2">Inventario Grupo 9</h4>
            <p class="text-muted small">Inicia sesión para continuar</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                <i class="bi bi-exclamation-circle me-1"></i> <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label fw-semibold">Usuario</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="user" class="form-control" placeholder="Tu usuario"
                           value="<?= htmlspecialchars($_POST['user'] ?? '') ?>" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="pass" class="form-control" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
            </button>
        </form>

        <hr class="my-3">
        <p class="text-center small text-muted mb-0">
            ¿No tienes cuenta?
            <a href="registro_usuario.php" class="text-decoration-none">Regístrate aquí</a>
        </p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
