
    $(document).ready(function(){
        $("#mensaje").hide();
        $("#mensajeE").hide();
        listarM();
    })

    function listarM(){


    $('#materias').DataTable({
         destroy: true,
         //processing: true,
         serverSide: true,
         ajax: {url: '/directivo/materias/e'},
         type: "post",
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
                    return '<a class="fa fa-cogs fa-1x" style="color:green;" onClick="editarMateria('+data+');" data-toggle="tooltip" data-placement="left" title="Editar Materia"></a>&nbsp;&nbsp;&nbsp; ' +
                    '<a class="fa fa-trash-alt fa-1x" style="color:red;" onClick="abrirModalEl('+data+');" data-toggle="tooltip" data-placement="left" title="Eliminar Materia"></a>'
                },
                targets: -1,className: "text-center"
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

/* 
Función para abrir el modal de nuevo Materia
*/
function modalNuevoM() {
    $("#modalNuevoM").modal('show');
}

function nuevoM(){

    var bandera = validar();

    if (bandera) {
    var nombreM = $('#nombreM').val();
    var unidades = $('#unidades').val();
    var cuat = $('#cuat').val();
    if(nombreM == "" || unidades == "" || cuat <= 0 ){
        alertify.notify('Los datos no pueden estar vacíos', 'primary', 2, function(){console.log('dismissed');});
        //alertify.error("Los datos no pueden estar vacíos");
    }else{
        jQuery.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: '/nuevoM/',
        method: 'post',
        data:{
            nombreM: nombreM,
            unidades: unidades,
            cuat: cuat,
        },
        success: function(data){ 
            if(data == 'Se ha agragado la nueva materia'){
                $('#modalNuevoM').modal('hide');
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
                    limpiar();
                })
            }else if(data == 'Ya existe la Materia'){
                $('#modalNuevoM').modal('hide');
                swal("Incorrecto!", data, "error");
                limpiar();
            }
        },
        error: function (request, status, error) {
            $('#modalNuevoM').modal('hide');
            alert(request.responseText);
            limpiar();
        },
        });
    }
    }
}

function validar() {
    var form = document.getElementById("nuevaMateria");
    limpiarErrores(form);

    var bandera = true;
    var nombre = document.getElementById("nombreM");
    var unidades = document.getElementById("unidades");
    var cuat = document.getElementById("cuat");

    if (nombre.value.trim() == "") {
        addError(nombre, "Campo requerido");
        bandera = false;
    } else {
        if (nombre.value.trim().length < 3) {
            addError(nombre, "El minimo");
            bandera = false;
        }
    }

    if (unidades.value.trim() == "") {
        addError(unidades, "Campo requerido");
        bandera = false;
    }else{
        if(unidades.value.trim() >= 10){
            addError(unidades, "El máximo de unidades es de 9");
            bandera = false;
        }else if(unidades.value.trim() <= 0){
            addError(unidades, "El mínimo de unidades es de 1");
            bandera = false;
        }
    }

    if(cuat.selectedOptions[0].value == 0 ){
        $("#mensaje").show();
        document.getElementById("mensaje").style.color = "red";

        document.getElementById("lvlcuat").style.color = "red";

        bandera = false;
    }else{
        $("#mensaje").hide();
        document.getElementById("lvlcuat").style.color = "black";
    }

    return bandera;
}

function limpiar(){
    var form = document.getElementById("nuevaMateria");
    limpiarErrores(form);
    $("#nombreM").val("");
    $("#unidades").val("");
    $('.selectpicker').selectpicker('val', '0');
    $("#mensaje").hide();
    document.getElementById("lvlcuat").style.color = "black";
}

function editarMateria(id){
    $('#editarMateria2').modal('show');
    // Método Ajax
    jQuery.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: '/infoMat/' + id,
        method: 'get',
        data:{},
        success: function(data){ 
            //console.log(data)
            $('#nombreME').val(data[0]['nombre']);
            $('#unidadesE').val(data[0]['unidades']);  
            $('#idM').val(id);
            $('#cuatE').selectpicker('val', data[0]['cuatrimestre']);
        }
    });
}

function limpiarE(){
    var form = document.getElementById("editarMateria");
    limpiarErrores(form);
    $("#nombreME").val("");
    $("#unidadesE").val("");
    $('#cuatE').selectpicker('val', '0');
    $("#mensajeE").hide();
    document.getElementById("lvlcuatE").style.color = "black";
}

function editarM(){

    var bandera = validarE();

    if (bandera) {
        var nombre = $("#nombreME").val();
        var unidades = $("#unidadesE").val();
        var cuatr = $("#cuatE").val();
        var id = $("#idM").val();
    if(nombre == "" || unidades == "" || cuatr <= 0 ){
        alertify.notify('Los datos no pueden estar vacíos', 'primary', 2, function(){console.log('dismissed');});
    }else{
        $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: '/editarM/',
        method: 'post',
        data:{
            nombre: nombre,
            unidades: unidades,
            cuatr: cuatr,
            id: id,
        },
        success: function(data){ 
            if(data == 'La materia ha sido actualizada'){
                $('#editarMateria2').modal('hide');
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
                    limpiarE();
                })
            }else if(data == 'No existe la materia'){
                $('#editarMateria2').modal('hide');
                swal("Incorrecto!", data, "error");
                limpiarE();
            }
        },
        error: function (request, status, error) {
            $('#editarMateria2').modal('hide');
            alert(request.responseText);
            limpiarE();
        },
        });
    }
    }

}

function validarE() {
    var form = document.getElementById("editarMateria");
    console.log(form);
    limpiarErrores(form);

    var bandera = true;
    var nombreM = document.getElementById("nombreME");
    var unidadesM = document.getElementById("unidadesE");
    var cuatM = document.getElementById("cuatE");

    if (nombreM.value.trim() == "") {
        addError(nombreM, "Campo requerido");
        bandera = false;
    } else {
        if (nombreM.value.trim().length < 3) {
            addError(nombreM, "El minimo");
            bandera = false;
        }
    }

    if (unidadesM.value.trim() == "") {
        addError(unidadesM, "Campo requerido");
        bandera = false;
    }else{
        if(unidadesM.value.trim() >= 10){
            addError(unidadesM, "El máximo de unidades es de 9");
            bandera = false;
        }else if(unidadesM.value.trim() <= 0){
            addError(unidadesM, "El mínimo de unidades es de 1");
            bandera = false;
        }
    }

    if(cuatM.selectedOptions[0].value == 0 ){
        $("#mensajeE").show();
        document.getElementById("mensajeE").style.color = "red";

        document.getElementById("lvlcuatE").style.color = "red";

        bandera = false;
    }else{
        $("#mensajeE").hide();
        document.getElementById("lvlcuatE").style.color = "black";
    }

    return bandera;
}

/*
Confirmar para eliminar un profesor
*/
function abrirModalEl(id){
    swal({
        title: "¿Seguro que desea eliminar la materia?",
        icon: "warning",
        buttons: true,
    }).then((willDelete) => {
        if(willDelete){
            eliminarM(id);
        }else{
            swal.close();
        }
    });
}

/*
Función para eliminar una materia
*/
function eliminarM(id){
    jQuery.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: '/eliminarM/',
        method: 'post',
        data:{
            id: id,
        },
        success: function(data){ 
            console.log(data);
            if(data == 'La materia ha sido eliminada'){
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
            }else if(data == 'No existe la materia'){
                swal("Incorrecto!", data, "error");
            }
        },
        error: function (request, status, error) {
            alert(request.responseText);
        },
    });
}




