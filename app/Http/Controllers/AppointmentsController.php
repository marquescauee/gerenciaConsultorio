<?php

namespace App\Http\Controllers;

use App\Mail\MailNotify;
use App\Models\Agenda;
use App\Models\Appointments;
use App\Models\Patient;
use App\Models\Procedures;
use Carbon\Carbon;
use Google\Service\Calendar\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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

        $patientEmail = DB::table('patients')
                            ->join('pessoas', 'pessoas.id', 'patients.id')
                            ->where('patients.id', $patient)
                            ->first()
                            ->email;

        $hoursAvailable = ["09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00"];

        $appointmentsOnSelectedDay = DB::table('appointments')
            ->join('dentists', 'dentists.id', 'appointments.id_dentist')
            ->where('dentists.id', Auth::user()->id)
            ->where('appointments.date', $date)
            ->get();

        foreach ($appointmentsOnSelectedDay as $appointment) {

            if (($key = array_search($appointment->start_time, $hoursAvailable)) !== false) {
                unset($hoursAvailable[$key]);

                $cont = 1;
                $timeRemove = $hoursAvailable[$key + $cont];

                while ($timeRemove < $appointment->end_time) {
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
                return view('appointments.setTime', compact('patient', 'procedure', 'date', 'hoursAvailable'))->with('errorTime', 'Conflito de horários. Visite seus agendamentos para visualizar seus horários livres.');
            }

            if ($request->time > $appointment->start_time && $request->time < $appointment->end_time) {
                return view('appointments.setTime', compact('patient', 'procedure', 'date', 'hoursAvailable'))->with('errorTime', 'Conflito de horários. Visite seus agendamentos para visualizar seus horários livres.');
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

        $procedure = Procedures::where('id', $request->procedure)->first()->description;

        $date = Carbon::parse($request->date)->format('d/m/Y');

        $time = $request->time;

        Mail::to($patientEmail)->send(new MailNotify(Auth::user(), $date, $time, $procedure));

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

        $day = Carbon::parse($request->date)->dayName;

        $exists = false;

        $daysAvailable = Agenda::where('id_dentist', Auth::user()->id)->get()->toArray();

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
            return view('appointments.setDate', compact('patient', 'procedure', 'date'))->with('errorDay', $formatedErroString);
        }

        return $this->createSetTime($procedure, $patient, $date);
    }

    public function createSetTime($procedure, $patient, $date)
    {

        $hoursAvailable = ["09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00"];

        $appointmentsOnSelectedDay = DB::table('appointments')
            ->join('dentists', 'dentists.id', 'appointments.id_dentist')
            ->where('dentists.id', Auth::user()->id)
            ->where('appointments.date', $date)
            ->get();

        foreach ($appointmentsOnSelectedDay as $appointment) {

            if (($key = array_search($appointment->start_time, $hoursAvailable)) !== false) {
                unset($hoursAvailable[$key]);

                $cont = 1;
                $timeRemove = $hoursAvailable[$key + $cont];

                while ($timeRemove < $appointment->end_time) {
                    unset($hoursAvailable[$key + $cont]);
                    $cont++;
                    if ($key + $cont > sizeof($hoursAvailable)) {
                        break;
                    }
                    if (!array_key_exists(($key + $cont), $hoursAvailable)) {
                        break;
                    }
                    $timeRemove = $hoursAvailable[$key + $cont];
                }
            }
        }

        return view('appointments.setTime', compact('procedure', 'patient', 'date', 'hoursAvailable'));
    }

    public function setTime(Request $request)
    {
        $hoursAvailable = ["09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00"];

        $date = $request->date;
        $procedure = $request->procedure;
        $patient = $request->patient;

        $appointmentsOnSelectedDay = DB::table('appointments')
            ->join('dentists', 'dentists.id', 'appointments.id_dentist')
            ->where('dentists.id', Auth::user()->id)
            ->where('appointments.date', $date)
            ->get();

        foreach ($appointmentsOnSelectedDay as $appointment) {

            if (($key = array_search($appointment->start_time, $hoursAvailable)) !== false) {
                unset($hoursAvailable[$key]);

                $cont = 1;
                $timeRemove = $hoursAvailable[$key + $cont];

                while ($timeRemove < $appointment->end_time) {
                    unset($hoursAvailable[$key + $cont]);
                    $cont++;
                    if ($key + $cont > sizeof($hoursAvailable)) {
                        break;
                    }
                    if (!array_key_exists(($key + $cont), $hoursAvailable)) {
                        break;
                    }
                    $timeRemove = $hoursAvailable[$key + $cont];
                }
            }
        }

        if ($request->time === null) {
            return view('appointments.setTime', compact('procedure', 'patient', 'date', 'hoursAvailable'))->with('errorTime', 'Selecione um horário');
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
