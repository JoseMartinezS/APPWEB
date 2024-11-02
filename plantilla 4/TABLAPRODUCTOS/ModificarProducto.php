<?php
// Configuración de la conexión
require_once('../config.inc.php');

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Recoger los datos del formulario
$id_producto = $_POST['id_producto'];
$nombre = $_POST["nombre"];
$descripcion = $_POST["descripcion"];
$precio = $_POST["precio"];
$stock = $_POST["stock"];
$peso = $_POST["peso"];

// Manejar la carga de una nueva imagen (opcional)
$imagen = null;
if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
    $imagen = "uploads/" . basename($_FILES["imagen"]["name"]);
    if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], "../" . $imagen)) {
        die("Error al subir la imagen.");
    }
}

// Imprimir variables para depuración
echo "ID Producto: " . $id_producto . "<br>";
echo "Nombre: " . $nombre . "<br>";
echo "Descripción: " . $descripcion . "<br>";
echo "Precio: " . $precio . "<br>";
echo "Stock: " . $stock . "<br>";
echo "Peso: " . $peso . "<br>";
if ($imagen) echo "Imagen: " . $imagen . "<br>";

// Preparar la consulta SQL
if ($imagen) {
    $sql = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio='$precio', stock='$stock', peso='$peso', imagen='$imagen' WHERE id_producto='$id_producto'";
} else {
    $sql = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio='$precio', stock='$stock', peso='$peso' WHERE id_producto='$id_producto'";
}

// Imprimir consulta SQL para depuración
echo $sql;

if ($conn->query($sql) === TRUE) {
    echo "Producto actualizado correctamente.";
    // Redirigir a la página de productos
    header("Location: ../TABLAPRODUCTOS/MostrarProductosEliminar.php");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();



?>
