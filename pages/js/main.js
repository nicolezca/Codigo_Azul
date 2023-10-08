document.addEventListener("DOMContentLoaded", function () {

    const btnform = document.getElementById("mostrarFormulario");
    const formulario = document.getElementById("formDoc");

    formulario.style.transform = "translateX(-100%)";

    btnform.addEventListener("click", function () {
        if (formulario.style.transform === "translateX(-100%)") {
            formulario.style.transform = "translateX(0)";
        } else {
            formulario.style.transform = "translateX(-100%)";
        }
    });

    //Filtrado por matricula del personal
    const filterMatriculaSelect = document.getElementById("filter_matricula");
    const aplicarFiltroButton = document.getElementById("aplicarFiltro");
    const tablaResultado = document.getElementById("Tabla").getElementsByTagName('tbody')[0];

    //funcion a la hora de hacer click se crea un evento
    aplicarFiltroButton.addEventListener("click", function () {
        const matricula = filterMatriculaSelect.value.toLowerCase();
        filtrarTabla(matricula);
    });
    //funcion de filtrado mediante una recorrigo por la tabla coincidiendo con la columna propuesta
    function filtrarTabla( matricula) {
        const filas = tablaResultado.getElementsByTagName("tr");

        for (let i = 0; i < filas.length; i++) {
            const fila = filas[i];
            const columnas = fila.getElementsByTagName("td");

            const matriculaColumna = columnas[4].textContent.toLowerCase(); // Columna de matricula
            //parametros si se cumple la funcion
            if ((matriculaColumna .includes(matricula) || matricula === "")) {
                fila.style.display = "table-row";
            } else {
                fila.style.display = "none";
            }
        }
    }
});
