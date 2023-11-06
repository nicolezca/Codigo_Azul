let inactivityTimer;

function startInactivityTimer() {
    inactivityTimer = setTimeout(function () {
        // El usuario está inactivo, realizar una solicitud al servidor para cerrar la sesión
        fetch('php/CerrarSesion.php')
            .then(response => {
                // Redirigir al usuario a la página de inicio de sesión u otra página de tu elección
                window.location.href = '../login/formulario.html';
            })
            .catch(error => {
                console.error('Error al cerrar la sesión:', error);
            });
    },46800); // 1 hora 30 media en milisegundos
}

function resetInactivityTimer() {
    clearTimeout(inactivityTimer);
    startInactivityTimer();
}

// Comienza a rastrear la inactividad cuando la página se carga
startInactivityTimer();

// Restablece el temporizador de inactividad cuando el usuario interactúa con la página
document.addEventListener('mousemove', resetInactivityTimer);
document.addEventListener('keydown', resetInactivityTimer);
