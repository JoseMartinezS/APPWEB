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
                WHERE c.id_usuario = ? AND p.status = 1";
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
    <link rel="stylesheet" href="stylePago.css">

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
<form id="customerInfoForm" action="procesar_pago.php" method="post">
<div class="form-group">
<label>Nombre</label>
<input type="text" name="nombre" id="nombre" required>
</div>
<div class="form-group">
<label>Apellidos</label>
<input type="text" name="apellidos" id="apellidos" required>
</div>
<div class="form-group">
<label>Email</label>
<input type="email" name="email" id="email" required>
</div>
<div class="form-group">
<label>Teléfono</label>
<input type="text" name="telefono" id="telefono" required>
</div>
<div class="form-group">
<label>Dirección</label>
<input type="text" name="direccion" id="direccion" required>
</div>
<div class="form-group">
<label>Dirección Línea 2</label>
<input type="text" name="direccion_linea2" id="direccion_linea2">
</div>
<div class="form-group">
<label>Dirección Línea 3</label>
<input type="text" name="direccion_linea3" id="direccion_linea3">
</div>
<div class="form-group">
<label>Código Postal</label>
<input type="text" name="codigo_postal" id="codigo_postal" required>
</div>
<div class="form-group">
<label>Ciudad</label>
<input type="text" name="ciudad" id="ciudad" required>
</div>
<div class="form-group">
<label>Estado</label>
<select name="estado" id="estado" required>
<option value="coahuila">Coahuila</option>
<option value="queretaro">Querétaro</option>
<!-- Otros estados -->
</select>
</div>
<button type="button" onclick="showPaymentForm()">Continuar</button>
</form>
</div>
 
<!-- Formulario de Pago -->
<div id="cardForm" style="display: none;">
<h2>Información de Pago</h2>
<form action="procesar_pago.php" method="post" id="paymentForm">
<div class="form-group">
<label>Número de Tarjeta</label>
<input type="text" name="card_number" id="card_number" data-openpay-card="card_number" required>
</div>
<div class="form-group">
<label>Nombre en la Tarjeta</label>
<input type="text" name="holder_name" id="holder_name" data-openpay-card="holder_name" required>
</div>
<div class="form-group">
<label>Fecha de Expiración</label>
<input type="text" name="expiry_month" id="expiry_month" placeholder="MM" data-openpay-card="expiration_month" required>
<input type="text" name="expiry_year" id="expiry_year" placeholder="AA" data-openpay-card="expiration_year" required>
</div>
<div class="form-group">
<label>CVV</label>
<input type="text" name="cvv2" id="cvv2" data-openpay-card="cvv2" required>
</div>
<div class="form-group">
<label>Dirección de la Tarjeta</label>
<input type="text" name="billing_address_line1" required>
</div>
<div class="form-group">
<label>Dirección Línea 2</label>
<input type="text" name="billing_address_line2">
</div>
<div class="form-group">
<label>Dirección Línea 3</label>
<input type="text" name="billing_address_line3">
</div>
<div class="form-group">
<label>Código Postal</label>
<input type="text" name="billing_postal_code" required>
</div>
<div class="form-group">
<label>Ciudad</label>
<input type="text" name="billing_city" required>
</div>
<div class="form-group">
<label>Estado</label>
<select name="billing_state" required>
<option value="coahuila">Coahuila</option>
<option value="queretaro">Querétaro</option>
<!-- Otros estados -->
</select>
</div>
<input type="hidden" name="billing_country_code" value="MX">
<input type="hidden" name="device_session_id" id="device_session_id">
<input type="hidden" name="token_id" id="token_id">
<!-- Campos Ocultos para la Información del Cliente -->
<input type="hidden" name="nombre" id="hidden_nombre">
<input type="hidden" name="apellidos" id="hidden_apellidos">
<input type="hidden" name="email" id="hidden_email">
<input type="hidden" name="telefono" id="hidden_telefono">
<input type="hidden" name="direccion" id="hidden_direccion">
<input type="hidden" name="direccion_linea2" id="hidden_direccion_linea2">
<input type="hidden" name="direccion_linea3" id="hidden_direccion_linea3">
<input type="hidden" name="codigo_postal" id="hidden_codigo_postal">
<input type="hidden" name="ciudad" id="hidden_ciudad">
<input type="hidden" name="estado" id="hidden_estado">

