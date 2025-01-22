<?php
$to = "dep.sistemas.caap@gmail.com"; // Cambia esto a tu correo de prueba
$subject = "Correo de prueba APP del dominio";
$message = "Este es un correo de prueba desde el servidor.";
$headers = "From: info@ambatoshop.com";

if (mail($to, $subject, $message, $headers)) {
    echo "Correo enviado exitosamente.";
} else {
    echo "Fallo al enviar el correo.";
}
?>
