<?php
session_start();
include('../../conexion/conexion.php');

$nombreSala = $_SESSION['nombre'];
$telEnfer = $_SESSION['telefono_enfermero'];
$telDoc = $_SESSION['telefono_doctor'];

// Lista de personal y sus números de teléfono
$personal = array(
    array('telefono' => $telDoc),  // Asegúrate de agregar  al número
    array('telefono' => $telEnfer),  // Asegúrate de agregar al número
    // Agrega más personal aquí si es necesario
);

require '../../vendor/autoload.php';

// Configura tus credenciales de Twilio
$sid = 'AC6ae023acc63e1bfc7f260a0aa57c1cb9';
$token = 'e63f8ef422dd8dc2e67e9134479c43e5';
$fromNumber = '+12255353683';  // Asegúrate de agregar 'whatsapp:' al número

// Crea un cliente Twilio
$client = new Twilio\Rest\Client($sid, $token);

foreach ($personal as $individuo) {
    $destinatario = $individuo['telefono'];
    $mensaje = 'Ha sido solicitado reportarse a la sala: ' . $nombreSala;

    try {
        $message = $client->messages->create(
            $destinatario,
            array(
                'from' => $fromNumber,
                'body' => $mensaje
            )
        );

        // Puedes registrar que se envió un mensaje de WhatsApp o realizar otras acciones aquí
    } catch (Exception $e) {
        // Captura y muestra cualquier error que ocurra
        echo 'Error al enviar el mensaje: ' . $e->getMessage();
    }
}

// Redirige a donde sea necesario después de enviar los mensajes de WhatsApp
//header("Location: ../inicio.php");
