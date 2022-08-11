/*
Leer el documento
*/
$(document).ready(function() {
    listarA();
    $("#mensaje").hide();
    $("#mensajeE").hide();
    $("#grupo").change(function(){
        idgrupo = $(this).val();
        listarP(idgrupo);
    })
});

//Función para listar Alumnos
function listarA(){
    $('#alumnos').DataTable({
        destroy: true,
        //processing: true,
        serverSide: true,
        ajax: {url: "/directivo/alumnos/e"},
        columns: [
           { data: 'name' },
           { data: 'apellidos' },
           { data: 'email' },
           { data: 'grupo' },
           { 
               data: 'id',
               render:function(data,type,row){
                   return '<a class="fas fa-users-cog fa-1x" style="color:green;" onClick="modalEditar('+data+');" data-toggle="tooltip" data-placement="left" title="Editar Datos Usuario"></a>&nbsp;&nbsp;&nbsp; ' +
                   '<a class="fas fa-trash-alt fa-1x" style="color:red;" onClick="eliminar('+data+');" data-toggle="tooltip" data-placement="left" title="Eliminar Usuario"></a>'
               },
               targets: -1,className: "text-center"
           },

        ],
        aoColumnDefs: [
           { bSortable: false, aTargets: -1 },
           { sWidth: "12%", aTargets: -1 },
        ],
        "language":{
           "search": "Buscar",
           "lengthMenu": "Mostrar _MENU_ usuarios por página",
           "info": "Mostrando página _PAGE_ de _PAGES_",
           "zeroRecords": "No se encontraron resultados",
           "emptyTable": "Ningún dato disponible en esta tabla",
           "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
           "infoFiltered": "(filtrado de un total de _MAX_ registros)",
           "infoThousands": ",",
           "loadingRecords": "Cargando...",
           "aria": {
                   "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                   "sortDescending": ": Activar para ordenar la columna de manera descendente"
           },
           "paginate": {
               "previous":"Anterior",
               "next": "Siguiente",
               "first": "Primero",
               "last": "Último"
           }
       }
     });
}

//Función para abrir el modal para agregar un Alumno
function modalNuevo(){
    $("#modalNuevo").modal('show');
}

//Función para agregar un nuevo Alumno
function nuevoA(){
    var bandera;

    bandera = validar();

    if(bandera){
        var nombre = $("#nombreA").val();
        var app = $("#apellidos").val();
        var email = $("#email").val();
        var grupo = $("#grupo").val();
        if(nombre == "" || app == "" || email == "" || grupo == ""){
            alertify.notify('Los datos no pueden estar vacíos', 'primary', 2, function(){console.log('dismissed');});
        }else{
            jQuery.ajax({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                url: '/nuevoA/',
                method: 'post',
                data:{
                    nombre: nombre,
                    apellidos: app,
                    email: email,
                    grupo: grupo,
                },
                success: function(data){ 
                    if(data == 'Se ha agragado un nuevo Alumno'){
                        $('#modalNuevo').modal('hide');
                        swal({
                            title: "Correcto",
                            text: data,
                            icon: "success",
                            showCancelButton: true,
                            confirmButtonColor: '#f7505a',
                            cancelButtonColor: '#f7505a',
                            buttons: {
                                confirm: true,
                            }
        
                        }).then(function() {
                            listarA();
                            limpiar();
                        })
                    }else if(data == 'Ya existe el Alumno'){
                        $('#modalNuevo').modal('hide');
                        limpiar();
                        swal("Incorrecto!", data, "error");
                    }
                },
                error: function (request, status, error) {
                    $('#modalNuevo').modal('hide');
                    limpiar();
                    alert(request.responseText);
                },
            });
        }
    }
}

//Función para abrir modal Editar
function modalEditar(id){
    $("#modalEditar").modal('show');

    // Método Ajax
    jQuery.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: '/infoA/' + id,
        method: 'get',
        data:{},
        success: function(data){ 
            $('#nombreAE').val(data[0]['name']);
            $('#apellidosE').val(data[0]['apellidos']);
            $('#emailE').val(data[0]['email']);
            $('#grupoE').val(data[0]['idGrupo']);
            $('#id').val(id);
        },error: function (request, status, error) {
            $('#modalEditar').modal('hide');
            limpiarE();
            alert(request.responseText);
        },
    });
}

//Función para editar Alumno
function editarA(){
    var bandera;

    bandera = validarE();

    if(bandera){
        var nombre = $("#nombreAE").val();
        var app = $("#apellidosE").val();
        var email = $("#emailE").val();
        var grupo = $("#grupoE").val();
        var id = $("#id").val();
        if(nombre == "" || app == "" || email == "" || grupo == ""){
            alertify.notify('Los datos no pueden estar vacíos', 'primary', 2, function(){console.log('dismissed');});
        }else{
            jQuery.ajax({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                url: '/editarA/',
                method: 'post',
                data:{
                    nombre: nombre,
                    apellidos: app,
                    email: email,
                    grupo: grupo,
                    id: id,
                },
                success: function(data){ 
                    if(data == 'Los datos del Alumno han sido actualizados'){
                        $('#modalEditar').modal('hide');
                        swal({
                            title: "Correcto",
                            text: data,
                            icon: "success",
                            showCancelButton: true,
                            confirmButtonColor: '#f7505a',
                            cancelButtonColor: '#f7505a',
                            buttons: {
                                confirm: true,
                            }
        
                        }).then(function() {
                            listarA();
                            limpiarE();
                        })
                    }else if(data == 'No existe la cuenta del alumno'){
                        $('#modalEditar').modal('hide');
                        limpiarE();
                        swal("Incorrecto!", data, "error");
                    }
                },
                error: function (request, status, error) {
                    $('#modalEditar').modal('hide');
                    limpiarE();
                    alert(request.responseText);
                },
            });
        }
    }
}

