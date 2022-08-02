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

class AlumnoController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware('alumno');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function indexA()
    {
        return view('alumno.home');
    }

    public function misCal(){
        $user = Auth::id();
        $grupo = Alumno::where('idUsuario','=',$user)->get('alumno.idGrupo');

        $idGrupo = (int)$grupo[0]['idGrupo'];

        $datos = GrupoProfesor::join('grupo','grupoProfesor.idGrupo','=','grupo.id')
        ->join('materia','grupoProfesor.idMateria','=','materia.id')
        ->where('grupoProfesor.idGrupo','=',$idGrupo)
        ->get(['materia.id as idMateria','grupoProfesor.id as idGP','materia.nombre as nombreM', 'grupo.nombreGrupo',
            'materia.unidades','grupo.id as idGrupo']);


            $j = 0;
            foreach($datos as $sku){
                $num2[$j] = json_decode((int)$sku->idMateria, true);
                
                $j++;
            }
        /*$datos = GrupoProfesor::join('grupo','grupoProfesor.idGrupo','=','grupo.id')
        ->join('materia','grupoProfesor.idMateria','=','materia.id')
        ->where('grupoProfesor.id','=',$id)
        ->get(['materia.id as idMateria','grupoProfesor.id as idGP','materia.nombre as nombreM', 'grupo.nombreGrupo',
            'materia.unidades','grupo.id as idGrupo']);*/
        
        $alumnos = Alumno::join('users','alumno.idUsuario','=','users.id')
        ->join('calificacion','alumno.idUsuario','=','calificacion.idAlumno')
        ->join('unidad','calificacion.idUnidad','=','unidad.id')
        ->where('alumno.idGrupo','=',$idGrupo)
        ->whereIn('unidad.idMateria',$num2)
        ->where('calificacion.idAlumno','=',$user)
        ->get(['users.name','unidad.id as idUnidad','unidad.numUnidad as unidad',
        'calificacion.calificacion as cal', 'users.apellidos', 'users.id as idAlumno','unidad.idMateria']);

        $nDatos = array_merge(array($datos),array($alumnos)); 

        return response()->json($nDatos);
    }
}
