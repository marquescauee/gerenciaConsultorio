<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Dentists;
use App\Models\Procedures;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentsClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create() {

        $procedures = Procedures::all();

        return view('appointments.patients.create', compact('procedures'));
    }

    public function createSetDentist(Request $request) {
        $procedure = $request->procedure;

        $speciality = DB::table('procedures')
                        ->join('specialities', 'specialities.id', 'procedures.id_speciality')
                        ->where('procedures.id', $procedure)
                        ->first();


        $dentists = DB::table('dentists')
                        ->join('specialities', 'specialities.id', 'dentists.speciality_id')
                        ->join('pessoas', 'pessoas.id', 'dentists.id')
                        ->where('specialities.id', $speciality->id)
                        ->get();


        return view('appointments.patients.setDentist', compact('procedure', 'dentists'));
    }

    public function setDentist(Request $request) {
        $procedure = $request->procedure;
        $dentist = $request->dentist;

        return view('appointments.patients.setDate', compact('procedure', 'dentist'));
    }

    // public function createSetDate(Request $request) {
    //     $procedure = $request->procedure;

    //     return view('appointments.patients.setDate', compact('procedure'));
    // }

    public function setDate(Request $request) {
        $procedure = $request->procedure;
        $dentist = $request->dentist;
        $date = $request->date;

        $data = Carbon::parse($request->date)->dayName;

        if ($data === 'Sunday' || $data === 'Saturday') {
            return view('appointments.patients.setDate', compact('procedure', 'date', 'dentist'))->with('errorDay', 'Não atendemos aos finais de semana.');
        }

        return $this->createSetTime($procedure, $date, $dentist);
    }

    public function createSetTime($procedure, $date, $dentist) {
        return view('appointments.patients.setTime', compact('procedure', 'date', 'dentist'));
    }

    public function setTime(Request $request) {

        $horario = substr($request->time, 0, 2);

        if ($horario < 9 || $horario > 17) {
            return view('appointments.setTime', compact('procedure', 'patient'))->with('errorTime', 'Selecione um horário entre 09 e 17');
        }

        return $this->store($request);
    }

    public function store(Request $request)
    {

        $patient = Auth::user()->id;
        $procedure = $request->procedure;
        $date = $request->date;
        $dentist = $request->dentist;

        $appointmentOnRequestDay = DB::table('appointments')
            ->join('dentists', 'dentists.id', 'appointments.id_dentist')
            ->where('date', $request->date)
            ->select(['appointments.date', 'appointments.start_time', 'appointments.end_time'])
            ->get();

        foreach ($appointmentOnRequestDay as $appointment) {
            if ($appointment->start_time === $request->time || $appointment->end_time === $request->time) {
                return view('appointments.patients.setTime', compact('patient', 'procedure', 'date', 'dentist'))->with('errorTime', 'Já existe uma consulta para este horário. Tente novamente.');
            }

            if ($request->time > $appointment->start_time && $request->time < $appointment->end_time) {
                return view('appointments.patients.setTime', compact('patient', 'procedure', 'date', 'dentist'))->with('errorTime', 'Já existe uma consulta para este horário. Tente novamente.');
            }
        }

        $procedimento = Procedures::where('id', $procedure)->first()->description;

        $endTime = $this->tabelaHorarios($procedimento, $request->time);

        foreach ($appointmentOnRequestDay as $appointment) {
            if ($endTime > $appointment->start_time && $endTime < $appointment->end_time) {
                return view('appointments.patients.setTime', compact('patient', 'procedure', 'date'))->with('errorTime', 'Conflito de horários. Visite seus agendamentos para visualizar seus horários livres.');
            }
        }

        Appointments::create([
            'id_procedure' => $request->procedure,
            'id_patient' => Auth::user()->id,
            'id_dentist' => $request->dentist,
            'date' => $request->date,
            'start_time' => $request->time,
            'end_time' => $this->tabelaHorarios($procedimento, $request->time)
        ]);

        $dentist = DB::table('dentists')
                    ->join('pessoas', 'pessoas.id', 'dentists.id')
                    ->first();

        $procedure = Procedures::where('id', $request->procedure)->first()->description;

        $date = Carbon::parse($request->date)->format('d/m/Y');

        $time = $request->time;

        return view('appointments.patients.success', compact('dentist', 'procedure', 'date', 'time'));
    }

    public function tabelaHorarios($procedimento, $startTime)
    {
        if ($procedimento === 'Extração de Dente Siso') {

            if ($startTime === '09:00') {
                return '11:00';
            } elseif ($startTime === '08:00') {
                return '10:00';
            } elseif ($startTime === '08:30') {
                return '10:30';
            } elseif ($startTime === '09:30') {
                return '11:30';
            } else {
                $startTime[1] = substr(intval($startTime[1] + 2), 0, 1);

                return $startTime;
            }
        }

        if ($procedimento === 'Avaliação') {
            if ($startTime === '09:30') {
                return '10:00';
            } else {
                if ($startTime[3] == 3) {
                    $startTime[3] = substr(0, 0, 1);
                    $startTime[1] = substr(intval($startTime[1] + 1), 0, 1);
                } else {
                    $startTime[3] = substr(3, 0, 1);
                }
            }

            return $startTime;
        }
    }
}
