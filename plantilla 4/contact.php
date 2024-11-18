<?php
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $phone = $_POST['PhoneNumber'];
    $message = $_POST['Message'];
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $secretKey = "6LdKw24qAAAAAG6a-8T0-A_A3aiVbUKHm5Bimbad";
    $verifyUrl = "https://www.google.com/recaptcha/api/siteverify";

    // Validación simple
    if (empty($name) || empty($email) || empty($message)) {
        header("Location: index.php?status=error");
        exit;
    }

    // Verificación de reCAPTCHA
    $responseCaptcha = file_get_contents($verifyUrl . "?secret=" . $secretKey . "&response=" . $recaptchaResponse);
    $responseKeys = json_decode($responseCaptcha, true);

    if (intval($responseKeys["success"]) !== 1) {
        header("Location: index.php?status=error");
        exit;
    } else {
        // CAPTCHA válido, procede con el envío del correo
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
            header("Location: index.php?status=success");
            exit;
        } catch (Exception $e) {
            header("Location: index.php?status=error");
            exit;
        }
    }
}
