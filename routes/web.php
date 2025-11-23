<?php

use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\ProfesorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

/* RUTAS DE EL MÓDULO DE PROFESORES */
Route::resource('profesores', ProfesorController::class);
Route::get('/profesores/modal/create', [ProfesorController::class, 'modalCreate'])
    ->name('profesores.modal.create');
Route::get('/profesores/modal/{id}/edit', [ProfesorController::class, 'modalEdit'])
    ->name('profesores.modal.edit');
Route::get('/profesores/filtrar/{estado}', [ProfesorController::class, 'filtrar']);
Route::put('/profesores/{id}/estado', [ProfesorController::class, 'cambiarEstado']);

/* RUTAS DEL MÓDULO DE CURSOS */
Route::resource('cursos', CursoController::class);
Route::get('/cursos/modal/create', [CursoController::class, 'modalCreate'])
    ->name('cursos.modal.create');
Route::get('/cursos/modal/{id}/edit', [CursoController::class, 'modalEdit'])
    ->name('cursos.modal.edit');
Route::get('/cursos/{id}/detalle', [CursoController::class, 'detalle'])
    ->name('cursos.detalle');

/* RUTAS DEL MÓDULO DE ALUMNOS */
Route::resource('alumnos', AlumnoController::class);
Route::get('/alumnos/modal/create', [AlumnoController::class, 'modalCreate'])
    ->name('alumnos.modal.create');
Route::get('/alumnos/modal/{id}/edit', [AlumnoController::class, 'modalEdit'])
    ->name('alumnos.modal.edit');
Route::get('/alumnos/filtrar/{estado}', [AlumnoController::class, 'filtrar'])
    ->name('alumnos.filtrar');
Route::put('/alumnos/{id}/estado', [AlumnoController::class, 'cambiarEstado'])
    ->name('alumnos.estado');

/* RUTAS PARA EL DASHBOARD */
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/alumnos/{id}/cursos', [AlumnoController::class, 'asignarCursos']);
Route::post('/alumnos/{id}/cursos', [AlumnoController::class, 'actualizarCursos'])->name('alumnos.cursos.update');

Route::get('/auth/redirect/{provider}', [SocialController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/callback/{provider}', [SocialController::class, 'callback'])->name('social.callback');