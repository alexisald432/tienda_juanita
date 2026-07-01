<?php
// ============================================
// ARCHIVO DE DIAGNÓSTICO TEMPORAL
// BORRAR DESPUÉS DE RESOLVER EL PROBLEMA
// ============================================

echo "<h2>Diagnóstico de Conexión - Railway</h2>";

// 1. Verificar si la variable MYSQL_URL existe (3 formas posibles de leerla)
echo "<h3>1. Variables de Entorno</h3>";

$url_getenv = getenv('MYSQL_URL');
$url_env    = $_ENV['MYSQL_URL'] ?? null;
$url_server = $_SERVER['MYSQL_URL'] ?? null;

echo "getenv('MYSQL_URL'): " . ($url_getenv ? '✅ ENCONTRADA' : '❌ NO ENCONTRADA') . "<br>";
echo "ENV['MYSQL_URL']: " . ($url_env ? '✅ ENCONTRADA' : '❌ NO ENCONTRADA') . "<br>";
echo "SERVER['MYSQL_URL']: " . ($url_server ? '✅ ENCONTRADA' : '❌ NO ENCONTRADA') . "<br><br>";

// 2. Buscar cualquier variable que contenga "MYSQL"
echo "<h3>2. Todas las variables con 'MYSQL' disponibles</h3>";
$encontradas = 0;
foreach ($_SERVER as $key => $value) {
    if (stripos($key, 'MYSQL') !== false) {
        echo "SERVER[$key] = " . substr($value, 0, 30) . "...<br>";
        $encontradas++;
    }
}
foreach ($_ENV as $key => $value) {
    if (stripos($key, 'MYSQL') !== false) {
        echo "ENV[$key] = " . substr($value, 0, 30) . "...<br>";
        $encontradas++;
    }
}
if ($encontradas === 0) {
    echo "❌ No se encontró NINGUNA variable MYSQL en el entorno.<br>";
    echo "<strong>Solución: Ve a tu servicio web en Railway → Variables → Add Reference → MySQL</strong><br>";
}

// 3. Intentar la conexión directa
echo "<h3>3. Prueba de Conexión</h3>";
$mysql_url = getenv('MYSQL_URL') ?: ($_ENV['MYSQL_URL'] ?? ($_SERVER['MYSQL_URL'] ?? null));

if ($mysql_url) {
    $db = parse_url($mysql_url);
    echo "Host: " . ($db['host'] ?? 'N/A') . "<br>";
    echo "Puerto: " . ($db['port'] ?? 'N/A') . "<br>";
    echo "Usuario: " . ($db['user'] ?? 'N/A') . "<br>";
    echo "BD: " . ltrim($db['path'] ?? '', '/') . "<br><br>";
    
    try {
        $dsn = "mysql:host={$db['host']};port={$db['port']};dbname=" . ltrim($db['path'], '/') . ";charset=utf8mb4";
        $pdo = new PDO($dsn, $db['user'], $db['pass']);
        echo "✅ <strong style='color:green;'>CONEXIÓN EXITOSA</strong><br>";
        
        // Verificar tablas
        $tablas = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        echo "Tablas encontradas: " . implode(', ', $tablas) . "<br>";
    } catch (PDOException $e) {
        echo "❌ <strong style='color:red;'>ERROR DE CONEXIÓN:</strong> " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ No hay URL de MySQL disponible. Las variables de entorno no están configuradas.<br>";
}

echo "<br><hr><small>Versión PHP: " . phpversion() . " | Extensión PDO MySQL: " . (extension_loaded('pdo_mysql') ? '✅' : '❌') . "</small>";
?>
