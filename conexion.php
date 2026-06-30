<?php
// ============================================
// Archivo de conexión a la Base de Datos (PDO)
// Adaptado para Railway (Variables de Entorno)
// ============================================

// Leer variables de entorno (Railway) o usar valores por defecto (Local/XAMPP)
// Se han configurado los valores por defecto para que apunten a tu XAMPP local
$host = getenv('MYSQLHOST') ?: 'localhost';
$puerto = getenv('MYSQLPORT') ?: '3306';
$usuario = getenv('MYSQLUSER') ?: 'root';
$contrasena = getenv('MYSQLPASSWORD') ?: '';
$bd = getenv('MYSQLDATABASE') ?: 'tienda_juanita';

// DSN para PDO
$dsn = "mysql:host=$host;port=$puerto;dbname=$bd;charset=utf8mb4";

// Opciones de PDO para mayor seguridad y manejo de errores
$opciones = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lanzar excepciones en errores
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Devolver arrays asociativos por defecto
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Usar prepared statements reales
];

try {
    // Crear la instancia de conexión PDO
    $conexion = new PDO($dsn, $usuario, $contrasena, $opciones);
} catch (PDOException $e) {
    // EN PRODUCCIÓN: Nunca usar echo $e->getMessage();
    // En Railway es mejor escribir al log del sistema (error_log) y mostrar un mensaje genérico.
    error_log("Error de conexión a BD: " . $e->getMessage());
    die("Lo sentimos, estamos experimentando problemas técnicos. Por favor, intenta más tarde.");
}
?>