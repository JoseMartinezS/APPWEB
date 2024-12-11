<!-- confirmacion_factura.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleConfirmacion.css">
    <title>Confirmación de Factura</title>
</head>
<body>
    <div class="container">
        <h1>Confirmación de Factura</h1>
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success' && isset($_GET['cfdi_id'])): ?>
            <p>Tu factura ha sido generada con éxito. ID de CFDI: <?php echo htmlspecialchars($_GET['cfdi_id']); ?></p>
            <p>Tu factura ha sido enviada a tu correo electrónico.</p>
        <?php else: ?>
            <p>Hubo un problema al generar la factura. Por favor, inténtalo de nuevo.</p>
        <?php endif; ?>
        <a href="../index.php">Regresar a la tienda</a>
    </div>
</body>
</html>
