<?php

namespace App\Http\Controllers;

use App\Models\Procedures;
use App\Models\Speciality;
use Illuminate\Http\Request;

class ProceduresController extends Controller
{

    public function __construct() {
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
        $procedures = Procedures::all();

        return view('procedures.index', compact('procedures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specialities = Speciality::all();

        return view('procedures.create', compact('specialities'));
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
            'description' => 'required|min:3|max:40|unique:procedures'
        ];

        $feedback = [
            'unique' => 'Este nome já existe registro.',
            'required' => 'O campo :attribute está vazio',
            'description.min' => 'O campo description deve ter no mínimo 3 caracteres.',
            'description.max' => 'O campo description deve ter no máximo 40 caracteres.',
        ];

        $request->validate($rules, $feedback);

        Procedures::create([
            'description' => $request->get('description'),
            'id_speciality' => $request->speciality
        ]);

        return redirect('/procedures');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Procedures  $procedures
     * @return \Illuminate\Http\Response
     */
    public function show(Procedures $procedures)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Procedures  $procedures
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $procedure = Procedures::find($id);
        $specialities = Speciality::all();

        return view('procedures.edit', compact('procedure', 'specialities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Procedures  $procedures
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'description' => 'required|min:3|max:40|unique:procedures'
        ];

        $feedback = [
            'unique' => 'Este nome já existe registro.',
            'required' => 'O campo :attribute está vazio',
            'description.min' => 'O campo description deve ter no mínimo 3 caracteres.',
            'description.max' => 'O campo description deve ter no máximo 40 caracteres.',
        ];

        $request->validate($rules, $feedback);

        $procedure = Procedures::find($request->get('id'));

        $procedure->update([
            'description' => $request->get('description'),
            'id_speciality' => $request->speciality
        ]);

        return redirect('/procedures');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Procedures  $procedures
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $procedure = Procedures::find($id);
        $procedure->delete();
        return redirect('/procedures');
    }
}
