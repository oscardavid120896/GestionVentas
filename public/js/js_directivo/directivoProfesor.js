/*
Leer el documento
*/
$(document).ready(function() {
    $("#myDIV2").hide();
    $("#tabla").hide();
    $("#uno").prop('disabled', true);
    //$('.mater').prop("disabled", true);
    $('#mater').prop('disabled', true);
    listar();
} );

/*
Función para eliminar un profesor
*/
function eliminarAsignacion(id){

    jQuery.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: '/eliminarAsigna/',
        method: 'post',
        data:{
            id: id,
        },
        success: function(data){ 
            if(data == 'Se ha eliminado la asignación'){
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
                    listarM();
                })
            }else if(data == 'No se pudo eliminar la asignación'){
                swal("Incorrecto!", data, "error");
                listarM();
            }
        },
        error: function (request, status, error) {
            listarM();
            alert(request.responseText);
        },
    });
}


var selects = $('#grupo, #prof');

$(selects).change(function(){
    //$('#mater').selectpicker('setStyle', 'disabled', 'remove');
    var grupo = $('#grupo').val();
    var prof = $('#prof').val();





    if(grupo != null && prof != null){
        console.log(grupo,prof);
        $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
            url: '/selectMateria/',
            method: 'post',
            data:{
                grupo: grupo,
                prof: prof,
            },
            success: function(data){ 
                console.log(data);
                if(data == 'El profesor no puede impartir más de 8 materias'){
                    $("#asignar").modal('hide');
                    swal({
                        title: "Hubo un problema",
                        text: data,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#f7505a',
                        cancelButtonColor: '#f7505a',
                        buttons: {
                            confirm: true,
                        }
                    }).then(function() {
                        limpiarSe();
                        $("#asignar").modal('show');
                    })
                }else if(data == 'No hay materias disponibles'){
                    $("#asignar").modal('hide');
                    swal({
                        title: "Hubo un problema",
                        text: data,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#f7505a',
                        cancelButtonColor: '#f7505a',
                        buttons: {
                            confirm: true,
                        }
                    }).then(function() {
                        limpiarSe();
                        $("#asignar").modal('show');
                    }) 
                }else{
                    $('#mater').empty().append('<option selected disabled value="0">Selecciona una Materia</option>');
                    $('#mater').prop('disabled', false);
                    //$("#mater").append('<option value="0" disabled selected>Selecciona una Materia</option>');
                    for (let i = 0; i < data.length; i++) 
                    $("#mater").append(
                    "<option value='" + data[i]['id'] + "'>" + data[i]['nombre'] + "</option>"
                    );
                }
            },
            
        }); 
    }else{
        console.log('Selecciona otro');
    }
});

function limpiarSe(){
    $("#grupo").selectpicker('val','0');
    $("#prof").selectpicker('val','0');
    $('#mater').prop('disabled', true);
    $('#mater').empty().append('<option selected disabled value="0">Selecciona una Materia</option>');
    
}

function asignacion(){
    var grupo = $("#grupo").val();
    var profesor = $("#prof").val();
    var mater = $("#mater").val();

    if(grupo == null || prof == null || mater == null){
        $("#asignar").modal('hide');
        swal({
            title: "Incorrecto",
            text: "Los datos no pueden ir vacíos",
            icon: "error",
            showCancelButton: true,
            confirmButtonColor: '#f7505a',
            cancelButtonColor: '#f7505a',
            buttons: {
                confirm: true,
            }

        }).then(function() {
            $("#asignar").modal('show');
        })
    }else{
        jQuery.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
            url: '/asignarMa/',
            method: 'post',
            data:{
                grupo: grupo,
                profesor: profesor,
                mater: mater,
            },
            success: function(data){ 
                if(data == 'Se ha asignado la materia correctamente'){
                    $('#asignar').modal('hide');
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
                        limpiarSe();
                        listarM();
                    })
                }else if(data == 'No se pudo asignar la materia'){
                    limpiarSe();
                    listarM();
                    $('#asignar').modal('hide');
                    swal("Incorrecto!", data, "error");
                }
            },
            error: function (request, status, error) {
                $('#asignar').modal('hide');
                limpiarSe();
                listarM();
                alert(request.responseText);
            },
        });
    }

    
}

