<?php
// db.php
// Conexión a la base de datos usando PDO

$host   = 'localhost';
$dbname = 'grupo_9';
$user   = 'root';
$pass   = '';

try {
    // Crear la conexión PDO con charset UTF-8
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    // Configurar PDO para que lance excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si falla la conexión, mostrar mensaje de error
    die('<div style="font-family:sans-serif;padding:20px;color:red;">
        <strong>Error de conexión:</strong> No se pudo conectar a la base de datos.<br>
        Verifica que MySQL esté activo y que la BD <em>grupo_9</em> exista.
    </div>');
}
?>
