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

    // Obtener el precio y peso del producto
    $sql = "SELECT precio, peso FROM productos WHERE id_producto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $producto_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();
    $precio_unitario = $producto['precio'];
    $peso_producto = $producto['peso'];

    // Calcular el peso total para esta cantidad de productos
    $peso_total = $peso_producto * $cantidad;

    // Calcular el costo de embalaje según el peso total
    $costo_embalaje = 0;
    if ($peso_total <= 1) {
        $costo_embalaje = 79 * ceil($peso_total / 1);
    } elseif ($peso_total <= 5) {
        $costo_embalaje = (393 * floor($peso_total / 5)) + (79 * ceil(($peso_total % 5) / 1));
    } else {
        $costo_embalaje = (786 * floor($peso_total / 10)) + (393 * floor(($peso_total % 10) / 5)) + (79 * ceil(($peso_total % 5) / 1));
    }

    // Insertar o actualizar el producto en detalle_carrito con el costo de embalaje
    $sql = "INSERT INTO detalle_carrito (id_carrito, id_producto, cantidad, precio_unitario, costo_embalaje) 
            VALUES (?, ?, ?, ?, ?) 
            ON DUPLICATE KEY UPDATE cantidad = cantidad + VALUES(cantidad), costo_embalaje = costo_embalaje + VALUES(costo_embalaje)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiidd", $carrito_id, $producto_id, $cantidad, $precio_unitario, $costo_embalaje);

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
