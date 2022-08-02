/*
Leer el documento
*/
$(document).ready(function() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          url: '/misCal/',
          method: 'get',
          data:{},
          success: function(data){ 
              /*$("#idg").val(id);
              $("#materias").hide();
              $("#unidades").show();*/
              console.log(data);
              var materia = data[0].length;

              var unidades;
              var a=0;
              for(i=0; i < materia; i++){
                  if(data[0][i]['unidades'] > a){
                      unidades = data[0][i]['unidades'];
                  }else{
                      a = data[0][i]['unidades'];
                  }
              }
              console.log(unidades);
              o=0;p=0;r=0;f=0;
              var titulo = "<br><h5>Mis Calificaciones</h5><br>";
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
   
  
                  
                  for ( i = 0; i < materia; i++){
                      
                      tr += '<tr>';
                      tr += '<td>' + data[0][o]['nombreM'] +'</td>';
                      for(j = 1; j <= unidades; j++){
                          if(j == unidades){
                              for(k=0; k < unidades; k++){
                                  tr += '<td >'+ '<input disabled ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="2" size="2" pattern="^[0-9]{4}$" min="0" max="10" step="1" style="width: 50px; heigth: 50px; text-align: center" required type="text" value="'+data[1][k+f]['cal']+'" id="'+data[1][k+f]['idCal'] +'">' +'</td>';
                                  p=k;
                              }
                              r = p+1;
                              f = f+r;
                          }else{
  
                          }
                          
  
                      }
                      tr += '</tr>';
                      o++;
                  }
  
  
                  tabla += tr;
                  tabla += '</tbody></table>';
   
                  $('#calif').html(tabla ); 
   
          },
          error: function (request, status, error) {
              alert(request.responseText);
          },
      });
});