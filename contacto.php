<?php
// ============================================
// Tienda Juanita — Página de Contacto
// Refactorizado: PDO + Includes
// ============================================

include("conexion.php");

$page_title = "Contacto — Tienda Juanita";
$page_subtitle = "Formulario de Contacto";

$status = $_GET['status'] ?? '';
$msg = $_GET['msg'] ?? '';

// Cargar los últimos mensajes usando PDO
$mensajes_recientes = [];
$sql_mensajes = "SELECT nombre, mensaje, fecha FROM contacto ORDER BY fecha DESC LIMIT 3";

try {
    $stmt = $conexion->query($sql_mensajes);
    $mensajes_recientes = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Error al cargar mensajes: " . $e->getMessage());
}

// Incluir encabezado
include("includes/header.php");
?>

<?php
if ($status === 'ok') {
    echo '<div class="alerta alerta-ok">✅ ¡Mensaje enviado correctamente!</div>';
} elseif ($status === 'error') {
    echo '<div class="alerta alerta-error">❌ ' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</div>';
}
?>

<section style="max-width: 500px; margin: 30px auto; background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
    <h2 style="text-align: center; color: #0077cc; font-size: 24px; margin-bottom: 15px;">📧 Escríbenos</h2>

    <div class="formulario">
        <form action="guardar.php" method="POST">
            <input type="text" name="nombre" placeholder="Tu nombre completo" required>
            <input type="email" name="correo" placeholder="Tu correo electrónico" required>
            <textarea name="mensaje" placeholder="Escribe tu mensaje aquí..." required></textarea>
            <button type="submit">📩 Enviar Mensaje</button>
        </form>
    </div>
</section>

<?php
if (!empty($mensajes_recientes)) {
?>
<div class="testimonios">
    <h3>💬 Mensajes Recientes</h3>
    <?php
    foreach ($mensajes_recientes as $m) {
        $nombre_seguro = htmlspecialchars($m['nombre'], ENT_QUOTES, 'UTF-8');
        $mensaje_seguro = htmlspecialchars($m['mensaje'], ENT_QUOTES, 'UTF-8');
        $fecha = date("d/m/Y H:i", strtotime($m['fecha']));
    ?>
        <div class="testimonio-card">
            <p class="nombre">👤 <?php echo $nombre_seguro; ?></p>
            <p>"<?php echo $mensaje_seguro; ?>"</p>
            <p class="fecha">📅 <?php echo $fecha; ?></p>
        </div>
    <?php } ?>
</div>
<?php } ?>

<?php
// Incluir el pie de página
include("includes/footer.php");

// Cerrar conexión
$conexion = null;
?>