/*
Leer el documento
*/
$(document).ready(function() {
    $("#myDIV2").hide();
    $("#myDIV3").hide();
    $("#tabla").hide();
    $("#uno").prop('disabled', true);
    listar();

    $("#grupo").change(function(){
        idgrupo = $(this).val();
        listarP(idgrupo);
    })
} );

function listarP(id){
    $("#tabla").show();
    listarPf(id);
}
/*
Función para crear tabla de datos de profesor
*/
function listarPf(id){
    console.log(id);
    $('#grupos').DataTable({
         destroy: true,
         //processing: true,
         serverSide: true,
         ajax: {url: "/directivo/profesores/e"},
         columns: [
            { data: 'name' },
            { data: 'apellidos' },
            { 
                data: 'id',
                render:function(data,type,row){
                    return '<a class="fas fa-users-cog fa-1x" style="color:green;" onClick="abrirModal('+data+');" data-toggle="tooltip" data-placement="left" title="Editar Datos Usuario"></a>&nbsp;&nbsp;&nbsp; '
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

function listarM(){
    $('#materias').DataTable({
         destroy: true,
         //processing: true,
         serverSide: true,
         ajax: {url: "/directivo/materias/e"},
         columns: [
            { data: 'nombre' },
            { 
                data: 'unidades',
                render:function(data,type,row){
                    return data + ' Unidad (es)'
                },
                targets: 1
            },
            { 
                data: 'cuatrimestre',
                render:function(data,type,row){
                    return data + ' Cuatrimestre'
                },
                targets: 2 
            },
            { 
                data: 'id',
                render:function(data,type,row){
                    return ' <center><a class="fa fa-tasks fa-1x" style="color:green;" onClick="abrirModalM('+data+');" data-toggle="tooltip" data-placement="left" title="Asignar Materia"></a>'
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

function myFunction() {
    tres = document.getElementById('tres');
    tres.className="btn btn-ligth";

    dos = document.getElementById('dos');
    dos.className="btn btn-light";

    uno = document.getElementById('uno');
    uno.className="btn btn-primary";
    $("#tres").prop('disabled',false);
    $("#dos").prop('disabled',false);
    $("#uno").prop('disabled',true);
    
    $("#myDIV3").hide();
    $("#myDIV2").hide();
    $("#myDIV").show();
}

function myFunction2() {
    tres = document.getElementById('tres');
    tres.className="btn btn-light";

    dos = document.getElementById('dos');
    dos.className="btn btn-primary";

    uno = document.getElementById('uno');
    uno.className="btn btn-light";

    
    $("#tres").prop('disabled',false);
    $("#uno").prop('disabled',false);
    $("#dos").prop('disabled',true);
    $("#myDIV3").hide();
    $("#myDIV").hide();
    $("#myDIV2").show();
    listarM();
}

function myFunction3() {
    tres = document.getElementById('tres');
    tres.className="btn btn-primary";

    dos = document.getElementById('dos');
    dos.className="btn btn-light";

    uno = document.getElementById('uno');
    uno.className="btn btn-light";

    $("#tres").prop('disabled',true);
    $("#uno").prop('disabled',false);
    $("#dos").prop('disabled',false);
    $("#myDIV").hide();
    $("#myDIV2").hide();
    $("#myDIV3").show();
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

function abrirModalM(id){
    $('#asignarMateria').modal('show');
    
    // Método Ajax
    /*jQuery.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: '/info/' + id,
        method: 'get',
        data:{},
        success: function(data){ 
            //console.log(data)
            $('#nombreM2').val(data[0]['name']);
            $('#unidades2').val(data[0]['apellidos']);  
            $('.selectpicker').selectpicker('val', data[0]['cuat']); 
        }
    });*/
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
        icon: "warning",
        buttons: ["Cancelar","Confirmar"],
        }).then(function() {
            eliminarC(id);
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
            if(data == 'Se ha agragado el nuevo profesor'){
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