/*
Función para crear tabla de datos de profesor
*/
function listar(){
    $('#profesores').DataTable({
         destroy: true,
         //processing: true,
         serverSide: true,
         ajax: {url: "/directivo/profesores/e"},
         columns: [
            { data: 'name' },
            { data: 'apellidos' },
            { data: 'email' },
            { data: 'cedula' },
            { data: 'rol' },
            { 
                data: 'id',
                render:function(data,type,row){
                    return '<a class="fas fa-users-cog fa-1x" style="color:green;" onClick="abrirModal('+data+');" data-toggle="tooltip" data-placement="left" title="Editar Datos Usuario"></a>&nbsp;&nbsp;&nbsp; ' +
                    '<a class="fas fa-trash-alt fa-1x" style="color:red;" onClick="eliminar('+data+');" data-toggle="tooltip" data-placement="left" title="Eliminar Usuario"></a>&nbsp;&nbsp;&nbsp; '+
                    '<a class="fas fa-cogs fa-1x" style="color:gray;" onClick="abrirModalCuenta('+data+');" data-toggle="tooltip" data-placement="left" title="Editar Cuenta"></a>'
                },
                targets: -1 
            },

         ],
         aoColumnDefs: [
            { bSortable: false, aTargets: -1 },
            { sWidth: "12%", aTargets: -1 },
         ],
         "language":{
            "search": "Buscar",
            "lengthMenu": "Mostrar _MENU_ profesores por página",
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

function listarM(){
    $('#asignada').DataTable({
         destroy: true,
         //processing: true,
         serverSide: true,
         ajax: {url: "/directivo/asignadas"},
         columns: [
            { data: 'grupo' },
            { data: 'name'},
            { data: 'materia'},
            { 
                data: 'id',
                render:function(data,type,row){
                    return ' <center><a class="fa fa-trash-alt fa-1x" style="color:red;" onClick="eliminarAsignacion('+data+');" data-toggle="tooltip" data-placement="left" title="Eliminar Asignación"></a>'
                },
                targets: -1 
            },

         ],
         aoColumnDefs: [
            { bSortable: false, aTargets: -1 },
            { sWidth: "10%", aTargets: -1 },
         ],
         "language":{
            "search": "Buscar",
            "lengthMenu": "Mostrar _MENU_ materias por página",
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

function myFunction() {

    dos = document.getElementById('dos');
    dos.className="btn btn-light";

    uno = document.getElementById('uno');
    uno.className="btn btn-primary";
    $("#dos").prop('disabled',false);
    $("#uno").prop('disabled',true);
    
    $("#myDIV2").hide();
    $("#myDIV").show();
}

function myFunction2() {

    dos = document.getElementById('dos');
    dos.className="btn btn-primary";

    uno = document.getElementById('uno');
    uno.className="btn btn-light";

    
    $("#uno").prop('disabled',false);
    $("#dos").prop('disabled',true);
    $("#myDIV").hide();
    $("#myDIV2").show();
    listarM();
}

function abrirModal(id){
    $('#exampleModal').modal('show');
    console.log(id);
    // Método Ajax
    jQuery.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: '/info/' + id,
        method: 'get',
        data:{},
        success: function(data){ 
            //console.log(data)
            $('#nombre').val(data[0]['name']);
            $('#apellidos').val(data[0]['apellidos']);  
            $('#puesto').val('Profesor');
            $('#id').val(id);
        }
    });
}

function modalAsignar(){
    $('#asignar').modal('show');
}

function abrirModalCuenta(id) {
    $('#exampleModal2').modal('show');
    
    // Método Ajax
    jQuery.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: '/info/' + id,
        method: 'get',
        data:{},
        success: function(data){  
            $('#id2').val(id); 
            $('#cedula').val(data[0]['cedula']);
            $('#email').val(data[0]['email']);
            $('.selectpicker').selectpicker('val', data[0]['rol']);      
        }
    });
}

/* 
Función para abrir el modal de nuevo
*/
function modalNuevo() {
    $("#modalNuevo").modal('show');
}


/*
Función  para limpiar campos
*/
function limpiar(){
    $('#nombre').val();
    $('#apellidos').val();
    $('#email').val();
}

/*
Función para editar un usuario
*/
function editarP(){
    var nombre = $('#nombre').val();
    var apellidos = $('#apellidos').val();
    var id = $('#id').val();

    if(nombre == "" || apellidos == ""){
        alertify.notify('Los datos no pueden estar vacíos', 'primary', 2, function(){console.log('dismissed');});
    }else{
        jQuery.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: '/editarP/',
        method: 'post',
        data:{
            nombre: nombre,
            apellidos: apellidos,
            id: id
        },
        success: function(data){ 
            if(data == 'El profesor ha sido actualizado'){
                $('#exampleModal').modal('hide');
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
                    listar();
                })
            }else if(data == 'No existe el profesor'){
                $('#exampleModal').modal('hide');
                swal("Incorrecto!", data, "error");
            }
        },
        error: function (request, status, error) {
            $('#exampleModal').modal('hide');
            alert(request.responseText);
        },
    });
    }
}


