<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('principal');
});

Auth::routes();

Route::get('/patients', [App\Http\Controllers\PatientController::class, 'index'])->name('home');

Route::get('/patients/add', [App\Http\Controllers\PatientController::class, 'create'])->name('patientsAdd');

Route::get('/patients/edit/{id}', [App\Http\Controllers\PatientController::class, 'edit']);

Route::post('/patients', [App\Http\Controllers\PatientController::class, 'store'])->name('patients.store');

Route::put('/patients', [App\Http\Controllers\PatientController::class, 'update'])->name('patients.update');

Route::delete('/patients/delete/{id}', [App\Http\Controllers\PatientController::class, 'destroy']);
