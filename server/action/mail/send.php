<?php
require("sendgrid-php/sendgrid-php.php");
$sendgrid = new SendGrid('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');
$email = new SendGrid\Email();
$email
    ->addTo('pixcompu@outlook.com')
    ->setFrom('geekstore@pixcompu.esy.es')
    ->setSubject('Subject goes here')
    ->setText('Hello World!')
    ->setHtml('<strong>Hello World!</strong>');
$sendgrid->send($email);

respondWithSuccess('Email enviado');

