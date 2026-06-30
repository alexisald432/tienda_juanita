<?php
// ============================================
// Guardar mensaje de contacto en la BD (PDO)
// ============================================

include("conexion.php");

// Validar que el request sea POST (evita acceso directo por URL)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

// Obtener y sanitizar los datos del formulario
$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$mensaje = trim($_POST['mensaje'] ?? '');

// Validar que los campos no estén vacíos
if (empty($nombre) || empty($correo) || empty($mensaje)) {
    header("Location: index.php?status=error&msg=" . urlencode("Todos los campos son obligatorios"));
    exit();
}

// Validar formato de correo electrónico
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    header("Location: index.php?status=error&msg=" . urlencode("El correo electrónico no es válido"));
    exit();
}

try {
    // Prepared statement para INSERT seguro (PDO)
    $sql = "INSERT INTO contacto (nombre, correo, mensaje) VALUES (:nombre, :correo, :mensaje)";
    $stmt = $conexion->prepare($sql);
    
    // Ejecutar pasando el array de parámetros
    $stmt->execute([
        ':nombre' => $nombre,
        ':correo' => $correo,
        ':mensaje' => $mensaje
    ]);

    // Éxito: redirigir con mensaje de confirmación
    header("Location: index.php?status=ok");
} catch (PDOException $e) {
    // Error al ejecutar
    error_log("Error al guardar mensaje: " . $e->getMessage());
    header("Location: index.php?status=error&msg=" . urlencode("Error al guardar el mensaje. Intenta de nuevo."));
}

// En PDO, la conexión se cierra automáticamente al finalizar el script o asignando null
$conexion = null;
?>