/*
Función para editar campos de la cuenta
*/
function editarCuenta(){
    var cedula = $('#cedula').val();
    var rol = $('#rol').val();
    var id = $('#id2').val();
    var email = $("#email").val();
    console.log(id);
    console.log(rol);
    
    jQuery.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: '/editarC/',
        method: 'post',
        data:{
            cedula: cedula,
            rol: rol,
            id: id,
            email: email
        },
        success: function(data){ 
            console.log(data);
            if(data == 'La cuenta del profesor ha sido actualizada'){
                $('#exampleModal2').modal('hide');
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
                    listar();
                })
            }else if(data == 'No existe la cuenta del profesor'){
                $('#exampleModal2').modal('hide');
                swal("Incorrecto!", data, "error");
            }
        },
        error: function (request, status, error) {
            //$('#exampleModal').modal('hide');
            alert(request.responseText);
        },
    });
}

/*
Confirmar para eliminar un profesor
*/
function eliminar(id){
    swal({
        title: "¿Seguro que desea eliminar este Profesor?",
        text: "Se eliminarán todos los datos referentes a este",
        icon: "warning",
        buttons: true,
        }).then((willDelete) => {
            if(willDelete){
                eliminarC(id);
            }else{
                swal.close();
            }
        });
}

/*
Función para eliminar un profesor
*/
function eliminarC(id){
    console.log(id);

    jQuery.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: '/eliminarC/',
        method: 'post',
        data:{
            id: id,
        },
        success: function(data){ 
            console.log(data);
            if(data == 'La cuenta del profesor ha sido eliminada'){
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
                    listar();
                })
            }else if(data == 'No existe la cuenta del profesor'){
                swal("Incorrecto!", data, "error");
            }
        },
        error: function (request, status, error) {
            alert(request.responseText);
        },
    });
}

/*
Función para agregar una nueva cuenta de Profesor
*/
function nuevoP(){
    var nombre = $('#nombre2').val();
    var apellidos = $('#apellidos2').val();
    var cedula = $('#cedula2').val();
    var puesto = 'Profesor';
    var email = $('#email2').val();
    var pass = $('#pass').val();
    

    jQuery.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: '/nuevoP/',
        method: 'post',
        data:{
            nombre: nombre,
            apellidos: apellidos,
            cedula: cedula,
            puesto: puesto,
            email: email,
            pass: pass
        },
        success: function(data){ 
            if(data == 'Se ha agregado el nuevo profesor'){
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
                    listar();
                })
            }else if(data == 'Ya existe el profesor con la misma cédula'){
                $('#modalNuevo').modal('hide');
                swal("Incorrecto!", data, "error");
            }
        },
        error: function (request, status, error) {
            $('#modalNuevo').modal('hide');
            alert(request.responseText);
        },
    });
}
