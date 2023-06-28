<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Appointments;
use App\Models\Dentists;
use App\Models\Speciality;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = DB::table('recipes')
            ->join('dentists', 'recipes.id_dentist', 'dentists.id')
            ->join('pessoas as dentists_people', 'dentists.id', '=', 'dentists_people.id')
            ->join('patients', 'recipes.id_patient', 'patients.id')
            ->join('pessoas as patients_people', 'patients.id', '=', 'patients_people.id')
            ->where('dentists_people.active', true)
            ->select('recipes.prescription', 'dentists.cro', 'dentists_people.*',
            'patients_people.name as patient_name')
            ->groupBy('dentists.id', 'patients.id', 'recipes.id')
            ->get();

        return view('recipes.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $patients = DB::table('patients')
            ->join('pessoas', 'patients.id', '=', 'pessoas.id')
            ->where('pessoas.active', true)
            ->get();

        $recipe = new Recipe();

        return view('recipes.create', compact('patients', 'recipe'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODO: Talvez apenas dentista possam cadastrar (teria que validar no sql)
        $rules = [
            'prescription' => 'required',
            'patient' => 'required',
        ];
        $feedback = [
            'required' => 'O campo :attribute está vazio.',
        ];

        $request->validate($rules, $feedback);

        Recipe::create([
            'id_dentist' => Auth::user()->id,
            'id_patient' => $request->patient,
            'prescription' => $request->prescription
        ]);

        return redirect()->route('recipes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $recipe = Recipe::find($id);
        $recipe->delete();

        return redirect()->route('recipes.index');
    }
}
