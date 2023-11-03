
document.addEventListener("DOMContentLoaded", function () {
    function toggleFormVisibility(buttonId, formId) {
        const btn = document.getElementById(buttonId);
        const form = document.getElementById(formId);
    
        form.style.transform = "translateX(-100%)";
    
        btn.addEventListener("click", function () {
            if (form.style.transform === "translateX(-100%)") {
                form.style.transform = "translateX(0)";
            } else {
                form.style.transform = "translateX(-100%)";
            }
        });
    }
    
    toggleFormVisibility("mostrarFormulario", "formDoc");
    toggleFormVisibility("pacienteExistente", "HistorialNuevo");
    
    
    
    //filtrado por DNI y ESTADO(alta,baja,espera)
    const filterDniInput = document.getElementById("filter_dni");
    const filterEstadoInput = document.getElementById("filter_estado");
    const aplicarFiltroButton = document.getElementById("aplicarFiltro");
    const tablaResultado = document.getElementById("Tabla").getElementsByTagName('tbody')[0];

    aplicarFiltroButton.addEventListener("click", function () {
        const dni = filterDniInput.value.toLowerCase();
        const estado = filterEstadoInput.value.toLowerCase();
        filtrarTabla(dni,estado);
    });

    function filtrarTabla(dni, estado) {
        const filas = tablaResultado.getElementsByTagName("tr");
        for (let i = 0; i < filas.length; i++) {
            const fila = filas[i];
            const columnas = fila.getElementsByTagName("td");
            const dniColumna = columnas[3].textContent.toLowerCase(); // Columna de DNI
            const estadoColumna = columnas[6].textContent.toLowerCase(); // Columna del estado
            if ((dniColumna.includes(dni) || dni === "") && (estadoColumna.includes(estado) || estado ==="") ) {
                fila.style.display = "table-row";
            } else {
                fila.style.display = "none";
            }
        }
    }
});
