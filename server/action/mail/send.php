<?php
require("sendgrid-php/sendgrid-php.php");
require_once('../../autoloader.php');

$destinatary = $_POST['destinatary'];
$message = $_POST['message'];

$sendgrid = new SendGrid('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');
$email = new SendGrid\Email();
$email
    ->addTo('luis.burgos.1995@gmail.com')
    ->addTo('pixcompu@outlook.com')
    ->addTo('mdoming@uady.mx')
    ->setFrom($destinatary)
    ->setSubject('Nuevo contacto de GeekStore2')
    ->setText($message)
    ->setHtml('<strong>'.$message.'</strong>');
$sendgrid->send($email);

respondWithSuccess('Tu opinion es muy valiosa, ¡Gracias!');

