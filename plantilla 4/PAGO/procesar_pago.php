<?php

require 'openpay/Openpay.php';

// Mostrar todos los datos recibidos para depuración
echo '<pre>';
var_dump($_POST);
echo '</pre>';

$openpay = Openpay::getInstance('mesi0huf4n1qrc3uvluo', 'sk_354e89d2b4ff48e48e01af84a0da38de', 'MX', '127.0.0.1');

if (isset($_POST['token_id'])) {
    echo "Token ID: " . $_POST['token_id'] . "<br>";
} else {
    echo "Token ID no está definido. <br>";
}

$chargeData = [
    'method' => 'card',
    'source_id' => $_POST['token_id'],
    'amount' => $total + $total_embalaje,
    'description' => 'Compra en tienda',
    'device_session_id' => $_POST['device_session_id'],
    'customer' => [
        'name' => $_POST['nombre'],
        'last_name' => $_POST['apellidos'],
        'email' => $_POST['email'],
    ],
    'card' => [
        'card_number' => $_POST['card_number'],
        'holder_name' => $_POST['holder_name'],
        'expiry_month' => $_POST['expiry_month'],
        'expiry_year' => $_POST['expiry_year'],
        'cvv2' => $_POST['cvv2']
    ]
];

try {
    $charge = $openpay->charges->create($chargeData);
    // Éxito: Pedido completado
    header("Location: success.php");
} catch (Exception $e) {
    // Error: Manejar el fallo del pago
    echo 'Error: ' . $e->getMessage();
}

?>
