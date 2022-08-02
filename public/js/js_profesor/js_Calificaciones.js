/*
Leer el documento
*/
$(document).ready(function() {
    $("#unidades").hide();
});


// Función para ver las calificaciones de los alumnos por materia y grupo
function revisar(id){
    jQuery.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: '/revisar/',
        method: 'post',
        data:{
            id: id,
        },
        success: function(data){ 
            $("#idg").val(id);
            $("#materias").hide();
            $("#unidades").show();
            console.log(data);
            var unidades = data[0][0]['unidades'];
            var posiciones = data[1].length;
            var alumnos = data[2];
            console.log(posiciones);
            o=0;p=0;r=0;f=0;
            var titulo = "<br><h5>Subir Calificaciones</h5><br>";
            var boton = '<br><center><button type="button" onclick="guardar();" class="btn btn-primary">Guardar</button></center><br>'
            var tabla = titulo +'<table class="table table-striped table-hover table-bordered" style="text-align: center;" id="calificaciones">';
                tabla += '<thead class="table-primary">';
                tabla += '<tr>';
                tabla += '<th style="width:200px">Nombre Alumno</th>';
                for (let i = 1; i <= unidades; i++){
                    tabla += "<th>" + 'Unidad' + i  + "</th>";
                }
                    
                tabla += '</tr>';
                tabla += '</thead>';
                tabla += '<tbody>';
                tr = '';
 

                
                for ( i = 0; i < alumnos; i++){
                    
                    tr += '<tr>';
                    tr += '<td>' + data[3][o]['name'] + ' ' + data[3][o]['apellidos'] +'</td>';
                    for(j = 1; j <= unidades; j++){
                        if(j == unidades){
                            for(k=0; k < unidades; k++){
                                tr += '<td >'+ '<input ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="2" size="2" pattern="^[0-9]{4}$" min="0" max="10" step="1" style="width: 50px; heigth: 50px; text-align: center" required type="text" value="'+data[1][k+f]['cal']+'" id="'+data[1][k+f]['idCal'] +'">' +'</td>';
                                p=k;
                            }
                            r = p+1;
                            f = f+r;
                            console.log(f);
                        }else{

                        }
                        

                    }
                    tr += '</tr>';
                    o++;
                }


                tabla += tr;
                tabla += '</tbody></table>' + boton;
 
                $('#unidades').html(tabla ); 
 
        },
        error: function (request, status, error) {
            alert(request.responseText);
        },
    });
}

function guardar(){
    var f = $("#idg").val();
    var todos = new Array();
    var i=0;
     $("#calificaciones input").each(function(){
         todos[i]=$(this).attr('id');
         i++;
    });

    var todos2 = new Array();
    var j=0;
     $("#calificaciones input").each(function(){
         if($(this).val()){
            todos2[j]=$(this).val();
            
         }else{
            todos2[j]="0";
         }
         
         j++;
    });

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        type: "POST",
        url: '/cali/',
        data: {'array': todos,
               'array2': todos2 },//capturo array     
        success: function(data){
            if(data == 'Se guardarón las calificaciones'){
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
                    revisar(f);
                })
            }
      }
});

}