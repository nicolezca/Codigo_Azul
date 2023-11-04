document.addEventListener("DOMContentLoaded",  () => {
    let emergenciaForm = document.getElementById('formularioSala');
    let btnEmergencia = document.getElementById('btnLlamado');
    
    emergenciaForm.style.transform = "translateX(-100%)";

    btnEmergencia.addEventListener('click', function(){
        if(emergenciaForm.style.transform === "translateX(-100%)"){
            emergenciaForm.style.transform = "translateX(0)";
        }else{
            emergenciaForm.style.transform = "translateX(-100%)";
        }
    })

    emergenciaForm.addEventListener('submit', function() {
        var sonido = document.getElementById('sonido');
        sonido.play();
        
        setTimeout(function() {
            sonido.pause();
            sonido.currentTime = 0;
        }, 8000);
    });

    const btnSesion = document.getElementById('CerrarSesion');
    const cardSesion = document.getElementById('cardSesion');
    //const btnCerrarSesion = document.getElementById('sesionCerrada');

    cardSesion.style.top = '-100%';

    btnSesion.addEventListener('click', function() {
        if(cardSesion.style.top === '-100%'){
            cardSesion.style.top ='0%';
        }else{
            cardSesion.style.top = '-100%';
        }
    }
    )



});

