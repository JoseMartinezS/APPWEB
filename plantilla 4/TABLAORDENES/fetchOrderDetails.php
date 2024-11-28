<?php
require '../config.inc.php';

$id_orden = $_GET['id_orden'];

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener los detalles de la orden y los datos del usuario
$sql_orden = "SELECT o.id_orden, o.fecha_orden, o.estado, o.direccion_envio, o.direccion_linea2, o.direccion_linea3, o.codigo_postal, o.ciudad, o.estado_envio, u.nombre, u.correo, u.telefono 
              FROM ordenes o 
              LEFT JOIN usuarios u ON o.id_usuario = u.id_usuario 
              WHERE o.id_orden = ?";
$stmt_orden = $conn->prepare($sql_orden);
$stmt_orden->bind_param("i", $id_orden);
$stmt_orden->execute();
$result_orden = $stmt_orden->get_result();
$orden = $result_orden->fetch_assoc();

// Verificar que los datos no sean null
$nombre_cliente = isset($orden['nombre']) ? htmlspecialchars($orden['nombre']) : 'N/A';
$correo_cliente = isset($orden['correo']) ? htmlspecialchars($orden['correo']) : 'N/A';
$telefono_cliente = isset($orden['telefono']) ? htmlspecialchars($orden['telefono']) : 'N/A';
$direccion_envio = isset($orden['direccion_envio']) ? htmlspecialchars($orden['direccion_envio']) : '';
$direccion_linea2 = isset($orden['direccion_linea2']) ? htmlspecialchars($orden['direccion_linea2']) : '';
$direccion_linea3 = isset($orden['direccion_linea3']) ? htmlspecialchars($orden['direccion_linea3']) : '';
$codigo_postal = isset($orden['codigo_postal']) ? htmlspecialchars($orden['codigo_postal']) : '';
$ciudad = isset($orden['ciudad']) ? htmlspecialchars($orden['ciudad']) : '';
$estado_envio = isset($orden['estado_envio']) ? htmlspecialchars($orden['estado_envio']) : '';

// Obtener los productos de la orden
$sql_detalles_orden = "SELECT p.nombre, p.imagen, do.cantidad, do.precio_unitario, do.costo_embalaje 
                       FROM detalle_orden do 
                       JOIN productos p ON do.id_producto = p.id_producto 
                       WHERE do.id_orden = ?";
$stmt_detalles_orden = $conn->prepare($sql_detalles_orden);
$stmt_detalles_orden->bind_param("i", $id_orden);
$stmt_detalles_orden->execute();
$result_detalles_orden = $stmt_detalles_orden->get_result();
?>

<div class="admin-details-container">
    <div class="admin-details-card">
        <div class="admin-order-general-details">
            <h2>Información General</h2>
            <p><strong>ID Orden:</strong> <?php echo htmlspecialchars($orden['id_orden']); ?></p>
            <p><strong>Fecha de Creación:</strong> <?php echo htmlspecialchars($orden['fecha_orden']); ?></p>
            <p><strong>Nombre del Cliente:</strong> <?php echo $nombre_cliente; ?></p>
            <p><strong>Email del Cliente:</strong> <?php echo $correo_cliente; ?></p>
            <p><strong>Teléfono del Cliente:</strong> <?php echo $telefono_cliente; ?></p>
            <p><strong>Dirección de Envío:</strong> <?php echo $direccion_envio . ', ' . $direccion_linea2 . ', ' . $direccion_linea3 . ', ' . $codigo_postal . ', ' . $ciudad . ', ' . $estado_envio; ?></p>
        </div>
    </div>
    <?php while ($row = $result_detalles_orden->fetch_assoc()): ?>
    <div class="admin-details-card">
        <img src="<?php echo htmlspecialchars('../' . $row['imagen']); ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>" class="admin-product-image">
        <div class="admin-product-details">
            <h2><?php echo htmlspecialchars($row['nombre']); ?></h2>
            <p><strong>Cantidad:</strong> <?php echo htmlspecialchars($row['cantidad']); ?></p>
            <p><strong>Precio Unitario:</strong> <?php echo htmlspecialchars($row['precio_unitario']); ?></p>
            <p><strong>Subtotal:</strong> <?php echo htmlspecialchars($row['cantidad'] * $row['precio_unitario']); ?></p>
            <p><strong>Costo de Embalaje:</strong> <?php echo htmlspecialchars($row['costo_embalaje']); ?></p>
        </div>
    </div>
    <?php endwhile; ?>
</div>
