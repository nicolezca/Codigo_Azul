<?php
// Inicia la sesión
session_start();

// Destruye la sesión actual
session_destroy();

header('Location: ../../login/formulario.html');
exit();


?>
