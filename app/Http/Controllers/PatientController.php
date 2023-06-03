<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Pessoa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = DB::table('patients')
            ->join('pessoas', 'patients.id', '=', 'pessoas.id')
            ->get();

        return view("home", compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $pessoa = Pessoa::create([
            'name' => $request['nome'],
            'password' => 1,
            'email' => $request['email'],
            'birthday' => $request['data_nasc'],
            'cellphone' => $request['telefone']
        ]);

        Patient::create([
            'id' => $pessoa->id,
            'cpf' => $request['cpf']
        ]);

        return redirect('/patients');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $patient = DB::table('patients')
            ->join('pessoas', 'patients.id', '=', 'pessoas.id')
            ->where('pessoas.id', $id)
            ->first();

        return view('patients.edit', ['patient' => $patient]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $patient = Pessoa::find($request['id']);

        $patient->update($request->all());

        return redirect('/patients');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient = Patient::find($id);

        $pessoa = Pessoa::find($id);

        $patient->delete();
        $pessoa->delete();

        return redirect('/patients');
    }
}
