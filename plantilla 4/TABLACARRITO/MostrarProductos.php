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
$sql = "SELECT id_producto, nombre, descripcion, precio, imagen FROM productos";
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
    <title>Mostrar Productos</title>
    <style>
    .card {
        width: 15rem;
        margin: 1rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-img-top {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        justify-content: space-between;
    }

    .btn {
        margin-top: auto;
    }

    .row {
        margin-left: -1rem;
        margin-right: -1rem;
    }

    /* Estilos para el carrito */
    #cart {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 20px;
        background-color: #f9f9f9;
    }

    #cart h5 {
        margin-bottom: 15px;
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

<!-- Contenedor del carrito -->
<div class="container mt-4">
    <div id="cart">
        <h5>Carrito de compras</h5>
        <ul id="cart-items" class="list-group">
            <li class="list-group-item">No hay productos en el carrito</li>
        </ul>
        <p class="mt-2">Total: $<span id="cart-total">0</span></p>
    </div>

    <div class="row">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $image_path = '../' . $row["imagen"];
                echo '<div class="col-3">';
                echo '<div class="card">';
                echo '<img src="' . htmlspecialchars($image_path) . '" class="card-img-top" alt="' . htmlspecialchars($row["nombre"]) . '">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($row["nombre"]) . '</h5>';
                echo '<p class="card-text">' . htmlspecialchars($row["descripcion"]) . '</p>';
                echo '<p class="card-text">Precio: $' . $row["precio"] . '</p>';
                echo '<input type="number" class="form-control mb-2 product-quantity" value="1" min="1" data-id="' . $row["id_producto"] . '" data-name="' . htmlspecialchars($row["nombre"]) . '" data-price="' . $row["precio"] . '">';
                echo '<button class="btn btn-primary add-to-cart" data-id="' . $row["id_producto"] . '" data-name="' . htmlspecialchars($row["nombre"]) . '" data-price="' . $row["precio"] . '">Agregar al Carrito</button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No hay productos disponibles.</p>';
        }
        $conn->close();
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Manejar los productos en el carrito
    let cart = [];
    let cartTotal = 0;

    // Función para actualizar el carrito en la interfaz
    function updateCart() {
        let cartItemsContainer = document.getElementById('cart-items');
        let cartTotalElement = document.getElementById('cart-total');

        // Limpiar la lista actual
        cartItemsContainer.innerHTML = '';

        // Si no hay productos, mostrar un mensaje
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<li class="list-group-item">No hay productos en el carrito</li>';
        } else {
            // Mostrar los productos en el carrito
            cart.forEach(function(item, index) {
                let listItem = document.createElement('li');
                listItem.classList.add('list-group-item');
                listItem.innerHTML = `${item.name} - $${item.price}`;
                cartItemsContainer.appendChild(listItem);
            });
        }

        // Actualizar el total del carrito
        cartTotalElement.innerText = cartTotal.toFixed(2);
    }

    // Manejar el evento de añadir productos al carrito
    document.querySelectorAll('.add-to-cart').forEach(function(button) {
    button.addEventListener('click', function() {
        let productId = this.getAttribute('data-id');
        let productName = this.getAttribute('data-name');
        let productPrice = parseFloat(this.getAttribute('data-price'));

        // Obtener la cantidad seleccionada para este producto
        let quantityInput = this.previousElementSibling; // Seleccionamos el input anterior al botón
        let quantity = parseInt(quantityInput.value);

        // Añadir la cantidad seleccionada al carrito
        for (let i = 0; i < quantity; i++) {
            cart.push({ id: productId, name: productName, price: productPrice });
        }

        // Sumar el total según la cantidad seleccionada
        cartTotal += productPrice * quantity;

        // Actualizar la vista del carrito
        updateCart();
    });
});
</script>
</body>
</html>
