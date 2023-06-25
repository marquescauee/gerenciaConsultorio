<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Appointments;
use App\Models\Dentists;
use App\Models\Speciality;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dentists = DB::table('dentists')
            ->join('pessoas', 'dentists.id', '=', 'pessoas.id')
            ->join('agendas', 'agendas.id_dentist', 'dentists.id')
            ->where('pessoas.active', true)
            ->select('agendas.id_dentist', 'dentists.*', 'pessoas.*')
            ->groupBy('dentists.id')
            ->groupBy('agendas.id_dentist')
            ->groupBy('pessoas.id')
            ->get();

        foreach ($dentists as $dentist) {
            $format = Carbon::parse($dentist->birthday)->format('d/m/Y');

            $dentist->birthday = $format;
        }

        $specialities = Speciality::all();

        return view('agendas.index', compact('dentists', 'specialities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dentists = DB::table('dentists')
            ->join('pessoas', 'dentists.id', '=', 'pessoas.id')
            ->where('pessoas.active', true)
            ->get();

        return view('agendas.create', compact('dentists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dentists = DB::table('dentists')
            ->join('pessoas', 'dentists.id', '=', 'pessoas.id')
            ->where('pessoas.active', true)
            ->get();

        if (sizeof($request->all()) === 2) {
            return view('agendas.create', compact('dentists'))->with('errMessage', 'Selecione pelo menos um dia da semana.');
        }

        $days = array_slice($request->all(), 2);

        foreach ($days as $day) {
            Agenda::create([
                'id_dentist' => $request->dentist,
                'day' => $day
            ]);
        }

        return redirect()->route('agendas.index');
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
    public function destroy($id)
    {

        $dentists = DB::table('dentists')
            ->join('pessoas', 'dentists.id', '=', 'pessoas.id')
            ->join('agendas', 'agendas.id_dentist', 'dentists.id')
            ->where('pessoas.active', true)
            ->select('agendas.id_dentist', 'dentists.*', 'pessoas.*')
            ->groupBy('agendas.id_dentist')
            ->groupBy('dentists.id')
            ->groupBy('pessoas.id')
            ->get();

        foreach ($dentists as $dentist) {
            $format = Carbon::parse($dentist->birthday)->format('d/m/Y');

            $dentist->birthday = $format;
        }

        $specialities = Speciality::all();

        $appointments = Appointments::all()->where('id_dentist', $id)->toArray();

        if ($appointments) {
            return view('agendas.index', compact('dentists', 'specialities'))->with('errMessage', "Impsosível deletar agenda. Este dentista ainda possui consultas pendentes.");
        }

        $agendas = Agenda::all()->where('id_dentist', $id)->toArray();

        foreach($agendas as $agenda) {
            $agendaDelete = Agenda::all()->where('id_dentist', $id)->where('day', $agenda['day'])->first();

            $agendaDelete->delete();
        }

        return redirect()->route('agendas.index');
    }
}
