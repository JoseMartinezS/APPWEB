<?php
session_start();
session_destroy(); // Destruir la sesión
header('Location: Iniciosesion.php'); // Redirigir a la página de inicio de sesión
exit;
?>
