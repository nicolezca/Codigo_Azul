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
});

