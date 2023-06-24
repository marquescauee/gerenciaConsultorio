<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Patient;
use App\Models\Procedures;
use Carbon\Carbon;
use Google\Service\Calendar\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\GoogleCalendar\Event as GoogleCalendarEvent;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = DB::table('appointments')
            ->join('patients', 'patients.id', 'appointments.id_patient')
            ->join('dentists', 'dentists.id', 'appointments.id_dentist')
            ->join('pessoas', 'pessoas.id', 'patients.id')
            ->join('procedures', 'procedures.id', 'appointments.id_procedure')
            ->where('appointments.id_dentist', Auth::user()->id)
            ->orderBy('appointments.date')
            ->select(['appointments.id', 'procedures.description', 'appointments.date', 'pessoas.name'])
            ->get();

        foreach ($appointments as $appointment) {
            $format = Carbon::parse($appointment->date)->format('d/m/Y');

            $appointment->date = $format;
        }

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $patients = DB::table('patients')->join('pessoas', 'patients.id', 'pessoas.id')->get();
        $procedures = Procedures::all();

        return view('appointments.create', compact('patients', 'procedures'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $patients = DB::table('patients')->join('pessoas', 'patients.id', 'pessoas.id')->get();
        $procedures = Procedures::all();

        $data = Carbon::parse($request->date)->dayName;

        $horario = substr($request->time, 0, 2);

        if ($horario < 9 || $horario > 17) {
            return view('appointments.create', compact('patients', 'procedures'))->with('errorTime', 'Selecione um horário entre 09 e 17');
        }

        if ($data === 'Sunday' || $data === 'Saturday') {
            return view('appointments.create', compact('patients', 'procedures'))->with('errorDay', 'Não selecione finais de semana');
        }

        $appointmentOnRequestDay = DB::table('appointments')
                                        ->join('dentists', 'dentists.id', 'appointments.id_dentist')
                                        ->where('date', $request->date)
                                        ->select(['appointments.date', 'appointments.start_time', 'appointments.end_time'])
                                        ->get();

        foreach($appointmentOnRequestDay as $appointment) {
            if($appointment->start_time === $request->time || $appointment->end_time === $request->time) {
                return view('appointments.create', compact('patients', 'procedures'))->with('errorTime', 'Já existe uma consulta para este horário. Tente novamente.');
            }

            if($request->time > $appointment->start_time && $request->time < $appointment->end_time) {
                return view('appointments.create', compact('patients', 'procedures'))->with('errorTime', 'Já existe uma consulta para este horário. Tente novamente.');
            }
        }

        $procedimento = Procedures::where('id', $request->procedure)->first()->description;

        Appointments::create([
            'id_procedure' => $request->procedure,
            'id_patient' => $request->patient,
            'id_dentist' => Auth::user()->id,
            'date' => $request->date,
            'start_time' => $request->time,
            'end_time' => $this->tabelaHorarios($procedimento,$request->time)
        ]);

        return redirect()->route('appointments.index');
    }

    public function tabelaHorarios($procedimento, $startTime) {
        if($procedimento === 'Extração de Dente Siso') {

            if($startTime === '09:00') {
                return '11:00';
            }
            elseif($startTime === '08:00') {
                return '10:00';
            }
            elseif($startTime === '08:30') {
                return '10:30';
            }
            elseif($startTime === '09:30') {
                return '11:30';
            } else {
                $startTime[1] = substr(intval($startTime[1] + 2), 0,1);

                return $startTime;
            }
        }

        if($procedimento === 'Avaliação') {
            if($startTime === '09:30') {
                return '10:00';
            } else {
                if($startTime[3] == 3) {
                    $startTime[3] = substr(0, 0,1);
                    $startTime[1] = substr(intval($startTime[1] + 1), 0,1);
                } else {
                    $startTime[3] = substr(3, 0,1);
                }
            }

            return $startTime;
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointments  $appointments
     * @return \Illuminate\Http\Response
     */
    public function show(Appointments $appointments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointments  $appointments
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointments $appointments)
    {
        //TODO
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointments  $appointments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointments $appointments)
    {
        //TODO
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointments  $appointments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointment = Appointments::find($id);

        $appointment->delete();

        return redirect()->route('appointments.index');
    }
}
