/*
Leer el documento
*/
$(document).ready(function() {
    $("#calif").hide();
    var datos = $("#datos").val();
    if(datos.length == 2){
        console.log(datos.length);
    }else{
        $("#alerta").hide();
    }
});

// Función para ver las calificaciones de los alumnos por materia y grupo
function revisar(id){
    jQuery.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
        url: '/misCal/',
        method: 'post',
        data:{
            id: id,
        },
        success: function(data){ 
            if(data == "Aún no hay Calificaciones"){
                $("#materias").hide();
                $("#calif").show();
                $("#alerta2").show();
            }else{
                $("#idg").val(id);
                $("#materias").hide();
                $("#calif").show();
                $("#alerta").hide();
                $("#alerta2").hide();
                console.log(data);
                var unidades = data[0][0]['unidades'];
                var posiciones = data[1].length;
                var alumnos = data[2];
                console.log(posiciones);
                o=0;p=0;r=0;f=0;
                var tabla = '<table class="table table-striped table-hover table-bordered" style="text-align: center;" id="calificaciones">';
                    tabla += '<thead class="table-primary">';
                    tabla += '<tr>';
                    tabla += '<th style="width:200px">Nombre Materia</th>';
                    for (let i = 1; i <= unidades; i++){
                        tabla += "<th>" + 'Unidad' + i  + "</th>";
                    }
                        
                    tabla += '</tr>';
                    tabla += '</thead>';
                    tabla += '<tbody>';
                    tr = '';
    
                    tr += '<tr>';
                    tr += '<td>' + data[0][0]['nombreM'] +'</td>';
                    for(j = 1; j <= unidades; j++){
                        if(j == unidades){
                            for(k=0; k < unidades; k++){
                                tr += '<td >'+data[1][k+f]['calificacion']+'</td>';
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

                    tabla += tr;
                    tabla += '</tbody></table>';
    
                    $('#calif').html(tabla ); 
            }
            
 
        },
        error: function (request, status, error) {
            alert(request.responseText);
        },
    });
}