$(document).ready(function(){

})

$("#btn1").click(function(){
	validar();
})

const inputs = document.querySelectorAll(".input");


function addcl(){
	let parent = this.parentNode.parentNode;
	parent.classList.add("focus");
}

function remcl(){
	let parent = this.parentNode.parentNode;
	if(this.value == ""){
		parent.classList.remove("focus");
	}
}


inputs.forEach(input => {
	input.addEventListener("focus", addcl);
	input.addEventListener("blur", remcl);
});



function validar() {
    var form = document.getElementById("login");
    limpiarErrores(form);

    var bandera = true;
    var email = document.getElementById("email");
    var password = document.getElementById("password");

    if (email.value.trim() == "") {
        addError(email, "Campo requerido");
        bandera = false;
    } else {
        if (email.value.trim().length < 10) {
            addError(nombre, "El mínimo son 10 cáracteres");
            bandera = false;
        }
    }

	if(password.value.trim() == ""){
		addError(password, "Campo Requerido");
		bandera = false;
	}
    return bandera;
}