<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use App\Models\Suppliers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuppliersController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('adminMiddleware');
        $this->middleware('funcionarioMiddleware');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = DB::table('suppliers')
            ->join('pessoas', 'suppliers.id', '=', 'pessoas.id')
            ->where('pessoas.active', 'true')
            ->get();

        foreach ($suppliers as $supplier) {
            $format = Carbon::parse($supplier->birthday)->format('d/m/Y');

            $supplier->birthday = $format;
        }

        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('suppliers.create');
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
            'cnpj' => 'required|unique:suppliers|regex:/^[0-9]{14}$/',
        ];

        $feedback = [
            'required' => 'O campo :attribute está vazio.',
            'name.min' => 'O campo name deve ter no mínimo 3 caracteres.',
            'name.max' => 'O campo name deve ter no máximo 40 caracteres.',
            'unique' => 'Este valor já possui registro.',
            'cnpj.regex' => 'O campo CNPJ está em um formato inválido.',
            'regex' => 'O campo :attribute possui caracteres inválidos ou quantidade insuficiente.',
            'email' => 'O email informado não é válido.',
        ];

        $request->validate($rules, $feedback);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'funcionario' => false,
            'password' => Hash::make('1234'),
        ]);

        $pessoa = Pessoa::create([
            'id' => $user->id,
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make('1234'),
            'birthday' => '03/02/2001',
            'cellphone' => $request['cellphone'],
            'active' => true
        ]);

        Suppliers::create([
            'id' => $pessoa->id,
            'cnpj' => $request->cnpj,
        ]);


        return redirect('/suppliers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Suppliers  $suppliers
     * @return \Illuminate\Http\Response
     */
    public function show(Suppliers $suppliers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Suppliers  $suppliers
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = DB::table('suppliers')
            ->join('pessoas', 'suppliers.id', '=', 'pessoas.id')
            ->where('pessoas.id', $id)
            ->first();


        $format = Carbon::parse($supplier->birthday)->format('d/m/Y');

        $supplier->birthday = $format;


        return view('suppliers.edit', ['supplier' => $supplier]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Suppliers  $suppliers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'name' => 'required|min:3|max:40',
            'email' => 'required|email',
            'cellphone' => 'required|regex:/^[0-9]{9}$/'
        ];

        $feedback = [
            'required' => 'O campo :attribute está vazio.',
            'name.min' => 'O campo name deve ter no mínimo 3 caracteres.',
            'name.max' => 'O campo name deve ter no máximo 40 caracteres.',
            'cnpj.regex' => 'O campo CNPJ está em um formato inválido.',
            'regex' => 'O campo :attribute possui caracteres inválidos ou quantidade insuficiente.',
            'email' => 'O email informado não é válido.',
        ];

        $request->validate($rules, $feedback);

        $supplier = Pessoa::find($request['id']);

        $supplier->update([
            'name' => $request->name,
            'email' => $request->email,
            'cellphone' => $request->cellphone
        ]);

        return redirect()->route('suppliers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Suppliers  $suppliers
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pessoa = Pessoa::find($id);

        $pessoa->update(['active' => false]);

        return redirect()->route('suppliers.index');
    }
}
