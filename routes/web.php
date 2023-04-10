<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [TaskController::class, 'index'])->name('gestor-tareas');
Route::post('/', [TaskController::class, 'store'])->name('anadir-tarea');
Route::delete('/', [TaskController::class, 'destroy'])->name('eliminar-tarea');
