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
use Illuminate\Support\Facades\Hash;


class DirectivoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
        $this->middleware('directivo');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function indexD()
    {
        return view('directivo.home');
    }

    public function getUsuarios(){
        $grupos = Grupo::all();
        $profesores = User::join('profesor','users.id','=','profesor.idUsuario')->where('users.rol','=','profesor')->get();
        return view('directivo.profesores',['grupos' => $grupos, 'profesores' => $profesores]);
    }

    public function getAlumnos(){
        $grupos = Grupo::all();
        return view('directivo.alumnos',['gr' => $grupos]);
    }

    public function getGrupos(){
        return view('directivo.grupos');
    }

    public function getMateriasM(){
        return view('directivo.materias');
    }


    public function getProfesores(Request $request){

    ## Read value
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length"); // Rows display per page

    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->get('search');

    $columnIndex = $columnIndex_arr[0]['column']; // Column index
    $columnName = $columnName_arr[$columnIndex]['data']; // Column name
    $columnSortOrder = $order_arr[0]['dir']; // asc or desc
    $searchValue = $search_arr['value']; // Search value

    // Total records
    $totalRecords = Profesor::join('users','profesor.idUsuario','=','users.id')->where('users.rol', 'profesor')->get(['profesor.*','users.*'])->count();
    $totalRecordswithFilter = Profesor::join('users','profesor.idUsuario','=','users.id')->where('users.rol', 'profesor')->where('users.name', 'like', '%' .$searchValue . '%')->get(['profesor.*','users.*'])->count();

    // Fetch records
    $records = Profesor::join('users','profesor.idUsuario','=','users.id')->where('users.rol', 'profesor')->orderBy('users.id',$columnSortOrder)
      ->where('users.name', 'like', '%' .$searchValue. '%')
      ->skip($start)
      ->take($rowperpage)
      ->get(['profesor.*','users.*']);

    $data_arr = array();
    

    foreach($records as $record){
       $id = $record->idUsuario;
       $name = $record->name;
       $apellidos = $record->apellidos;
       $email = $record->email;
       $rol = $record->rol;
       $cedula = $record->cedula;


       $data_arr[] = array(
         "id" => $id,
         "name" => $name,
         "apellidos" => $apellidos,
         "email" => $email,
         "rol" => $rol,
         "cedula" => $cedula
       );
    }

    $response = array(
       "draw" => intval($draw),
       "iTotalRecords" => $totalRecords,
       "iTotalDisplayRecords" => $totalRecordswithFilter,
       "aaData" => $data_arr
    );

    echo json_encode($response);
    exit;
    }

    public function infoUser($id){
        $user = User::where('id', $id)->get('id');
        $in = Profesor::join('users','profesor.idUsuario','=','users.id')->where('users.id', $id)->get(['profesor.*','users.*']);

        return response()->json($in);
    }

    public function editarProfesor(Request $request){
        
        if($request->isMethod('post')){
            $nombre = $request->input("nombre");
            $apellidos = $request->input("apellidos");
            $id = $request->input("id");

            $existe = User::where('id','=',$id)->count();

            if($existe > 0){
                $editarUsuario = User::find($id);
                $editarUsuario->name = $nombre;
                $editarUsuario->apellidos = $apellidos;
                $editarUsuario->save();

                $respuesta = "El profesor ha sido actualizado"; 
            }else{
                $respuesta = "No existe el profesor";
            }

        }else{
            $respuesta = "No se pudieron guardar los cambios";
        }

        return response()->json($respuesta);
    }

    public function editarProfesorC(Request $request){
        
        if($request->isMethod('post')){
            $cedula = $request->input("cedula");
            $email = $request->input("email");
            $rol = $request->input("rol");
            $id2 = $request->input("id");

            $existe = User::where('id','=',$id2)->count();
            
            if($existe > 0){
                $editarUsuario = User::find($id2);
                $editarUsuario->rol = $rol;
                $editarUsuario->email = $email;
                $editarUsuario->save();
                
                Profesor::where('idUsuario', '=', $id2)->update([
                    'cedula' => $cedula
                ]);

                $respuesta = "La cuenta del profesor ha sido actualizada"; 
            }else{
                $respuesta = "No existe la cuenta del profesor";
            }

        }else{
            $respuesta = "No se pudieron guardar los cambios";
        }

        return response()->json($respuesta);

    }

    public function eliminarProfesor(Request $request){
        
        if($request->isMethod('post')){
            $id2 = $request->input("id");

            $existe = User::where('id','=',$id2)->count();
            
            if($existe > 0){
                $pro = GrupoProfesor::where('idProfesor','=',$id2)->get();
                if($pro->count() == 0){
                }else{
                    $k = 0;
                foreach($pro as $sku){
                    $num3[$k] = $sku->id;
                        
                    $k++;
                }
                Calificacion::whereIn('idGrupoProfesor',$num3)->delete();
            }
                
                GrupoProfesor::where('idProfesor','=',$id2)->delete();
                Profesor::where('idUsuario', '=', $id2)->delete();
                User::where('id','=',$id2)->delete();

                $respuesta = "La cuenta del profesor ha sido eliminada"; 
            }else{
                $respuesta = "No existe la cuenta del profesor";
            }

        }else{
            $respuesta = "No se pudo eliminar el profesor";
        }

        return response()->json($respuesta);

    }

    public function agregarProfesor(Request $request){
        
        if($request->isMethod('post')){
            $nombre = $request->input("nombre");
            $apellidos = $request->input("apellidos");
            $cedula = $request->input("cedula");
            $email = $request->input("email");
            $puesto = $request->input("puesto");
            $pass = $request->input("pass");
            $passE;

            $existe = Profesor::where('cedula','=',$cedula)->count();
            
            if($existe <= 0){
                $usuario = new User;
                $profesor = new Profesor;

                $passE = Hash::make($pass);

                $usuario->name = $nombre;
                $usuario->apellidos = $apellidos;
                $usuario->email = $email;
                $usuario->password = $passE;
                $usuario->rol = $puesto;
                $usuario->save();

                $idUsuario = $usuario->id;

                $profesor->cedula = $cedula;
                $profesor->idUsuario = $idUsuario;
                $profesor->save();

                $respuesta = "Se ha agregado el nuevo profesor"; 
            }else{
                $respuesta = "Ya existe el profesor con la misma cédula";
            }

        }else{
            $respuesta = "No se pudo agregar un nuevo profesor";
        }

        return response()->json($respuesta);

    }

    //Materias
    public function getMaterias(Request $request){

        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
    
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');
    
        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
    
        // Total records
        $totalRecords = Materia::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Materia::select('count(*) as allcount')->where('nombre', 'like', '%' .$searchValue . '%')->count();
    
        // Fetch records
        $records = Materia::orderBy($columnName,$columnSortOrder)
        ->where('materia.nombre', 'like', '%' .$searchValue . '%')
        ->select('materia.*')
        ->skip($start)
        ->take($rowperpage)
        ->get();
    
        $data_arr = array();
        
    
        foreach($records as $record){
           $id = $record->id;
           $nombre = $record->nombre;
           $unidades = $record->unidades;
           $cuatri = $record->cuatrimestre;
    
           $data_arr[] = array(
             "id" => $id,
             "nombre" => $nombre,
             "unidades" => $unidades,
             "cuatrimestre" => $cuatri
           );
        }
    
        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordswithFilter,
           "aaData" => $data_arr
        );
    
        return json_encode($response);
        exit;
        }

        public function agregarMateria(Request $request){
        
            if($request->isMethod('post')){
                $nombreM = $request->input("nombreM");
                $unidades = $request->input("unidades");
                $cuat = $request->input("cuat");
    
                $existe = Materia::where('nombre','=',$nombreM)->count();
                
                if($existe <= 0){
                    $materia = new Materia;
                    
                    $nomUnidad = "";
    
                    $materia->nombre = $nombreM;
                    $materia->unidades = $unidades;
                    $materia->cuatrimestre = $cuat;
                    $materia->save();

                    for($i = 1; $i <= $unidades; $i++){
                        $unidad = new Unidad;
                        $unidad->numUnidad = "Unidad ".$i;
                        $unidad->idMateria = $materia->id;
                        $unidad->save();
                    }
    
                    $respuesta = "Se ha agragado la nueva materia"; 
                }else{
                    $respuesta = "Ya existe la Materia";
                }
    
            }else{
                $respuesta = "No se pudo agregar una nueva materia";
            }
            return response()->json($respuesta);
    
        }

        public function infoMat($id){
            $mat = Materia::where('id', $id)->get();
    
            return response()->json($mat);
        }

        public function editarMateria(Request $request){
            if($request->isMethod('post')){
                $nombre = $request->input("nombre");
                $unidades = $request->input("unidades");
                $cuatr = $request->input("cuatr");
                $id = $request->input("id");
    
                $existe = Materia::where('id','=',$id)->count();
                
                if($existe > 0){
                    $editarMateria = Materia::find($id);
                    $editarMateria->nombre = $nombre;
                    $editarMateria->unidades = $unidades;
                    $editarMateria->cuatrimestre = $cuatr;
                    $editarMateria->save();
                    
                    $datoLR = Unidad::where('idMateria','=',$id)->get();
                    if($datoLR->count() == 0){

                    }else{
                        $k = 0;
                        foreach($datoLR as $sku){
                            $num3[$k] = $sku->id;
                            
                            $k++;
                        }
                        Calificacion::whereIn('idUnidad',$num3)->delete();
                    }
                    
                    //GrupoProfesor::where('idMateria','=',$id)->delete();

                    Unidad::where('idMateria', '=', $id)->delete();

                    for($i = 1; $i <= $unidades; $i++){
                        $unidad = new Unidad;
                        $unidad->numUnidad = "Unidad ".$i;
                        $unidad->idMateria = $id;
                        $unidad->save();
                    }
    
                    $respuesta = "La materia ha sido actualizada"; 
                }else{
                    $respuesta = "No existe la materia";
                }
    
            }else{
                $respuesta = "No se pudieron guardar los cambios";
            }
    
            return response()->json($respuesta);
        }

        public function eliminarMat(Request $request){
            if($request->isMethod('post')){
                $id = $request->input("id");
    
                $existe = Materia::where('id','=',$id)->count();
                
                if($existe > 0){
                    $datoLR = GrupoProfesor::where('idMateria','=',$id)->get();
                    if($datoLR->count() > 0){
                        $respuesta = "No se puede eliminar la materia, ya que aún esta asignada";
                    }else{
                        Unidad::where('idMateria','=',$id)->delete();
                        Materia::where('id', '=', $id)->delete();

                        $respuesta = "La materia ha sido eliminada"; 
                    }
                }else{
                    $respuesta = "No existe la materia";
                }
    
            }else{
                $respuesta = "No se pudo eliminar el profesor";
            }
    
            return response()->json($respuesta);
        }
    
    //Grupos
    public function getGruposA(Request $request){

        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
    
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');
    
        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
    
        // Total records
        $totalRecords = Grupo::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Grupo::select('count(*) as allcount')->where('nombreGrupo', 'like', '%' .$searchValue . '%')->count();
    
        // Fetch records
        $records = Grupo::orderBy($columnName,$columnSortOrder)
        ->where('grupo.nombreGrupo', 'like', '%' .$searchValue . '%')
        ->select('grupo.*')
        ->skip($start)
        ->take($rowperpage)
        ->get();
    
        $data_arr = array();
        
    
        foreach($records as $record){
           $id = $record->id;
           $nombre = $record->nombreGrupo;
    
           $data_arr[] = array(
             "id" => $id,
             "nombreGrupo" => $nombre,
           );
        }
    
        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordswithFilter,
           "aaData" => $data_arr
        );
    
        return json_encode($response);
        exit;
    }

    //Función para crear un nuevo Grupo
    public function nuevoGrupo(Request $request){

        if($request->isMethod('post')){

            $nombreG = $request->input("nombre");

            $existe = Grupo::where('nombreGrupo','=',$nombreG)->count();
            
            if($existe <= 0){
                $grupo = new Grupo;

                $grupo->nombreGrupo = $nombreG;
                $grupo->save();

                $respuesta = "Se ha agragado un nuevo Grupo"; 
            }else{
                $respuesta = "Ya existe el Grupo";
            }

        }else{
            $respuesta = "No se pudo agregar un nuevo grupo";
        }

        return response()->json($respuesta);
    }

    //Función para recuperar información de grupo
    public function infoG($id){
        $gr = Grupo::where('id', $id)->get();

        return response()->json($gr);
    }

    //Función para editar un grupo
    public function editarGrupo(Request $request){
        if($request->isMethod('post')){

            $nombre = $request->input("nombre");
            $id = $request->input("id");

            $existe = Grupo::where('id','=',$id)->count();
            
            if($existe > 0){
                $editarMateria = Grupo::find($id);
                $editarMateria->nombreGrupo = $nombre;
                $editarMateria->save();
                
                $respuesta = "El Grupo ha sido actualizado"; 
            }else{
                $respuesta = "No existe el Grupo";
            }

        }else{
            $respuesta = "No se pudieron guardar los cambios";
        }

        return response()->json($respuesta);
    }

    //Función para eliminar un grupo definitivamente
    public function eliminarG(Request $request){
        if($request->isMethod('post')){
            $id = $request->input("id");

            $existe = Grupo::where('id','=',$id)->count();
            
            if($existe > 0){
                $datoLR = Alumno::where('idGrupo', '=', $id)->get();
                if($datoLR->count() > 0){
                    $respuesta = "No se puede eliminar el grupo, ya que aún hay alumnos";
                }else{
                    $dato2 = GrupoProfesor::where('idGrupo','=',$id)->get();
                    if($dato2->count() > 0 ){
                        $respuesta = "No se puede eliminar el grupo, ya que aún hay materias asignadas";
                    }else{
                        Grupo::where('id', '=', $id)->delete();
                        $respuesta = "El Grupo ha sido eliminado"; 
                    }
                }            
            }else{
                $respuesta = "No existe el Grupo";
            }

        }else{
            $respuesta = "No se pudo eliminar el Grupo";
        }

        return response()->json($respuesta);
    }

    //Función para listar Alumnos
    public function listarAlumnos(Request $request){
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
    
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');
    
        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value
    
        // Total records
        $totalRecords = Alumno::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Alumno::join('users','alumno.idUsuario','=','users.id')->where('users.rol', 'alumno')->where('users.name', 'like', '%' .$searchValue . '%')->get(['alumno.*','users.*'])->count();
    
        // Fetch records
        $records = Alumno::join('grupo','alumno.idGrupo','=','grupo.id')->join('users','alumno.idUsuario','=','users.id')->where('users.rol', 'alumno')
        ->orderBy('users.id',$columnSortOrder)
        ->where('users.name', 'like', '%' .$searchValue . '%')
        ->skip($start)
        ->take($rowperpage)
        ->get(['grupo.*','alumno.*','users.*']);
    
        $data_arr = array();
        
    
        foreach($records as $record){
           $id = $record->id;
           $name = $record->name;
           $apellidos = $record->apellidos;
           $email = $record->email;
           $grupo = $record->nombreGrupo;
    
           $data_arr[] = array(
            "id" => $id,
            "name" => $name,
            "apellidos" => $apellidos,
            "email" => $email,
            "grupo" => $grupo
           );
        }
    
        $response = array(
           "draw" => intval($draw),
           "iTotalRecords" => $totalRecords,
           "iTotalDisplayRecords" => $totalRecordswithFilter,
           "aaData" => $data_arr
        );
    
        return json_encode($response);
        exit;
    }

    //Función para agregar un nuevo Alumno
    public function agregarAlumno(Request $request){

        if($request->isMethod('post')){
            $nombre = $request->input("nombre");
            $apellidos = $request->input("apellidos");
            $email = $request->input("email");
            $grupo = $request->input("grupo");
            $pass = "password";
            $passE;

            $existe = User::select('*')
            ->where([
                ['name', '=', $nombre],
                ['apellidos','=',$apellidos]
            ])->orWhere('email','=',$email)->count();
                        
            if($existe <= 0){
                $usuario = new User;
                $alumno = new Alumno;

                $passE = Hash::make($pass);

                $usuario->name = $nombre;
                $usuario->apellidos = $apellidos;
                $usuario->email = $email;
                $usuario->password = $passE;
                $usuario->rol = "alumno";
                $usuario->save();

                $idUsuario = $usuario->id;

                $alumno->idGrupo = $grupo;
                $alumno->idUsuario = $idUsuario;
                $alumno->save();

                $respuesta = "Se ha agragado un nuevo Alumno"; 
            }else{
                $respuesta = "Ya existe el Alumno";
            }

        }else{
            $respuesta = "No se pudo agregar un nuevo alumno";
        }

        return response()->json($respuesta);
    }

    //función para obtener la información del alumno
    public function infoA($id){
        $al = User::join('alumno','alumno.idUsuario','=','users.id')->where('users.id', $id)->get();

        return response()->json($al);
    }

    //función para editar información del alumno
    public function editarAlumno(Request $request){
        if($request->isMethod('post')){

            $nombre = $request->input("nombre");
            $apellidos = $request->input("apellidos");
            $email = $request->input("email");
            $grupo = $request->input("grupo");
            $id = $request->input("id");

            $existe = User::where('id','=',$id)->count();
            
            if($existe > 0){
                $editarUsuario = User::find($id);
                $editarUsuario->name = $nombre;
                $editarUsuario->apellidos = $apellidos;
                $editarUsuario->email = $email;
                $editarUsuario->save();
                
                Alumno::where('idUsuario', '=', $id)->update([
                    'idGrupo' => $grupo
                ]);

                $respuesta = "Los datos del Alumno han sido actualizados"; 
            }else{
                $respuesta = "No existe la cuenta del alumno";
            }

        }else{
            $respuesta = "No se pudieron guardar los cambios";
        }

        return response()->json($respuesta);
    }

    //Función para eliminar un alumno definitivamente
    public function eliminarA(Request $request){

        if($request->isMethod('post')){
            $id = $request->input("id");

            $existe = User::where('id','=',$id)->count();
            
            if($existe > 0){

                Calificacion::where('idAlumno','=',$id)->delete();
                Alumno::where('idUsuario', '=', $id)->delete();
                User::where('id', '=', $id)->delete();

                $respuesta = "Los datos del Alumno han sido eliminados correctamente"; 
            }else{
                $respuesta = "No existe información de este Alumno";
            }

        }else{
            $respuesta = "No se pudo eliminar los datos del Alumno";
        }

        return response()->json($respuesta);
    }

        //Función para llenar select de Materia
        public function selectMateria(Request $request){

            if($request->isMethod('post')){
                $idGrupo = $request->input("grupo");
                $idProf = $request->input("prof");

                $existe = GrupoProfesor::join('materia','grupoProfesor.idMateria','=','materia.id')
                ->where([
                    ['idProfesor', '=', $idProf],
                    ['idGrupo','=',$idGrupo]
                ])->count();
                
                if($existe > 0){
                    $query = GrupoProfesor::join('materia','grupoProfesor.idMateria','=','materia.id')
                    ->where([
                        ['idProfesor', '=', $idProf],
                        ['idGrupo','=',$idGrupo]
                    ])->get('grupoProfesor.idMateria');
                    $i = 0;
                    foreach($query as $sku){
                        $num[$i] = json_decode((int)$sku->idMateria, true);
                        
                        $i++;
                    }
                    $existe2 = GrupoProfesor::join('materia','grupoProfesor.idMateria','=','materia.id')
                    ->where([
                        ['idProfesor', '!=', $idProf],
                        ['idGrupo','=',$idGrupo]
                    ])->count();

                    if($existe2 > 0){
                        $query2 = GrupoProfesor::join('materia','grupoProfesor.idMateria','=','materia.id')
                        ->where([
                            ['idProfesor', '!=', $idProf],
                            ['idGrupo','=',$idGrupo]
                        ])->get('grupoProfesor.idMateria');
                        $i = 0;
                        foreach($query as $sku){
                            $num2[$i] = json_decode((int)$sku->idMateria, true);
                        
                            $i++;
                        }
                        $total = array_merge($num,$num2);
                        $datos = Materia::select('*')->whereNotIn('id',$total)->get();
                    }else{
                        $datosR = Materia::select('*')->whereNotIn('id',$num)->count();
                        if($datosR > 0){
                            $datos = Materia::select('*')->whereNotIn('id',$num)->get();
                        }else{
                            $datos = "No hay materias disponibles";
                        }
                    }   
                }else{
                    $exister = GrupoProfesor::join('materia','grupoProfesor.idMateria','=','materia.id')
                    ->where('idGrupo','=',$idGrupo)->count();
                    if($exister > 0){
                        $mat = GrupoProfesor::join('materia','grupoProfesor.idMateria','=','materia.id')
                        ->where('idGrupo','=',$idGrupo)->get('grupoProfesor.idMateria');
                        $i = 0;
                        foreach($mat as $sku){
                            $num2[$i] = json_decode((int)$sku->idMateria, true);
                        
                            $i++;
                        }
                        $datosR = Materia::select('*')->whereNotIn('id',$num2)->count();
                        if($datosR > 0){
                            $datos = Materia::select('*')->whereNotIn('id',$num2)->get();
                        }else{
                            $datos = "No hay materias disponibles";
                        }
                    }else{
                        $datos = Materia::all();
                    }
                }
            }else{
                $datos = "No se pudo recuperar la información";
            }
    
            return response()->json($datos);
        }

    public function asignarMa(Request $request){

        if($request->isMethod('post')){

            $grupo = $request->input("grupo");
            $profesor = $request->input("profesor");
            $mater = $request->input("mater");

            $existe = GrupoProfesor::where([
                ['idGrupo','=',$grupo],
                ['idProfesor','=',$profesor],
                ['idMateria','=',$mater],
                ])->count();
            
            if($existe <= 0){
                $asignar = new GrupoProfesor;

                $asignar->idGrupo = $grupo;
                $asignar->idProfesor = $profesor;
                $asignar->idMateria = $mater;
                $asignar->save();

                $respuesta = "Se ha asignado la materia correctamente"; 
            }else{
                $respuesta = "No se pudo asignar la materia";
            }

        }else{
            $respuesta = "No se pudo asignar la materia";
        }

        return response()->json($respuesta);
    }

    //Materias Asignadas
