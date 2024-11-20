<?php
require 'vendor/autoload.php';

use Openpay\Data\Openpay;

$isProduction = false; // Cambia a true si estás en producción

$openpay = Openpay::getInstance('mesi0huf4n1qrc3uvluo', 'sk_354e89d2b4ff48e48e01af84a0da38de', 'MX', '127.0.0.1');

// Datos del cliente
$customerData = array(
    'name' => 'Teofilo',
    'last_name' => 'Velazco',
    'email' => 'teofilo@payments.com',
    'phone_number' => '4421112233',
    'address' => array(
        'line1' => 'Privada Rio No. 12',
        'line2' => 'Co. El Tintero',
        'line3' => '',
        'postal_code' => '76920',
        'state' => 'Querétaro',
        'city' => 'Querétaro',
        'country_code' => 'MX'
    )
);

// Datos del cargo
$chargeData = array(
    'method' => 'card',
    'source_id' => $_POST['token_id'], // Usar el token generado desde el frontend
    'amount' => 100,
    'description' => 'Cargo inicial a mi merchant',
    'order_id' => 'ORDEN-00071',
    'device_session_id' => $_POST['device_session_id'], // Recibir el device session ID
    'customer' => $customerData
);

try {
    $charge = $openpay->charges->create($chargeData);
    echo 'Cargo creado exitosamente. ID del Cargo: ' . $charge->id;
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
