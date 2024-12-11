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
    <!-- Asegúrate de incluir el enlace a Font Awesome en tu archivo HTML -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="styleOrdenesUsuario.css">

      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Rizomat</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="../css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="../css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="../css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="../images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="../css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <!--[if lt IE 9]>]-->
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 20px;
        }
</style>
<body>
<header>
    <!-- header inner -->
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-3 col logo_section">
                    <div class="full">
                        <div class="center-desk">
                            <div class="logo">
                                <a href="index.html"><img src="../images/logo.png" alt="#" style="width: 300px; height: auto;" /></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 offset-md-1">
                    <nav class="navigation navbar navbar-expand-md navbar-dark">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="../index.php">Inicio</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../about.php">Acerca</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../valores.php">Valores</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../productos.php">Productos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../proceso.php">Proceso</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../contactanos.php">Contactanos</a>
                                </li>
                                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="../TABLAORDENES/adminOrdenes.php">Órdenes</a>
                                    </li>
                                <?php endif; ?>
                                <?php if (isset($_SESSION['usuario'])): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="../TABLAORDENES/UsuarioOrdenes.php">Compras</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                            <div class="navbar-icons">
                                <?php if (isset($_SESSION['usuario'])): ?>
                                    <span class="nav-link" style="color: rgb(10, 10, 10);" title="Usuario"><?php echo $_SESSION['usuario']; ?></span>
                                    <a class="nav-link" href="../logout.php" style="color: rgb(10, 10, 10);" title="Cerrar Sesión">
                                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                                    </a>
                                    <?php if ($_SESSION['is_admin']): ?>
                                        <a class="nav-link" href="../TABLAPRODUCTOS/RegisterProducto.php" style="color: rgb(12, 12, 12);" title="Registrar Producto">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </a>
                                        <a class="nav-link" href="../TABLAPRODUCTOS/MostrarProductosEliminar.php" style="color: rgb(8, 8, 8);" title="Eliminar Producto">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a class="nav-link" href="../Iniciosesion.php" style="color: rgb(10, 10, 10);" title="Login">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </a>
                                <?php endif; ?>
                                <a class="nav-link" href="TABLACARRITO/MostrarProductos.php" style="color: rgb(8, 8, 8);" title="Carrito">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>

    <br>
    
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

    <footer>
   <div class="footer">
      <div class="container">
         <div class="row">
            <div class="col-md-3 col-sm-6">
               <ul class="social_icon">
                  <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                  <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                  <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                  <li><a href="https://www.instagram.com/rizomatss?igsh=MThtdG54ZWNwdXBpMg==" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>

               </ul>
               <p class="variat pad_roght2">Nuestros chetos de embalaje son una solución ecológica, ideales para proteger tus productos durante el envío.</p>
            </div>
            <div class="col-md-3 col-sm-6">
               <h3>TE AYUDAMOS?</h3>
               <p class="variat pad_roght2">Ofrecemos soluciones de embalaje que cuidan el medio ambiente y aseguran la integridad de tus envíos.</p>
            </div>
            <div class="col-md-3 col-sm-6">
               <h3>INFORMACIÓN</h3>
               <ul class="link_menu">
                  <li><a href="index.html">Inicio</a></li>
                  <li><a href="about.html">Acerca de</a></li>
                  <li><a href="service.html">Servicios</a></li>
                  <li><a href="gallery.html">Galería</a></li>
                  <li><a href="testimonial.html">Testimonios</a></li>
                  <li><a href="contact.html">Contáctanos</a></li>
               </ul>
            </div>
            <div class="col-md-3 col-sm-6">
               <h3>NUESTRO Diseño</h3>
               <p class="variat">Cuidamos del planeta con productos de embalaje sostenibles y eficaces.</p>
            </div>
            
         </div>
      </div>
      <div class="copyright">
         <div class="container">
            <div class="row">
               <div class="col-md-10 offset-md-1">
                  <p>© 2024 Todos los derechos reservados. Rizomat
               </div>
            </div>
         </div>
      </div>
   </div>
</footer>

</body>

</html>



