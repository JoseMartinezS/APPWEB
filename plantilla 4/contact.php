<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incluye la clase autoload generada por Composer
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $phone = $_POST['PhoneNumber'];
    $message = $_POST['Message'];

    // Validación simple
    if(empty($name) || empty($email) || empty($message)) {
        echo 'Por favor, completa todos los campos obligatorios.';
        exit;
    }

    $mail = new PHPMailer(true);
    
    try {
        // Configuración del servidor SMTP (Gmail)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'josedejesusmartinezsilva@gmail.com'; // Tu correo de Gmail
        $mail->Password = 'rkqufgfqtbdejjki'; // La contraseña de tu cuenta de Gmail o una contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Encriptación TLS
        $mail->Port = 587; // El puerto SMTP (TLS = 587)

        // Configuración del correo
        $mail->setFrom('josedejesusmartinezsilva@gmail.com', 'Nombre'); // Remitente
        $mail->addAddress('josedejesusmartinezsilva@gmail.com'); // Destinatario (puedes cambiarlo si es otro correo)

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje de contacto';
        $mail->Body = "<p><strong>Nombre:</strong> $name</p>
                       <p><strong>Email:</strong> $email</p>
                       <p><strong>Teléfono:</strong> $phone</p>
                       <p><strong>Mensaje:</strong><br>$message</p>";

        // Enviar el correo
        $mail->send();
        echo 'El mensaje ha sido enviado exitosamente.';
    } catch (Exception $e) {
        echo "El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}";
    }
}
?>
