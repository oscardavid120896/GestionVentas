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
    var eme = $("#email").val();
    var password = document.getElementById("password");

    var em = validarCorreo(eme);
    if (eme == "") {
        addError(email, "Campo requerido");
        bandera = false;
    } else {
        if (em == "") {
            addError(email, "El email es incorrecto");
            bandera = false;
        }else if(em == "Es incorrecta"){
            addError(email, "El email es incorrecto");
            bandera = false;
        }
    }

	if(password.value.trim() == ""){
		addError(password, "Campo Requerido");
		bandera = false;
	}
    return bandera;
}

function validarCorreo(valor){
    var res = "";
    if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(valor)){
        res = "Es correcta";
       } else {
        res = "Es incorrecta";
       }
    return res;
}