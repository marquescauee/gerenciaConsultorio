<?php

namespace App\Http\Controllers;

use App\Models\Dentists;
use App\Models\Pessoa;
use App\Models\Speciality;
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
        $pessoa = Pessoa::create([
            'name' => $request['nome'],
            'email' => $request['email'],
            'birthday' => $request['data_nasc'],
            'cellphone' => $request['telefone']
        ]);


        Dentists::create([
            'id' => $pessoa->id,
            'speciality_id' => $request['speciality'],
            'CRO' => $request->cro,
            'password' => Hash::make($request->password),
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
        $dentist = Pessoa::find($request['id']);

        $dentist->update($request->all());

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
