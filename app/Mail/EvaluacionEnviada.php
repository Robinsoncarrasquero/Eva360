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
    public $the_view;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EmailSend $dataEvaluador,$view)
    {
        //
        $this->dataEvaluador=$dataEvaluador;
        $this->the_view=$view;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->the_view);
    }
}
