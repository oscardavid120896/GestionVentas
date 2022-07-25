<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Profesor;
use App\Models\Materia;
use App\Models\Grupo;
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
        return view('directivo.profesores',['grupos' => $grupos]);
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

                $respuesta = "Se ha agragado el nuevo profesor"; 
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
    
                    $materia->nombre = $nombreM;
                    $materia->unidades = $unidades;
                    $materia->cuatrimestre = $cuat;
                    $materia->save();
    
                    $respuesta = "Se ha agragado la nueva materia"; 
                }else{
                    $respuesta = "Ya existe la Materia";
                }
    
            }else{
                $respuesta = "No se pudo agregar una nueva materia";
            }
            return response()->json($respuesta);
    
        }
    
}
