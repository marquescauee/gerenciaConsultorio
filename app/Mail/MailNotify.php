<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNotify extends Mailable
{
    use Queueable, SerializesModels;

    public $dentist;
    public $date;
    public $time;
    public $procedure;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dentist, $date, $time, $procedure)
    {
        $this->dentist = $dentist;
        $this->date = $date;
        $this->time = $time;
        $this->procedure = $procedure;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contaparaprojetopin@gmail.com', 'Gerência Consultório')->subject('Agendamento de Consulta')->view('emails.index')->with('dentist', $this->dentist)->with('date', $this->date)->with('time', $this->time)->with('procedure', $this->procedure);
    }
}
