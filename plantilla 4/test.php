<?php
require 'vendor/autoload.php';

use Openpay\Data\Openpay;

$openpay = Openpay::getInstance('mesi0huf4n1qrc3uvluo', 'sk_354e89d2b4ff48e48e01af84a0da38de', 'MX', false);
echo "SDK de OpenPay instalado correctamente!";
