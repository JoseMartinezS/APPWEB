<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "Chicharit1245";
$dbname = "tienda_carrito";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    die(json_encode(['success' => false, 'message' => 'Usuario no autenticado.']));
}

$usuario_id = $_SESSION['usuario_id'];
$input = json_decode(file_get_contents('php://input'), true);

// Validar entrada
if (!isset($input['productId']) || !is_numeric($input['productId'])) {
    die(json_encode(['success' => false, 'message' => 'ID de producto inválido o datos incompletos.']));
}

$productId = intval($input['productId']);

// Eliminar producto del detalle_carrito
$sql = "
    DELETE dc
    FROM detalle_carrito dc
    JOIN carrito c ON dc.id_carrito = c.id_carrito
    WHERE c.id_usuario = ? AND dc.id_producto = ?
";
$stmt = $conn->prepare($sql);

// Comprobar si la preparación del statement fue exitosa
if (!$stmt) {
    die(json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta: ' . $conn->error]));
}

$stmt->bind_param("ii", $usuario_id, $productId);

// Ejecutar la consulta y verificar si se eliminó algún registro
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Producto eliminado del carrito.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Producto no encontrado en el carrito.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error al eliminar el producto del carrito: ' . $stmt->error]);
}

// Cerrar statement y conexión
$stmt->close();
$conn->close();
?>
