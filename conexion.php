<?php
// ============================================
// Archivo de conexión a la Base de Datos (PDO)
// Adaptado para Railway (MYSQL_URL) y XAMPP local
// ============================================

// Railway provee una sola variable MYSQL_URL con todo incluido
// Formato: mysql://usuario:contraseña@host:puerto/base_de_datos
$mysql_url = getenv('MYSQL_URL');

if ($mysql_url) {
    // PRODUCCIÓN (Railway): Parsear la URL de conexión
    $db = parse_url($mysql_url);
    $host       = $db['host'];
    $puerto     = $db['port'];
    $usuario    = $db['user'];
    $contrasena = $db['pass'];
    $bd         = ltrim($db['path'], '/'); // Quitar la "/" inicial del path
} else {
    // LOCAL (XAMPP): Valores por defecto para desarrollo
    $host       = 'localhost';
    $puerto     = '3306';
    $usuario    = 'root';
    $contrasena = '';
    $bd         = 'tienda_juanita';
}

// DSN para PDO
$dsn = "mysql:host=$host;port=$puerto;dbname=$bd;charset=utf8mb4";

// Opciones de PDO
$opciones = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $conexion = new PDO($dsn, $usuario, $contrasena, $opciones);
} catch (PDOException $e) {
    error_log("Error de conexión a BD: " . $e->getMessage());
    die("Lo sentimos, estamos experimentando problemas técnicos. Por favor, intenta más tarde.");
}
?>