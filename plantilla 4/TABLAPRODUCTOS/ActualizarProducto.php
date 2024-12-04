<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="icon" href="../images/fevicon.png" type="image/gif" />

    <style>
        body {
            background-color: #e6f9e6;
            font-family: 'Arial', sans-serif;
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

<?php
// Conexión a la base de datos
require_once('../config.inc.php');

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Comprobar si se ha recibido el ID del producto
if (isset($_GET['id'])) {
    $id_producto = intval($_GET['id']);

    // Consulta para obtener los datos del producto
    $sql = "SELECT * FROM productos WHERE id_producto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    // Comprobar si el producto existe
    if (!$producto) {
        echo "Producto no encontrado.";
        exit;
    }
} else {
    echo "ID de producto no proporcionado.";
    exit;
}

// Procesar el formulario de actualización si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idProducto = intval($_POST['idProducto']);
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    $peso = floatval($_POST['peso']);
    $imagen = $_FILES['imagen']['name'] ? "uploads/" . basename($_FILES['imagen']['name']) : null;

    // Manejar la carga de la imagen
    if ($imagen) {
        move_uploaded_file($_FILES["imagen"]["tmp_name"], "../" . $imagen);
        $sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=?, peso=?, imagen=? WHERE id_producto=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdiisi", $nombre, $descripcion, $precio, $stock, $peso, $imagen, $idProducto);
    } else {
        $sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=?, peso=? WHERE id_producto=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdiis", $nombre, $descripcion, $precio, $stock, $peso, $idProducto);
    }

    if ($stmt->execute()) {
        // Redirigir a la página principal después de la actualización
        header("Location: TABLAPRODUCTOS/MostrarProductosEliminar.php");
        exit;
    } else {
        echo "Error al actualizar el producto: " . $stmt->error;
    }
}

// Cerrar la conexión
$conn->close();
?>

<section class="h-100 h-custom">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-8 col-xl-6">
                <div class="card rounded-3">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 px-md-2">Editar Producto</h3>

                        <!-- Formulario para editar el producto -->
                        <form action="ModificarProducto.php?id=<?= $producto['id_producto'] ?>" method="POST" enctype="multipart/form-data">

                            <!-- Campo oculto para el ID del producto -->
                            <input type="hidden" name="id_producto" value="<?= $producto['id_producto'] ?>">

                            <div class="form-outline mb-4">
                                <input type="text" name="nombre" id="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre']) ?>" required />
                                <label class="form-label" for="nombre">Nombre del Producto</label>
                            </div>

                            <div class="form-outline mb-4">
                                <textarea name="descripcion" id="descripcion" class="form-control" rows="4" required><?= htmlspecialchars($producto['descripcion']) ?></textarea>
                                <label class="form-label" for="descripcion">Descripción</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="number" step="0.01" name="precio" id="precio" class="form-control" value="<?= htmlspecialchars($producto['precio']) ?>" required />
                                <label class="form-label" for="precio">Precio</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="number" name="stock" id="stock" class="form-control" value="<?= htmlspecialchars($producto['stock']) ?>" required />
                                <label class="form-label" for="stock">Stock</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="number" step="0.01" name="peso" id="peso" class="form-control" value="<?= htmlspecialchars($producto['peso']) ?>" required />
                                <label class="form-label" for="peso">Peso(KG)</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" />
                                <label class="form-label" for="imagen">Imagen del Producto (opcional)</label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg mb-1">Actualizar Producto</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



</body>
</html>
