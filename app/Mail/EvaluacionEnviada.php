<?php

namespace App\Mail;

use App\EmailSend;
use App\Evaluador;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EvaluacionEnviada extends Mailable
{
    use Queueable, SerializesModels;

    public $dataEvaluador;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EmailSend $dataEvaluador)
    {
        //
        $this->dataEvaluador=$dataEvaluador;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.evaluacion-enviada');
    }
}
