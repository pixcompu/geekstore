<?php
require_once('../../autoloader.php');
define('SUBJECT', 'Contact From');
define('EMAIL_FROM', 'geekstore@geekstore.com');

$destinatary = $_POST['destinatary'];
$subject = SUBJECT;
$message = $_POST['message'];
$headers =
    "From: " . EMAIL_FROM . "\r\n" .
    "CC: ". $destinatary;
mail(
    $destinatary,
    $subject,
    $message,
    $headers
);

respondWithSuccess('Correo Enviado');

