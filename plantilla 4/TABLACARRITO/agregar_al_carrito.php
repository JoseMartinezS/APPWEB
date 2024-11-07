<?php
session_start();
require '../config.inc.php';

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];
    $usuario_id = $_SESSION['usuario_id'];

    // Obtener el ID del carrito del usuario o crearlo si no existe
    $sql = "SELECT id_carrito FROM carrito WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $carrito_id = $row['id_carrito'];
    } else {
        $sql = "INSERT INTO carrito (id_usuario) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $carrito_id = $stmt->insert_id;
    }

    // Obtener el precio del producto
    $sql = "SELECT precio FROM productos WHERE id_producto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $producto_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();
    $precio_unitario = $producto['precio'];

    // Insertar o actualizar el producto en detalle_carrito
    $sql = "INSERT INTO detalle_carrito (id_carrito, id_producto, cantidad, precio_unitario) 
            VALUES (?, ?, ?, ?) 
            ON DUPLICATE KEY UPDATE cantidad = cantidad + VALUES(cantidad)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiid", $carrito_id, $producto_id, $cantidad, $precio_unitario);

    if ($stmt->execute()) {
        echo "Producto agregado al carrito en la base de datos.";
    } else {
        echo "Error al agregar el producto al carrito en la base de datos.";
    }

    $stmt->close();
    $conn->close();

    // Redirigir de vuelta a la página de productos o carrito
    header('Location: MostrarProductos.php');
    exit;
}
?>
