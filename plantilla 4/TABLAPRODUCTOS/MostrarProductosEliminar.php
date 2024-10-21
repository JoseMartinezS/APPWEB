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

<!DOCTYPE html>
<html lang="es">
<head>
    
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="icon" href="../images/fevicon.png" type="image/gif" />
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
                                    <a class="nav-link" href="../index.html">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#about">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="service.html">Services</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="gallery.html">Gallery</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#testimonial">Testimonial</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-primary" href="test.php">Contact Us</a>
                                </li>
                            </ul>
                            <div class="navbar-icons">
                                <a class="nav-link" href="../Iniciosesion.php" style="color: rgb(10, 10, 10);" title="Login">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </a>
                                <a class="nav-link" href="../TABLAPRODUCTOS/RegisterProducto.php" style="color: rgb(12, 12, 12);" title="Registrar Producto">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </a>
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
