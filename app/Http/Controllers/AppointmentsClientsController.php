<?php

namespace App\Http\Controllers;

use App\Mail\MailNotify;
use App\Models\Agenda;
use App\Models\Appointments;
use App\Models\Dentists;
use App\Models\Procedures;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AppointmentsClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $procedures = Procedures::all();

        return view('appointments.patients.create', compact('procedures'));
    }

    public function createSetDentist(Request $request)
    {
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

    public function setDentist(Request $request)
    {
        $procedure = $request->procedure;
        $dentist = $request->dentist;

        return view('appointments.patients.setDate', compact('procedure', 'dentist'));
    }

    public function setDate(Request $request)
    {
        $procedure = $request->procedure;
        $dentist = $request->dentist;
        $date = $request->date;

        $data = Carbon::parse($request->date)->dayName;

        if ($data === 'Sunday' || $data === 'Saturday') {
            return view('appointments.patients.setDate', compact('procedure', 'date', 'dentist'))->with('errorDay', 'Não atendemos aos finais de semana.');
        }

        $data = Carbon::parse($request->date)->dayName;

        if ($data === 'Sunday' || $data === 'Saturday') {
            return view('appointments.patients.setDate', compact('procedure', 'patient'))->with('errorDay', 'Não selecione finais de semana');
        }

        $day = Carbon::parse($request->date)->dayName;

        $exists = false;

        $daysAvailable = Agenda::where('id_dentist', $dentist)->get()->toArray();

        $daysOfWeek = [];

        foreach ($daysAvailable as $dayAvailable) {
            array_push($daysOfWeek, $dayAvailable['day']);
            if ($dayAvailable['day'] === $day) {
                $exists = true;
            }
        }

        for ($i = 0; $i < sizeof($daysOfWeek); $i++) {
            if ($daysOfWeek[$i] === 'Monday') {
                $daysOfWeek[$i] = 'Segunda';
            }

            if ($daysOfWeek[$i] === 'Tuesday') {
                $daysOfWeek[$i] = 'Terça';
            }

            if ($daysOfWeek[$i] === 'Wednesday') {
                $daysOfWeek[$i] = 'Quarta';
            }

            if ($daysOfWeek[$i] === 'Thursday') {
                $daysOfWeek[$i] = 'Quinta';
            }

            if ($daysOfWeek[$i] === 'Friday') {
                $daysOfWeek[$i] = 'Sexta';
            }
        }


        $formatedErroString = 'Este dentista não atende no dia selecionado, somente às ' . implode('s, ', $daysOfWeek);

        $formatedErroString .= 's.';


        if (!$exists) {
            return view('appointments.patients.setDate', compact('dentist', 'procedure', 'date'))->with('errorDay', $formatedErroString);
        }

        return $this->createSetTime($procedure, $date, $dentist);
    }

    public function createSetTime($procedure, $date, $dentist)
    {

        $hoursAvailable = ["09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00"];

        $appointmentsOnSelectedDay = DB::table('appointments')
            ->join('dentists', 'dentists.id', 'appointments.id_dentist')
            ->where('dentists.id', $dentist)
            ->where('appointments.date', $date)
            ->get();

        foreach ($appointmentsOnSelectedDay as $appointment) {

            if (($key = array_search($appointment->start_time, $hoursAvailable)) !== false) {
                unset($hoursAvailable[$key]);

                $cont = 1;
                $timeRemove = $hoursAvailable[$key + $cont];

                while($timeRemove < $appointment->end_time) {
                    unset($hoursAvailable[$key + $cont]);
                    $cont++;
                    $timeRemove = $hoursAvailable[$key + $cont];
                }
            }
        }

        return view('appointments.patients.setTime', compact('procedure', 'date', 'dentist', 'hoursAvailable'));
    }

    public function setTime(Request $request)
    {

        $procedure = $request->procedure;
        $dentist = $request->dentist;
        $date = $request->date;

        $hoursAvailable = ["09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00"];

        $appointmentsOnSelectedDay = DB::table('appointments')
            ->join('dentists', 'dentists.id', 'appointments.id_dentist')
            ->where('dentists.id', $dentist)
            ->where('appointments.date', $date)
            ->get();

        foreach ($appointmentsOnSelectedDay as $appointment) {

            if (($key = array_search($appointment->start_time, $hoursAvailable)) !== false) {
                unset($hoursAvailable[$key]);

                $cont = 1;
                $timeRemove = $hoursAvailable[$key + $cont];

                while($timeRemove < $appointment->end_time) {
                    unset($hoursAvailable[$key + $cont]);
                    $cont++;
                    $timeRemove = $hoursAvailable[$key + $cont];
                }
            }
        }

        if($request->time === null) {
            return view('appointments.patients.setTime', compact('procedure', 'dentist', 'date', 'hoursAvailable'))->with('errorTime', 'Selecione um horário');
        }

        $horario = substr($request->time, 0, 2);

        if ($horario < 9 || $horario > 17) {
            return view('appointments.patients.setTime', compact('procedure', 'dentist', 'date', 'hoursAvailable'))->with('errorTime', 'Selecione um horário');
        }

        return $this->store($request);
    }

    public function store(Request $request)
    {

        $patient = Auth::user()->id;
        $procedure = $request->procedure;
        $date = $request->date;
        $dentist = $request->dentist;

        $hoursAvailable = ["09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00"];

        $appointmentsOnSelectedDay = DB::table('appointments')
            ->join('dentists', 'dentists.id', 'appointments.id_dentist')
            ->where('dentists.id', $dentist)
            ->where('appointments.date', $date)
            ->get();

        foreach ($appointmentsOnSelectedDay as $appointment) {

            if (($key = array_search($appointment->start_time, $hoursAvailable)) !== false) {
                unset($hoursAvailable[$key]);

                $cont = 1;
                $timeRemove = $hoursAvailable[$key + $cont];

                while($timeRemove < $appointment->end_time) {
                    unset($hoursAvailable[$key + $cont]);
                    $cont++;
                    $timeRemove = $hoursAvailable[$key + $cont];
                }
            }
        }

        $appointmentOnRequestDay = DB::table('appointments')
            ->join('dentists', 'dentists.id', 'appointments.id_dentist')
            ->where('date', $request->date)
            ->select(['appointments.date', 'appointments.start_time', 'appointments.end_time'])
            ->get();

        foreach ($appointmentOnRequestDay as $appointment) {
            if ($appointment->start_time === $request->time || $appointment->end_time === $request->time) {
                return view('appointments.patients.setTime', compact('patient', 'procedure', 'date', 'dentist', 'hoursAvailable'))->with('errorTime', 'Horário Indisponível');
            }

            if ($request->time > $appointment->start_time && $request->time < $appointment->end_time) {
                return view('appointments.patients.setTime', compact('patient', 'procedure', 'date', 'dentist', 'hoursAvailable'))->with('errorTime', 'Horário Indisponível');
            }
        }

        $procedimento = Procedures::where('id', $procedure)->first()->description;

        $endTime = $this->tabelaHorarios($procedimento, $request->time);

        foreach ($appointmentOnRequestDay as $appointment) {
            if ($endTime > $appointment->start_time && $endTime < $appointment->end_time) {
                return view('appointments.patients.setTime', compact('patient', 'procedure', 'date', 'dentist', 'hoursAvailable'))->with('errorTime', 'Horário Indisponível');
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
        ->where('dentists.id', $request->dentist)
        ->first();

        $procedure = Procedures::where('id', $request->procedure)->first()->description;

        $date = Carbon::parse($request->date)->format('d/m/Y');

        $time = $request->time;

        Mail::to(Auth::user()->email)->send(new MailNotify($dentist, $date, $time, $procedure));

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

        if ($procedimento === 'Avaliação de Sisos') {
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
