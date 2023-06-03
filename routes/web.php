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

//Patients Routes
Route::get('/patients', [App\Http\Controllers\PatientController::class, 'index'])->name('home');
Route::get('/patients/add', [App\Http\Controllers\PatientController::class, 'create'])->name('patientsAdd');
Route::get('/patients/edit/{id}', [App\Http\Controllers\PatientController::class, 'edit']);
Route::post('/patients', [App\Http\Controllers\PatientController::class, 'store'])->name('patients.store');
Route::put('/patients', [App\Http\Controllers\PatientController::class, 'update'])->name('patients.update');
Route::delete('/patients/delete/{id}', [App\Http\Controllers\PatientController::class, 'destroy']);

//Dentists Routes
Route::get('/dentists', [App\Http\Controllers\DentistsController::class, 'index'])->name('dentists.index');
Route::get('/dentists/add', [App\Http\Controllers\DentistsController::class, 'create'])->name('dentists.create');
Route::get('/dentists/edit/{id}', [App\Http\Controllers\DentistsController::class, 'edit']);
Route::post('/dentists', [App\Http\Controllers\DentistsController::class, 'store'])->name('dentists.store');
Route::put('/dentists', [App\Http\Controllers\DentistsController::class, 'update'])->name('dentists.update');
Route::delete('/dentists/delete/{id}', [App\Http\Controllers\DentistsController::class, 'destroy']);
