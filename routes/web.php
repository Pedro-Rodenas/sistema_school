<?php

use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\ProfesorController;
use Illuminate\Support\Facades\Route;

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


Route::get('/auth/redirect/{provider}', [SocialController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/callback/{provider}', [SocialController::class, 'callback'])->name('social.callback');