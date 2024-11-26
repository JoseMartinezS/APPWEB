<!DOCTYPE html>
<html>
<head>
    <title>Generar Token y Device Session ID</title>
    <script src="https://js.openpay.mx/openpay.v1.min.js"></script>
    <script src="https://js.openpay.mx/openpay-data.v1.min.js"></script>
</head>
<body>
    <h2>Información de Pago</h2>
    <form id="paymentForm">
        <!-- Información de Pago -->
        <div class="form-group">
            <label>Número de Tarjeta</label>
            <input type="text" name="card_number" id="card_number" data-openpay-card="card_number" required>
        </div>
        <div class="form-group">
            <label>Nombre en la Tarjeta</label>
            <input type="text" name="holder_name" id="holder_name" data-openpay-card="holder_name" required>
        </div>
        <div class="form-group">
            <label>Fecha de Expiración</label>
            <input type="text" name="expiry_month" id="expiry_month" placeholder="MM" data-openpay-card="expiration_month" required>
            <input type="text" name="expiry_year" id="expiry_year" placeholder="AA" data-openpay-card="expiration_year" required>
        </div>
        <div class="form-group">
            <label>CVV</label>
            <input type="text" name="cvv2" id="cvv2" data-openpay-card="cvv2" required>
        </div>
        <input type="hidden" name="device_session_id" id="device_session_id">
        <input type="hidden" name="token_id" id="token_id">
        <button type="button" onclick="generateToken()">Pagar</button>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Inicializar OpenPay
            OpenPay.setId('mesi0huf4n1qrc3uvluo');  // Tu ID de comerciante
            OpenPay.setApiKey('pk_aa4a3ed461a24c7d8ea57b03505299e8');  // Tu API Key pública
            OpenPay.setSandboxMode(true);  // Usa true para modo sandbox, false para producción

            // Generar device session ID
            var deviceSessionId = OpenPay.deviceData.setup("paymentForm", "device_session_id");

            // Mostrar el device session ID en la consola para verificarlo
            console.log("Device Session ID: " + deviceSessionId);
        });

        function generateToken() {
            // Crear el token de forma asíncrona
            OpenPay.token.extractFormAndCreate('paymentForm', success_callback, error_callback);
        }

        function success_callback(response) {
            // Recibir y conservar el token en success_callback
            var token_id = response.data.id;
            document.getElementById('token_id').value = token_id;

            // Enviar el formulario al backend
            var form = document.getElementById('paymentForm');
            form.action = 'test3.php';
            form.method = 'post';
            form.submit();
        }

        function error_callback(response) {
            console.log(response); // Revisar la respuesta completa en la consola
            alert('ERROR al generar el token: ' + response.data.description);
        }
    </script>
</body>
</html>
