<?php
require 'vendor/autoload.php';

use Openpay\Data\Openpay;

$isProduction = false; // Cambia a true si estás en producción

$openpay = Openpay::getInstance('mesi0huf4n1qrc3uvluo', 'sk_354e89d2b4ff48e48e01af84a0da38de', 'MX', '127.0.0.1');

$cardData = array(
    'holder_name' => 'Luis Pérez',
    'card_number' => '4111111111111111',
    'cvv2' => '123',
    'expiration_month' => '12',
    'expiration_year' => '24',
    'address' => array(
        'line1' => 'Av. 5 de Febrero No. 1',
        'line2' => 'Col. Felipe Carrillo Puerto',
        'line3' => 'Zona industrial Carrillo Puerto',
        'postal_code' => '76920',
        'state' => 'Querétaro',
        'city' => 'Querétaro',
        'country_code' => 'MX'
    )
);

try {
    $card = $openpay->cards->add($cardData);
    echo 'Tarjeta agregada exitosamente. ID de la Tarjeta: ' . $card->id;
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
