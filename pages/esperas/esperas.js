document.addEventListener("DOMContentLoaded", function () {

    const btn = document.getElementById('mostrarFormulario');
    const form = document.getElementById('formularioAtender');

    form.style.transform ="translateX(-100%)"
    btn.addEventListener('click', () => {
        if (form.style.transform === "translateX(-100%)") {
            form.style.transform = "translateX(0)";
        } else {
            form.style.transform = "translateX(-100%)";
        }
    })



});
