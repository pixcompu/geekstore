<?php

require("sendgrid-php/sendgrid-php.php");
require_once('../../autoloader.php');

try{
    validateFields(
        array(
            'destinatary' => 'Proporciona un destinatario',
            'message' => 'Proporciona un mensaje'
        )
    );

    $destinatary = $_POST['destinatary'];
    $message = $_POST['message'];

    $sendgrid = new SendGrid('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');
    $email = new SendGrid\Email();
    $email
        ->addTo($destinatary)
        ->addCc('luis.burgos.1995@gmail.com')
        ->addCc('elsy_pinzonv@hotmail.com')
        ->addCc('mdoming@correo.uady.mx')
        ->setFrom('geekstore@pixcompu.esy.es')
        ->setSubject('Nuevo Contacto de ' . $destinatary)
        ->setText($message)
        ->setHtml('<p>'.$message.'</p>');
    $sendgrid->send($email);
    respondWithSuccess('Email enviado');

}catch(Exception $e){
    if( $e->getCode() == FIELD_NOT_FOUND){
        respondWithError($e->getMessage());
    }else{
        respondWithError('No se pudo enviar tu mensaje, aún puedes mantanarte en contacto con nosotros a través de ventas@geektore.com');
    }
}


