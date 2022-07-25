
    $(document).ready(function(){
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

    /* 
Función para abrir el modal de nuevo Materia
*/
function modalNuevoM() {
    $("#modalNuevoM").modal('show');
}

// // Example starter JavaScript for disabling form submissions if there are invalid fields
// (function () {
//   'use strict'

//   // Fetch all the forms we want to apply custom Bootstrap validation styles to
//   var forms = document.querySelectorAll('.needs-validation')

//   // Loop over them and prevent submission
//   Array.prototype.slice.call(forms)
//     .forEach(function (form) {
//       form.addEventListener('submit', function (event) {
//         if (!form.checkValidity()) {
//           event.preventDefault()
//           event.stopPropagation()
//         }

//         form.classList.add('was-validated')
//       }, false)
//     })
// })()
/*
Función para agregar una nueva cuenta de Profesor
*/
function nuevoM(){

    var bandera = validar();

    if (bandera) {
        var nombreM = $('#nombreM').val();
    var unidades = $('#unidades').val();
    var cuat = $('#cuat').val();
    if(nombreM == "" || unidades == "" || cuat == "" ){
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
                })
            }else if(data == 'Ya existe la Materia'){
                $('#modalNuevoM').modal('hide');
                swal("Incorrecto!", data, "error");
            }
        },
        error: function (request, status, error) {
            $('#modalNuevoM').modal('hide');
            alert(request.responseText);
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

    return bandera;
}




