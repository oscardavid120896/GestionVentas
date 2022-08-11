<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Profesor;
use App\Models\Materia;
use App\Models\Unidad;
use App\Models\Grupo;
use App\Models\Alumno;
use App\Models\GrupoProfesor;
use App\Models\Calificacion;


class ProfesorController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware('profesor');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function indexP()
    {
        $id = Auth::id(); 

        $datos = GrupoProfesor::join('grupo','grupoProfesor.idGrupo','=','grupo.id')
        ->join('materia','grupoProfesor.idMateria','=','materia.id')
        ->where('grupoProfesor.idProfesor','=',$id)
        ->get(['materia.id as idMateria','grupoProfesor.id as idGP','materia.nombre as nombreM', 'grupo.nombreGrupo']);

        return view('profesor.home',['datos' => $datos]);
    }

    public function revisar(Request $request){
        $id = $request->input('id');

        $datosd = GrupoProfesor::join('grupo','grupoProfesor.idGrupo','=','grupo.id')
        ->join('materia','grupoProfesor.idMateria','=','materia.id')
        ->where('grupoProfesor.id','=',$id)
        ->get(['materia.id as idMateria','grupoProfesor.id as idGP','materia.nombre as nombreM', 'grupo.nombreGrupo',
            'materia.unidades','grupo.id as idGrupo']);
        

        $alumnosd = Alumno::join('users','alumno.idUsuario','=','users.id')
        ->where('alumno.idGrupo','=',$datosd[0]['idGrupo'])
        ->count();
        
        if($alumnosd > 0){
            $datos = GrupoProfesor::join('grupo','grupoProfesor.idGrupo','=','grupo.id')
        ->join('materia','grupoProfesor.idMateria','=','materia.id')
        ->where('grupoProfesor.id','=',$id)
        ->get(['materia.id as idMateria','grupoProfesor.id as idGP','materia.nombre as nombreM', 'grupo.nombreGrupo',
            'materia.unidades','grupo.id as idGrupo']);
        
        $alumnos = Alumno::join('users','alumno.idUsuario','=','users.id')
        ->join('calificacion','alumno.idUsuario','=','calificacion.idAlumno')
        ->join('unidad','calificacion.idUnidad','=','unidad.id')
        ->where('alumno.idGrupo','=',$datos[0]['idGrupo'])
        ->where('unidad.idMateria','=',$datos[0]['idMateria'])
        ->get(['users.name','unidad.id as idUnidad','unidad.numUnidad as unidad',
        'calificacion.calificacion as cal', 'users.apellidos', 'users.id as idAlumno']);

        $alumnos2 = Alumno::where('idGrupo','=',$datos[0]['idGrupo'])->get();
        $alumnos5 = Alumno::join('users','alumno.idUsuario','=','users.id')
        ->where('idGrupo','=',$datos[0]['idGrupo'])->get();
        $uni = Unidad::where('idMateria','=',$datos[0]['idMateria'])->get();

        //$calificaciones = $datos[0]['unidades'];

        for($j = 0; $j < $alumnos2->count(); $j++){
            for($i = 0; $i < $uni->count(); $i++){
                $cal = new Calificacion;
                $cal->calificacion = 0;
                $cal->idAlumno = $alumnos2[$j]['idUsuario'];
                $cal->idUnidad = $uni[$i]['id'];
                $cal->idGrupoProfesor = $datos[0]['idGP'];
                $cal->save();
            }
        }

        $i=0;
        foreach($alumnos as $a){
            $total[$i] = $a->idAlumno;
            $i++;
        }

        /*if($alumnos->count() == 0){
            for($j = 0; $j < $alumnos2->count(); $j++){
                for($i = 0; $i < $uni->count(); $i++){
                    $cal = new Calificacion;
                    $cal->calificacion = 0;
                    $cal->idAlumno = $alumnos2[$j]['idUsuario'];
                    $cal->idUnidad = $uni[$i]['id'];
                    $cal->idGrupoProfesor = $datos[0]['idGP'];
                    $cal->save();
                }
            }
        }else{
            $i=0;
            foreach($alumnos as $a){
                $total[$i] = $a->idAlumno;
                $i++;
            }
        }*/

                
        $alumnos3 = Alumno::join('users','alumno.idUsuario','=','users.id')
        ->join('calificacion','alumno.idUsuario','=','calificacion.idAlumno')
        ->join('unidad','calificacion.idUnidad','=','unidad.id')
        ->where('alumno.idGrupo','=',$datos[0]['idGrupo'])
        ->where('unidad.idMateria','=',$datos[0]['idMateria'])
        ->get(['users.name','unidad.id as idUnidad','unidad.numUnidad as unidad',
        'calificacion.calificacion as cal', 'users.apellidos', 'users.id as idAlumno','calificacion.id as idCal']);
            
        $nDatos = array_merge(array($datos),array($alumnos3),array($alumnos2->count()),array($alumnos5));
        }else{
            $nDatos = "Aún no hay alumnos registrados";
        }
        
        return response()->json($nDatos);
    }

    public function cali(Request $request){
        $ids = $request->input('array');
        $cal = $request->input('array2');

        $i = 0;
        foreach($ids as $sku){
            $num[$i] = json_decode((int)$sku, true);
            
            $i++;
        }

        $coun = count($ids);

        $j = 0;
        foreach($cal as $sku){
            $num2[$j] = json_decode((int)$sku, true);
            
            $j++;
        }

        for($r=0; $r < $coun; $r++){
            Calificacion::where('id', '=', $num[$r])->update([
                'calificacion' => $num2[$r]
            ]);
        }

        $respuesta = "Se guardarón las calificaciones";

        //$ids->count();
        return response()->json($respuesta);
    }
}
