<?php
// registro_usuario.php
// Formulario para crear una cuenta nueva en el sistema

session_start();

// Si ya hay sesión activa, ir al dashboard
if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

$error   = '';
$success = '';

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['user']    ?? '');
    $password = trim($_POST['pass']    ?? '');
    $confirm  = trim($_POST['confirm'] ?? '');

    // Validaciones básicas
    if (empty($username) || empty($password) || empty($confirm)) {
        $error = 'Todos los campos son obligatorios.';
    } elseif (strlen($password) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres.';
    } elseif ($password !== $confirm) {
        $error = 'Las contraseñas no coinciden.';
    } else {
        // Conexión a la base de datos
        require_once 'db.php';

        // Verificar si el usuario ya existe
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE user = ?");
        $stmt->execute([$username]);

        if ($stmt->fetch()) {
            $error = 'Ese nombre de usuario ya está registrado.';
        } else {
            // Hashear la contraseña con bcrypt
            $hash = password_hash($password, PASSWORD_BCRYPT);

            // Insertar el nuevo usuario
            $stmt = $pdo->prepare("INSERT INTO usuarios (user, pass) VALUES (?, ?)");
            $stmt->execute([$username, $hash]);

            $success = 'Usuario registrado correctamente.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario – Grupo 9</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,.10); }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">

    <div class="card p-4" style="width: 400px;">

        <!-- Encabezado -->
        <div class="text-center mb-4">
            <i class="bi bi-person-plus fs-1 text-primary"></i>
            <h4 class="fw-bold mt-2">Crear Cuenta</h4>
            <p class="text-muted small mb-0">Completa los datos para registrarte</p>
        </div>

        <!-- Mensaje de error -->
        <?php if ($error): ?>
            <div class="alert alert-danger py-2">
                <i class="bi bi-exclamation-circle me-1"></i>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Mensaje de éxito -->
        <?php if ($success): ?>
            <div class="alert alert-success py-2">
                <i class="bi bi-check-circle me-1"></i>
                <?= htmlspecialchars($success) ?>
                – <a href="login.php" class="alert-link">Inicia sesión aquí</a>
            </div>
        <?php endif; ?>

        <!-- Formulario de registro -->
        <form method="POST">

            <div class="mb-3">
                <label class="form-label fw-semibold">Nombre de usuario</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text"
                           name="user"
                           class="form-control"
                           placeholder="Ej: jperez"
                           value="<?= htmlspecialchars($_POST['user'] ?? '') ?>"
                           required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password"
                           name="pass"
                           class="form-control"
                           placeholder="Mínimo 6 caracteres"
                           required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Confirmar contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password"
                           name="confirm"
                           class="form-control"
                           placeholder="Repite la contraseña"
                           required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-person-check me-1"></i> Registrarse
            </button>

        </form>

        <hr class="my-3">
        <p class="text-center small text-muted mb-0">
            ¿Ya tienes cuenta?
            <a href="login.php" class="text-decoration-none">Inicia sesión</a>
        </p>

    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
