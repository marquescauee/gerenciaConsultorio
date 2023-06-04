<?php

namespace App\Http\Controllers;

use App\Models\Speciality;
use Illuminate\Http\Request;

class SpecialityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specialities = Speciality::all();

        return view('specialities.index', compact('specialities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('specialities.create');
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
            'name' => 'required|unique:specialities|min:3|max:40'
        ];

        $feedback = [
            'required' => 'O campo :attribute está vazio.',
            'name.min' => 'O campo nome deve ter no mínimo 3 caracteres.',
            'name.max' => 'O campo nome deve ter no máximo 40 caracteres.',
            'unique' => 'Este valor já possui registro.'
        ];

        $request->validate($rules, $feedback);

        Speciality::create([
            'name' => $request->name
        ]);

        return redirect()->route('specialities.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Speciality  $speciality
     * @return \Illuminate\Http\Response
     */
    public function show(Speciality $speciality)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Speciality  $speciality
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $speciality = Speciality::find($id);

        return view('specialities.edit', compact('speciality'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Speciality  $speciality
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'name' => 'required|min:3|max:40'
        ];

        $feedback = [
            'required' => 'O campo :attribute está vazio.',
            'name.min' => 'O campo nome deve ter no mínimo 3 caracteres.',
            'name.max' => 'O campo nome deve ter no máximo 40 caracteres.'
        ];

        $request->validate($rules, $feedback);

        $speciality = Speciality::find($request->id);

        $speciality->update(['name' => $request->name]);

        return redirect()->route('specialities.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Speciality  $speciality
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $speciality = Speciality::find($id);

        $speciality->delete();

        return redirect()->route('specialities.index');
    }
}
