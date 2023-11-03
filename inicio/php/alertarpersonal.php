<?php
session_start();

include('../../conexion/conexion.php');

require_once '../../vendor/autoload.php';
use Twilio\Rest\Client;
$sid    = "AC6ae023acc63e1bfc7f260a0aa57c1cb9";
$token  = "457bbf117fce8e0e8c3af4f49f586399";
$twilio = new Client($sid, $token);

$nombreSala = $_SESSION['nombre'];
$telEnfer = $_SESSION['telefono_enfermero'];
$telDoc = $_SESSION['telefono_doctor'];


    $mensaje = 'Ha sido solicitado reportarse a la sala: ' . $nombreSala;    
    $message = $twilio->messages
    ->create(
    "whatsapp:$telEnfer", // to
            array(
                "from" => "whatsapp:+14155238886",
                "body" => "$mensaje"
            )
        );

        print($mensaje);
        // Redirige a donde sea necesario después de enviar los mensajes
//header("Location: ../inicio.php");
