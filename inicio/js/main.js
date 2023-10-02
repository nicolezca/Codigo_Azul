let emergenciaForm = document.getElementById('formularioSala');
let btnEmergencia = document.getElementById('btnLlamado');

btnEmergencia.addEventListener('click', function(){
    if(emergenciaForm.style.right === "-100%"){
        emergenciaForm.style.right="0";
    }else{
        emergenciaForm.style.right="-100%";
    }
})