<?php

use App\Models\Dentists;
use App\Models\Patient;
use App\Models\Procedures;
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

//HealthPlans Routes
Route::get('/plans', [App\Http\Controllers\HealthPlanController::class, 'index'])->name('plans.index');
Route::get('/plans/add', [App\Http\Controllers\HealthPlanController::class, 'create'])->name('plans.create');
Route::post('/plans', [\App\Http\Controllers\HealthPlanController::class, 'store'])->name('plans.store');
Route::get('/plans/edit/{id}', [App\Http\Controllers\HealthPlanController::class, 'edit'])->name('plans.edit');
Route::put('/plans', [App\Http\Controllers\HealthPlanController::class, 'update'])->name('plans.update');
Route::delete('/plans/delete/{id}', [App\Http\Controllers\HealthPlanController::class, 'destroy'])->name('plans.delete');

//Suppliers Routes
Route::get('/suppliers', [\App\Http\Controllers\SuppliersController::class, 'index'])->name('suppliers.index');
Route::get('/suppliers/add', [App\Http\Controllers\SuppliersController::class, 'create'])->name('suppliers.create');
Route::post('/suppliers', [\App\Http\Controllers\SuppliersController::class, 'store'])->name('suppliers.store');
Route::get('/suppliers/edit/{id}', [App\Http\Controllers\SuppliersController::class, 'edit'])->name('suppliers.edit');
Route::put('/suppliers', [App\Http\Controllers\SuppliersController::class, 'update'])->name('suppliers.update');
Route::delete('/suppliers/delete/{id}', [App\Http\Controllers\SuppliersController::class, 'destroy'])->name('suppliers.delete');

//Procedure Routes
Route::get('/procedures', [\App\Http\Controllers\ProceduresController::class, 'index'])->name('procedures.index');
Route::get('/procedures/add', [App\Http\Controllers\ProceduresController::class, 'create'])->name('procedures.create');
Route::post('/procedures', [\App\Http\Controllers\ProceduresController::class, 'store'])->name('procedures.store');
Route::get('/procedures/edit/{id}', [App\Http\Controllers\ProceduresController::class, 'edit'])->name('procedures.edit');
Route::put('/procedures', [App\Http\Controllers\ProceduresController::class, 'update'])->name('procedures.update');
Route::delete('/procedures/delete/{id}', [App\Http\Controllers\ProceduresController::class, 'destroy'])->name('procedures.delete');

//Appointments Routes
Route::get('/appointments', [\App\Http\Controllers\AppointmentsController::class, 'index'])->name('appointments.index');
Route::get('/appointments/add', [App\Http\Controllers\AppointmentsController::class, 'create'])->name('appointments.create');
Route::post('/appointments', [\App\Http\Controllers\AppointmentsController::class, 'store'])->name('appointments.store');
Route::delete('/appointments/delete/{id}', [App\Http\Controllers\AppointmentsController::class, 'destroy'])->name('appointments.delete');
Route::post('/appointments/add/setDate', [App\Http\Controllers\AppointmentsController::class, 'createSetDate'])->name('appointments.createSetDate');
Route::post('/appointments/setDate', [App\Http\Controllers\AppointmentsController::class, 'setDate'])->name('appointments.setDate');
Route::post('/appointments/add/setTime', [App\Http\Controllers\AppointmentsController::class, 'createSetTime'])->name('appointments.createSetTime');
Route::post('/appointments/setTime', [App\Http\Controllers\AppointmentsController::class, 'setTime'])->name('appointments.setTime');


Route::get('/appointments/clients', [App\Http\Controllers\AppointmentsClientsController::class, 'create'])->name('appointments.clients.create');

Route::get('/gerarDados', function () {
    if (DB::table('specialities')->count() == 0) {
        DB::table('specialities')->insert([
            'name' => 'ortodontia'
        ]);

        //create admin dentists
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


        //create patient
        $user2 = User::create([
            'name' => 'paciente1',
            'email' => 'paciente1@gmail.com',
            'password' => Hash::make('teste1234'),
            'funcionario' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('pessoas')->insert([
            'id' => $user2->id,
            'name' => 'paciente1',
            'email' => 'paciente1@gmail.com',
            'birthday' => Carbon::now(),
            'cellphone' => 111111111,
            'active' => true,
            'password' => $user2->password
        ]);

        Patient::create([
            'id' => $user2->id,
            'cpf' => '12312312312'
        ]);

        //create procedure
        $procedure = Procedures::create([
            'description' => 'Extração de Dente Siso'
        ]);

        //create appointment
        DB::table('appointments')->insert([
            'id_procedure' => $procedure->id,
            'id_patient' => $user2->id,
            'id_dentist' => $user->id,
            'date' => '2023-06-23',
            'start_time' => '09:00',
            'end_time' => '11:00'
        ]);

    }

    return redirect('/');
});
