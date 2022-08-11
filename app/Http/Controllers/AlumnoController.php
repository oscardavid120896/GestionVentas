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
        $user = Auth::id();
        $grupo = Alumno::where('idUsuario','=',$user)->get('alumno.idGrupo');

        $idGrupo = (int)$grupo[0]['idGrupo'];

        $datos = GrupoProfesor::join('grupo','grupoProfesor.idGrupo','=','grupo.id')
        ->join('materia','grupoProfesor.idMateria','=','materia.id')
        ->where('grupoProfesor.idGrupo','=',$idGrupo)
        ->get(['materia.id as idMateria','grupoProfesor.id as idGP','materia.nombre as nombreM', 'grupo.nombreGrupo',
            'materia.unidades','grupo.id as idGrupo']);

        return view('alumno.home',['datos' => $datos]);
    }

    public function misCal(Request $request){
        $user = Auth::id();
        $idGrupo = $request->input('id');

        $datos = GrupoProfesor::join('grupo','grupoProfesor.idGrupo','=','grupo.id')
        ->join('materia','grupoProfesor.idMateria','=','materia.id')
        ->where('grupoProfesor.id','=',$idGrupo)
        ->get(['materia.id as idMateria','grupoProfesor.id as idGP','materia.nombre as nombreM', 'grupo.nombreGrupo',
            'materia.unidades','grupo.id as idGrupo']);

        $cal = Calificacion::where([
            ['idGrupoProfesor','=',$idGrupo],
            ['idAlumno','=',$user]
        ])->count();
        if($cal > 0){
            $cal2 = Calificacion::where([
                ['idGrupoProfesor','=',$idGrupo],
                ['idAlumno','=',$user]
            ])->get();

            $respuesta = array_merge(array($datos),array($cal2));
        }else{
            $respuesta = "Aún no hay Calificaciones";
        }

        return response()->json($respuesta);
    }
}
