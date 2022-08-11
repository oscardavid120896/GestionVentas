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
{{ Breadcrumbs::render('home')}}

<div id="alerta"><p>Aún no tiene materias asignadas</p></div>
<input type="hidden" value="{{$datos}}" id="datos">
<div id="materias">
    <div class="row">
    @foreach($datos as $d)
        <div class="col-sm-3" >
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{$d->nombreM}}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <img src="vendor/adminlte/dist/img/otra.jpg" class="card-img-top img-fluid" width="20" height="100"><br>
                    <br>
                    <center>
                        <span><i class="fa fa-users"></i> Grupo: {{$d->nombreGrupo}}</span><br>
                        <span><i class="fa fa-tasks"></i> Materia: {{$d->nombreM}}</span><br>
                    </center>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <center>
                        <button type="button" onclick="revisar({{$d->idGP}});" class="btn btn-primary">Calificar</button>
                    </center>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>
    @endforeach
    </div>
</div>

<div id="unidades">
    <div id="alerta2">Aún no hay alumnos registrados</div>
</div>
<input type="hidden" id="idg">

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="../js/js_profesor/js_Calificaciones.js"></script>

@stop

