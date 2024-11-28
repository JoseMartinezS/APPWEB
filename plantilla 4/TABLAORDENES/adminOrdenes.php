<?php
session_start();
require '../config.inc.php';

// Verificar si el usuario es un administrador
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    die('Acceso denegado.');
}

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Actualizar estado de la orden si se envía el formulario
if (isset($_POST['update_status'])) {
    $id_orden = $_POST['id_orden'];
    $nuevo_estado = $_POST['estado'];
    $sql_update = "UPDATE ordenes SET estado = ? WHERE id_orden = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("si", $nuevo_estado, $id_orden);
    $stmt_update->execute();
    echo "Estado de la orden actualizado exitosamente.";
}

// Filtrar y ordenar las órdenes
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';

$sql_ordenes = "SELECT * FROM ordenes WHERE 1=1";

if ($start_date) {
    $sql_ordenes .= " AND fecha_orden >= '$start_date'";
}

if ($end_date) {
    $sql_ordenes .= " AND fecha_orden <= '$end_date'";
}

$sql_ordenes .= " ORDER BY fecha_orden $order";

$result_ordenes = $conn->query($sql_ordenes);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Órdenes</title>
    <link rel="stylesheet" href="adminStyles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>Administrar Órdenes</h1>
    
    <!-- Filtros -->
    <div class="admin-filters">
        <form id="filter-form" method="GET" action="adminOrdenes.php">
            <label for="start-date">Fecha de Inicio:</label>
            <input type="date" id="start-date" name="start_date" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">
            
            <label for="end-date">Fecha de Fin:</label>
            <input type="date" id="end-date" name="end_date" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>">
            
            <label for="order">Ordenar por Fecha:</label>
            <select id="order" name="order">
                <option value="asc" <?php echo isset($_GET['order']) && $_GET['order'] == 'asc' ? 'selected' : ''; ?>>Ascendente</option>
                <option value="desc" <?php echo isset($_GET['order']) && $_GET['order'] == 'desc' ? 'selected' : ''; ?>>Descendente</option>
            </select>
            
            <button type="submit" class="admin-filter-button">Filtrar</button>
        </form>
    </div>
    
    <div class="admin-orders-container">
        <?php while ($row = $result_ordenes->fetch_assoc()): ?>
        <div class="admin-order-card">
            <div class="admin-order-details">
                <p><strong>ID Orden:</strong> <?php echo htmlspecialchars($row['id_orden']); ?></p>
                <p><strong>ID Usuario:</strong> <?php echo htmlspecialchars($row['id_usuario']); ?></p>
                <p><strong>Total:</strong> <?php echo htmlspecialchars($row['total']); ?></p>
                <p><strong>Fecha:</strong> <?php echo htmlspecialchars($row['fecha_orden']); ?></p>
                <p><strong>Estado:</strong> <?php echo htmlspecialchars($row['estado']); ?></p>
                <form action="adminOrdenes.php" method="post" class="admin-update-form">
                    <input type="hidden" name="id_orden" value="<?php echo $row['id_orden']; ?>">
                    <select name="estado">
                        <option value="Pendiente" <?php if ($row['estado'] == 'Pendiente') echo 'selected'; ?>>Pendiente</option>
                        <option value="En Proceso" <?php if ($row['estado'] == 'En Proceso') echo 'selected'; ?>>En Proceso</option>
                        <option value="Completada" <?php if ($row['estado'] == 'Completada') echo 'selected'; ?>>Completada</option>
                    </select>
                    <button type="submit" name="update_status">Actualizar</button>
                </form>
                <button type="button" class="admin-view-details-button btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailsModal" data-id="<?php echo $row['id_orden']; ?>">Ver Detalles</button>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Detalles de la Orden</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Aquí se cargarán los detalles de la orden con Ajax -->
                </div>
            </div>
        </div>
    </div>

    <script>
    $('#detailsModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var orderId = button.data('id');
        var modal = $(this);

        $.ajax({
            url: 'fetchOrderDetails.php',
            type: 'GET',
            data: { id_orden: orderId },
            success: function (response) {
                modal.find('.modal-body').html(response);
            }
        });
    });
    </script>

</body>
</html>



