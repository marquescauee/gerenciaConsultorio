<?php

namespace App\Http\Controllers;

use App\Models\HealthPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HealthPlanController extends Controller
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
        $plans = DB::table('health_plans')->get();

        return view('plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plan = new HealthPlan();
        return view('plans.create', compact('plan'));
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
            'name' => 'required|min:3|max:40|unique:health_plans'
        ];

        $feedback = [
            'unique' => 'Este nome já existe registro.',
            'required' => 'O campo :attribute está vazio',
            'name.min' => 'O campo name deve ter no mínimo 3 caracteres.',
            'name.max' => 'O campo name deve ter no máximo 40 caracteres.',
        ];

        $request->validate($rules, $feedback);

        HealthPlan::create([
            'name' => $request->get('name')
        ]);

        return redirect('/plans');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HealthPlan  $healthPlan
     * @return \Illuminate\Http\Response
     */
    public function show(HealthPlan $healthPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HealthPlan  $healthPlan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = DB::table('health_plans')->where('id', $id)->first();
        return view('plans.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HealthPlan  $healthPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = [
            'name' => 'required|min:3|max:40|unique:health_plans'
        ];

        $feedback = [
            'unique' => 'Este nome já existe registro.',
            'required' => 'O campo :attribute está vazio',
            'name.min' => 'O campo name deve ter no mínimo 3 caracteres.',
            'name.max' => 'O campo name deve ter no máximo 40 caracteres.',
        ];

        $plan = HealthPlan::find($request->get('id'));
        $request->validate($rules, $feedback);
        $plan->update(['name' => $request->get('name')]);

        return redirect('/plans');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HealthPlan  $healthPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $plan = HealthPlan::find($id);
        $plan->delete();
        return redirect('/plans');
    }
}
