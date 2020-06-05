<?php

namespace App\Mail;

use App\Evaluador;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmergencyCallReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $distressCall;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Evaluador $distressCall)
    {
        //
        $this->distressCall=$distressCall;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.emergency-call');
    }
}
