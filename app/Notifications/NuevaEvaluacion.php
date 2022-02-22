<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NuevaEvaluacion extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $url=Route('evaluacion.token',$notifiable->remember_token);

        return (new MailMessage)
            ->greeting('Hola.')
            ->line($notifiable->name)

            ->line('Se ha enviado una Nueva Evaluacion para que la respondas en la plataforma.')
            ->action('Responder', url($url))
            ->line('Responder la evaluacion es muy simple, intuito, facil y rápido.')
            ->line('Gracias por utilizar nuestro Sistema de Evaluacion de Desempeño Por Competencias HR-FeedBack-360')
            ->salutation('Saludos');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'evaluado_id' => $this->notifiable->id,
            'name' => $this->notifiable->name,
            'email'=> $this->notifiable->email,
        ];
    }
}
