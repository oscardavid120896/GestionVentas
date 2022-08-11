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

{{ Breadcrumbs::render('profesor') }}

<br>

<div class="container-fluid">
    <div class="row col-12">
        <div class="card">
            <div class="card-header">
                <button id="uno" type="button" onclick="myFunction();" class="btn btn-primary">Profesores</button>
                <button id="dos" type="button" onclick="myFunction2();" class="btn btn-light">Asignar Materia</button>
            </div>
        </div>
    </div>
</div>

<br>



<!-- Primer DIV-->
<div id="myDIV" class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Profesores</h3>
                    <button id="uno" type="button" onclick="modalNuevo();" style="float: right" class="btn btn-primary btn-sm">Agregar</button>
                </div>
            <!-- /.card-header -->
            <div class="card-body" id="ta">
                <table id="profesores" class="table table-bordered table-striped shadow-lg mt-4">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Correo Electrónico</th>
                            <th>Cédula</th>
                            <th>Rol</th>
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

<!--Segundo Div-->
<div id="myDIV2" class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Materias</h3>
                    <button id="uno" type="button" onclick="modalAsignar();" style="float: right" class="btn btn-primary btn-sm">Agregar asignación</button>
                </div>
            <!-- /.card-header -->
            <div class="card-body" id="tab">
                <table id="asignada" class="table table-bordered table-striped shadow-lg mt-4">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Grupo</th>
                            <th>Profesor</th>
                            <th>Materia</th>
                            <th>Eliminar</th>
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


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar profesor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" id="nuevoProfesor" >

        <input type="hidden" class="form-control" id="id"> 
        <label id="lblnombre" for="nombre">Nombre</label>
        <input type="text" class="form-control" id="nombre" aria-describedby="inputGroupPrepend" required maxlength="50">
        <div id="feedback-nombre"></div>

        <label id="lblapellidos" for="apellidos">Apellidos</label>
        <input type="text" class="form-control" id="apellidos" aria-describedby="inputGroupPrepend" required maxlength="50">
        <div id="feedback-apellidos"></div>

        <label for="puesto">Puesto</label>
        <input type="text" class="form-control" id="puesto" disabled>

        <div class="modal-footer">
            <button type="button" onclick="limpiarE();" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" value="submit" id="btn1" onclick="editarP();" class="btn btn-primary">Guardar información</button>
        </div>
        </form> 
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar cuenta del profesor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" id="cuenta">

            <input type="hidden" class="form-control" id="id2"> 
            <label id="lblcedula" for="cedula">Cédula</label>
            <input type="text" class="form-control" id="cedula" required maxlength="6">
            <div id="feedback-cedula"></div>


            <label id="lblemail" for="correo">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" required maxlength="50">
            <div id="feedback-email"></div>

            <label for="rol">Puesto: </label><br>

            <select id="rol" class="selectpicker" data-live-search="true" >
                <option disabled>Seleccione un rol...</option>
                <option value="directivo">Directivo</option>
                <option value="profesor">Profesor</option>
            </select>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="limpiarC();" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btn2" onclick="editarCuenta();" class="btn btn-primary">Guardar información</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Nuevo-->
<div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar nuevo profesor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" id="nuevoProfesor2">

            <label id="lblnombre2" for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre2" required maxlength="50">
            <div id="feedback-nombre2"></div>

            <label id="lblapellidos2" for="apellidos2">Apellidos</label>
            <input type="text" class="form-control" id="apellidos2" required maxlength="50">
            <div id="feedback-apellidos2"></div>

            <label id="lblcedula2" for="cedula2">Cédula</label>
            <input type="text" class="form-control" id="cedula2" required maxlength="6">
            <div id="feedback-cedula2"></div>

            <label id="lblemail2" for="email2">Correo Electrónico</label>
            <input type="email" class="form-control" id="email2" maxlength="50" required>
            <div id="feedback-email2"></div>

            <label id="lblpass" for="pass">Contraseña</label>
            <input type="password" class="form-control" id="pass" maxlength="8" required>
            <div id="feedback-pass"></div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="limpiar();" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btn2" onclick="nuevoP();" class="btn btn-primary">Guardar información</button>
      </div>
    </div>
  </div>
</div>

<!-- Asignar Modal-->
<div class="modal fade bd-example-modal-lg" id="asignar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Asignar materia a profesores</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <div style="display:flex;">

            <div id="divGrupo">
              <label for="grupo">Grupo: </label><br>
                <select id="grupo" class="selectpicker" data-live-search="true">
                  <option value="0" disabled selected>Selecciona un grupo</option>
                  @foreach($grupos as $g)
                  <option value="{{$g->id}}">{{$g->nombreGrupo}}</option>
                  @endforeach
                </select>
            </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <div id="divProf">
              <label for="prof">Profesor: </label><br>
                <select id="prof" class="selectpicker" data-live-search="true" >
                  <option value="0" disabled selected>Selecciona un profesor</option>
                  @foreach($profesores as $pro)
                  <option value="{{$pro->idUsuario}}">{{$pro->name}}</option>
                  @endforeach
                </select>
            </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <div id="divMater">
              <label for="mater">Materia: </label><br>
                <select id="mater" class="form-control" title="Selecciona una Materia" disabled>
                  <option value="0" disabled selected>Selecciona una Materia</option>
                </select>
            </div>

          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="limpiarSe();" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btn2" onclick="asignacion();" class="btn btn-primary">Asignar</button>
      </div>
    </div>
  </div>
</div>


@endsection

@section('js')





<!-- Latest compiled and minified JavaScript -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="../js/js_directivo/directivoProfesor.js"></script>
<script src="../js/validaciones.js"></script>
@stop