<?php 
session_start();
include('../../conexion/conexion.php');

    $nombreSala = $_SESSION['nombre'];
    $telEnfer = $_SESSION['telefono_enfermero'];
    $telDoc = $_SESSION['telefono_doctor'];

    // Lista de personal y sus números de teléfono
$personal = array(
    array('telefono' => $telDoc),
    array('telefono' => $telEnfer),
    // Agrega más personal aquí si es necesario
);

require '../../vendor/autoload.php';

// Configura tus credenciales de Twilio
$sid = 'AC6ae023acc63e1bfc7f260a0aa57c1cb9';
$token = '8a5f1b1fdce554c04e07bdc6b739384e';
$fromNumber = '+12255353683';

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

        // Puedes registrar que se envió un mensaje a $nombre o realizar otras acciones aquí
    } catch (Exception $e) {
        // Captura y muestra cualquier error que ocurra
        echo 'Error al enviar el mensaje a ' . $nombre . ': ' . $e->getMessage();
    }
}
// Redirige a donde sea necesario después de enviar los mensajes
header("Location: ../inicio.php");
//Asegúrate de reemplazar $telDoc y $telEnfer con los números de teléfono reales de tu personal y ajustar el bucle según tus necesidades. Esto enviará mensajes a cada destinatario en la lista de personal.
?>