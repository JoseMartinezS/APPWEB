<?php
require 'vendor/autoload.php';

use Openpay\Data\Openpay;

$isProduction = TRUE; // Cambia a true si estás en producción

$openpay = Openpay::getInstance('mesi0huf4n1qrc3uvluo', 'sk_354e89d2b4ff48e48e01af84a0da38de', 'MX', '127.0.0.1');

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
			'city' => 'Querétaro.',
			'country_code' => 'MX'
            
        )
    );
    

    try { 
        $customer = $openpay->customers->add($customerData); 
        echo 'Cliente agregado exitosamente. ID del Cliente: ' . $customer->id; 
    } catch (Exception $e) { echo 'Error: ' . $e->getMessage(); 
        // Puedes agregar más manejo de errores aquí si es necesario 
    }
?>



