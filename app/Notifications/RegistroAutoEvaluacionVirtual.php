<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistroAutoEvaluacionVirtual extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($route)
    {
        //
        $this->route=$route;
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

        $url=Route($this->route,$notifiable->remember_token);

        return (new MailMessage)
            ->greeting('Hola.')
            ->line($notifiable->name)

            ->line('Bienvenido a la plataforma para la Evaluacion Virtual. Desde aqui puedes acceder directamente al cuestionario de Competencias.')
            ->line('Que tengas mucho exito en tu Auto Evaluacion Virtual.')
            ->action('Responder Auto Evaluacion', url($url))
            ->line('Gracias por probar el  Sistema de Evaluaciones de Desempeño Por Competencias HR-FeedBack-360')
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
            'evaluacion_id' => $this->notifiable->id,
            'name' => $this->notifiable->name,
            'email'=> $this->notifiable->email,
        ];
    }
}
