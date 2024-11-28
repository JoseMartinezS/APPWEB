<?php
require '../vendor/autoload.php';
require '../config.inc.php';

session_start();

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

use Openpay\Data\Openpay;

$isProduction = false; // Cambia a true si estás en producción

$openpay = Openpay::getInstance('mesi0huf4n1qrc3uvluo', 'sk_354e89d2b4ff48e48e01af84a0da38de', 'MX', '127.0.0.1');

if (isset($_POST['token_id'])) {
    echo "Token ID: " . $_POST['token_id'] . "<br>";
} else {
    echo "Token ID no está definido. <br>";
    exit;
}

// Datos del cliente
$customerData = array(
    'name' => $_POST['nombre'],
    'last_name' => $_POST['apellidos'],
    'email' => $_POST['email'],
    'phone_number' => $_POST['telefono'],
    'address' => array(
        'line1' => $_POST['direccion'],
        'line2' => $_POST['direccion_linea2'],
        'line3' => $_POST['direccion_linea3'],
        'postal_code' => $_POST['codigo_postal'],
        'state' => $_POST['estado'],
        'city' => $_POST['ciudad'],
        'country_code' => 'MX'
    )
);

// Datos del cargo
$chargeData = array(
    'method' => 'card',
    'source_id' => $_POST['token_id'],
    'amount' => $_POST['total'] + $_POST['total_embalaje'],
    'description' => 'Compra en tienda',
    'device_session_id' => $_POST['device_session_id'],
    'customer' => $customerData
);

try {
    // Inserta la orden en la base de datos
    $fecha_orden = date('Y-m-d H:i:s');
    $estado = 'Pendiente'; // Estado inicial de la orden
    $total = $_POST['total'] + $_POST['total_embalaje'];
    $direccion = $_POST['direccion'];
    $direccion_linea2 = $_POST['direccion_linea2'];
    $direccion_linea3 = $_POST['direccion_linea3'];
    $codigo_postal = $_POST['codigo_postal'];
    $ciudad = $_POST['ciudad'];
    $estado_envio = $_POST['estado'];
    $pago_id = null; // Definido como null inicialmente

    $sql_orden = "INSERT INTO ordenes (id_usuario, total, fecha_orden, estado, pago_id, direccion_envio, direccion_linea2, direccion_linea3, codigo_postal, ciudad, estado_envio) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt_orden = $conn->prepare($sql_orden);
    $stmt_orden->bind_param("idsssssssss",
        $usuario_id,
        $total,
        $fecha_orden,
        $estado,
        $pago_id,
        $direccion,
        $direccion_linea2,
        $direccion_linea3,
        $codigo_postal,
        $ciudad,
        $estado_envio
    );
    $stmt_orden->execute();

    $id_orden = $conn->insert_id; // Obtener el ID de la orden insertada

    // Obtener productos del carrito
    $sql_carrito = "SELECT p.id_producto, dc.cantidad, p.precio, dc.costo_embalaje 
                    FROM detalle_carrito dc 
                    JOIN productos p ON dc.id_producto = p.id_producto 
                    JOIN carrito c ON dc.id_carrito = c.id_carrito 
                    WHERE c.id_usuario = ? AND p.status = 1";
    $stmt_carrito = $conn->prepare($sql_carrito);
    $stmt_carrito->bind_param("i", $usuario_id);
    $stmt_carrito->execute();
    $result_carrito = $stmt_carrito->get_result();
    $productosCarrito = [];

    while ($row = $result_carrito->fetch_assoc()) {
        $productosCarrito[] = $row;
    }

    // Inserta los detalles de la orden en la base de datos
    foreach ($productosCarrito as $producto) {
        $id_producto = $producto['id_producto'];
        $cantidad = $producto['cantidad'];
        $precio = $producto['precio'];
        $costo_embalaje = $producto['costo_embalaje'];

        $sql_detalle = "INSERT INTO detalle_orden (id_orden, id_producto, cantidad, precio_unitario, costo_embalaje)
                        VALUES (?, ?, ?, ?, ?)";
        $stmt_detalle = $conn->prepare($sql_detalle);
        $stmt_detalle->bind_param("iiidd",
            $id_orden,
            $id_producto,
            $cantidad,
            $precio,
            $costo_embalaje
        );
        $stmt_detalle->execute();
    }

    // Procesar el pago con OpenPay
    $charge = $openpay->charges->create($chargeData);

    // Actualizar el estado de la orden y el pago ID
    $estado_completado = 'En Proceso';
    $charge_id = $charge->id;

    $sql_update_orden = "UPDATE ordenes SET estado = ?, pago_id = ? WHERE id_orden = ?";
    $stmt_update_orden = $conn->prepare($sql_update_orden);
    $stmt_update_orden->bind_param("ssi", $estado_completado, $charge_id, $id_orden);
    $stmt_update_orden->execute();

    echo 'Cargo creado exitosamente. ID del Cargo: ' . $charge->id;

    // Vaciar el carrito de compras
    $sql_vaciar_carrito = "DELETE dc FROM detalle_carrito dc
                          JOIN carrito c ON dc.id_carrito = c.id_carrito
                          WHERE c.id_usuario = ?";
    $stmt_vaciar_carrito = $conn->prepare($sql_vaciar_carrito);
    $stmt_vaciar_carrito->bind_param("i", $usuario_id);
    $stmt_vaciar_carrito->execute();

    // Redirigir a la página de éxito
    header("Location: success.html?order_id=$id_orden");

} catch (OpenpayApiTransactionError $e) {
    echo 'ERROR en la transacción: ' . $e->getMessage() . ' [request_id: ' . $e->getRequestId() . ']';
} catch (OpenpayApiRequestError $e) {
    echo 'ERROR en la petición: ' . $e->getMessage();
} catch (OpenpayApiConnectionError $e) {
    echo 'ERROR en la conexión a Openpay: ' . $e->getMessage();
} catch (OpenpayApiAuthError $e) {
    echo 'ERROR en la autenticación: ' . $e->getMessage();
} catch (OpenpayApiError $e) {
    echo 'ERROR en Openpay: ' . $e->getMessage();
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
