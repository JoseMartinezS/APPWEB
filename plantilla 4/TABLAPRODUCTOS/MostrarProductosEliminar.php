<?php
// Conexión a la base de datos
require_once('../config.inc.php');

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta para obtener los productos
$sql = "SELECT id_producto, nombre, descripcion, precio, imagen, peso FROM productos WHERE status = 1";
$result = $conn->query($sql);
?>

<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Asegúrate de incluir el enlace a Font Awesome en tu archivo HTML -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <title>Lista de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .product-card img {
            width: 100%;
            height: 180px; /* Tamaño fijo */
            object-fit: contain; /* Mantener relación de aspecto sin recortar */
            border-radius: 8px;
            margin-bottom: 15px;
            background-color: #f4f4f4; /* O un color de fondo para relleno si las imágenes no ocupan todo el espacio */
        }

        .product-card h2 {
            font-size: 20px;
            margin: 10px 0;
        }

        .product-card p {
            font-size: 14px;
            color: #555;
            margin-bottom: 15px;
        }

        .product-card .price {
            font-weight: bold;
            font-size: 18px;
            color: #28a745;
            margin-bottom: 15px;
        }

        .product-card .actions {
            display: flex;
            justify-content: space-around;
        }

        .product-card a {
            padding: 10px 15px;
            text-decoration: none;
            color: #fff;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .product-card a.edit {
            background-color: #007bff;
        }

        .product-card a.delete {
            background-color: #dc3545;
        }

        .product-card a:hover {
            opacity: 0.8;
        }
    </style>
</head>
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
                                    <a href="index.html"><img src="../images/logo.png" alt="#" style="width: 150px; height: auto;" /></a>
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
                                            <a class="nav-link" href="MostrarProductosEliminar.php" style="color: rgb(8, 8, 8);" title="Eliminar Producto">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <a class="nav-link" href="Iniciosesion.php" style="color: rgb(10, 10, 10);" title="Login">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a class="nav-link" href="/web/plantilla%204/TABLACARRITO/MostrarProductos.php" style="color: rgb(8, 8, 8);" title="Carrito">
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
    </br>
<h1>Productos Disponibles</h1>

<div class="product-grid">
    <?php
    if ($result->num_rows > 0) {
        // Mostrar los productos en tarjetas
        while($row = $result->fetch_assoc()) {
            // Construir el path de la imagen (preparar para evitar problemas)
            $image_path = '../' . htmlspecialchars($row["imagen"]);
            
            echo "<div class='product-card'>";
            // Mostrar imagen si existe, si no, mostrar una imagen por defecto
            if (!empty($row["imagen"])) {
                echo "<img src='" . $image_path . "' alt='Imagen del producto'>";
            } else {
                echo "<img src='no_image_available.png' alt='No disponible'>";
            }
            echo "<h2>" . htmlspecialchars($row["nombre"]) . "</h2>";
            echo "<p>" . htmlspecialchars($row["descripcion"]) . "</p>";
            echo "<p class='price'>Precio: $" . $row["precio"] . "</p>";
            echo "<p>Peso: " . htmlspecialchars($row["peso"]) . " kg</p>";
            echo "<div class='actions'>
                    <a href='ActualizarProducto.php?id=" . $row["id_producto"] . "' class='edit'>Editar</a>
                    <form action='EliminarProductos.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='id_producto' value='" . $row["id_producto"] . "'>
                        <button type='submit' class='btn btn-danger' onclick='return confirm(\"¿Estás seguro de que quieres eliminar este producto?\")'>Eliminar</button>
                    </form>
                  </div>";
            echo "</div>";
        }
    } else {
        echo "<p>No se encontraron productos</p>";
    }
    ?>
</div>

</body>
</html>

<?php
$conn->close();
?>
