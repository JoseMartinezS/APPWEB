<?php
session_start();

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

// Consulta para obtener los productos en el carrito
$sql_carrito = "SELECT p.nombre, p.precio, dc.cantidad, p.imagen, dc.costo_embalaje 
                FROM detalle_carrito dc 
                JOIN productos p ON dc.id_producto = p.id_producto 
                JOIN carrito c ON dc.id_carrito = c.id_carrito 
                WHERE c.id_usuario = ?";
$stmt_carrito = $conn->prepare($sql_carrito);
$stmt_carrito->bind_param("i", $usuario_id);
$stmt_carrito->execute();
$result_carrito = $stmt_carrito->get_result();

// Variables para el total y el costo de embalaje
$total = 0;
$total_embalaje = 0;
$productosCarrito = [];

// Procesar los resultados
while ($row = $result_carrito->fetch_assoc()) {
    $productosCarrito[] = $row;
    $total += $row['precio'] * $row['cantidad'];
    $total_embalaje += $row['costo_embalaje'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Pago</title>
    <script src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>

    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            margin: 20px;
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 1000px;
        }

        /* Contenedores de columnas */
        .column {
            width: 50%;
            padding: 20px;
        }

        /* Estilo del formulario */
        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Checkbox */
        .save-info {
            margin-top: 10px;
        }

        /* Estilo para el contenedor de pasos */
        .step-indicator {
            display: flex;
            margin-bottom: 20px;
        }

        .step {
            flex: 1;
            text-align: center;
            font-weight: bold;
            padding: 10px;
            color: #fff;
            border-radius: 5px;
        }

        .step-active {
            background-color: #007bff;
        }

        .step-inactive {
            background-color: #ccc;
        }

        /* Botón de pago */
        button[type="button"],
        button[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="button"]:hover,
        button[type="submit"]:hover {
            background-color: #218838;
        }

        /* Ocultar el formulario de tarjeta al inicio */
        #cardForm {
            display: none;
        }

        /* Estilo para el contenedor de productos */
        .product-list {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .product-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .product-item img {
            border-radius: 5px;
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .product-item p {
            margin: 0;
        }

        .product-summary {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .product-summary h2 {
            text-align: center;
        }
        .product-summary p.total {
            font-weight: bold;
            margin-top: 15px;
            text-align: right;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Columna Izquierda (Formulario de Información del Cliente y Pago) -->
    <div class="column">
        <!-- Indicador de Pasos -->
        <div class="step-indicator">
            <div id="step1" class="step step-active">1. Información del Cliente</div>
            <div id="step2" class="step step-inactive">2. Información de Pago</div>
        </div>

        <!-- Formulario de Información del Cliente -->
        <div id="customerForm">
            <h2>Información del Cliente</h2>
            <form id="customerInfoForm" action="procesar_cliente.php" method="post">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="nombre" required>
                </div>
                <div class="form-group">
                    <label>Apellidos</label>
                    <input type="text" name="apellidos" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" required>
                </div>
                <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" name="direccion" required>
                </div>
                <div class="form-group">
                    <label>Código Postal</label>
                    <input type="text" name="codigo_postal" required>
                </div>
                <div class="form-group">
                    <label>Ciudad</label>
                    <input type="text" name="ciudad" required>
                </div>
                <div class="form-group">
                    <label>Estado</label>
                    <select name="estado" required>
                        <option value="queretaro">Querétaro</option>
                        <!-- Otros estados -->
                    </select>
                </div>
                <button type="button" onclick="showPaymentForm()">Continuar</button>
            </form>
        </div>

        <!-- Formulario de Pago -->
        <div id="cardForm">
            <h2>Información de Pago</h2>
            <form action="procesar_pago.php" method="post">
                <div class="form-group">
                    <label>Número de Tarjeta</label>
                    <input type="text" name="card_number" required>
                </div>
                <div class="form-group">
                    <label>Nombre en la Tarjeta</label>
                    <input type="text" name="card_name" required>
                </div>
                <div class="form-group">
                    <label>Fecha de Expiración</label>
                    <input type="text" name="expiry_date" placeholder="MM/AA" required>
                </div>
                <div class="form-group">
                    <label>CVV</label>
                    <input type="text" name="cvv" required>
                </div>
                <button type="submit">Pagar</button>
            </form>
        </div>
    </div>

    <!-- Columna Derecha (Resumen de Productos) -->
    <div class="product-summary">
        <h2>Resumen de Productos</h2>
            <?php if (!empty($productosCarrito)): ?>
                <?php foreach ($productosCarrito as $producto): ?>
                    <div class="product-item">
                        <img src="<?php echo htmlspecialchars('../' . $producto['imagen']); ?>" alt="Imagen de <?php echo htmlspecialchars($producto['nombre']); ?>" style="width: 50px; height: 50px; margin-right: 10px;">
                        <div>
                            <p><?php echo htmlspecialchars($producto['nombre']); ?></p>
                            <p>Precio: $<?php echo number_format($producto['precio'], 2); ?></p>
                            <p>Cantidad: <?php echo $producto['cantidad']; ?></p>
                            <p>Costo de embalaje: $<?php echo number_format($producto['costo_embalaje'], 2); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
                <p class="total">Total de productos: $<?php echo number_format($total, 2); ?></p>
                <p class="total">Total Costo de Embalaje: $<?php echo number_format($total_embalaje, 2); ?></p>
                <p class="total">Gran Total: $<?php echo number_format($total + $total_embalaje, 2); ?></p>
            <?php else: ?>
                <p>No hay productos en el carrito.</p>
            <?php endif; ?>
        </div>

    
</div>

<script>
    function showPaymentForm() {
        // Ocultar el formulario de cliente y mostrar el de pago
        document.getElementById("customerForm").style.display = "none";
        document.getElementById("cardForm").style.display = "block";

        // Cambiar el estado de los pasos
        document.getElementById("step1").classList.remove("step-active");
        document.getElementById("step1").classList.add("step-inactive");
        document.getElementById("step2").classList.remove("step-inactive");
        document.getElementById("step2").classList.add("step-active");
    }
</script>

</body>
</html>

