@extends('adminlte::page')

@section('content')
<br>
{{ Breadcrumbs::render('home')}}

<div id="alerta"><p>Aún no hay materias asignadas a tu grupo</p></div>
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
                    <br>
                    <center>
                        <span><i class="fa fa-users"></i> Grupo: {{$d->nombreGrupo}}</span><br>
                        <span><i class="fa fa-tasks"></i> Materia: {{$d->nombreM}}</span><br>
                    </center>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <center>
                        <button type="button" onclick="revisar({{$d->idGP}});" class="btn btn-primary">Ver Calificaciones</button>
                    </center>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>
    @endforeach
    </div>
</div>

<div id="calif">
    <div id="alerta2">Aún no hay Calificaciones</div>
</div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="../js/js_alumno/js_Calificaciones.js"></script>
@stop
