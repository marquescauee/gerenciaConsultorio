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

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('funcionarioMiddleware');
    }

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


    public function create()
    {
        $patients = DB::table('patients')->join('pessoas', 'patients.id', 'pessoas.id')->get();
        $procedures = Procedures::all();

        return view('appointments.create', compact('patients', 'procedures'));
    }

    public function store(Request $request)
    {

        $patient = $request->patient;
        $procedure = $request->procedure;
        $date = $request->date;


        $appointmentOnRequestDay = DB::table('appointments')
            ->join('dentists', 'dentists.id', 'appointments.id_dentist')
            ->where('date', $request->date)
            ->select(['appointments.date', 'appointments.start_time', 'appointments.end_time'])
            ->get();

        foreach ($appointmentOnRequestDay as $appointment) {
            if ($appointment->start_time === $request->time || $appointment->end_time === $request->time) {
                return view('appointments.setTime', compact('patient', 'procedure', 'date'))->with('errorTime', 'Já existe uma consulta para este horário. Tente novamente.');
            }

            if ($request->time > $appointment->start_time && $request->time < $appointment->end_time) {
                return view('appointments.setTime', compact('patient', 'procedure', 'date'))->with('errorTime', 'Já existe uma consulta para este horário. Tente novamente.');
            }
        }

        $procedimento = Procedures::where('id', $request->procedure)->first()->description;

        $endTime = $this->tabelaHorarios($procedimento, $request->time);

        foreach ($appointmentOnRequestDay as $appointment) {
            if ($endTime > $appointment->start_time && $endTime < $appointment->end_time) {
                return view('appointments.setTime', compact('patient', 'procedure', 'date'))->with('errorTime', 'Conflito de horários. Visite seus agendamentos para visualizar seus horários livres.');
            }
        }

        Appointments::create([
            'id_procedure' => $request->procedure,
            'id_patient' => $request->patient,
            'id_dentist' => Auth::user()->id,
            'date' => $request->date,
            'start_time' => $request->time,
            'end_time' => $this->tabelaHorarios($procedimento, $request->time)
        ]);

        return redirect()->route('appointments.index');
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

    public function createSetDate(Request $request)
    {
        $procedure = $request->procedure;
        $patient = $request->patient;

        return view('appointments.setDate', compact('procedure', 'patient'));
    }

    public function setDate(Request $request)
    {
        $procedure = $request->procedure;
        $patient = $request->patient;
        $date = $request->date;

        $data = Carbon::parse($request->date)->dayName;

        if ($data === 'Sunday' || $data === 'Saturday') {
            return view('appointments.setDate', compact('procedure', 'patient'))->with('errorDay', 'Não selecione finais de semana');
        }

        return $this->createSetTime($procedure, $patient, $date);
    }

    public function createSetTime($procedure, $patient, $date) {
        return view('appointments.setTime', compact('procedure', 'patient', 'date'));
    }

    public function setTime(Request $request)
    {

        $horario = substr($request->time, 0, 2);

        if ($horario < 9 || $horario > 17) {
            return view('appointments.setTime', compact('procedure', 'patient'))->with('errorTime', 'Selecione um horário entre 09 e 17');
        }

        return $this->store($request);
    }


    public function destroy($id)
    {
        $appointment = Appointments::find($id);

        $appointment->delete();

        return redirect()->route('appointments.index');
    }
}
