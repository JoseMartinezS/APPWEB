<?php
// Recoger los datos del formulario
$nombre = $_POST["nombre"];
$descripcion = $_POST["descripcion"];
$precio = $_POST["precio"];
$stock = $_POST["stock"];
$peso = $_POST["peso"];

// Configuración de la conexión
require_once('../config.inc.php');

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Manejar la carga de la imagen
$imagen = null;
if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
    $imagen = "uploads/" . basename($_FILES["imagen"]["name"]);
    if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], "../" . $imagen)) {
        die("Error al subir la imagen.");
    }
}

// Preparar la consulta SQL
$sql = "INSERT INTO productos (nombre, descripcion, precio, stock, peso, imagen) 
VALUES ('$nombre', '$descripcion', '$precio', '$stock', '$peso', '$imagen')";

if ($conn->query($sql) === TRUE) {
    // Cerrar conexión
    $conn->close();
    // Redirigir a index.html
    header("Location: ../index.html");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
