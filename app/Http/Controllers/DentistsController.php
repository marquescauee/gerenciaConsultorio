<?php

namespace App\Http\Controllers;

use App\Models\Dentists;
use App\Models\Pessoa;
use App\Models\Speciality;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DentistsController extends Controller
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
        $dentists = DB::table('dentists')
            ->join('pessoas', 'dentists.id', '=', 'pessoas.id')
            ->where('admin', 0)
            ->get();

        foreach ($dentists as $dentist) {
            $format = Carbon::parse($dentist->birthday)->format('d/m/Y');

            $dentist->birthday = $format;
        }

        $specialities = Speciality::all();

        return view('dentists.index', compact('dentists', 'specialities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specialities = Speciality::all();

        return view('dentists.create', compact('specialities'));
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
            'cellphone' => 'required|regex:/^[0-9]{9}$/|unique:pessoas',
            'birthday' => 'required|date_format:d/m/Y',
            'CRO' => 'required|unique:dentists|regex:/^[A-Z]{2}-[0-9]{5}$/',
            'password' => 'required|min:8'
        ];

        $feedback = [
            'required' => 'O campo :attribute está vazio.',
            'name.min' => 'O campo name deve ter no mínimo 3 caracteres.',
            'name.max' => 'O campo name deve ter no máximo 40 caracteres.',
            'unique' => 'Este valor já possui registro.',
            'password.min' => 'O campo senha deve ter no mínimo 8 caracteres',
            'CRO.regex' => 'O campo CRO está em um formato inválido.',
            'regex' => 'O campo :attribute possui caracteres inválidos ou quantidade insuficiente.',
            'email' => 'O email informado não é válido.',
            'date_format' => 'Formato de data inválido.'
        ];

        $request->validate($rules, $feedback);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request->password),
            'funcionario' => 1
        ]);

        $pessoa = Pessoa::create([
            'id' => $user->id,
            'name' => $request['name'],
            'email' => $request['email'],
            'birthday' => $request['birthday'],
            'cellphone' => $request['cellphone'],
            'password' => $user->password
        ]);

        Dentists::create([
            'id' => $pessoa->id,
            'speciality_id' => $request['speciality'],
            'CRO' => $request->CRO,
            'admin' => 0
        ]);


        return redirect('/dentists');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dentists  $dentists
     * @return \Illuminate\Http\Response
     */
    public function show(Dentists $dentists)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dentists  $dentists
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dentist = DB::table('dentists')
            ->join('pessoas', 'dentists.id', '=', 'pessoas.id')
            ->where('pessoas.id', $id)
            ->first();

        $format = Carbon::parse($dentist->birthday)->format('d/m/Y');

        $dentist->birthday = $format;


        $specialities = Speciality::all();

        return view('dentists.edit', ['dentist' => $dentist, 'specialities' => $specialities]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dentists  $dentists
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'name' => 'required|min:3|max:40',
            'email' => 'required|email',
            'cellphone' => 'required|regex:/^[0-9]{9}$/',
            'birthday' => 'required|date_format:d/m/Y',
        ];

        $feedback = [
            'required' => 'O campo :attribute está vazio.',
            'name.min' => 'O campo name deve ter no mínimo 3 caracteres.',
            'name.max' => 'O campo name deve ter no máximo 40 caracteres.',
            'password.min' => 'O campo senha deve ter no mínimo 8 caracteres',
            'unique' => 'Este valor já possui registro.',
            'regex' => 'O campo :attribute possui caracteres inválidos ou quantidade insuficiente.',
            'size' => 'O campo :attribute não possui a quantidade de números necessária.',
            'email' => 'O email informado não é válido.',
            'date_format' => 'Formato de data inválido.'
        ];

        $request->validate($rules, $feedback);

        $dentist = Pessoa::find($request['id']);

        if ($request->password) {
            $dentist->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'birthday' => $request['birthday'],
                'cellphone' => $request['cellphone'],
                'password' => Hash::make($request['password'])
            ]);
        } else {
            $dentist->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'birthday' => $request['birthday'],
                'cellphone' => $request['cellphone'],
            ]);
        }

        $dentist = Dentists::find($request['id']);
        $dentist->update(['speciality_id' => $request['speciality']]);

        return redirect('/dentists');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dentists  $dentists
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dentist = Dentists::find($id);

        $pessoa = Pessoa::find($id);

        $dentist->delete();
        $pessoa->delete();

        return redirect('/dentists');
    }
}
