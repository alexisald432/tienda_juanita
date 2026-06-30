<?php
// ============================================
// Tienda Juanita — Página Principal (index.php)
// Refactorizado: PDO + Includes + Imágenes Locales
// ============================================

include("conexion.php");

// Variables para el <head> y <header> en header.php
$page_title = "Tienda Juanita — Dulces y Botanas";
$page_subtitle = "Los mejores dulces al mejor precio";

// Mensajes de estado del formulario
$status = $_GET['status'] ?? '';
$msg = $_GET['msg'] ?? '';

// Cargar productos usando PDO
// Filtramos los IDs duplicados directamente en la consulta (7: Botanas duplicadas, 10: Chicles de cinta)
$sql_productos = "SELECT id_producto, nombre, precio, categoria FROM productos WHERE id_producto NOT IN (7, 10) ORDER BY categoria, nombre";
$productos_por_categoria = [];
$total_productos = 0;

try {
    $stmt = $conexion->query($sql_productos);
    $productos = $stmt->fetchAll();
    
    foreach ($productos as $producto) {
        $cat = $producto['categoria'];
        $productos_por_categoria[$cat][] = $producto;
        $total_productos++;
    }
} catch (PDOException $e) {
    error_log("Error al cargar productos: " . $e->getMessage());
}

// Mapeo de imágenes locales (carpeta media/)
$imagenes_productos = [
    1  => "media/surtidos.webp",
    2  => "media/gomitas.jpg",
    3  => "media/chocolates.jpg",
    4  => "media/papas.jpg",
    5  => "media/refrescos.jpg",
    6  => "media/paquetes.jpg",
    8  => "media/chocolate_suelto.jpg",
    9  => "media/chicles.webp"
];

// Incluir el encabezado (contiene <!DOCTYPE>, <head>, <header> y <nav>)
include("includes/header.php");
?>

<!-- Banner -->
<img class="banner" src="media/tienda.jpg" alt="Banner de la Tienda Juanita">

<!-- ============================================
     MENSAJES DE ESTADO DEL FORMULARIO
     ============================================ -->
<?php
if ($status === 'ok') {
    echo '<div class="alerta alerta-ok">✅ ¡Tu mensaje fue enviado correctamente! Te contactaremos pronto.</div>';
} elseif ($status === 'error') {
    $msg_seguro = htmlspecialchars($msg, ENT_QUOTES, 'UTF-8');
    echo '<div class="alerta alerta-error">❌ Error: ' . $msg_seguro . '</div>';
}
?>

<!-- ============================================
     SECCIÓN DE PRODUCTOS
     ============================================ -->
<section id="productos">
    <h2 class="titulo">🛒 Nuestros Productos</h2>

    <?php
    if (!empty($productos_por_categoria)) {
        foreach ($productos_por_categoria as $categoria => $productos) {
            echo '<div class="categoria-header">';
            echo '<span class="subtitulo-cat">📦 ' . htmlspecialchars($categoria, ENT_QUOTES, 'UTF-8') . '</span>';
            echo '</div>';
            echo '<div class="productos">';

            foreach ($productos as $prod) {
                $id = (int)$prod['id_producto'];
                $nombre = htmlspecialchars($prod['nombre'], ENT_QUOTES, 'UTF-8');
                $precio = number_format($prod['precio'], 2);
                $imagen = $imagenes_productos[$id] ?? 'https://via.placeholder.com/300x200?text=Sin+imagen';
    ?>
                <div class="card">
                    <img src="<?php echo $imagen; ?>" alt="Producto: <?php echo $nombre; ?>">
                    <h3><?php echo $nombre; ?></h3>
                    <p class="precio">$<?php echo $precio; ?></p>
                    <span class="categoria-tag"><?php echo htmlspecialchars($categoria, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
    <?php
            } // fin foreach productos
            echo '</div>'; // fin .productos
        } // fin foreach categorías
    } else {
        echo '<p style="text-align:center;color:#999;">No hay productos disponibles en este momento.</p>';
    }
    ?>
</section>

<!-- ============================================
     SECCIÓN MULTIMEDIA
     ============================================ -->
<section id="multimedia">
    <h2 class="titulo">🎬 Multimedia</h2>

    <div class="multimedia">
        <div class="multimedia-grid">
            <div class="multimedia-item">
                <h3>🎥 Video Promocional</h3>
                <video controls poster="media/tienda.jpg">
                    <source src="media/promo_tienda.mp4" type="video/mp4">
                    Tu navegador no soporta el elemento de video.
                </video>
                <p style="margin-top:8px;color:#666;font-size:14px;">🍬 Conoce nuestra tienda y productos</p>
            </div>
            <div class="multimedia-item">
                <h3>🎵 Música de la Tienda</h3>
                <img src="media/tienda.jpg" alt="Portada de audio" style="width:100%;height:150px;object-fit:cover;border-radius:10px;">
                <audio controls style="width:100%;margin-top:10px;">
                    <source src="media/musica_tienda.mp3" type="audio/mpeg">
                    Tu navegador no soporta el elemento de audio.
                </audio>
                <p style="margin-top:8px;color:#666;font-size:14px;">🎶 Escucha mientras compras</p>
            </div>
        </div>
    </div>
</section>

<!-- ============================================
     FORMULARIO DE CONTACTO
     ============================================ -->
<section id="contacto">
    <h2 class="titulo">📧 Contacto</h2>

    <div class="formulario">
        <form action="guardar.php" method="POST">
            <input type="text" name="nombre" placeholder="Tu nombre completo" required>
            <input type="email" name="correo" placeholder="Tu correo electrónico" required>
            <textarea name="mensaje" placeholder="Escribe tu mensaje aquí..." required></textarea>
            <button type="submit">📩 Enviar Mensaje</button>
        </form>
    </div>
</section>

<!-- ============================================
     DIRECCIÓN Y HORARIO
     ============================================ -->
<section id="direccion">
    <h2 class="titulo">📍 Dirección</h2>

    <div class="direccion">
        <p>📍 Avenida Dulce Vida #456, Colonia Centro</p>
        <p>Estado de México, San Pedro</p>
        <p>📞 Tel: 55 7890 1234</p>
        <p>🕒 Horario: 9:00 AM - 9:00 PM</p>
    </div>
</section>

<?php
// Incluir el pie de página
include("includes/footer.php");

// Cerrar conexión
$conexion = null;
?>
