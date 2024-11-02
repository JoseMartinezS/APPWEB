<?php
// Recoger los datos del formulario
$nombre = $_POST["nombre"];
$correo = $_POST["correo"];
$telefono = $_POST["telefono"];
$direccion = $_POST["direccion"];
$contrasena = $_POST["contrasena"];

// Configuración de la conexión
require_once('../config.inc.php');

// Hashear la contraseña
$hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Preparar la consulta SQL
$sql = "INSERT INTO usuarios (nombre, correo, telefono, direccion, contrasena) 
VALUES ('$nombre', '$correo', '$telefono', '$direccion', '$hashedPassword')";

if ($conn->query($sql) === TRUE) {
    // Cerrar conexión
    $conn->close();
    // Redirigir a index.html
    header("Location: ../Iniciosesion.php");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
