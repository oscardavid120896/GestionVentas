/*
Funcion para agregar campos de error
*/
function addError(e, mensaje) {
    var lbl = document.getElementById("lbl" + e.id);
    if (lbl != null) {
        lbl.classList.add("text-danger");
    }

    var feedback = document.getElementById("feedback-" + e.id);
    e.classList.remove("is-valid");
    e.classList.add("is-invalid");
    if (feedback != null) {
        feedback.innerHTML = mensaje;
        feedback.classList.add("invalid-feedback");
    }
}


/*
Función para limpiar campos de errores
*/
function limpiarErrores(form) {
    var elements = form.elements;
    for (let e of elements) {
        var lbl = document.getElementById("lbl" + e.id);
        if (lbl != null) {
            lbl.classList.remove("text-danger");
        }

        var feedback = document.getElementById("feedback-" + e.id);
        if (feedback != null) {
            feedback.innerHTML = "";
        }
        e.classList.remove("is-valid");
        e.classList.remove("is-invalid");
    }
}