window.addEventListener('DOMContentLoaded', () => {

    /* imagen */

    var img = document.querySelector('.imagen')
    const rol = localStorage.getItem('rol');      // 'cliente', 'proveedor', etc.
    const genero = localStorage.getItem('genero'); // 'femenino', 'masculino', 'otro'

    // Verificar valores
    console.log("Rol seleccionado:", rol);
    console.log("Género seleccionado:", genero);


    if( rol == "cliente"){
        if( genero == "masculino"){
            img.innerHTML = '<img src="../img/RECURSOS/Ilustraciones/1-Cliente/masculino.svg">';
        }if(genero == "femenino"){
            img.innerHTML = '<img src="../img/RECURSOS/Ilustraciones/1-Cliente/Femenino.svg">';
        }if(genero == "otro"){
            img.innerHTML = '<img src="../img/RECURSOS/Ilustraciones/1-Cliente/trans.svg">';
        }
    }if( rol == "proveedor"){
        if( genero == "masculino"){
            img.innerHTML = '<img src="../img/RECURSOS/Ilustraciones/2-Proveedor/masculino.svg">';
        }if(genero == "femenino"){
            img.innerHTML = '<img src="../img/RECURSOS/Ilustraciones/2-Proveedor/Femenino.svg">';
        }if(genero == "otro"){
            img.innerHTML = '<img src="../img/RECURSOS/Ilustraciones/2-Proveedor/trans.svg">';
        }
    }

    /* Fecha */
    const dias = document.getElementById("col-dia");
    const meses = document.getElementById("col-mes");
    const anios = document.getElementById("col-anio");

    function agregarEspacios(col) {
        for (let i = 0; i < 1; i++) {
        const empty = document.createElement("div");
        empty.className = "picker-option";
        empty.textContent = "";
        col.appendChild(empty);
        }
    }

    function generarOpciones() {
        // Día
        agregarEspacios(dias);
        for (let i = 1; i <= 31; i++) {
        const el = document.createElement("div");
        el.className = "picker-option";
        el.textContent = i;
        dias.appendChild(el);
        }
        agregarEspacios(dias);

        // Mes
        const mesesNombres = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
        agregarEspacios(meses);
        for (let i = 0; i < 12; i++) {
        const el = document.createElement("div");
        el.className = "picker-option";
        el.textContent = mesesNombres[i];
        el.setAttribute("data-value", (i + 1).toString().padStart(2, '0'));
        meses.appendChild(el);
        }
        agregarEspacios(meses);

        // Año
        agregarEspacios(anios);
        const currentYear = new Date().getFullYear();
        for (let i = currentYear; i >= 1900; i--) {
        const el = document.createElement("div");
        el.className = "picker-option";
        el.textContent = i;
        anios.appendChild(el);
        }
        agregarEspacios(anios);
    }

    function highlightCenter(column) {
        const options = column.querySelectorAll('.picker-option');
        const center = column.scrollTop + 40;
        options.forEach(opt => opt.classList.remove("selected"));
        options.forEach(opt => {
        if (opt.offsetTop <= center && opt.offsetTop + 40 > center) {
            opt.classList.add("selected");
        }
        });
    }

    [dias, meses, anios].forEach(col => {
        col.addEventListener("scroll", () => {
        clearTimeout(col._timeout);
        col._timeout = setTimeout(() => {
            const nearest = Math.round(col.scrollTop / 40);
            col.scrollTo({ top: nearest * 40, behavior: "smooth" });
            highlightCenter(col);
        }, 100);
        });
    });

    window.onload = () => {
        generarOpciones();
        dias.scrollTop = 14 * 40;
        meses.scrollTop = 11 * 40;
        anios.scrollTop = (new Date().getFullYear() - 1990 + 2) * 40; // +2 por espacios
        [dias, meses, anios].forEach(col => highlightCenter(col));
    };
});

// Función global para enviar la fecha
window.enviarFecha = function() {
    const dias = document.getElementById("col-dia");
    const meses = document.getElementById("col-mes");
    const anios = document.getElementById("col-anio");
    
    const dia = dias.querySelector('.selected')?.textContent.padStart(2, '0');
    const mes = meses.querySelector('.selected')?.getAttribute('data-value');
    const anio = anios.querySelector('.selected')?.textContent;

    if (!dia || !mes || !anio) {
        alert("Selecciona correctamente la fecha.");
        return false;
    }

    document.getElementById("fecha_nacimiento").value = `${anio}-${mes}-${dia}`;
    console.log("Fecha seleccionada:", `${anio}-${mes}-${dia}`); // Para depuración
    return true;
}