<?php

use App\Models\Dentists;
use App\Models\Speciality;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

//Specialities Routes
Route::get('/specialities', [\App\Http\Controllers\SpecialityController::class, 'index'])->name('specialities.index');
Route::get('/specialities/create', [\App\Http\Controllers\SpecialityController::class, 'create'])->name('specialities.create');
Route::post('/specialities', [\App\Http\Controllers\SpecialityController::class, 'store'])->name('specialities.store');
Route::get('/specialities/edit/{id}', [\App\Http\Controllers\SpecialityController::class, 'edit'])->name('specialities.edit');
Route::put('/specialities', [\App\Http\Controllers\SpecialityController::class, 'update'])->name('specialities.update');
Route::delete('/specialities/delete/{id}', [\App\Http\Controllers\SpecialityController::class, 'destroy'])->name('specialities.delete');

Route::get('/gerarDados', function () {
    if (DB::table('specialities')->count() == 0) {
        DB::table('specialities')->insert([
            'name' => 'ortodontia'
        ]);

        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin1234'),
            'funcionario' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('pessoas')->insert([
            'id' => $user->id,
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'birthday' => Carbon::now(),
            'cellphone' => 111111111,
            'active' => true,
            'password' => $user->password
        ]);

        $speciality = Speciality::all()->first();

        DB::table('dentists')->insert([
            'id' => $user->id,
            'speciality_id' => $speciality->id,
            'CRO' => 'SC-12345',
            'admin' => 1,
        ]);
    }

    return redirect('/');
});
