<?php
/**
 * Created by PhpStorm.
 * User: Marteen Munevar
 * Date: 11/06/2019
 * Time: 11:14 PM
 */

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

$titulo = $_POST['titulo'];
$nombres = $_POST['nombres'];
$emailSolicitante= $_POST['email'];
$prefacio = $_POST['prefacio'];


$to = "carlosacademico2017@gmail.com";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .=    'X-Mailer: PHP/' . phpversion();

$message = "
<html>
<head>
<title>HTML</title>
</head>
<body>
<h1>".$nombres."</h1>
<p>".$prefacio."</p>
<br>
<p>Responder Al siguiente correo: </p>".$emailSolicitante."</body>
</html>";


if (mail($to, $titulo, $message, $headers)) {
    echo json_encode([
        'estado' => 'ok',
        'mensaje' => 'Solicitud enviada, Nos contactaremos al email proporcionado.'
    ]);
}else{
    echo json_encode([
        'estado' => 'Error',
        'mensaje' => 'Error al enviar mensaje'
    ]);
}


