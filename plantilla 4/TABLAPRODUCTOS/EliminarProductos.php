<?php
// Configuración de la conexión
require_once('../config.inc.php');

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Recoger el ID del producto
$id_producto = $_POST['id_producto'];

// Preparar la consulta SQL para actualizar el status
$sql = "UPDATE productos SET status=0 WHERE id_producto=?";

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_producto);

if ($stmt->execute()) {
    // Redirigir a la página principal después de la actualización
    header("Location: ../TABLAPRODUCTOS/MostrarProductosEliminar.php");
    exit;
} else {
    echo "Error al actualizar el producto: " . $stmt->error;
}

$conn->close();
?>
