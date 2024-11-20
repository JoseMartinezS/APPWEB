<?php
require '../vendor/autoload.php';
 
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
    'amount' => $_POST['total'] + $_POST['total_embalaje'], // Puedes ajustar el monto según sea necesario
    'description' => 'Compra en tienda',
    'device_session_id' => $_POST['device_session_id'],
    'customer' => $customerData
);
 
try {
    $charge = $openpay->charges->create($chargeData);
    echo 'Cargo creado exitosamente. ID del Cargo: ' . $charge->id;
    // Redirigir a una página de éxito (opcional)
    header("Location: success.html");
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