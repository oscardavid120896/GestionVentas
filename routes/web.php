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
Route::get('/directivo/materias', [App\Http\Controllers\DirectivoController:: class, 'getMateriasM'])->name('directivo.materias');
Route::get('/info/{id}', [App\Http\Controllers\DirectivoController:: class, 'infoUser'])->name('info');
Route::post('/nuevoP', [App\Http\Controllers\DirectivoController:: class, 'nuevoProfesor']);
Route::post('/editarP', [App\Http\Controllers\DirectivoController:: class, 'editarProfesor']);
Route::post('/editarC', [App\Http\Controllers\DirectivoController:: class, 'editarProfesorC']);
Route::post('/eliminarC', [App\Http\Controllers\DirectivoController:: class, 'eliminarProfesor']);
Route::post('/nuevoP', [App\Http\Controllers\DirectivoController:: class, 'agregarProfesor']);
Route::get('/directivo/profesores/e', [App\Http\Controllers\DirectivoController:: class, 'getProfesores'])->name('directivo.getProfesores');
Route::get('/directivo/materias/e', [App\Http\Controllers\DirectivoController:: class, 'getMaterias'])->name('directivo.getMaterias');
Route::post('/nuevoM', [App\Http\Controllers\DirectivoController:: class, 'agregarMateria']);
Route::get('/infoMat/{id}', [App\Http\Controllers\DirectivoController:: class, 'infoMat'])->name('infoMat');
Route::post('/editarM', [App\Http\Controllers\DirectivoController:: class, 'editarMateria']);
Route::post('/eliminarM', [App\Http\Controllers\DirectivoController:: class, 'eliminarMat']);

//Rutas de Alumno
Route::get('/alumno', [App\Http\Controllers\AlumnoController::class, 'indexA'])->name('alumno');

//Rutas de Profesor
Route::get('/profesor', [App\Http\Controllers\ProfesorController::class, 'indexP'])->name('profesor');

