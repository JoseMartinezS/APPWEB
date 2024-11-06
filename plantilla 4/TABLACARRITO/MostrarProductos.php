<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "Chicharit1245";
$dbname = "tienda_carrito";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    die('Usuario no autenticado.');
}

$usuario_id = $_SESSION['usuario_id'];

// Consulta para obtener los productos disponibles 
$sql_productos = "SELECT id_producto, nombre, descripcion, precio, imagen, peso FROM productos WHERE status = 1"; 
$result_productos = $conn->query($sql_productos);

// Consulta para obtener los productos del carrito 
$sql_carrito = "SELECT p.nombre, p.precio, dc.cantidad, p.id_producto 
FROM detalle_carrito dc JOIN productos p 
ON dc.id_producto = p.id_producto JOIN carrito c 
ON dc.id_carrito = c.id_carrito WHERE c.id_usuario = ?"; 
$stmt_carrito = $conn->prepare($sql_carrito); 
$stmt_carrito->bind_param("i", $usuario_id); 
$stmt_carrito->execute(); 
$result_carrito = $stmt_carrito->get_result(); 
$total = 0;
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
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Arial', sans-serif;
        }

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

    /* FIN para el carrito */

    /* Estilos para el detalle carrito */
    .cart-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .cart-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            margin-right: 15px;
        }

        .cart-item .cart-details {
            flex-grow: 1;
        }

        .cart-item .cart-price {
            font-weight: bold;
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

<!-- Contenedor del carrito --> 
 <div class="container mt-4"> 
    <div id="cart"> 
        <h5>Carrito de compras</h5> 
        <ul id="cart-items" class="list-group"> 
            <?php if ($result_carrito->num_rows > 0): ?>
                 <?php while ($row = $result_carrito->fetch_assoc()):
                     ?> <li class="list-group-item"> 
                        <?php echo htmlspecialchars($row['nombre']); ?> - $<?php echo number_format($row['precio'], 2); ?> x <?php echo $row['cantidad']; ?> 
                        <?php $total += $row['precio'] * $row['cantidad']; ?>
                     </li> 
                    <?php endwhile; ?> 
                        <?php else: ?>
                         <li class="list-group-item">No hay productos en el carrito</li> 
                        <?php endif; ?> 
                    </ul> <p class="mt-2">Total: $<span id="cart-total"><?php echo number_format($total, 2); ?></span></p> 
                    <button id="checkout-button" class="btn btn-success mt-3" onclick="window.location.href='../PAGO/pago.php'">Comprar</button> 
                </div> 
                
            <div class="row"> 
                <?php if 
                ($result_productos->num_rows > 0) { 
                while($row = $result_productos->fetch_assoc()) { 
                    $image_path = '../' . $row["imagen"]; 
                    echo '<div class="col-3">';
                    echo '<div class="card">'; 
                    echo '<img src="' . htmlspecialchars($image_path) . '" class="card-img-top" alt="' . htmlspecialchars($row["nombre"]) . '">'; 
                    echo '<div class="card-body">'; 
                    echo '<h5 class="card-title">' . htmlspecialchars($row["nombre"]) . '</h5>'; 
                    echo '<p class="card-text">' . htmlspecialchars($row["descripcion"]) . '</p>'; 
                    echo '<p class="card-text">Precio: $' . $row["precio"] . '</p>'; 
                    echo '<form action="agregar_al_carrito.php" method="post">'; 
                    echo '<input type="hidden" name="producto_id" value="' . $row["id_producto"] . '">'; 
                    echo '<input type="number" class="form-control mb-2" name="cantidad" value="1" min="1">'; 
                    echo '<button type="submit" class="btn btn-primary">Agregar al Carrito</button>'; 
                    echo '</form>'; 
                    echo '</div>'; 
                    echo '</div>'; 
                    echo '</div>'; 
                    } 
                } else { 
                    echo '<p>No hay productos disponibles.</p>'; } ?> </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Manejar los productos en el carrito
    let cart = [];
    let cartTotal = 0;
    let totalWeight = 0;

    // Precios de los costales
    const bagPrices = {
        '1kg': 79,
        '5kg': 393,
        '10kg': 786
    };

    // Función que determina cuántos costales son necesarios según el peso total
    function calculatePackaging(totalWeight) {
        let cost = 0;

        // Redondear hacia arriba el peso a la siguiente unidad si el decimal es mayor a 0.50
        totalWeight = Math.ceil(totalWeight); 

        // Comenzamos a restar según el peso redondeado
        while (totalWeight > 0) {
            if (totalWeight >= 10) {
                cost += bagPrices['10kg'];
                totalWeight -= 10;
            } else if (totalWeight >= 5) {
                cost += bagPrices['5kg'];
                totalWeight -= 5;
            } else if (totalWeight >= 1) {
                cost += bagPrices['1kg'];
                totalWeight -= 1;
            }
        }

        return cost;
    }

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
            cart.forEach(function(item) {
                let listItem = document.createElement('li');
                listItem.classList.add('list-group-item');

                // Crear contenido del producto (imagen + detalles)
                listItem.innerHTML = `
                    <div class="cart-item">
                        <img src="${item.image}" alt="${item.name}" style="width: 50px; height: 50px;">
                        <div class="cart-details">
                            <strong>${item.name}</strong>
                            <p>${item.description}</p>
                            <p>Peso: ${item.weight}kg</p>
                        </div>
                        <span class="cart-price">$${item.price}</span>
                    </div>
                `;
                cartItemsContainer.appendChild(listItem);
            });
        }

        // Calcular el costo de los costales según el peso total de los productos
        let packagingCost = calculatePackaging(totalWeight);

        // Actualizar el total del carrito sumando el costo de los productos y el embalaje
        let totalCost = cartTotal + packagingCost;
        cartTotalElement.innerText = totalCost.toFixed(2);
    }

    // Manejar el evento de añadir productos al carrito
    document.querySelectorAll('.add-to-cart').forEach(function(button) {
        button.addEventListener('click', function() {
            let productId = this.getAttribute('data-id');
            let productName = this.getAttribute('data-name');
            let productPrice = parseFloat(this.getAttribute('data-price'));
            let productWeight = parseFloat(this.previousElementSibling.getAttribute('data-weight'));
            let productImage = this.previousElementSibling.getAttribute('data-image');
            let productDescription = this.previousElementSibling.getAttribute('data-description');

            // Obtener la cantidad seleccionada para este producto
            let quantityInput = this.previousElementSibling; 
            let quantity = parseInt(quantityInput.value);

            // Añadir la cantidad seleccionada al carrito
            for (let i = 0; i < quantity; i++) {
                cart.push({
                    id: productId, 
                    name: productName, 
                    price: productPrice, 
                    weight: productWeight, 
                    image: productImage, 
                    description: productDescription 
                });
            }

            // Sumar el peso total de los productos agregados
            totalWeight += productWeight * quantity;

            // Sumar el total según la cantidad seleccionada
            cartTotal += productPrice * quantity;

            // Actualizar la vista del carrito
            updateCart();
        });
    });
</script>



</body>
</html>
$stmt_carrito->close();
$conn->close();
?>