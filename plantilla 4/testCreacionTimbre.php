<?php
require 'vendor/autoload.php';
use Facturama\Client;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

// Configuración de la API para el entorno sandbox
$client = new Client('JoseMartinez2002', 'Piece1245', ['url' => 'https://apisandbox.facturama.mx']);

// Establecer la fecha específica (fecha de ayer)
$date = date('Y-m-d\TH:i:s', strtotime('-1 day'));

// Datos del CFDI
$cfdi = [
    'NameId' => '1',
    'Currency' => 'MXN',
    'Folio' => '100',
    'Serie' => null,
    'CfdiType' => 'I',
    'PaymentForm' => '03',
    'PaymentMethod' => 'PUE',
    'OrderNumber' => 'TEST-001',
    'ExpeditionPlace' => '25680', // Código postal en tu perfil fiscal
    'Date' => $date, // Fecha específica ajustada
    'PaymentConditions' => 'CREDITO A SIETE DIAS',
    'Observations' => 'Elemento Observaciones solo visible en PDF',
    'Exportation' => '01',
    'Issuer' => [
        'Rfc' => 'EKU9003173C9',
        'Name' => 'ESCUELA KEMPER URGATE',
        'FiscalRegime' => '601'
    ],
    'Receiver' => [
        'Rfc' => 'URE180429TM6',
        'CfdiUse' => 'CP01',
        'Name' => 'UNIVERSIDAD ROBOTICA ESPAÑOLA',
        'FiscalRegime' => '601',
        'TaxZipCode' => '86991'
    ],
    'Items' => [
        [
            'ProductCode' => '10101504',
            'IdentificationNumber' => 'EDL',
            'Description' => 'Estudios de laboratorio',
            'Unit' => 'NO APLICA',
            'UnitCode' => 'MTS',
            'UnitPrice' => 50,
            'Quantity' => 2.0,
            'Subtotal' => 100,
            'TaxObject' => '02',
            'Taxes' => [
                [
                    'Total' => 16,
                    'Name' => 'IVA',
                    'Base' => 100,
                    'Rate' => 0.16,
                    'IsRetention' => false
                ]
            ],
            'Total' => 116
        ],
        [
            'ProductCode' => '10101504',
            'IdentificationNumber' => '001',
            'Description' => 'SERVICIO DE COLOCACION',
            'Unit' => 'NO APLICA',
            'UnitCode' => 'E49',
            'UnitPrice' => 100.0,
            'Quantity' => 15.0,
            'Subtotal' => 1500.0,
            'Discount' => 0.0,
            'TaxObject' => '02',
            'Taxes' => [
                [
                    'Total' => 240.0,
                    'Name' => 'IVA',
                    'Base' => 1500.0,
                    'Rate' => 0.16,
                    'IsRetention' => false
                ]
            ],
            'Total' => 1740.0
        ]
    ]
];

// Función para registrar errores
function logError($message) {
    file_put_contents('C:/Users/pepec/Documents/FACTURAS/error_log.txt', $message . PHP_EOL, FILE_APPEND);
}

// Timbrar el CFDI
try {
    $response = $client->post('3/cfdis', $cfdi);
    if (isset($response->Id)) {
        echo 'CFDI generado y timbrado correctamente.<br>';
        // Descargar el XML y el PDF del CFDI
        $cfdi_id = $response->Id;

        // Obtener URLs de descarga de XML y PDF desde la API
        $xmlUrl = "https://apisandbox.facturama.mx/Cfdi/xml/issued/$cfdi_id";
        $pdfUrl = "https://apisandbox.facturama.mx/Cfdi/pdf/issued/$cfdi_id";

        // Crear un cliente Guzzle para hacer las solicitudes GET con autenticación
        $guzzleClient = new GuzzleClient();

        // Descargar el XML
        try {
            $xmlResponse = $guzzleClient->get($xmlUrl, [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode('JoseMartinez2002:Piece1245')
                ]
            ]);
            $xmlData = json_decode($xmlResponse->getBody()->getContents(), true);
            if (isset($xmlData['Content'])) {
                $xml = base64_decode($xmlData['Content']);
                file_put_contents('C:/Users/pepec/Documents/FACTURAS/archivo.xml', $xml);
                echo 'XML descargado correctamente.<br>';
            } else {
                logError('Contenido XML no válido: ' . json_encode($xmlData));
                echo 'Error al descargar el XML.<br>';
            }
        } catch (RequestException $e) {
            logError('Error al descargar el XML: ' . $e->getMessage());
            echo 'Error al descargar el XML: ' . $e->getMessage() . '<br>';
        }

        // Descargar el PDF
        try {
            $pdfResponse = $guzzleClient->get($pdfUrl, [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode('JoseMartinez2002:Piece1245')
                ]
            ]);
            $pdfData = json_decode($pdfResponse->getBody()->getContents(), true);
            if (isset($pdfData['Content'])) {
                $pdf = base64_decode($pdfData['Content']);
                file_put_contents('C:/Users/pepec/Documents/FACTURAS/archivo.pdf', $pdf);
                echo 'PDF descargado correctamente.<br>';
            } else {
                logError('Contenido PDF no válido: ' . json_encode($pdfData));
                echo 'Error al descargar el PDF.<br>';
            }
        } catch (RequestException $e) {
            logError('Error al descargar el PDF: ' . $e->getMessage());
            echo 'Error al descargar el PDF: ' . $e->getMessage() . '<br>';
        }

    } else {
        echo 'Error al generar el CFDI: ' . json_encode($response, JSON_PRETTY_PRINT);
    }
} catch (Exception $e) {
    logError('Error: ' . $e->getMessage());
    echo 'Error: ' . $e->getMessage();
}
?>
