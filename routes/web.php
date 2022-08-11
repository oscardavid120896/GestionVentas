<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes(['verify'=>true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Rutas del Directivo
Route::get('/directivo', [App\Http\Controllers\DirectivoController::class, 'indexD'])->name('directivo');
Route::get('/directivo/profesores', [App\Http\Controllers\DirectivoController:: class, 'getUsuarios'])->name('directivo.profesores');
Route::get('/directivo/alumnos', [App\Http\Controllers\DirectivoController:: class, 'getAlumnos'])->name('directivo.alumnos');
Route::get('/directivo/grupos', [App\Http\Controllers\DirectivoController:: class, 'getGrupos'])->name('directivo.grupos');
Route::get('/directivo/materias', [App\Http\Controllers\DirectivoController:: class, 'getMateriasM'])->name('directivo.materias');
Route::get('/info/{id}', [App\Http\Controllers\DirectivoController:: class, 'infoUser'])->name('info');

Route::get('/directivo/profesores/e', [App\Http\Controllers\DirectivoController:: class, 'getProfesores'])->name('directivo.getProfesores');
Route::get('/directivo/grupos/e', [App\Http\Controllers\DirectivoController:: class, 'getGruposA'])->name('directivo.getGrupos');
Route::get('/directivo/materias/e', [App\Http\Controllers\DirectivoController:: class, 'getMaterias'])->name('directivo.getMaterias');
Route::get('/directivo/alumnos/e', [App\Http\Controllers\DirectivoController:: class, 'listarAlumnos'])->name('directivo.listarAlumnos');

Route::get('/infoMat/{id}', [App\Http\Controllers\DirectivoController:: class, 'infoMat'])->name('infoMat');
Route::get('/infoG/{id}', [App\Http\Controllers\DirectivoController:: class, 'infoG'])->name('infoG');
Route::get('/infoA/{id}', [App\Http\Controllers\DirectivoController:: class, 'infoA'])->name('infoA');

Route::get('/materia', [App\Http\Controllers\DirectivoController::class, 'materia'])->name('materia');
Route::get('/grupo', [App\Http\Controllers\DirectivoController::class, 'grupo'])->name('grupo');
Route::get('/alumnos', [App\Http\Controllers\DirectivoController::class, 'alumnos'])->name('alumnos');

Route::get('/directivo/asignadas', [App\Http\Controllers\DirectivoController:: class, 'listarAsignadas'])->name('directivo.listarAsignadas');

//Rutas de Alumno
Route::get('/alumno', [App\Http\Controllers\AlumnoController::class, 'indexA'])->name('alumno');


//Rutas de Profesor
Route::get('/profesor', [App\Http\Controllers\ProfesorController::class, 'indexP'])->name('profesor');

Route::post('/revisar', [App\Http\Controllers\ProfesorController::class, 'revisar']);
    Route::post('/cali', [App\Http\Controllers\ProfesorController::class, 'cali']);
    Route::post('/misCal', [App\Http\Controllers\AlumnoController::class, 'misCal']);
    Route::post('/selectMateria', [App\Http\Controllers\DirectivoController:: class, 'selectMateria']);
    Route::post('/asignarMa', [App\Http\Controllers\DirectivoController:: class, 'asignarMa']);
    Route::post('/editarM', [App\Http\Controllers\DirectivoController:: class, 'editarMateria']);
    Route::post('/editarA', [App\Http\Controllers\DirectivoController:: class, 'editarAlumno']);
    Route::post('/eliminarM', [App\Http\Controllers\DirectivoController:: class, 'eliminarMat']);
    Route::post('/eliminarA', [App\Http\Controllers\DirectivoController:: class, 'eliminarA']);
    Route::post('/eliminarG', [App\Http\Controllers\DirectivoController:: class, 'eliminarG']);
    Route::post('/eliminarAsigna', [App\Http\Controllers\DirectivoController:: class, 'eliminarAsigna']);
    Route::post('/nuevoM', [App\Http\Controllers\DirectivoController:: class, 'agregarMateria']);
    Route::post('/nuevoA', [App\Http\Controllers\DirectivoController:: class, 'agregarAlumno']);
    Route::post('/nuevoP', [App\Http\Controllers\DirectivoController:: class, 'nuevoProfesor']);
Route::post('/nuevoG', [App\Http\Controllers\DirectivoController:: class, 'nuevoGrupo']);
Route::post('/editarP', [App\Http\Controllers\DirectivoController:: class, 'editarProfesor']);
Route::post('/editarC', [App\Http\Controllers\DirectivoController:: class, 'editarProfesorC']);
Route::post('/editarG', [App\Http\Controllers\DirectivoController:: class, 'editarGrupo']);
Route::post('/eliminarC', [App\Http\Controllers\DirectivoController:: class, 'eliminarProfesor']);
Route::post('/nuevoP', [App\Http\Controllers\DirectivoController:: class, 'agregarProfesor']);
Route::group(['middleware'=> ['cors']],function(){
    
});

