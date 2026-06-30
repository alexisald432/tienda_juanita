<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Tienda Juanita — Los mejores dulces, botanas y bebidas al mejor precio en Estado de México.">
<title><?php echo isset($page_title) ? $page_title : 'Tienda Juanita — Dulces y Botanas'; ?></title>
<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<!-- ============================================
     HEADER — Encabezado principal
     ============================================ -->
<header id="inicio">
    <h1>🍭 Tienda Juanita</h1>
    <p><?php echo isset($page_subtitle) ? $page_subtitle : 'Los mejores dulces al mejor precio'; ?></p>
    <?php if (isset($total_productos) && $total_productos > 0): ?>
        <p>✨ Tenemos <strong><?php echo $total_productos; ?></strong> productos disponibles para ti</p>
    <?php endif; ?>
</header>

<!-- ============================================
     NAVEGACIÓN — Organización del sitio
     ============================================ -->
<nav>
    <a href="index.php">Inicio</a>
    <a href="index.php#productos">Productos</a>
    <a href="index.php#multimedia">Multimedia</a>
    <a href="contacto.php">Contacto</a>
    <a href="index.php#direccion">Dirección</a>
</nav>
