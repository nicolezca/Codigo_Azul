<?php 
session_start();
include('../../conexion/conexion.php');

    $nombreSala = $_SESSION['nombre'];

require '../../vendor/autoload.php';

// Configura tus credenciales de Twilio
$sid = 'AC6ae023acc63e1bfc7f260a0aa57c1cb9';
$token = '8a5f1b1fdce554c04e07bdc6b739384e';
$fromNumber = '+12255353683';

// Crea un cliente Twilio
$client = new Twilio\Rest\Client($sid, $token);

// Número de teléfono de destino y mensaje
$destinatario =  '+542241562603'; 
$mensaje = 'ha sido solicitado reportese a la sala: ' . $nombreSala ;

// Envía el SMS
try {
    $message = $client->messages->create(
        $destinatario,
        array(
            'from' => $fromNumber,
            'body' => $mensaje
        )
    );
    header(
        "Location:../inicio.php"
    );
    //header(
      //  "Location: ../../pages/llamado/atencion.php");
    //exit();
} catch (Exception $e) {
    // Captura y muestra cualquier error que ocurra
    echo 'Error al enviar el mensaje: ' . $e->getMessage();
}


?>