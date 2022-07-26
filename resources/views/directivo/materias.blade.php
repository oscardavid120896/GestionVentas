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

<div id="myDIV2" class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Materias</h3>
                    <button id="dos" type="button" onclick="modalNuevoM();" style="float: right" class="btn btn-primary btn-sm">Agregar</button>
                </div>
            <!-- /.card-header -->
            <div class="card-body" id="tab">
                <table id="materias" class="table table-bordered table-striped shadow-lg mt-4">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Nombre</th>
                            <th>Unidades</th>
                            <th>Cuatrimestre</th>
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

<!-- Modal Nuevo Materia-->
<div class="modal fade" id="modalNuevoM" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar nueva materia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" id="nuevaMateria" novalidate>
        
            <label id="lblnombreM" for="nombreM">Nombre Materia</label><br>
            <input type="text" class="form-control" id="nombreM" aria-describedby="inputGroupPrepend" required>
            <div id="feedback-nombreM"></div>

            <label id="lblunidades" for="unidades">Cantidad Unidades</label>
            <input type="number" class="form-control" id="unidades" required oninput="this.value|=0" pattern="[0-9]{2}" maxlength="2" minlength="1"/>
            <div id="feedback-unidades"></div>

            <label id="lvlcuat" for="cuat">Cuatrimestre: </label><br>
            <select id="cuat" name="cuat" class="form-control selectpicker ProductNumber error" data-live-search="true" required="true">
                <option disabled selected value="0">Seleccione un cuatrimestre...</option>
                <option value="1">1.ª Cuatrimestre</option>
                <option value="2">2.ª Cuatrimestre</option>
                <option value="3">3.ª Cuatrimestre</option>
                <option value="4">4.ª Cuatrimestre</option>
                <option value="5">5.ª Cuatrimestre</option>
                <option value="6">6.ª Cuatrimestre</option>
                <option value="7">7.ª Cuatrimestre</option>
                <option value="8">8.ª Cuatrimestre</option>
                <option value="9">9.ª Cuatrimestre</option>
                <option value="10">10.ª Cuatrimestre</option>
            </select>
            <div id="mensaje">Favor de seleccionar una opción</div>
            
            <div class="modal-footer">
                <button type="button" onclick="limpiar();" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btn2" onclick="nuevoM()";  class="btn btn-primary">Guardar información</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Nuevo Materia-->
<div class="modal fade" id="editarMateria2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Materia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" id="editarMateria" novalidate>

            <input type="text" class="form-control" id="idM" aria-describedby="inputGroupPrepend">

            <label id="lblnombreME" for="nombreME">Nombre Materia</label><br>
            <input type="text" class="form-control" id="nombreME" aria-describedby="inputGroupPrepend" required>
            <div id="feedback-nombreME"></div>

            <label id="lblunidadesE" for="unidadesE">Cantidad Unidades</label>
            <input type="number" class="form-control" id="unidadesE" required oninput="this.value|=0" pattern="[0-9]{2}" maxlength="2" minlength="1"/>
            <div id="feedback-unidadesE"></div>

            <label id="lvlcuatE" for="cuatE">Cuatrimestre: </label><br>
            <select id="cuatE" name="cuatE" class="form-control selectpicker ProductNumber error" data-live-search="true" required="true">
                <option disabled selected value="0">Seleccione un cuatrimestre...</option>
                <option value="1">1.ª Cuatrimestre</option>
                <option value="2">2.ª Cuatrimestre</option>
                <option value="3">3.ª Cuatrimestre</option>
                <option value="4">4.ª Cuatrimestre</option>
                <option value="5">5.ª Cuatrimestre</option>
                <option value="6">6.ª Cuatrimestre</option>
                <option value="7">7.ª Cuatrimestre</option>
                <option value="8">8.ª Cuatrimestre</option>
                <option value="9">9.ª Cuatrimestre</option>
                <option value="10">10.ª Cuatrimestre</option>
            </select>
            <div id="mensajeE">Favor de seleccionar una opción</div>
            
            <div class="modal-footer">
                <button type="button" onclick="limpiarE();" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btn2" onclick="editarM()";  class="btn btn-primary">Guardar cambios</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="../js/js_directivoMateria/directivoMateria.js"></script>
<script src="../js/validaciones.js"></script>
@stop