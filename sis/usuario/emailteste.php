<?php
$to = 'alegomes.16@hotmail.com';  // Substitua pelo e-mail de destino
$subject = 'Teste de Envio de E-mail';
$message = 'Este e um teste de envio de e-mail usando o Gmail via XAMPP.';
$headers = 'From: alegomes.160591@gmail.com' . "\r\n" .
           'Reply-To: alegomes.160591@gmail.com' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();

if (mail($to, $subject, $message, $headers)) {
    echo 'E-mail enviado com sucesso!';
} else {
    echo 'Falha no envio do e-mail.';
}
?>