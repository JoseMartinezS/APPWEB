<?php
session_start(); // Iniciar la sesión

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "Chicharit1245"; // La variable correcta es 'password'
$dbname = "tienda_carrito";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener las credenciales del formulario
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

// Consulta para obtener el usuario
$sql = "SELECT * FROM usuarios WHERE correo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    // Verificar la contraseña hasheada
    if (password_verify($contrasena, $user['contrasena'])) {
        $_SESSION['usuario_id'] = $user['id_usuario']; // Asegúrate de establecer el ID del usuario en la sesión
        $_SESSION['usuario'] = $user['nombre']; // Usar el nombre del usuario
        $_SESSION['correo'] = $user['correo']; // Guardar el correo del usuario
        $_SESSION['is_admin'] = $user['is_admin']; // Verificar si es administrador
        header('Location: index.php'); // Redirigir a la página principal
        exit;
    } else {
        echo 'Correo o contraseña incorrectos';
    }
} else {
    echo 'Correo o contraseña incorrectos';
}

$stmt->close();
$conn->close();
?>
