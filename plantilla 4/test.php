<?php
$servername = "localhost";
$username = "root"; 
$contrasena = "Chicharit1245";   
$dbname = "tienda_carrito"; 

// Crear conexión
$conn = new mysqli($servername, $username, $contrasena, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Conexión exitosa";
$conn->close();
?>
