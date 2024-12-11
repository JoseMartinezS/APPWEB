<?php
session_start();
require '../config.inc.php'; // Incluir archivo de configuración de base de datos
require '../vendor/autoload.php';
use Facturama\Client;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

// Configuración de la API para el entorno sandbox
$client = new Client('JoseMartinez2002', 'Piece1245', ['url' => 'https://apisandbox.facturama.mx']);

// Establecer la fecha específica (fecha de ayer)
$date = date('Y-m-d\TH:i:s', strtotime('-1 day'));

// Capturar datos del formulario
$id_orden = $_POST['id_orden'];
$rfc = $_POST['rfc'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$correo = $_POST['correo'];

// Aquí se debe obtener la información de la orden usando $id_orden de la base de datos
// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_orden = "SELECT o.total, p.nombre AS producto_nombre, p.descripcion, do.cantidad, p.precio
              FROM ordenes o
              JOIN detalle_orden do ON o.id_orden = do.id_orden
              JOIN productos p ON do.id_producto = p.id_producto
              WHERE o.id_orden = ?";
$stmt_orden = $conn->prepare($sql_orden);
$stmt_orden->bind_param("i", $id_orden);
$stmt_orden->execute();
$result_orden = $stmt_orden->get_result();
$items = [];

while ($row = $result_orden->fetch_assoc()) {
    $items[] = [
        'ProductCode' => '10101504', // Usar un valor conocido válido
        'IdentificationNumber' => 'GENERIC', // Valor genérico
        'Description' => $row['descripcion'],
        'Unit' => 'NO APLICA', // Valor genérico
        'UnitCode' => 'ACT', // Valor genérico
        'UnitPrice' => (float) $row['precio'], // Asegurarnos de que sea un número
        'Quantity' => (float) $row['cantidad'], // Asegurarnos de que sea un número
        'Subtotal' => round($row['precio'] * $row['cantidad'], 2),
        'TaxObject' => '02', // Valor genérico
        'Taxes' => [
            [
                'Total' => round($row['precio'] * $row['cantidad'] * 0.16, 2),
                'Name' => 'IVA',
                'Base' => round($row['precio'] * $row['cantidad'], 2),
                'Rate' => 0.16,
                'IsRetention' => false
            ]
        ],
        'Total' => round($row['precio'] * $row['cantidad'] * 1.16, 2)
    ];
}

// Datos del CFDI
$cfdi = [
    'NameId' => '1',
    'Currency' => 'MXN',
    'Folio' => '100',
    'CfdiType' => 'I',
    'PaymentForm' => '03',
    'PaymentMethod' => 'PUE',
    'OrderNumber' => 'ORDER_' . $id_orden,
    'ExpeditionPlace' => '25680',
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
        'Rfc' => $rfc,
        'CfdiUse' => 'CP01',
        'Name' => $nombre,
        'FiscalRegime' => '601',
        'TaxZipCode' => '86991'
    ],
    'Items' => $items
];

// Función para registrar errores
function logError($message) {
    file_put_contents('C:/Users/pepec/Documents/FACTURAS/error_log.txt', $message . PHP_EOL, FILE_APPEND);
}

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

        // Redirigir a la página de confirmación 
        header("Location: confirmacion_factura.php?status=success&cfdi_id=$cfdi_id"); exit();

    } else {
        echo 'Error al generar el CFDI: ' . json_encode($response, JSON_PRETTY_PRINT);
    }
} catch (Exception $e) {
    logError('Error: ' . $e->getMessage());
    echo 'Error: ' . $e->getMessage();
}
?>