public function listarAsignadas(Request $request){
    ## Read value
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length"); // Rows display per page

    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->get('search');

    $columnIndex = $columnIndex_arr[0]['column']; // Column index
    $columnName = $columnName_arr[$columnIndex]['data']; // Column name
    $columnSortOrder = $order_arr[0]['dir']; // asc or desc
    $searchValue = $search_arr['value']; // Search value

    // Total records
    $totalRecords = GrupoProfesor::select('count(*) as allcount')->count();
    $totalRecordswithFilter = GrupoProfesor::join('grupo','grupoProfesor.idGrupo','=','grupo.id')->where('grupo.nombreGrupo', 'like', '%' .$searchValue . '%')->get(['grupo.*','grupoProfesor.*'])->count();

    // Fetch records
    $records = GrupoProfesor::join('grupo','grupoProfesor.idGrupo','=','grupo.id')
    ->join('materia','grupoProfesor.idMateria','=','materia.id')
    ->join('users','grupoProfesor.idProfesor','=','users.id')
    ->orderBy('grupoProfesor.id',$columnSortOrder)
    ->where('grupo.nombreGrupo', 'like', '%' .$searchValue . '%')
    ->skip($start)
    ->take($rowperpage)
    ->get(['grupo.*','materia.*','users.*','grupoProfesor.*']);

    $data_arr = array();
    

    foreach($records as $record){
       $id = $record->id;
       $name = $record->name;
       $materia = $record->nombre;
       $grupo = $record->nombreGrupo;

       $data_arr[] = array(
        "id" => $id,
        "name" => $name,
        "materia" => $materia,
        "grupo" => $grupo
       );
    }

    $response = array(
       "draw" => intval($draw),
       "iTotalRecords" => $totalRecords,
       "iTotalDisplayRecords" => $totalRecordswithFilter,
       "aaData" => $data_arr
    );

    return json_encode($response);
    exit;
}

public function eliminarAsigna(Request $request){
        
    if($request->isMethod('post')){

        $id = $request->input("id");

        $existe = GrupoProfesor::where('id','=',$id)->count();
        
        if($existe > 0){
            Calificacion::where('idGrupoProfesor','=',$id)->delete();
            GrupoProfesor::where('id', '=', $id)->delete();

            $respuesta = "Se ha eliminado la asignación"; 
        }else{
            $respuesta = "No se pudo eliminar la asignación";
        }

    }else{
        $respuesta = "No se pudo eliminar la asignación";
    }

    return response()->json($respuesta);

}

}