/*
Confirmar para eliminar un Alumno
*/
function eliminar(id){
    swal({
        title: "¿Seguro que desea eliminar este alumno?",
        icon: "warning",
        buttons: true,
    }).then((willDelete) => {
        if(willDelete){
            eliminarA(id);
        }else{
            swal.close();
        }
    });
}

/*
Función para eliminar un alumno
*/
function eliminarA(id){
    jQuery.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: '/eliminarA/',
        method: 'post',
        data:{
            id: id,
        },
        success: function(data){ 
            console.log(data);
            if(data == 'Los datos del Alumno han sido eliminados correctamente'){
                swal({
                    title: "Correcto",
                    text: data,
                    icon: "success",
                    showCancelButton: true,
                    confirmButtonColor: '#f7505a',
                    cancelButtonColor: '#f7505a',
                    buttons: {
                        confirm: true,
                    }
                }).then(function() {
                    listarA();
                })
            }else if(data == 'No existe información de este Alumno'){
                swal("Incorrecto!", data, "error");
            }
        },
        error: function (request, status, error) {
            alert(request.responseText);
        },
    });
}

//Función para limpiar campos de Modal Nuevo
function limpiar(){
    var form = document.getElementById("nuevoAlumno");
    limpiarErrores(form);
    $("#nombreA").val("");
    $("#apellidos").val("");
    $("#email").val("");
    $('#grupo').selectpicker('val', '0');
    document.getElementById("lblgrupo").style.color = "black";
    $("#mensaje").hide();
}

//Función para limpiar campos de Modal Nuevo
function limpiarE(){
    var form = document.getElementById("editarAlumno");
    limpiarErrores(form);
    $("#nombreAE").val("");
    $("#apellidosE").val("");
    $("#emailE").val("");
    $('#grupoE').val("0");
    $("#id").val("");
    document.getElementById("lblgrupoE").style.color = "black";
    $("#mensajeE").hide();
}

//Validar campos
function validar(){
    var form = document.getElementById("nuevoAlumno");
    limpiarErrores(form);

    var bandera = true;
    var nombre = document.getElementById("nombreA");
    var app = document.getElementById("apellidos");
    var email = document.getElementById("email");
    var eme = $("#email").val();
    var grupo = document.getElementById("grupo");

    if (nombre.value.trim() == "") {
        addError(nombre, "Campo requerido");
        bandera = false;
    } else {
        if (nombre.value.trim().length < 3) {
            addError(nombre, "El minimo son 3 caracteres");
            bandera = false;
        }else if(nombre.value.trim().length > 50){
            addError(nombre, "El máximo son 50 caracteres");
            bandera = false;
        }
    }

    if (app.value.trim() == "") {
        addError(app, "Campo requerido");
        bandera = false;
    } else {
        if (app.value.trim().length < 3) {
            addError(app, "El minimo son 3 caracteres");
            bandera = false;
        }else if(app.value.trim().length > 50){
            addError(app, "El máximo son 50 caracteres");
            bandera = false;
        }
    }

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


    if(grupo.selectedOptions[0].value == 0 ){
        $("#mensaje").show();
        document.getElementById("mensaje").style.color = "red";

        document.getElementById("lblgrupo").style.color = "red";

        bandera = false;
    }else{
        $("#mensaje").hide();
        document.getElementById("lblgrupo").style.color = "black";
    }

    return bandera;
}

//Validar campos
function validarE(){
    var form = document.getElementById("editarAlumno");
    limpiarErrores(form);

    var bandera = true;
    var nombre = document.getElementById("nombreAE");
    var app = document.getElementById("apellidosE");
    var email = document.getElementById("emailE");
    var eme = $("#emailE").val();
    var grupo = document.getElementById("grupoE");

    if (nombre.value.trim() == "") {
        addError(nombre, "Campo requerido");
        bandera = false;
    } else {
        if (nombre.value.trim().length < 3) {
            addError(nombre, "El minimo son 3 caracteres");
            bandera = false;
        }else if(nombre.value.trim().length > 50){
            addError(nombre, "El máximo son 50 caracteres");
            bandera = false;
        }
    }

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

    if (app.value.trim() == "") {
        addError(app, "Campo requerido");
        bandera = false;
    } else {
        if (app.value.trim().length < 3) {
            addError(app, "El minimo son 3 caracteres");
            bandera = false;
        }else if(app.value.trim().length > 50){
            addError(app, "El máximo son 50 caracteres");
            bandera = false;
        }
    }

    if(grupo.selectedOptions[0].value == 0 ){
        $("#mensajeE").show();
        document.getElementById("mensajeE").style.color = "red";

        document.getElementById("lblgrupoE").style.color = "red";

        bandera = false;
    }else{
        $("#mensajeE").hide();
        document.getElementById("lblgrupoE").style.color = "black";
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