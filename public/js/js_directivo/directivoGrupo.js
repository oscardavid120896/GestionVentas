/*
Leer el documento
*/
$(document).ready(function() {
    listarA();
});

//Listar todos los grupos
function listarA(){
    $('#grupos').DataTable({
        destroy: true,
        //processing: true,
        serverSide: true,
        ajax: {url: "/directivo/grupos/e"},
        columns: [
           { data: 'nombreGrupo', className: "text-center" },
           { 
               data: 'id',
               render:function(data,type,row){
                   return '<a class="fas fa-cog fa-1x" style="color:green;" onClick="modalEditar('+data+');" data-toggle="tooltip" data-placement="left" title="Editar Grupo"></a>&nbsp;&nbsp;&nbsp; ' +
                          '<a class="fas fa-trash-alt fa-1x" style="color:red;" onClick="eliminar('+data+');" data-toggle="tooltip" data-placement="left" title="Eliminar Grupo"></a>'
               },
               targets: -1,
               className: "text-center" 
           },

        ],
        aoColumnDefs: [
           { bSortable: false, aTargets: -1 },
           { sWidth: "20%", aTargets: -1 },
        ],
        "language":{
           "search": "Buscar",
           "lengthMenu": "Mostrar _MENU_ grupos por página",
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

//Abrir Modal
function modalNuevo(){
    $("#modalNuevo").modal('show');
}

//Limpiar Modal Nuevo
function limpiar(){
    var form = document.getElementById("nuevoGrupo");
    limpiarErrores(form);
    $("#nombreG").val("");
}

//Limpiar Modal Editar
function limpiarE(){
    var form = document.getElementById("editarGrupo");
    limpiarErrores(form);
    $("#nombreGE").val("");
}

//Guardar nuevo Grupo
function nuevoG(){
    var bandera = validar();
    
    if(bandera){
        debugger;
        var nombre = $('#nombreG').val();
        if(nombre == ""){
            alertify.notify('Los datos no pueden estar vacíos', 'primary', 2, function(){console.log('dismissed');});
        }else{
            jQuery.ajax({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                url: 'https://tranquil-mountain-72526.herokuapp.com/nuevoG/',
                method: 'post',
                data:{
                    nombre: nombre,
                },
                success: function(data){ 
                    if(data == 'Se ha agragado un nuevo Grupo'){
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
                    }else if(data == 'Ya existe el Grupo'){
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

//Función para abrir el modal para editar campos 
function modalEditar(id){
    $("#modalEditar").modal('show');

    // Método Ajax
    jQuery.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: '/infoG/' + id,
        method: 'get',
        data:{},
        success: function(data){ 
            $('#nombreGE').val(data[0]['nombreGrupo']);
            $('#id').val(id);
        }
    });
}


//Función para mandar los campos a editar de grupo
function editarG(){
    var bandera = validarE();

    if(bandera){
        var nombre = $("#nombreGE").val();
        var id = $("#id").val();
        if(nombre == ""){
            alertify.notify('Los datos no pueden estar vacíos', 'primary', 2, function(){console.log('dismissed');});
        }else{
            $.ajax({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                url: '/editarG/',
                method: 'post',
                data:{
                    nombre: nombre,
                    id: id,
                },
                success: function(data){ 
                    if(data == 'El Grupo ha sido actualizado'){
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
                    }else if(data == 'No existe el Grupo'){
                        $('#modalEditar').modal('hide');
                        swal("Incorrecto!", data, "error");
                        limpiarE();
                    }
                },
                error: function (request, status, error) {
                    $('#modalEditar').modal('hide');
                    alert(request.responseText);
                    limpiarE();
                },
            });
        }
    }
}

//Validar campos
function validar(){
    var form = document.getElementById("nuevoGrupo");
    limpiarErrores(form);

    var bandera = true;
    var nombre = document.getElementById("nombreG");

    if (nombre.value.trim() == "") {
        addError(nombre, "Campo requerido");
        bandera = false;
    } else {
        if (nombre.value.trim().length < 8) {
            addError(nombre, "El minimo son 8 caracteres");
            bandera = false;
        }else if(nombre.value.trim().length > 9){
            addError(nombre, "El máximo son 9 caracteres");
            bandera = false;
        }
    }

    return bandera;
}

//Validar campos
function validarE(){
    var form = document.getElementById("editarGrupo");
    limpiarErrores(form);

    var bandera = true;
    var nombre = document.getElementById("nombreGE");

    if (nombre.value.trim() == "") {
        addError(nombre, "Campo requerido");
        bandera = false;
    } else {
        if (nombre.value.trim().length < 8) {
            addError(nombre, "El minimo son 8 caracteres");
            bandera = false;
        }else if(nombre.value.trim().length > 9){
            addError(nombre, "El máximo son 9 caracteres");
            bandera = false;
        }
    }

    return bandera;
}

/*
Confirmar para eliminar un grupo
*/
function eliminar(id){
    swal({
        title: "¿Seguro que desea eliminar el grupo?",
        icon: "warning",
        buttons: true,
    }).then((willDelete) => {
        if(willDelete){
            eliminarG(id);
        }else{
            swal.close();
        }
    });
}

//Función para eliminar definitivamente el grupo
function eliminarG(id){
    jQuery.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: '/eliminarG/',
        method: 'post',
        data:{
            id: id,
        },
        success: function(data){ 
            console.log(data);
            if(data == 'El Grupo ha sido eliminado'){
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
            }else if(data == 'No existe el Grupo'){
                swal("Incorrecto!", data, "error");
            }else if(data == "No se puede eliminar el grupo, ya que aún hay alumnos"){
                swal("Incorrecto!", data, "warning");
            }else if(data == "No se puede eliminar el grupo, ya que aún hay materias asignadas"){
                swal("Incorrecto!", data, "warning");
            }
        },
        error: function (request, status, error) {
            alert(request.responseText);
        },
    });
}