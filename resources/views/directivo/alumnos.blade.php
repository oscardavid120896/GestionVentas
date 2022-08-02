@extends('adminlte::page')

@section('content')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>

<!-- 
    RTL version
-->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css"/>
<br>

{{ Breadcrumbs::render('alumnos') }}

<br>

<!-- Primer DIV-->
<div id="myDIV" class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Alumnos</h3>
                    <button id="uno" type="button" onclick="modalNuevo();" style="float: right" class="btn btn-primary btn-sm">Agregar</button>
                </div>
            <!-- /.card-header -->
            <div class="card-body" id="ta">
                <table id="alumnos" class="table table-bordered table-striped shadow-lg mt-4">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Correo Electrónico</th>
                            <th>Grupo</th>
                            <th>Acciones</th>
                        </tr>
                   </thead>
                </table>
            </div>
            <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>

<!-- Modal Nuevo-->
<div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar nuevo alumno</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" id="nuevoAlumno">

            <label id="lblnombreA" for="nombreA">Nombre</label><br>
            <input type="text" class="form-control" id="nombreA" aria-describedby="inputGroupPrepend" required>
            <div id="feedback-nombreA"></div>

            <label id="lblapellidos" for="apellidos">Apellidos</label><br>
            <input type="text" class="form-control" id="apellidos" aria-describedby="inputGroupPrepend" required>
            <div id="feedback-apellidos"></div>

            <label id="lblemail" for="email">Correo Electrónico</label><br>
            <input type="text" class="form-control" id="email" aria-describedby="inputGroupPrepend" required>
            <div id="feedback-email"></div>

            <label id="lblgrupo" for="grupo">Grupo</label><br>
            <select id="grupo" class="form-control selectpicker" data-live-search="true" >
                <option disabled value="0" selected>Seleccione un grupo...</option>
                @foreach($gr as $g)
                <option value="{{$g->id}}">{{$g->nombreGrupo}}</option>
                @endforeach
            </select>
            <div id="mensaje">Selecciona una opción</div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="limpiar();" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btn2" onclick="nuevoA();" class="btn btn-primary">Guardar información</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar alumno</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" id="editarAlumno">

            <input type="hidden" class="form-control" id="id" >
            <label id="lblnombreAE" for="nombreAE">Nombre</label><br>
            <input type="text" class="form-control" id="nombreAE" aria-describedby="inputGroupPrepend" required>
            <div id="feedback-nombreAE"></div>

            <label id="lblapellidosE" for="apellidosE">Apellidos</label><br>
            <input type="text" class="form-control" id="apellidosE" aria-describedby="inputGroupPrepend" required>
            <div id="feedback-apellidosE"></div>

            <label id="lblemailE" for="emailE">Correo Electrónico</label><br>
            <input type="text" class="form-control" id="emailE" aria-describedby="inputGroupPrepend" required>
            <div id="feedback-emailE"></div>

            <label id="lblgrupoE" for="grupoE">Grupo</label><br>
            <select id="grupoE" class="form-control" data-live-search="true">
                <option disabled value="0">Seleccione un grupo...</option>
                @foreach($gr as $g)
                <option value="{{$g->id}}">{{$g->nombreGrupo}}</option>
                @endforeach
            </select>
            <div id="mensajeE">Selecciona una opción</div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="limpiarE();" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btn2" onclick="editarA();" class="btn btn-primary">Guardar información</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="../js/js_directivo/directivoAlumno.js"></script>
<script src="../js/validaciones.js"></script>
@stop