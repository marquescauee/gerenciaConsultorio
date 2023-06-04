<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Pessoa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('funcionarioMiddleware');
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
            'name' => 'required|min:3|max:40',
            'email' => 'required|email|unique:pessoas',
            'cpf' => 'required|regex:/^[0-9]{11}$/|unique:patients',
            'cellphone' => 'required|regex:/^[0-9]{9}$/|unique:pessoas',
            'birthday' => 'required|date_format:d/m/Y'
        ];
        $feedback = [
            'required' => 'O campo :attribute está vazio.',
            'name.min' => 'O campo name deve ter no mínimo 3 caracteres.',
            'name.max' => 'O campo name deve ter no máximo 40 caracteres.',
            'numeric' => 'O campo :attribute deve conter apenas números.',
            'regex' => 'O campo :attribute possui caracteres inválidos.',
            'size' => 'O campo :attribute não possui a quantidade de números necessária.',
            'email' => 'O email informado não é válido.',
            'date_format' => 'Formato de data inválido.',
            'unique' => 'Este valor já possui registro.'
        ];

        $request->validate($rules, $feedback);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request->password),
            'funcionario' => 0
        ]);

        $pessoa = Pessoa::create([
            'id' => $user->id,
            'name' => $request['name'],
            'email' => $request['email'],
            'birthday' => $request['birthday'],
            'cellphone' => $request['cellphone'],
            'password' => $user->password
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


        $format = Carbon::parse($patient->birthday)->format('d/m/Y');

        $patient->birthday = $format;


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
        $rules = [
            'name' => 'required|min:3|max:40',
            'email' => 'required|email',
            'cellphone' => 'required|regex:/^[0-9]{9}$/',
            'birthday' => 'required|date_format:d/m/Y'
        ];
        $feedback = [
            'required' => 'O campo :attribute está vazio.',
            'name.min' => 'O campo name deve ter no mínimo 3 caracteres.',
            'name.max' => 'O campo name deve ter no máximo 40 caracteres.',
            'numeric' => 'O campo :attribute deve conter apenas números.',
            'regex' => 'O campo :attribute possui caracteres inválidos.',
            'email' => 'O email informado não é válido.',
            'date_format' => 'Formato de data inválido.'
        ];

        $request->validate($rules, $feedback);

        $patient = Pessoa::find($request['id']);

        if ($request->password) {
            $patient->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'birthday' => $request['birthday'],
                'cellphone' => $request['cellphone'],
                'password' => Hash::make($request['password'])
            ]);
        } else {
            $patient->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'birthday' => $request['birthday'],
                'cellphone' => $request['cellphone']
            ]);
        }

        return redirect()->route('home');
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
