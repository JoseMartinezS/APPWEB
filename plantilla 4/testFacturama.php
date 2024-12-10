<?php
require 'vendor/autoload.php';
use Facturama\Client;

// Configuración de la API
$client = new Client('JoseMartinez2002', 'Piece1245', ['url' => 'https://api.facturama.mx']);

// Verificación de la conexión
try {
    $accounts = $client->get('Client');
    if (!empty($accounts) && is_array($accounts)) {
        foreach ($accounts as $account) {
            echo 'Conexión exitosa con Facturama. Cuenta: ' . $account->Email . '<br>';
        }
    } else {
        echo 'No se pudo obtener la cuenta.';
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

?>