<!-- Campos Ocultos para la Costo del Carrito -->
<input type="hidden" name="total" id="total">
<input type="hidden" name="total_embalaje" id="total_embalaje">

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
// Configuración de OpenPay
OpenPay.setId('mesi0huf4n1qrc3uvluo');
OpenPay.setApiKey('pk_aa4a3ed461a24c7d8ea57b03505299e8'); // Asegúrate de usar la API key pública aquí
OpenPay.setSandboxMode(true); // Cambia a false para producción
 
// Genera device_session_id para antifraude
OpenPay.deviceData.setup("paymentForm", "device_session_id");
 
function showPaymentForm() {
    // Ocultar el formulario de cliente y mostrar el de pago
    document.getElementById("customerForm").style.display = "none";
    document.getElementById("cardForm").style.display = "block";
 
    // Transferir datos del formulario del cliente a campos ocultos del formulario de pago
    document.getElementById("hidden_nombre").value = document.getElementById("nombre").value;
    document.getElementById("hidden_apellidos").value = document.getElementById("apellidos").value;
    document.getElementById("hidden_email").value = document.getElementById("email").value;
    document.getElementById("hidden_telefono").value = document.getElementById("telefono").value;
    document.getElementById("hidden_direccion").value = document.getElementById("direccion").value;
    document.getElementById("hidden_direccion_linea2").value = document.getElementById("direccion_linea2").value;
    document.getElementById("hidden_direccion_linea3").value = document.getElementById("direccion_linea3").value;
    document.getElementById("hidden_codigo_postal").value = document.getElementById("codigo_postal").value;
    document.getElementById("hidden_ciudad").value = document.getElementById("ciudad").value;
    document.getElementById("hidden_estado").value = document.getElementById("estado").value;

    // Transferir los valores de total y total de embalaje
    document.getElementById("total").value = <?php echo json_encode($total); ?>;     
    document.getElementById("total_embalaje").value = <?php echo json_encode($total_embalaje); ?>;
 
    // Cambiar el estado de los pasos
    document.getElementById("step1").classList.remove("step-active");
    document.getElementById("step1").classList.add("step-inactive");
    document.getElementById("step2").classList.remove("step-inactive");
    document.getElementById("step2").classList.add("step-active");
}
 
// Captura el evento de envío del formulario de pago
document.getElementById("paymentForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita el envío automático del formulario
 
    // Extrae los datos del formulario y crea el token
    console.log("Datos del formulario antes de crear el token:");
    var formData = new FormData(document.getElementById("paymentForm"));
    for (var pair of formData.entries()) {
        console.log(pair[0]+ ': ' + pair[1]);
    }
 
    OpenPay.token.extractFormAndCreate('paymentForm', successCallback, errorCallback);
});
 
function successCallback(response) {
    const token_id = response.data.id;
 
    // Crear un campo oculto para el token y añadirlo al formulario
    let tokenInput = document.createElement("input");
    tokenInput.setAttribute("type", "hidden");
    tokenInput.setAttribute("name", "token_id");
    tokenInput.setAttribute("value", token_id);
    document.getElementById("paymentForm").appendChild(tokenInput);
 
    // Enviar el formulario con el token añadido
    console.log("Enviando formulario con token_id:", token_id);
    document.getElementById("paymentForm").submit();
}
 
function errorCallback(response) {
    console.log("Error al crear el token:", response); // Mostrar el contenido de response en la consola
    alert("Error: " + (response.data ? response.data.description : "Error desconocido"));
}
</script>

</body>
</html>

