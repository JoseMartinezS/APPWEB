<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $phone = $_POST['PhoneNumber'];
    $message = $_POST['Message'];

    $to = 'pepe.chuy2001@hotmail.com'; // Cambia a tu dirección de correo
    $subject = 'Nuevo mensaje de contacto';
    $body = "Nombre: $name\nEmail: $email\nTeléfono: $phone\nMensaje: $message";

    if (mail($to, $subject, $body)) {
        echo "Mensaje enviado con éxito.";
    } else {
        echo "Error al enviar el mensaje.";
    }
}
?>
