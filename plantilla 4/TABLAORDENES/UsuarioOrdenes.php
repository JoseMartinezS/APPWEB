<?php
session_start();
require '../config.inc.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    die('Usuario no autenticado.');
}

$usuario_id = $_SESSION['usuario_id'];

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener todas las órdenes del usuario
$sql_ordenes_usuario = "SELECT o.id_orden, o.total, o.fecha_orden, o.estado, p.nombre, p.imagen, do.cantidad
                        FROM ordenes o
                        JOIN detalle_orden do ON o.id_orden = do.id_orden
                        JOIN productos p ON do.id_producto = p.id_producto
                        WHERE o.id_usuario = ?";
$stmt_ordenes_usuario = $conn->prepare($sql_ordenes_usuario);
$stmt_ordenes_usuario->bind_param("i", $usuario_id);
$stmt_ordenes_usuario->execute();
$result_ordenes_usuario = $stmt_ordenes_usuario->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
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
                                        <a class="nav-link" href="../TABLAORDENES/misCompras.php">Compras</a>
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
                                <a class="nav-link" href="../TABLACARRITO/MostrarProductos.php" style="color: rgb(8, 8, 8);" title="Carrito">
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
    
    <h1>Compras</h1>
    <div class="compras-orders-container">
        <?php while ($row = $result_ordenes_usuario->fetch_assoc()): ?>
        <div class="compras-order-card">
            <img src="<?php echo htmlspecialchars('../' . $row['imagen']); ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>" class="compras-product-image">
            <div class="compras-order-details">
                <span class="compras-order-status <?php echo strtolower(str_replace(' ', '-', $row['estado'])); ?>"><?php echo htmlspecialchars($row['estado']); ?></span>
                <h2><?php echo htmlspecialchars($row['nombre']); ?></h2>
                <p>Cantidad: <?php echo htmlspecialchars($row['cantidad']); ?></p>
                <p>Fecha: <?php echo htmlspecialchars($row['fecha_orden']); ?></p>
            </div>
            <div class="compras-order-actions">
                <a href="facturacion.php?id_orden=<?php echo $row['id_orden']; ?>" class="compras-facturar-button">Generar Factura</a>
                <a href="cart.php" class="compras-buy-again-button">Volver a comprar</a>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    <br>
    <br>
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
