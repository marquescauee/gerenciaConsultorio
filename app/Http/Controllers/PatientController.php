<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Pessoa;
use App\Models\User;
use Carbon\Carbon;
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

        foreach ($patients as $patient) {
            $format = Carbon::parse($patient->birthday)->format('d/m/Y');

            $patient->birthday = $format;
        }

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

        $rules = [
            'nome' => 'required|min:3|max:40',
            'email' => 'required|email',
            'cpf' => 'required|size:11|regex:/^[0-9]{11}$/',
            'telefone' => 'required|size:9|regex:/^[0-9]{9}$/',
            'data_nasc' => 'required|date_format:d/m/Y'
        ];
        $feedback = [
            'required' => 'O campo :attribute está vazio.',
            'nome.min' => 'O campo nome deve ter no mínimo 3 caracteres.',
            'nome.max' => 'O campo nome deve ter no máximo 40 caracteres.',
            'numeric' => 'O campo :attribute deve conter apenas números.',
            'regex' => 'O campo :attribute possui caracteres inválidos.',
            'size' => 'O campo :attribute não possui a quantidade de números necessária.',
            'email' => 'O email informado não é válido.',
            'date_format' => 'Formato de data inválido.'
        ];

        $request->validate($rules, $feedback);

        $pessoa = Pessoa::create([
            'name' => $request['nome'],
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
